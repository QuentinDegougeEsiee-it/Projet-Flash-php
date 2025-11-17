
-----

<a href="https://git.io/typing-svg"><img src="https://readme-typing-svg.herokuapp.com?font=Fira+Code&pause=1000&color=F7F7F7&width=435&lines=%F0%9F%9A%80+Projet+Flash+PHP" alt="Typing SVG" /></a>
-----

Un projet d'école pour transformer un site statique en application web dynamique avec PHP, MySQL et un jeu interactif. L'objectif est de dynamiser le site en le connectant à une base de données, permettant une interaction complète des utilisateurs.

<p align="left">
  <img src="https://img.shields.io/badge/PHP-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP"/>
  <img src="https://img.shields.io/badge/MySQL-%234479A1.svg?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/>
  <img src="https://img.shields.io/badge/HTML5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5"/>
  <img src="https://img.shields.io/badge/CSS3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3"/>
</p>
<p align="left">
  <img src="https://img.shields.io/badge/Status-En%20Cours-yellow.svg?style=for-the-badge" alt="Status"/>
  <img src="https://img.shields.io/badge/contributors-3-brightgreen.svg?style=for-the-badge" alt="Contributors"/>
  <img src="https://img.shields.io/github/stars/YOUR_USERNAME/YOUR_REPO?style=for-the-badge&logo=github" alt="Stars"/>
  <img src="https://img.shields.io/github/forks/YOUR_USERNAME/YOUR_REPO?style=for-the-badge&logo=github" alt="Forks"/>
  <img src="https://img.shields.io/badge/license-MIT-blue.svg?style=for-the-badge" alt="License"/>
</p>

-----

