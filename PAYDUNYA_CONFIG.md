# Configuration PayDunya pour Gestion Habitation

## 📌 Étapes de configuration

### 1. Obtenir les clés API PayDunya

1. Créez un compte sur [PayDunya](https://paydunya.com)
2. Accédez à votre tableau de bord
3. Naviguez vers **Paramètres > Clés API**
4. Récupérez vos clés :
   - Master Key
   - Public Key
   - Private Key
   - Token

### 2. Configurer le fichier .env

Remplacez les valeurs dans votre fichier `.env` :

```env
# PayDunya Configuration
PAYDUNYA_MASTER_KEY=votre_master_key_ici
PAYDUNYA_PUBLIC_KEY=votre_public_key_ici
PAYDUNYA_PRIVATE_KEY=votre_private_key_ici
PAYDUNYA_TOKEN=votre_token_ici
PAYDUNYA_MODE=test  # Utilisez 'live' pour la production
```

### 3. Vider le cache Laravel

```bash
php artisan config:clear
```

## 🔄 Fonctionnement du paiement

### Workflow complet :

1. **L'utilisateur accède au formulaire** de création de certificat
   - Route : `/certificats/create`
   - Affiche le formulaire avec montant de 5 000 FCFA

2. **Soumission du formulaire**
   - Action : `POST /certificat/payer`
   - Les données sont sauvegardées en session
   - Redirection vers PayDunya

3. **Paiement sur PayDunya**
   - L'utilisateur effectue le paiement via Mobile Money ou Carte bancaire
   - PayDunya traite le paiement

4. **Retour après paiement**
   - **Succès** : Redirection vers `/payment/success`
     - Le certificat est créé en base de données
     - Message de confirmation affiché
   - **Annulation** : Redirection vers `/certificats`
     - Les données en session sont supprimées

### Routes utilisées :

```php
POST /certificat/payer          → Initialise le paiement
GET  /payment/success           → Confirmation et création du certificat
```

## 💰 Montant du certificat

Le montant est défini dans `PaydunyaService::initPayment()` :

```php
$paydunya->initPayment(5000, "Paiement Certificat d'Habitation");
```

Pour modifier le montant, éditez :
- `app/Services/PaydunyaService.php` (ligne avec initPayment)
- `resources/views/certificats/create.blade.php` (affichage du montant)

## 🔒 Sécurité

### Protection des routes

Les routes de paiement sont protégées :
```php
Route::post('/certificat/payer', ...)
    ->middleware(['auth', 'admin']);
```

### Stockage temporaire

Les données du certificat sont stockées en session pendant le paiement et supprimées après :
```php
session(['certificat_data' => $request->only(...)]);
session()->forget('certificat_data');
```

## 🧪 Mode Test vs Production

### Mode Test (développement)
```env
PAYDUNYA_MODE=test
```
- Utilisez les clés de test PayDunya
- Aucun argent réel n'est débité
- Tous les paiements sont des simulations

### Mode Production (live)
```env
PAYDUNYA_MODE=live
```
- Utilisez les clés de production PayDunya
- Les paiements sont réels
- Assurez-vous que tout fonctionne en test avant

## 📝 Méthodes de paiement disponibles

PayDunya supporte :
- 💳 **Mobile Money** (Orange Money, MTN Mobile Money, Moov Money)
- 💳 **Cartes bancaires** (Visa, Mastercard)
- 💳 **Airtel Money**

## 🛠 Dépannage

### Erreur : "Undefined method 'getInvoiceUrl'"
**Solution :** Vérifiez que le package PayDunya est bien installé :
```bash
composer require paydunya/paydunya
```

### Erreur : "Invalid credentials"
**Solution :** Vérifiez vos clés API dans le fichier `.env` et videz le cache :
```bash
php artisan config:clear
```

### Le paiement ne redirige pas
**Solution :** Vérifiez que les routes `payment.success` et `certificats.index` existent :
```bash
php artisan route:list | grep payment
```

### Session vide après paiement
**Solution :** Assurez-vous que `SESSION_DRIVER=database` dans `.env` et que la table sessions existe :
```bash
php artisan session:table
php artisan migrate
```

## 📚 Documentation PayDunya

- [Documentation officielle](https://paydunya.com/developers)
- [SDK PHP](https://github.com/paydunya/paydunya-php)

## ✅ Checklist avant mise en production

- [ ] Clés API de production configurées
- [ ] `PAYDUNYA_MODE=live`
- [ ] Tests de paiement réussis
- [ ] URL de retour accessible publiquement (pas localhost)
- [ ] Certificats SSL installés (HTTPS requis)
- [ ] Logs de paiement configurés
- [ ] Gestion des erreurs testée

## 🔔 Notes importantes

1. **URL de callback** : L'URL `payment.success` doit être accessible publiquement en production (pas localhost)
2. **HTTPS obligatoire** : PayDunya exige HTTPS en production
3. **Timeout** : Le paiement expire après 30 minutes
4. **Webhooks** : Pour une sécurité maximale, implémentez les webhooks PayDunya

## 💡 Améliorations futures suggérées

1. **Ajouter une table `paiements`** pour tracer tous les paiements
2. **Implémenter les webhooks** PayDunya pour une confirmation sécurisée
3. **Ajouter un statut** au certificat (en_attente, payé, échoué)
4. **Logger les transactions** pour audit
5. **Envoyer un email** de confirmation après paiement réussi

---

**Version** : 1.0.0  
**Date** : Février 2026  
**Intégration** : PayDunya PHP SDK
