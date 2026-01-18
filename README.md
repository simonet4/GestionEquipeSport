# Gestion Équipe Sport

Application web de gestion d'équipe sportive (adaptée au football) développée en PHP avec architecture MVC. Permet la gestion des joueurs, des matchs, des feuilles de match, des statistiques, et l'authentification sécurisée.

## Fonctionnalités

- **Authentification** : Connexion sécurisée avec mots de passe hashés. Mot de passe oublié avec réinitialisation.
- **Gestion des joueurs** : CRUD complet (ajout, modification, suppression, liste) avec statuts (Actif, Blessé, etc.).
- **Gestion des matchs** : CRUD des matchs avec résultats et évaluations.
- **Feuilles de match** : Sélection des titulaires et remplaçants, validation du nombre minimum de joueurs.
- **Statistiques** : Stats globales (matchs gagnés/perdus/nuls) et par joueur (sélections, moyennes, % victoires).
- **Profil utilisateur** : Modification du login, email, et mot de passe.
- **URLs propres** : Utilisation de .htaccess pour des URLs sans index.php.

## Technologies utilisées

- **Backend** : PHP 8+ avec architecture MVC
- **Base de données** : MySQL via PDO
- **Frontend** : HTML, CSS, Bootstrap 5
- **Sécurité** : Sessions PHP, mots de passe hashés (BCRYPT), prévention injections SQL
- **Serveur** : Apache (avec mod_rewrite pour .htaccess)

## Installation

1. **Prérequis** :
   - XAMPP (ou serveur Apache + MySQL + PHP 8+)
   - Git

2. **Clonage du projet** :
   ```bash
   git clone https://github.com/votre-repo/GestionEquipeSport.git
   cd GestionEquipeSport
   ```

3. **Configuration de la base de données** :
   - Importer le fichier `sql/gestion_sport.sql` dans phpMyAdmin (ou votre outil MySQL).
   - Modifier `config/db.php` avec vos credentials DB :
     ```php
     private $host = 'localhost';
     private $dbname = 'gestion_sport';
     private $user = 'root';
     private $pass = '';
     ```
   - Créer et configurer `config/secrets.php` avec le mot de passe administrateur (non committé).

4. **Lancement** :
   - Placer le dossier `public` dans le répertoire web de XAMPP (htdocs).
   - Accéder à `http://localhost/GestionEquipeSport/public/`
   - Login par défaut : `admin` / `admin`

## Structure du projet

```
GestionEquipeSport/
├── config/
│   └── db.php              # Configuration DB (Singleton)
├── controllers/
│   ├── AuthController.php  # Authentification
│   ├── JoueurController.php # Gestion joueurs
│   ├── MatchController.php # Gestion matchs
│   └── ...
├── models/
│   ├── JoueurModel.php     # Modèle joueurs
│   ├── MatchModel.php      # Modèle matchs
│   └── ...
├── views/
│   ├── layout.php          # Template principal
│   ├── auth/               # Vues auth
│   ├── joueurs/            # Vues joueurs
│   └── ...
├── public/
│   ├── index.php           # Point d'entrée
│   └── .htaccess           # Réécriture URLs
├── sql/
│   └── gestion_sport.sql   # Schéma DB
└── README.md
```

## Utilisation

- **Connexion** : Utilisez le login `admin` / `admin`.
- **Navigation** : Menu principal pour accéder aux sections Joueurs, Matchs, Statistiques, Profil.
- **Ajout/Modification** : Boutons dédiés sur les listes.
- **Feuilles de match** : Accessible depuis la liste des matchs.

## Sécurité

- Authentification obligatoire.
- Mots de passe hashés.
- Requêtes préparées pour éviter les injections SQL.
- Sessions sécurisées.

## Auteurs

- Projet réalisé en binôme pour le module R3.01.

## Licence

MIT License. 