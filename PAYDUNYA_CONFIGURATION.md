# Configuration PayDunya

## Flux de Paiement Complet

### 1. Mode Production (PAYDUNYA_SIMULATE=false)

1. **Initialisation du paiement**
   - L'habitant clique sur le bouton "Payer" pour son certificat
   - Le contrôleur `HabitantDashboardController@payer` est appelé
   - L'ID du certificat est sauvegardé en session

2. **Création de la facture PayDunya**
   - Le service `PaydunyaService->initPayment()` configure une facture `CheckoutInvoice`
   - Montant : 5000 FCFA
   - Description : "Paiement Certificat d'Habitation #X"
   - URL de retour : `route('habitant.payment.success')`
   - URL d'annulation : `route('habitant.dashboard')`
   - L'API PayDunya crée la facture et retourne une URL de paiement

3. **Redirection vers PayDunya**
   - L'utilisateur est redirigé vers la page de paiement sécurisée PayDunya (sandbox en mode test)
   - Interface de paiement : Mobile Money, Carte bancaire, etc.

4. **Traitement du paiement**
   - L'utilisateur entre ses identifiants de test (en sandbox) ou réels (en production)
   - PayDunya traite le paiement
   - Un token de transaction unique est généré

5. **Callback de retour**
   - PayDunya redirige vers l'URL de callback : `/habitant/payment/success?token=XXX`
   - Le contrôleur `HabitantDashboardController@paymentSuccess` est appelé

6. **Vérification du paiement**
   - Le service `PaydunyaService->verifyPayment($token)` est appelé
   - Appel API à PayDunya pour confirmer le statut du paiement
   - Vérification que le statut est "completed"

7. **Mise à jour du certificat**
   - Si le paiement est validé :
     - Le statut du certificat passe à "payé"
     - Le `transaction_id` est enregistré dans la base de données
     - La session est nettoyée
     - Redirection vers le dashboard avec message de succès
   - Si le paiement échoue :
     - Redirection vers le dashboard avec message d'erreur
     - Le certificat reste en statut "en_attente"

### 2. Mode Simulation (PAYDUNYA_SIMULATE=true)

1. L'habitant clique sur "Payer"
2. Le système génère un token simulé (`SIM` + timestamp)
3. Redirection immédiate vers la page de succès avec le token
4. Vérification simulée (toujours successful)
5. Le statut passe à "payé" avec le token simulé

---

## Problème rencontré

L'API PayDunya en mode test peut parfois être indisponible ou très lente, causant des erreurs de timeout :
```
cURL error 28: Connection timed out after 10010 milliseconds
```

## Solution : Mode Simulation

Pour le développement local, un **mode simulation** a été implémenté. Ce mode permet de tester le flux de paiement sans faire d'appel réel à l'API PayDunya.

### Activation du mode simulation

Dans le fichier `.env`, ajoutez ou modifiez :
```env
PAYDUNYA_SIMULATE=true
```

### Désactivation du mode simulation (Production)

Pour utiliser la vraie API PayDunya en production :
```env
PAYDUNYA_SIMULATE=false
```

## Comment ça fonctionne

### Mode Simulation (PAYDUNYA_SIMULATE=true)
1. L'habitant clique sur "Payer"
2. Le système redirige directement vers la page de succès avec un ID de transaction simulé
3. Le statut du certificat passe à "payé"
4. Un avertissement jaune s'affiche sur le dashboard indiquant que les paiements sont simulés

### Mode Production (PAYDUNYA_SIMULATE=false)
1. L'habitant clique sur "Payer"
2. Le système appelle l'API PayDunya réelle
3. L'habitant est redirigé vers la page de paiement PayDunya
4. Après paiement, PayDunya redirige vers la page de succès
5. Le statut du certificat passe à "payé"

## Gestion d'erreurs

Le service PayDunya (app/Services/PaydunyaService.php) gère maintenant les erreurs :

- **En mode debug (APP_DEBUG=true)** : Les détails techniques de l'erreur sont affichés
- **En mode production** : Un message générique est affiché à l'utilisateur
- Toutes les erreurs sont loguées dans `storage/logs/laravel.log`

## Configuration PayDunya

Vos credentials PayDunya actuels (dans `.env`) :
```env
PAYDUNYA_MASTER_KEY=Cds1lpDN-HITb-DGFA-J2Yq-2NOwqdh4DlJw
PAYDUNYA_PUBLIC_KEY=test_public_zOlVGSsnjSt0LYZd7RBULkp3QVP
PAYDUNYA_PRIVATE_KEY=test_private_qXOrLgkM1UE2CXCEvfMmyFIYAN3
PAYDUNYA_TOKEN=NwO0VxyXVrSBAsMobpZl
PAYDUNYA_MODE=test
```

Ces credentials sont en mode **test**. Pour passer en production, vous devrez :
1. Créer un compte PayDunya de production
2. Obtenir vos credentials de production
3. Mettre à jour le `.env` avec `PAYDUNYA_MODE=live` et les nouveaux credentials
4. Désactiver le mode simulation avec `PAYDUNYA_SIMULATE=false`

## Montant du paiement

Le montant est actuellement fixé à **5000 FCFA** dans le contrôleur `HabitantDashboardController@payer`.

Pour le modifier, éditez [app/Http/Controllers/HabitantDashboardController.php](app/Http/Controllers/HabitantDashboardController.php#L71) :
```php
$result = $paydunya->initPayment(
    5000, // <-- Modifier ici
    "Paiement Certificat d'Habitation #{$certificat->id}",
    route('habitant.payment.success'),
    route('habitant.dashboard')
);
```
