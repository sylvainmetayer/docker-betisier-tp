# Betisier-TP

DUT Informatique 2ème Année. Ce site est disponible à l'adresse suivante : [Betisier de Sylvain Metayer](http://betisier.sylvainmetayer.fr).

## 1- Informations
- Les mots interdits doivent être constitué au minimum de 3 lettres, il s'agit d'un réglage MySQL. [Détails ici](http://stackoverflow.com/a/17797003)
- Le fichier "simulationMail.txt" doit avoir les droits rw-, car des écritures et lecture sont faites sur ce fichier.
- Dans le jeu d'essais initial (script SQL importé), une erreur est présente. En effet, la citation "Tous les 4, vous commencez à me casser les pieds !" est validée (cit_valide = 1) mais la date de validation de citation (cit_date_valide) est NULL.
- Dans le jeu d'essai initial, table citation, une erreur dans la structure de la table est présente. En effet, le "cit_valide" est un "bit(1)" alors qu'il devrait être un "char(1)"
- L'étudiante "Sophie Delmas" (per_num=53) possède des citations sur elle (per_num), a validé des citation (per_num_valide), et est étudiante, donc a déposé des citations (per_num_etu). Ce comportement ne devrait normalement pas être possible, mais est normalement géré par le site.

## 2- Fonctionnalités demandées
- Conception Objet (Classe, Manager, PDO, ..)
- Programmation modulaire exigée
- Gestion des droits d'accès aux différentes fonctionnalités (connexion et droits d'accès)
- Listage, modification et suppression des villes
- Listage, ajout, modification et suppression de personne
- Liste, ajout, suppression, et validation de citation
- Lors de l'ajout d'une citation, certains mots sont interdits (index fulltext)
- Une citation ne peut-être affichée publiquement et ouverte au vote que si elle a été approuvée par un administrateur
- Possiblité pour les élèves de voter pour des citations
- Le site doit être valide W3C (HTML et CSS)

## 3- Fonctionnalités supplémentaires

- Tableaux triables
- Gestion des erreurs via des exceptions
- Gestion des mots interdits (ajout/suppression/modification)
- Contrôle des numéros de téléphone
- Contrôle de validité des emails (via la fonction filter_var de php)
- Changement du titre de la page de façon dynamique (javascript)
- Affichage aléatoire d'un avatar pour les détails d'une personne
- Affichage d'une phrase aléatoire lors de l'ajout d'une citation
- Il est possible de saisir les dates à l'aide d'un calendrier (jquery)
- Salutation personnalisée selon l'heure
- Simulation d'un formulaire de contact
  - SMTP indisponible sur le serveur de rendu du TP, donc simulation dans un fichier texte.
- Affichage en Markdown pour l'admin des demande de contact reçus
- Lors de l'inscription, interdiction d'utiliser un mot de passe trop simple ([Plus d'informations ici](http://goo.gl/YP4xEh))
- Une personne connectée peut changer son mot de passe
- On masque les détails d'une personne aux utilisateurs non connectés
- Test du référencement (Essayez de rechercher "betisier IUT" ou "betisier sylvain metayer" sur Google)
- Il n'est pas possible de saisir du javascript dans les champs de saisie (empeche d'executer du code js)

## 4- Mise en service
1. Cloner le dépôt [Betisier](https://github.com/sylvainmetayer/Betisier-TP)
2. Importer la script "admin/betisier.sql" dans une base de données.
2. Executer le script "admin/pwd.sql" dans la base de données créée précédemment.
3. Configurer le fichier "include/config.inc.php" dont le modèle se trouve ci-dessous
4. S'assurer que les fichiers "admin/ideesCitations.txt" et "admin/simulationMail.md" existent.

###Structure des fichiers de configurations
"include/config.inc.php" : Le grain de sel est utilisé pour générer un hash du mot de passe. Plus il est complexe, plus votre hash sera résistant !
```
define('DBHOST', "");
define('DBNAME', "");
define('DBUSER', "");
define('DBPASSWD', "");
define('GRAIN_SEL', "");
define('ENV','dev'); //env ou prod
```

".htaccess" : Ce fichier permet de restreindre l'accès au site, selon des règles établies. Le chemin est à adapter, mais doit être absolu.
```
#On interdit le listage des répertoires
Options -Indexes

<Files "README.md">
deny from all
</Files>
```