## 📚 Sommaire

  * [👥 Notre Équipe](https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php?tab=readme-ov-file#-notre-équipe)
  * [✨ Fonctionnalités (Backlog)](https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php?tab=readme-ov-file#-fonctionnalit%C3%A9s-backlog)
  * [🛠️ Installation & Démarrage](https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php?tab=readme-ov-file#%EF%B8%8F-installation--d%C3%A9marrage)
  * [💻 Technologies Utilisées](https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php?tab=readme-ov-file#-technologies-utilis%C3%A9es)
  * [📁 Structure du Projet](https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php?tab=readme-ov-file#-structure-du-projet)
  * [🤝 Contribuer](https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php?tab=readme-ov-file#-structure-du-projet)
  * [📜 Licence](https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php?tab=readme-ov-file#-structure-du-projet)

-----

## 👥 Notre Équipe 

  * [Tristan](https://github.com/Trisrav)
  * [Emma](https://github.com/emma-nkn)
  * [Quentin](https://github.com/QuentinDegougeEsiee-it)

-----

## ✨ Fonctionnalités (Backlog)

Notre projet est découpé en plusieurs "Epics" pour organiser le développement.

### Epic 1 : Travaux Préparatoires

  * **Organisation :** Mise en place de l'architecture du projet, conversion des fichiers `.html` en `.php` et utilisation d'imports (`head`, `header`, `footer`).
  * **Base de données :** Création d'une fonction `connectToDbAndGetPdo` dans `utils/database.php` pour se connecter à la BDD et retourner l'objet PDO.

### Epic 2 : Rendre le site dynamique

  * **Navigation :** Mise en surbrillance de la page active dans le menu.
  * **Accueil :** Affichage de statistiques dynamiques (nombre de joueurs, etc.) récupérées depuis la base de données.
  * **Scores :** Page des scores affichant le nom du jeu, le pseudo, la difficulté et le score. La ligne du joueur connecté est mise en surbrillance.
  * **Filtre :** Ajout d'un champ de recherche sur la page des scores pour filtrer par pseudo.

### Epic 3 : Gestion des utilisateurs

  * **Inscription :** Formulaire d'inscription avec contrôles de données stricts (format email, pseudo unique de 4+ caractères, mot de passe de 8+ caractères avec chiffre, majuscule et caractère spécial). Le mot de passe est haché.
  * **Connexion :** Formulaire de connexion qui, en cas de succès, stocke l'ID de l'utilisateur dans `$_SESSION['userId']`.
  * **Profil :** Le nom du joueur connecté est affiché dans le header. Une page "Mon Compte" permet de :
      * Modifier l'email et le mot de passe.
      * Modifier la photo de profil via un formulaire d'upload. La photo est stockée dans `userFiles/{userId}/`.

### Epic 4 : Communication

  * **Contact :** Formulaire de contact qui envoie un email à l'administrateur.
  * **Chat :** Page de chat pour les utilisateurs connectés.
      * Affiche les messages des dernières 24h, du plus vieux au plus récent.
      * Les messages de l'utilisateur connecté sont en bleu, les autres en gris.
  * **API :** Affichage d'un GIF de chat aléatoire sur la page de chat, récupéré via l'API `https://api.thecatapi.com`.

-----

## 🛠️ Installation & Démarrage

Suivez ces étapes pour mettre en place le projet sur votre machine locale.

### Prérequis

  * Un serveur web local (Apache, Nginx) ou [PHP](https://www.php.net/downloads) (\>= 7.4)
  * Un système de gestion de base de données [MySQL](https://www.mysql.com/downloads/)

### Étapes

1.  **Cloner le dépôt**

    ```bash
    git clone https://github.com/QuentinDegougeEsiee-it/Projet-Flash-php.git
    cd VOTRE_REPO
    ```

2.  **Configuration de la Base de Données**

      * Importez le fichier `database.sql` (ou nom similaire) dans votre instance MySQL pour créer la structure des tables.
      * Renommez `utils/database.example.php` en `utils/database.php` (si un template est fourni) OU ouvrez `utils/database.php`.
      * Modifiez la fonction `connectToDbAndGetPdo` avec vos propres identifiants de base de données (hôte, nom de la BDD, utilisateur, mot de passe).

3.  **Lancer le serveur**
    Utilisez le serveur PHP intégré pour un développement facile :

    ```bash
    php -S localhost:8000
    ```

    Ouvrez ensuite `http://localhost:8000` dans votre navigateur.

-----

## 💻 Technologies Utilisées

  * **Backend :** PHP
  * **Base de données :** MySQL (via l'objet PDO)
  * **Frontend :** HTML5, CSS3
  * **API :** Consommation d'API REST (JSON)
  * **Gestion de version :** Git & GitHub

-----

## 📁 Structure du Projet

Voici l'arborescence des fichiers de notre projet :

```
.
├── .git/             # Dossier caché de Git
├── assets/           # Fichiers statiques (images, css, ...)
├── documentations/   # Documentations techniques
├── games/
│   └── memory/       # Dossier du jeu de mémoire
│       ├── index.php   # Page du jeu
│       └── scores.php  # Page des scores
├── partials/         # Vues partielles (includes)
│   ├── footer.php    # Pied de page
│   ├── head.php      # Balise <head>
│   └── header.php    # En-tête de page
├── userFiles/        # Fichiers uploadés par les utilisateurs
│   └── 1/            # Dossier par utilisateur
├── utils/            # Fichiers utilitaires
│   ├── common.php      # Appelé sur toutes les pages
│   ├── database.php    # Connexion BDD
│   ├── security.php    # Fonctions de sécurité
│   ├── userConnexion.php # Fonctions de connexion/déconnexion
│   └── validators.php  # Fonctions de contrôle des données
├── .gitignore        # Fichiers à exclure de Git
├── chat.php          # Page de chat
├── contact.php       # Page de contact
├── disconnect.php    # Page de déconnexion
├── index.php         # Page d'accueil
├── login.php         # Page de connexion
├── myAccount.php     # Page de gestion du compte
├── readme.md         # Documentation du projet
└── register.php      # Page d'inscription
```

-----

## 🤝 Contribuer

Les contributions sont les bienvenues \! Si vous souhaitez contribuer :

1.  **Forkez** le projet.
2.  Créez une nouvelle branche (`git checkout -b feature/ma-super-feature`).
3.  **Commitez** vos changements (`git commit -m 'Ajout de ma-super-feature'`).
4.  **Pushez** vers la branche (`git push origin feature/ma-super-feature`).
5.  Ouvrez une **Pull Request**.

-----

## 📜 Licence

Ce projet est distribué sous la Licence MIT. Voir le fichier `LICENSE` pour plus d'informations (si applicable).