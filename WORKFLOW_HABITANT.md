# 🔄 Nouveau Workflow avec Rôle Habitant

## 📋 Vue d'ensemble des changements

Le système a été mis à jour pour **séparer les rôles** et introduire un **workflow de paiement en deux étapes** :

1. **L'administrateur** crée les certificats (statut : "en_attente")
2. **L'habitant** se connecte et paie pour accéder à son certificat (statut passe à "payé")

---

## 👥 Rôles du système

### 🔑 Administrateur (admin)
- **Accès** : Gestion complète des habitants et certificats
- **Permissions** :
  - Créer/Modifier/Supprimer des habitants
  - Créer/Modifier/Supprimer des certificats
  - Voir tous les certificats (payés ou non)
- **Dashboard** : `/habitants` (liste des habitants)

### 👤 Habitant (habitant)
- **Accès** : Voir et payer ses propres certificats
- **Permissions** :
  - Voir ses certificats en attente de paiement
  - Payer pour débloquer un certificat (5 000 FCFA)
  - Télécharger/Voir ses certificats payés uniquement
- **Dashboard** : `/habitant/dashboard` (mes certificats)

---

## 🗄️ Modifications de la base de données

### Table `certificats`
✅ **Nouvelle colonne** : `statut` (enum)
- Valeurs possibles : `en_attente`, `paye`
- Valeur par défaut : `en_attente`

### Table `habitants`
✅ **Nouvelle colonne** : `user_id` (foreign key)
- Lie un habitant à un compte utilisateur
- Permet à l'habitant de se connecter et voir ses certificats

### Table `users`
✅ **Colonne modifiée** : `role`
- Valeurs possibles : `admin`, `habitant`
- Détermine les permissions et redirections

---

## 🔄 Workflow complet

### 📝 Étape 1 : Création du certificat (Admin)

```
┌─────────────────────────────────────────┐
│  Admin se connecte                      │
│  → Redirection vers /habitants          │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Admin clique "Ajouter un certificat"   │
│  → /certificats/create                  │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Formulaire rempli :                    │
│  - Date du certificat                   │
│  - Sélection de l'habitant              │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Certificat créé en base de données     │
│  Statut : "en_attente"                  │
│  → Notification à l'habitant (futur)    │
└─────────────────────────────────────────┘
```

### 💳 Étape 2 : Paiement du certificat (Habitant)

```
┌─────────────────────────────────────────┐
│  Habitant s'inscrit/se connecte         │
│  → Redirection vers /habitant/dashboard │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Dashboard habitant                     │
│  → Liste des certificats avec statut    │
│  • En attente (bouton "Payer")          │
│  • Payé (bouton "Voir le certificat")   │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Habitant clique "Payer"                │
│  → POST /habitant/certificat/{id}/payer │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Initialisation paiement PayDunya       │
│  → Redirection vers page PayDunya       │
│  → Montant : 5 000 FCFA                 │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Habitant effectue le paiement          │
│  (Mobile Money ou Carte bancaire)       │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Retour automatique après paiement      │
│  → GET /habitant/payment/success        │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Statut du certificat mis à jour        │
│  Statut : "en_attente" → "paye"         │
└───────────────┬─────────────────────────┘
                │
                ▼
┌─────────────────────────────────────────┐
│  Habitant peut maintenant voir/         │
│  télécharger son certificat officiel    │
└─────────────────────────────────────────┘
```

---

## 🛠️ Fichiers créés/modifiés

### ✨ Nouveaux fichiers

1. **Migration** : `2026_02_12_120409_add_statut_to_certificats_table.php`
   - Ajoute la colonne `statut` à la table certificats

2. **Migration** : `2026_02_12_122031_add_user_id_to_habitants_table.php`
   - Ajoute la colonne `user_id` à la table habitants

3. **Middleware** : `app/Http/Middleware/HabitantMiddleware.php`
   - Protège les routes réservées aux habitants

4. **Contrôleur** : `app/Http/Controllers/HabitantDashboardController.php`
   - Gère l'espace habitant (dashboard, paiement, visualisation)

5. **Vue** : `resources/views/habitant/dashboard.blade.php`
   - Dashboard de l'habitant avec liste de ses certificats

### 📝 Fichiers modifiés

1. **Modèles** :
   - `app/Models/Certificat.php` - Ajout `statut` au fillable
   - `app/Models/Habitant.php` - Ajout `user_id` et relation `user()`
   - `app/Models/User.php` - Ajout `role` et relation `habitant()`

2. **Contrôleurs** :
   - `app/Http/Controllers/CertificatController.php` - Création avec statut "en_attente"
   - `app/Http/Controllers/Auth/AuthenticatedSessionController.php` - Redirection selon rôle
   - `app/Http/Controllers/Auth/RegisteredUserController.php` - Enregistrement avec rôle

3. **Vues** :
   - `resources/views/certificats/create.blade.php` - Formulaire admin sans paiement
   - `resources/views/certificats/index.blade.php` - Affichage du statut
   - `resources/views/layouts/main.blade.php` - Menu selon rôle
   - `resources/views/auth/register.blade.php` - Choix du rôle

4. **Routes** :
   - `routes/web.php` - Routes habitant et protection par middleware

5. **Configuration** :
   - `bootstrap/app.php` - Enregistrement middleware habitant

---

## 🔐 Sécurité implémentée

### Middleware
- ✅ **AdminMiddleware** : Protège les routes admin (habitants, certificats CRUD)
- ✅ **HabitantMiddleware** : Protège les routes habitant (dashboard, paiement)

