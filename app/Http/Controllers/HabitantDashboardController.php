<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificat;
use App\Models\Habitant;
use App\Services\PaydunyaService;
use Illuminate\Support\Facades\Auth;

class HabitantDashboardController extends Controller
{
    /**
     * Afficher le dashboard habitant avec ses certificats
     */
    public function index()
    {
        $habitant = Auth::guard('habitant')->user();
        
        // Récupérer les certificats de cet habitant
        $certificats = Certificat::where('habitant_id', $habitant->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('habitant.dashboard', compact('certificats', 'habitant'));
    }

    /**
     * Afficher un certificat (seulement si payé)
     */
    public function show(Certificat $certificat)
    {
        $habitant = Auth::guard('habitant')->user();
        
        // Vérifier que le certificat appartient bien à cet habitant
        if ($certificat->habitant_id !== $habitant->id) {
            abort(403, 'Ce certificat ne vous appartient pas.');
        }
        
        // Vérifier que le certificat est payé
        if ($certificat->statut !== 'paye') {
            return redirect()->route('habitant.dashboard')
                ->with('error', 'Vous devez payer ce certificat pour y accéder.');
        }
        
        // Indiquer qu'on est dans la vue habitant pour adapter les routes
        $isHabitantView = true;
        
        return view('certificats.show', compact('certificat', 'isHabitantView'));
    }

    /**
     * Initier le paiement pour un certificat
     */
    public function payer(Certificat $certificat)
    {
        $habitant = Auth::guard('habitant')->user();
        
        // Vérifier que le certificat appartient bien à cet habitant
        if ($certificat->habitant_id !== $habitant->id) {
            abort(403, 'Ce certificat ne vous appartient pas.');
        }
        
        // Vérifier que le certificat n'est pas déjà payé
        if ($certificat->statut === 'paye') {
            return redirect()->route('habitant.dashboard')
                ->with('info', 'Ce certificat est déjà payé.');
        }
        
        // Sauvegarder l'ID du certificat en session
        session(['certificat_id' => $certificat->id]);
        
        // Initialiser le paiement PayDunya
        $paydunya = new PaydunyaService();
        $result = $paydunya->initPayment(
            5000, 
            "Paiement Certificat d'Habitation #{$certificat->id}",
            route('habitant.payment.success'),
            route('habitant.dashboard')
        );
        
        if ($result['success']) {
            return redirect($result['url']);
        }
        
        $errorMessage = $result['error'] ?? 'Erreur lors de l\'initialisation du paiement';
        if (env('APP_DEBUG') && isset($result['technical_error'])) {
            $errorMessage .= ' (' . $result['technical_error'] . ')';
        }
        
        return back()->with('error', $errorMessage);
    }


    /**
     * Confirmation du paiement (callback PayDunya)
     */
    public function paymentSuccess(Request $request)
    {
        $certificatId = session('certificat_id');
        
        if (!$certificatId) {
            return redirect()->route('habitant.dashboard')
                ->with('error', 'Session de paiement expirée. Veuillez réessayer.');
        }
        
        $certificat = Certificat::find($certificatId);
        
        if (!$certificat) {
            return redirect()->route('habitant.dashboard')
                ->with('error', 'Certificat non trouvé.');
        }
        
        // Vérifier que le certificat n'est pas déjà payé
        if ($certificat->statut === 'paye') {
            session()->forget('certificat_id');
            return redirect()->route('habitant.dashboard')
                ->with('info', 'Ce certificat est déjà payé.');
        }
        
        // Récupérer le token de paiement depuis PayDunya
        $token = $request->get('token');
        
        if (!$token) {
            return redirect()->route('habitant.dashboard')
                ->with('error', 'Token de paiement manquant.');
        }
        
        // Vérifier le paiement auprès de PayDunya
        $paydunya = new PaydunyaService();
        $verification = $paydunya->verifyPayment($token);
        
        if ($verification['success']) {
            // Mettre à jour le statut du certificat
            $certificat->update([
                'statut' => 'paye',
                'transaction_id' => $verification['transaction_id'] ?? $token
            ]);
            
            session()->forget('certificat_id');
            
            $message = 'Paiement réussi ! Votre certificat est maintenant accessible.';
            if (isset($verification['simulated']) && $verification['simulated']) {
                $message .= ' (Mode simulation)';
            }
            
            return redirect()->route('habitant.dashboard')
                ->with('success', $message);
        }
        
        // Paiement échoué ou en attente
        $errorMsg = 'Le paiement n\'a pas pu être confirmé.';
        if (isset($verification['error'])) {
            $errorMsg .= ' ' . $verification['error'];
        }
        
        return redirect()->route('habitant.dashboard')
            ->with('error', $errorMsg);
    }
}
