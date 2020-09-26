<u>Mode de déploiement</u>

- Outil nécéssaires pour faire tourner l'application:

	- Une plateforme de développement Web comportant PHP >=7.3, Apache et MySQL >= 5.7
		=> Exemple: Wamp, Mamp, Xamp
	- Une base de données fonctionnelle et accessible en locale
	- composer
	- un invité de ligne de commande en mode console
		=> Ex cmd, terminal, POWERSHELL
	- un accès internet

- Migrer l'application sur son pc en local:

	1 - Cloner le répertoire du git avec la commande une commande git clone "https://url_du_git"
	
	2 - Importer le fichier migrations/voyage_db.sql sur sa base de données locale
	
	3 - Renseigner le fichier config.ini à la racine du projet avec ses identifiants à la base de données
	
	4 - Dans un invité de commande se positionner à la racine du projet et lancer la commande suivante:
		
		- composer install

	5 - Créér le dossier uploads/ à la racine du projet

- Tests unitaire

Il faut lancer la commande "./vendor/bin/phpunit tests" pour lancer les tests.

