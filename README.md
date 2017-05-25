Projet SteamBanque
version 1.0.2 beta - 25 mai 2017
    Corrections de divers bug CSS
    Importation de clients avec un solde initial différent (voir importation CSV) 

version 1.0.1 beta
  sylvain 18 décembre 2016 - 2 mars 2017
  temps de développement = 39h00


Permet de gérer une banque dans un univers alternatif pour la durée d'un jeu de 
rôles grandeur nature. A la base le monde était d'ambiance steampunk, d'où le nom.

Installation : 
 - Copier les fichiers dans un serveur web via FTP (filezilla par exemple).
 - Personnaliser le fichier inc/config.dist.php avec les paramètres fournis par votre
   hébergeur en renommant ce fichier inc/config.php
 - Sur le serveur de base de données, importer le script de création docs/steambanque.sql
    (le projet a été développé sous mariadb/mysql, il n'a pas été testé avec un autre sgbd)
 - Connectez-vous sur le site. Il y a un utilisateur par défaut identifiant : admin,
    mot de passe : 123123
et voilà !

Limitations : 
 - Chaque joueur ne peut avoir qu'un seul compte avec une autorisation de découvert.
 - Les comptes sont gérés en valeur entière (pas de centimes).
 - Il n'y a pas d'agios pour les découverts.
 - Un joueur peut visualiser son compte, effectuer des transactions avec un autre
     joueur, modifier son mot de passe
 - Un administrateur (oui, il peut y en avoir plusieurs) peut :     
    - voir tous les soldes des comptes, (avec le nom, et horodatage de la dernière connexion)
    - voir les dernières transactions (avec des filtres)
    - supprimer un client (avec un avertissement, mais sans annulation possible).
    - effectuer une transaction pour un autre joueur (par exemple un PNJ).
        Attention, il n'y a pas de controles de l'état de PNJ.
    - importer un fichier text/CSV des joueurs au format 
        numcompte;prenom;nom;codepin
        L'entête du fichier doit être présent.
    - Ajouter un client 'à la main'
    - Modifier les paramètres d'un client (mot de passe, nom, prénom, autorisation de découvert)
    - Modifier un grand nombre de paramètre de l'application (titre, monnaie, 
        symbole, découvert autorisé par défaut, qualité du mot de passe, etc.)

Me contacter 
    Vous souhaitez me signaler un bug, ou ajouter une fonctionnalité,
    Vous trouvez cette application bouleversante et vous souhaitez me féliciter,
    ou tout simplement, vous voulez me faire un don

    Contactez-moi à lelfe.sylvain@laposte.net

Licence : Creative Common 3 By-NC-SA Pas d'utilisation commerciale, partage à l'identique et droit de citation.

L'image de fond est protégée par la même licence pour http://www.myfreetextures.com/
