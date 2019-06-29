# Ryoko - Projet WEB de fin de CIR 2
Réalisé par : Fatih KOYUNCU, Alexandre THOMAS

### Contexte
L’objectif du projet est de réaliser un site pour un organisme de voyage
permettant à celui-ci de proposer à ses clients de sélectionner un ou plusieurs
voyages.
L’agence de voyages souhaite avoir à la fois un front (partie accessible aux
clients) et un back (partie réservée à l’administration du site).

### Installation
Le projet nécessite que les logiciels apache 2, php 7 et MySQL soient correctement installés. On considère être sur un système d'exploitation linux Debian.

1. Déplacer le contenu de ce dossier (fichiers au même niveau que le readme) dans le répertoire désiré.
	 Pour la suite de l'installation, on appelera ce répertoire [PROJECT].
	 Exemple : [PROJECT] = /var/www/html ou [PROJECT] = /var/www/sites/groupe11

1. Deux VirtualHosts doivent être ajoutés afin de permettre l'accès aux parties front et back
	 Voici le fichier de configuration d'apache à mettre en place.

	```
  Listen 80

	NameVirtualHost *:80

	<VirtualHost *:80>
		ServerName www.monsitedevoyage.groupe11.isen

		ServerAdmin alexandre.thomas@isen-ouest.yncrea.fr
		DocumentRoot [PROJECT]/user
		DirectoryIndex index.php

		Alias /travels [PROJECT]/travels
		<Directory "[PROJECT]/travels">
			Options Indexes FollowSymLinks MultiViews
			AllowOverride None
			Order allow,deny
			Allow from all
		</Directory>

		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.log combined
	</VirtualHost>

	<VirtualHost *:80>
		ServerName admin.monsitedevoyage.groupe11.isen

		ServerAdmin alexandre.thomas@isen-ouest.yncrea.fr
		DocumentRoot [PROJECT]/admin
		DirectoryIndex index.php

		Alias /travels [PROJECT]/travels
		<Directory "[PROJECT]/travels">
			Options Indexes FollowSymLinks MultiViews
			AllowOverride None
			Order allow,deny
			Allow from all
		</Directory>

		ErrorLog ${APACHE_LOG_DIR}/error.log
		CustomLog ${APACHE_LOG_DIR}/access.log combined
	</VirtualHost>
	 ```

	 Cette configuration redirige les requêtes vers le front et le back aux fichiers php respectifs. De plus, l'alias
	 permet de rendre accessible le dossier travels/ depuis les deux côtés.

2. Les droits d'écriture et de lecture doivent être donnés du dossier travels/ doivent être donné à apache
	 Pour cela, veuillez exécuter la commande (en étant dans le dossier [PROJECT]):
	 ```
	 	sudo chown www-data travels/
	 ```

3. Pour installer la base de données, veuillez exécuter la commande (en étant dans le dossier [PROJECT]):
	 ```
	 	mysql < Config/database.sql
	 ```
	 Le script s'occupe de créer une base, de la structurer et de créer un utilisateur ayant les droits dessus.

4. Enfin, veuillez démarrer/relancer apache et mysql avec la commande :
	```
		sudo service apache2 restart; sudo service mysql restart
	```

5. Le site web devrait maintenant être fonctionnel


### Peuplage
Afin de vérifier le bon fonctionnement du site, il est possible d'y ajouter des données.
1. Pour peupler la base de données, veuillez exécuter la commande (en étant dans le dossier [PROJECT]):
	```
		mysql < Config/data.sql
	```

2. Pour ajouter les images correspondantes aux voyages, veuillez exécuter la commande (en étant dans le dossier [PROJECT]) :
	```
		cp Config/travelsImg/* travels/
	```

3. Le site web devrait maintenant contenir plusieurs exemples de données

Les identifiants pour accéder à la partie administrateur sont :
 - Login : admin
 - Mot de passe : ryokoAdmin
