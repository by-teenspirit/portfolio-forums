# portfolio-forums

Portfolio des créations faites pour des forums Forumactif — codes et graphismes —
sous forme d'un petit site PHP avec espace d'administration.

## Ce que fait le site

Trois pages publiques :

| Page | Contenu |
|---|---|
| `index.php` | l'accueil |
| `codes.php` | les codes, filtrables par type |
| `graph.php` | les graphismes |

Le filtre de `codes.php` reprend les catégories du métier : *maquette non codée*,
puis la structure d'un forum (page d'accueil, catégories, QEEL, affichage des
sujets, d'un sujet, du profil, barre de navigation, liste des membres) et les
fiches (fiche RP, fiche personnage/répertoire, fiche de liens).

Une fois connectée, une barre d'administration apparaît : `admin.php` pour
ajouter une création, `upload.php` pour l'enregistrer avec son fichier, son
type, sa description et son éventuel lien GitHub, `edit.php` pour la modifier.
L'authentification passe par `login.php`, qui vérifie le mot de passe avec
`password_verify` contre la table `admins`.

## Structure

```text
├── index.php codes.php graph.php    les pages publiques
├── login.php logout.php             l'authentification
├── admin.php upload.php edit.php    l'espace d'administration
├── includes/header.php footer.php   la coquille commune et la navigation
├── config.php                       la connexion PDO
├── sql/database.sql                 le schéma de la base
├── style.css
└── uploads/                         les fichiers envoyés depuis l'admin
```

## Faire tourner le site

Il faut PHP avec PDO MySQL, et un serveur local (MAMP, WAMP, ou
`php -S localhost:8000`).

1. créer la base `portfolio_forums` ;
2. importer `sql/database.sql` ;
3. ajuster l'hôte, l'utilisateur et le mot de passe dans `config.php` ;
4. insérer un compte dans `admins`, avec un mot de passe hashé par
   `password_hash()` — `login.php` ne reconnaît que ce format ;
5. servir le dossier et ouvrir `index.php`.

## À savoir

- **`sql/database.sql` est vide.** Le schéma des tables `codes`, `graphismes` et
  `admins` n'est nulle part : il faut le recréer à la main à partir des requêtes
  de `upload.php` et `codes.php` avant que le site puisse tourner ailleurs.
- `config.php` contient des identifiants en dur (`root`, mot de passe vide).
  C'est le réglage MAMP par défaut ; il est à remplacer, et à sortir du dépôt,
  pour toute mise en ligne.
- `upload.php` enregistre le fichier envoyé sous `time() . "_" . nom d'origine`
  sans vérifier son type ni son extension. L'envoi est réservé à l'admin
  connectée, mais sur un serveur public ce point est à durcir avant d'ouvrir le
  formulaire.
