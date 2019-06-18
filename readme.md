# Ryoko - Projet WEB de fin de CIR 2

### Installation
On considère être dans le dossier du projet Ryoko/

1. Le projet nécessite que apache 2, php et MySQL soient correctement installés
2. Pour mettre en place la base de données merci d'utiliser le fichier Config/database.sql. Celui-ci va créer la base, les tables et un utilisateur
3. Afin de faire fonctionner les interfaces utilisateur et administrateur, merci de configurer les VirtualHosts tels que :
	- L'adresse www.monsitedevoyage.groupe11.isen redirige vers le fichier index.php à la racine du projet
	- L'adresse admin.monsitedevoyage.groupe11.isen redirige vers le fichier index-admin.php à la racine du projet
