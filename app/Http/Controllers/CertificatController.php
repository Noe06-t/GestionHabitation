<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificat;
use App\Models\Habitant;
use App\Services\PaydunyaService;

class CertificatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lister tous les certificats
        $certificats = Certificat::with('habitant')->get();
        return view('certificats.index', compact('certificats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Formulaire de création d'un certificat
        $habitants = Habitant::all();
        return view('certificats.create', compact('habitants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Enregistrer un nouveau certificat avec statut en_attente
        $request->validate([
            'date_certificat' => 'required|date',
            'habitant_id' => 'required|exists:habitants,id'
        ]);

        Certificat::create([
            'date_certificat' => $request->date_certificat,
            'habitant_id' => $request->habitant_id,
            'statut' => 'en_attente'
        ]);

        return redirect()->route('certificats.index')
                         ->with('success', 'Certificat créé avec succès. L\'habitant peut maintenant se connecter pour effectuer le paiement.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificat $certificat)
    {
        $certificat->load('habitant');
        return view('certificats.show', compact('certificat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificat $certificat)
    {
        $habitants = Habitant::all();
        return view('certificats.edit', compact('certificat', 'habitants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificat $certificat)
    {
        $certificat->update($request->all());
        return redirect()->route('certificats.index')
                         ->with('success', 'Certificat mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificat $certificat)
    {
        // Sauvegarder le nom de l'habitant pour le message
        $habitantNom = $certificat->habitant->nom . ' ' . $certificat->habitant->prenom;
        
        // Supprimer uniquement le certificat (l'habitant reste intact)
        $certificat->delete();
        
        return redirect()->route('certificats.index')
                         ->with('success', "Certificat supprimé avec succès. L'habitant {$habitantNom} n'a pas été supprimé.");
    }
}
