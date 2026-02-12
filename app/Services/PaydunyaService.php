<?php

namespace App\Services;

use Paydunya\Setup;
use Paydunya\Checkout\CheckoutInvoice;
use Illuminate\Support\Facades\Log;
use Exception;

class PaydunyaService
{
    public function initPayment($amount, $description, $returnUrl, $cancelUrl)
    {
        // Mode simulation pour le développement local
        if (env('PAYDUNYA_SIMULATE', false)) {
            return $this->simulatePayment($returnUrl);
        }

        try {
            Setup::setMasterKey(env('PAYDUNYA_MASTER_KEY'));
            Setup::setPrivateKey(env('PAYDUNYA_PRIVATE_KEY'));
            Setup::setPublicKey(env('PAYDUNYA_PUBLIC_KEY'));
            Setup::setToken(env('PAYDUNYA_TOKEN'));
            Setup::setMode(env('PAYDUNYA_MODE'));

            $invoice = new CheckoutInvoice();

            $invoice->addItem($description, 1, $amount, $amount);
            $invoice->setTotalAmount($amount);

            $invoice->setReturnUrl($returnUrl);
            $invoice->setCancelUrl($cancelUrl);

            if ($invoice->create()) {
                return [
                    'success' => true,
                    'url' => $invoice->getInvoiceUrl()
                ];
            }

            return [
                'success' => false,
                'error' => 'Erreur lors de la création de la facture PayDunya'
            ];
        } catch (Exception $e) {
            Log::error('Erreur PayDunya: ' . $e->getMessage());
            
            // En mode développement, proposer la simulation
            if (env('APP_DEBUG')) {
                return [
                    'success' => false,
                    'error' => 'Le service de paiement est indisponible. Ajoutez PAYDUNYA_SIMULATE=true dans votre .env pour utiliser le mode simulation.',
                    'technical_error' => $e->getMessage()
                ];
            }
            
            return [
                'success' => false,
                'error' => 'Le service de paiement est temporairement indisponible. Veuillez réessayer plus tard.',
                'technical_error' => $e->getMessage()
            ];
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function verifyPayment($token)
    {
        // En mode simulation, toujours retourner succès
        if (env('PAYDUNYA_SIMULATE', false)) {
            return [
                'success' => true,
                'status' => 'completed',
                'transaction_id' => $token,
                'simulated' => true
            ];
        }

        try {
            Setup::setMasterKey(env('PAYDUNYA_MASTER_KEY'));
            Setup::setPrivateKey(env('PAYDUNYA_PRIVATE_KEY'));
            Setup::setPublicKey(env('PAYDUNYA_PUBLIC_KEY'));
            Setup::setToken(env('PAYDUNYA_TOKEN'));
            Setup::setMode(env('PAYDUNYA_MODE'));

            $invoice = new CheckoutInvoice();
            
            // Récupérer les détails de la facture
            if ($invoice->confirm($token)) {
                $status = $invoice->status;
                
                return [
                    'success' => $status === 'completed',
                    'status' => $status,
                    'transaction_id' => $token,
                    'amount' => $invoice->getTotalAmount()
                ];
            }

            return [
                'success' => false,
                'error' => 'Impossible de vérifier le paiement'
            ];
        } catch (Exception $e) {
            Log::error('Erreur vérification PayDunya: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => 'Erreur lors de la vérification du paiement',
                'technical_error' => $e->getMessage()
            ];
        }
    }

    /**
     * Simulation de paiement pour le développement local
     */
    private function simulatePayment($returnUrl)
    {
        // Générer un token simulé
        $token = 'SIM' . time() . rand(1000, 9999);
        
        // Ajouter un paramètre pour simuler un paiement réussi
        $simulatedReturnUrl = $returnUrl . '?token=' . $token . '&simulated=true';
        
        return [
            'success' => true,
            'url' => $simulatedReturnUrl,
            'simulated' => true
        ];
    }
}
