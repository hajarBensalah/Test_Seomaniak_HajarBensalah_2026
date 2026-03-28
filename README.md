#  Gestion de Contacts

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-9.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat-square&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-22c55e?style=flat-square)

Application web CRUD complète pour gérer un répertoire de contacts, construite avec Laravel, MySQL et un design CSS personnalisé sans framework.

---

## À propos

**Gestion de Contacts** est une application web qui permet de créer, consulter, modifier et supprimer des contacts depuis une interface propre et responsive.

L'application repose sur une architecture **MVC + Service Layer** :
le contrôleur reste léger (validation + délégation), la logique métier est isolée dans un service dédié, et le modèle Eloquent gère la persistance. Chaque couche a une responsabilité unique et clairement définie.

---

##  Stack technique

| Couche        | Technologie                              |
|---------------|------------------------------------------|
| Langage       | PHP 8.x                                  |
| Framework     | Laravel 9.x                              |
| Base de données | MySQL 8.0                              |
| Templates     | Blade (moteur de vues Laravel)           |
| Styles        | CSS custom — variables, Grid, Flexbox    |
| Données test  | Faker via Laravel Factory & Seeder       |

> Aucun framework CSS (pas de Bootstrap, pas de Tailwind) — design entièrement maison.

---

##  Architecture du projet

```
gestionContacts/
│
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ContactController.php   # 7 méthodes RESTful, validation, redirects
│   ├── Models/
│   │   └── Contact.php                 # Modèle Eloquent avec $fillable
│   └── Services/
│       └── ContactService.php          # Logique métier isolée (CRUD + recherche)
│
├── database/
│   ├── factories/
│   │   └── ContactFactory.php          # Génération de faux contacts via Faker
│   ├── migrations/
│   │   └── ..._create_contacts_table.php
│   └── seeders/
│       ├── ContactSeeder.php           # Insère 10 contacts de test
│       └── DatabaseSeeder.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Layout principal : navbar, flash, @yield
│       └── contacts/
│           ├── index.blade.php         # Liste paginée + barre de recherche
│           ├── create.blade.php        # Formulaire de création
│           ├── edit.blade.php          # Formulaire d'édition pré-rempli
│           └── show.blade.php          # Fiche détail lecture seule
│
├── routes/
│   └── web.php                         # Route::resource('contacts', ...)
│
├── public/
│   └── css/
│       └── app.css                     # Feuille de style unique, variables CSS
│
└── .env.example                        # Template de configuration (ne pas commiter .env)
```

### Flux d'une requête

```
HTTP Request
    │
    ▼
routes/web.php
    │
    ▼
ContactController        ← valide les données (Request::validate)
    │
    ▼
ContactService           ← logique métier (requêtes Eloquent, recherche, pagination)
    │
    ▼
Contact Model            ← accès à la base de données via Eloquent ORM
    │
    ▼
MySQL Database
    │
    ▼
View (Blade)             ← rendu HTML retourné au navigateur
```

---

##  Installation & Setup

### Prérequis

- PHP ≥ 8.0
- Composer
- MySQL ≥ 8.0


### Étapes

**1. Cloner le dépôt**
```bash
git clone https://github.com/votre-utilisateur/gestion-contacts.git
cd gestion-contacts
```

**2. Installer les dépendances PHP**
```bash
composer install
```

**3. Copier le fichier d'environnement**
```bash
cp .env.example .env
```

**4. Générer la clé d'application**
```bash
php artisan key:generate
```

**5. Configurer la base de données dans `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestion_contacts
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

**6. Exécuter les migrations et le seeder**
```bash
php artisan migrate --seed
```

**7. Lancer le serveur de développement**
```bash
php artisan serve
```

Ouvrir [http://localhost:8000](http://localhost:8000) dans le navigateur.

---

## Variables d'environnement

Les variables suivantes doivent être configurées dans le fichier `.env` :

| Variable        | Description                          | Exemple              |
|-----------------|--------------------------------------|----------------------|
| `APP_NAME`      | Nom affiché de l'application         | `Gestion de Contacts`|
| `APP_ENV`       | Environnement (`local` / `production`)| `local`             |
| `APP_KEY`       | Clé de chiffrement (générée auto)    | `base64:...`         |
| `APP_DEBUG`     | Mode debug (`true` en dev uniquement)| `true`               |
| `DB_HOST`       | Hôte de la base de données           | `127.0.0.1`          |
| `DB_PORT`       | Port MySQL                           | `3306`               |
| `DB_DATABASE`   | Nom de la base de données            | `gestion_contacts`   |
| `DB_USERNAME`   | Utilisateur MySQL                    | `root`               |
| `DB_PASSWORD`   | Mot de passe MySQL                   | `secret`             |

>  **Ne jamais commiter le fichier `.env`** — il contient vos identifiants de base de données. Il est déjà listé dans `.gitignore`.

---

##  Routes disponibles

Déclarées en une seule ligne via `Route::resource` :

```php
Route::resource('contacts', ContactController::class);
```

| Méthode HTTP | URL                      | Action      | Description                        |
|--------------|--------------------------|-------------|------------------------------------|
| `GET`        | `/contacts`              | `index`     | Afficher la liste paginée          |
| `GET`        | `/contacts/create`       | `create`    | Afficher le formulaire de création |
| `POST`       | `/contacts`              | `store`     | Enregistrer un nouveau contact     |
| `GET`        | `/contacts/{id}`         | `show`      | Afficher la fiche d'un contact     |
| `GET`        | `/contacts/{id}/edit`    | `edit`      | Afficher le formulaire d'édition   |
| `PUT/PATCH`  | `/contacts/{id}`         | `update`    | Mettre à jour un contact           |
| `DELETE`     | `/contacts/{id}`         | `destroy`   | Supprimer un contact               |

---

## ✅ Fonctionnalités

- ✅ Lister les contacts avec pagination (10 par page)
- ✅ Rechercher un contact par nom, email, entreprise ou téléphone
- ✅ Créer un nouveau contact via formulaire validé
- ✅ Modifier un contact existant (formulaire pré-rempli)
- ✅ Supprimer un contact avec confirmation via modal personnalisé
- ✅ Voir la fiche détail complète d'un contact
- ✅ Cliquer sur une ligne du tableau pour accéder au détail
- ✅ Validation des formulaires (côté serveur, avec messages d'erreur)
- ✅ Messages flash de confirmation après chaque action CRUD
- ✅ Dates de création et dernière modification avec heure
- ✅ Données de test (Seeder avec 10 contacts générés via Faker)
- ✅ Design responsive (mobile, tablette, desktop)

---

## 🧱 Bonnes pratiques appliquées

**Sécurité**
- Protection contre le Mass Assignment via `$fillable` sur le modèle `Contact`
- Validation stricte de toutes les données entrantes dans `store()` et `update()`
- Unicité de l'email vérifiée en base de données et en validation Laravel
- Fichier `.env` exclu du versioning via `.gitignore`

**Architecture**
- **Service Layer** : la logique métier est isolée dans `ContactService`, le contrôleur reste pur (validation + délégation + réponse)
- **Route Model Binding** : Laravel résout automatiquement `Contact $contact` depuis l'URL
- **Pagination** : `paginate(10)` avec conservation des paramètres de recherche via `withQueryString()`

**UX**
- Modal de confirmation CSS pour les suppressions (sans `confirm()` natif du navigateur)
- Flash messages stylisés (vert succès, rouge erreur)
- Barre de recherche avec indicateur de résultats et bouton de réinitialisation

---