### Vérifications de propriété
- ✅ Habitant ne peut voir que **ses propres certificats**
- ✅ Habitant ne peut payer que **ses certificats non payés**
- ✅ Habitant ne peut voir le PDF que si **statut = "payé"**

### Protection CSRF
- ✅ Formulaires protégés par token CSRF Laravel
- ✅ Validation des données côté serveur

---

## 📱 Guide d'utilisation

### 🔧 Pour l'Administrateur

1. **Se connecter** avec un compte admin
2. **Créer un habitant** via `/habitants/create`
3. **Créer un certificat** via `/certificats/create`
   - Sélectionner l'habitant
   - Choisir la date
   - Le certificat est créé avec statut "En attente"
4. **Informer l'habitant** qu'un certificat est prêt (par email/SMS - à implémenter)

### 👤 Pour l'Habitant

1. **S'inscrire** via `/register` en choisissant le rôle "Habitant"
   - L'admin devra lier ce compte au profil habitant (user_id)
2. **Se connecter** → Redirection automatique vers le dashboard
3. **Voir ses certificats** avec leurs statuts
4. **Cliquer "Payer"** sur un certificat en attente
5. **Effectuer le paiement** via PayDunya (5 000 FCFA)
6. **Retour automatique** après paiement réussi
7. **Cliquer "Voir le certificat"** pour télécharger le PDF officiel

---

## 🎨 Différences visuelles

### Dashboard Admin (`/habitants`)
- Menu : **Habitants** | **Certificats**
- Boutons : Ajouter, Modifier, Supprimer
- Tableau avec **colonne Statut** (En attente / Payé)

### Dashboard Habitant (`/habitant/dashboard`)
- Menu : **Mes Certificats**
- Carte de bienvenue avec nom de l'habitant
- Tableau avec actions conditionnelles :
  - **Statut "En attente"** → Bouton "Payer (5 000 FCFA)"
  - **Statut "Payé"** → Bouton "Voir le certificat"

---

## 🔄 Prochaines améliorations suggérées

### 🚀 Priorité haute
- [ ] **Lier automatiquement** user_id lors de la création d'habitant
- [ ] **Email de notification** quand un certificat est créé
- [ ] **Historique des paiements** dans un tableau dédié
- [ ] **Webhooks PayDunya** pour confirmation sécurisée

### 💡 Priorité moyenne
- [ ] **Facture PDF** après paiement réussi
- [ ] **Notifications SMS** via Twilio ou autre
- [ ] **Page de profil habitant** pour modifier ses infos
- [ ] **Statistiques admin** : nombre de certificats payés/en attente

### 🎯 Priorité basse
- [ ] **Export Excel** des certificats
- [ ] **Recherche avancée** par statut, date, habitant
- [ ] **Tableau de bord admin** avec graphiques
- [ ] **Multi-langue** (français/wolof)

---

## 🧪 Comment tester

### Test Admin

```bash
# 1. Créer un compte admin
php artisan tinker
User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password'), 'role' => 'admin']);

# 2. Se connecter et créer un habitant
# 3. Créer un certificat pour cet habitant
# 4. Vérifier que le statut est "en_attente"
```

### Test Habitant

```bash
# 1. Créer un compte habitant via /register (rôle: Habitant)
# 2. Lier manuellement le user_id à l'habitant en base :
php artisan tinker
$habitant = Habitant::find(1);
$user = User::where('email', 'habitant@test.com')->first();
$habitant->user_id = $user->id;
$habitant->save();

# 3. Se connecter → Voir le dashboard avec certificat en attente
# 4. Tester le paiement avec les clés test PayDunya
# 5. Vérifier que le statut passe à "payé"
# 6. Vérifier que le bouton "Voir" apparaît
```

---

## 📊 Résumé des modifications

| Composant | Avant | Après |
|-----------|-------|-------|
| **Rôles** | Admin uniquement | Admin + Habitant |
| **Paiement** | Admin paie lors création | Habitant paie après création |
| **Statut certificat** | Aucun | en_attente / paye |
| **Accès certificat** | Tout le monde | Seulement si payé |
| **Lien User-Habitant** | Aucun | user_id dans habitants |
| **Routes** | /certificats (admin) | /certificats (admin) + /habitant/* (habitant) |
| **Navigation** | Même menu pour tous | Menu selon rôle |

---

## 🎓 Concepts techniques utilisés

- ✅ **Middleware personnalisé** (AdminMiddleware, HabitantMiddleware)
- ✅ **Route Model Binding** Laravel
- ✅ **Eloquent Relations** (hasMany, belongsTo, hasOne)
- ✅ **Enum MySQL** pour le statut
- ✅ **Session Laravel** pour stocker l'ID certificat pendant paiement
- ✅ **Policy-based authorization** (vérification de propriété)
- ✅ **Redirection conditionnelle** selon rôle
- ✅ **Intégration API tierce** (PayDunya SDK)

---

## 📞 Support

Pour toute question sur le nouveau workflow :
1. Consultez ce document
2. Vérifiez les routes : `php artisan route:list`
3. Vérifiez les migrations : `php artisan migrate:status`
4. Consultez la documentation PayDunya : [PAYDUNYA_CONFIG.md](PAYDUNYA_CONFIG.md)

---

**Version** : 2.0.0  
**Date** : 12 Février 2026  
**Statut** : ✅ Opérationnel (tests requis)
