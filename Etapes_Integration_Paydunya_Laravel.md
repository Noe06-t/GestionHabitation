# Intégration de PayDunya dans un Projet Laravel

## 🎯 Objectif

Permettre à un utilisateur de payer un certificat via PayDunya avant sa
création en base de données.

------------------------------------------------------------------------

# ✅ Étape 1 : Installation du SDK

``` bash
composer require paydunya/paydunya
```

Laravel charge automatiquement `vendor/autoload.php`, aucune inclusion
manuelle n'est nécessaire.

------------------------------------------------------------------------

# ✅ Étape 2 : Configuration des clés API

Ajouter dans le fichier `.env` :

    PAYDUNYA_MASTER_KEY=your_master_key
    PAYDUNYA_PUBLIC_KEY=your_public_key
    PAYDUNYA_PRIVATE_KEY=your_private_key
    PAYDUNYA_TOKEN=your_token
    PAYDUNYA_MODE=test

Puis exécuter :

``` bash
php artisan config:clear
```

------------------------------------------------------------------------

# ✅ Étape 3 : Création d'un Service PayDunya

Créer le fichier :

`app/Services/PaydunyaService.php`

``` php
<?php

namespace App\Services;

use Paydunya\Setup;
use Paydunya\Checkout\CheckoutInvoice;

class PaydunyaService
{
    public function initPayment($amount, $description)
    {
        Setup::setMasterKey(env('PAYDUNYA_MASTER_KEY'));
        Setup::setPrivateKey(env('PAYDUNYA_PRIVATE_KEY'));
        Setup::setPublicKey(env('PAYDUNYA_PUBLIC_KEY'));
        Setup::setToken(env('PAYDUNYA_TOKEN'));
        Setup::setMode(env('PAYDUNYA_MODE'));

        $invoice = new CheckoutInvoice();

        $invoice->addItem($description, 1, $amount, $amount);
        $invoice->setTotalAmount($amount);

        $invoice->setReturnUrl(route('payment.success'));
        $invoice->setCancelUrl(route('certificats.index'));

        if ($invoice->create()) {
            return $invoice->getCheckoutUrl();
        }

        return false;
    }
}
```

------------------------------------------------------------------------

# ✅ Étape 4 : Modifier le CertificatController

Ajouter une méthode de paiement :

``` php
use App\Services\PaydunyaService;

public function payer(Request $request)
{
    $request->validate([
        'date_certificat' => 'required|date',
        'habitant_id' => 'required|exists:habitants,id'
    ]);

    session([
        'certificat_data' => $request->only('date_certificat', 'habitant_id')
    ]);

    $paydunya = new PaydunyaService();
    $url = $paydunya->initPayment(5000, "Paiement Certificat");

    if ($url) {
        return redirect($url);
    }

    return back()->with('error', 'Erreur lors du paiement');
}
```

------------------------------------------------------------------------

# ✅ Étape 5 : Définir les Routes

Dans `routes/web.php` :

``` php
Route::post('/certificat/payer', [CertificatController::class, 'payer'])
    ->name('certificat.payer');

Route::get('/payment/success', [CertificatController::class, 'success'])
    ->name('payment.success');
```

------------------------------------------------------------------------

# ✅ Étape 6 : Confirmation du Paiement

``` php
public function success()
{
    $data = session('certificat_data');

    if ($data) {
        Certificat::create($data);
        session()->forget('certificat_data');
    }

    return redirect()->route('certificats.index')
        ->with('success', 'Paiement réussi et certificat créé');
}
```

------------------------------------------------------------------------

# 🔐 Étape 7 : Amélioration Professionnelle (Recommandée)

Pour une meilleure sécurité :

-   Utiliser le `token` retourné par PayDunya
-   Vérifier le statut du paiement via l'API
-   Implémenter une `callback URL` (webhook)
-   Ajouter un champ `statut` dans la table certificats

------------------------------------------------------------------------

# 🚀 Workflow Final

1.  L'utilisateur clique sur "Passer certificat"
2.  Redirection vers PayDunya
3.  Paiement effectué
4.  Retour vers `/payment/success`
5.  Création du certificat en base de données

------------------------------------------------------------------------

# 🎓 Résultat

Le certificat est créé uniquement si le paiement est validé. Le système
respecte la logique métier et les bonnes pratiques minimales de
sécurité.
