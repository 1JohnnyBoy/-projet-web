# Projet Web — Catalogue de Smartphones

Application web de gestion d'un catalogue de smartphones, développée en PHP/MySQL avec XAMPP.

---

## Prérequis

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP)
- Navigateur web

---

## Installation

1. Placer le dossier `projet-web` dans `C:/xampp0/htdocs/`
2. Démarrer Apache et MySQL depuis le panneau XAMPP
3. Créer les deux bases de données via phpMyAdmin :

### Base `smartphones`

```sql
CREATE DATABASE smartphones;
USE smartphones;

CREATE TABLE le_c (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Marque VARCHAR(100),
    modèle VARCHAR(100),
    couleur VARCHAR(100),
    photo VARCHAR(255),
    prix DECIMAL(10,2),
    stockage INT
);
```

### Base `email_base`

```sql
CREATE DATABASE email_base;
USE email_base;

CREATE TABLE adresse_email (
    id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(30),
    Mail VARCHAR(255),
    MDP VARCHAR(255)
);
```

4. Accéder à l'application : `http://localhost/projet-web/index.php`

---

## Structure du projet

```
projet-web/
│
├── index.php            # Page d'accueil — recherche et affichage des smartphones
├── index.css            # Styles de la page d'accueil (responsive)
│
├── ajout.php            # Formulaire d'ajout d'un smartphone
├── ajout.css            # Styles de la page d'ajout
│
├── modification.php     # Formulaire de mise à jour du prix et du stockage
├── modification.css     # Styles de la page de modification
│
├── suppression.php      # Formulaire de suppression d'un smartphone
├── suppression.css      # Styles de la page de suppression
│
├── connexxion.php       # Formulaire de connexion utilisateur
├── connexxion.css       # Styles de la page de connexion
│
├── inscription.php      # Formulaire d'inscription utilisateur
├── inscription.css      # Styles de la page d'inscription
│
├── index.html           # Page HTML statique (point d'entrée alternatif)
│
├── photo_telephones.webp  # Image de bannière de la page d'accueil
│
└── uploads/             # Dossier des photos de smartphones uploadées
    ├── iPhone 16 noir.jpg
    ├── iphone 17 pro max.webp
    ├── S26 noir.jpg
    ├── Fold 6 Silver Shadow.png
    ├── flip 7.jpg
    ├── Mate X7.png
    ├── P50 Pro Gold.jpg
    ├── p80 pro.png
    ├── Xiaomi 17 Ultra.webp
    ├── pixel 10 pro.jpg
    ├── pink 9 pro pixel.jpg
    ├── Ice Blue.webp
    └── Air Bleu-ciel.jpg
```

---

## Fonctionnalités

### Catalogue (`index.php`)
- Affichage de tous les smartphones sous forme de cartes
- Recherche par marque
- Affichage : photo, marque, modèle, prix, couleur
- Design responsive (smartphone, tablette, desktop)

### Ajout (`ajout.php`)
- Ajout d'un smartphone avec : marque, modèle, couleur, photo, prix, stockage
- Upload de photo vers le dossier `uploads/`
- Vérification que le modèle n'existe pas déjà en base

### Modification (`modification.php`)
- Mise à jour du prix et du stockage d'un smartphone par son modèle

### Suppression (`suppression.php`)
- Suppression d'un smartphone par sa marque et son modèle

### Inscription (`inscription.php`)
- Création de compte avec nom, email et mot de passe
- Mot de passe haché avec `password_hash()`
- Vérification que l'email n'est pas déjà utilisé

### Connexion (`connexxion.php`)
- Authentification par email et mot de passe
- Redirection vers `index.php` après connexion

---

## Bases de données

| Base          | Table           | Colonnes principales                              |
|---------------|-----------------|---------------------------------------------------|
| `smartphones` | `le_c`          | Marque, modèle, couleur, photo, prix, stockage    |
| `email_base`  | `adresse_email` | Username, Mail, MDP                               |

---

## Technologies utilisées

- **PHP** — logique serveur et interactions avec la base de données (PDO)
- **MySQL** — stockage des données
- **HTML / CSS** — interface utilisateur
- **XAMPP** — environnement de développement local
