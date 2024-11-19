### installation

1. Se connecter sur la VM serveur
2. Se rendre à la racine du dossier html : `cd /var/www/html`
3. Cloner le projet : `git clone nom-du-repo`
4. Créer la BDD a la racine du projet :
   - Créer le fichier .env.local en dupliquant le .env : `cp .env .env.local`
   - Ouvrir le fichier avec nano pour le modifier : `nano .env.local`
   - Dans la ligne `APP_Secret` : modifier les derniers caractères par d'autres caractères au hasard (il faut simplement que la chaîne de caractère soit différente de celle qui existe initialement)
   - Compléter la ligne `DATABASE_URL` correspondant à MariaDB en indiquant un utilisateur et son mdp + le nom de la BDD + la bonne version de MariaDB
   - Sortir avec ctrl X et enregistrer en tapant yes
5. Créer l'utilisateur dans mysql et lui donner les droits sur la BDD :
   - mysql est normalement déjà installé, on peut donc utiliser : `sudo mysql`
   - Lancer les commandes suivantes (sans oublier les ;) : 
     - `CREATE USER 'apocalypse'@'localhost' IDENTIFIED BY '6q595XmCKm';`
     - `GRANT ALL PRIVILEGES ON *.* TO 'apocalypse'@'localhost' WITH GRANT OPTION;`
   - on sort avec : `exit`
6. Faire un `composer install`
   (On obtient une erreur mais attention : ne pas faire de composer update pour éviter les problèmes de versions entre le développement en local et le déploiement sur le serveur)
7. Récupérer les paquets php existant :
   ```bash 
   dpkg -l 
   grep php 
   tee packages.txt
   cat packages.txt
   ```
   (liste les paquets existant + filtre pour garder toutes les lignes avec php + les copie dans le fichier packages.txt + ouvre le fichier en lecture)
8. Exécuter la commande suivante pour ajouter les paquets PHP : `sudo add-apt-repository ppa:ondrej/php`
9. Installer le mod d'Apache pour PHP3.8 : ` sudo apt install libapache2-mod-php8.3`
10. Activer la version 8.3 et désactiver la version actuelle (8.1 dans mon cas) de PHP :
   ```bash
   sudo a2enmod php8.3
   sudo a2dismod php8.1
   ````
11. Relancer Apache : `sudo systemctl restart apache2`
12. Vérifier si la bonne version s'est installée et activée : `php --version`
13. Relancer un `composer install`
14. En cas de message d'erreur demandant d'installer ext-xml :
    - lancer la commander : `sudo apt install php8.3-xml`
    - refaire un `composer install`
15. Installer mysql pour PHP8.3 : `sudo apt install php8.3-mysql`
16. Créer la BDD et migrer via Doctrine :
    ```bash
    php bin/console database:doctrine:create 
    php bin/console do:mi:mi
    php bin/console do:fi:lo 
    ```
    En cas d'erreur au lancement des commandes : retirer "php" et commencer directement à "bin/console"
17. Pour vérifier si la BDD est bien créée :
    ```bash
    sudo mysql
    show databases;
    use nom-de-votre-bdd;
    show tables;
    exit
    ```
Créer le virtual host :
1. Se placer dans le dossier : `cd /etc/apache2/sites-available`
2. Rajouter un fichier .conf avec le nom du dossier du projet qu'on veut déployer : `sudo nano nom-du-dossier-projet.conf`
3. Copier et compléter dans le fichier vierge :
    ```bash
    <VirtualHost *:80>
        # Adresse (nom de domaine) sur laquelle on va aller pour accéder à l'application
        # ATTENTION, bien remplacer {{PSEUDO-GITHUB}} par votre pseudo GitHub !
        ServerName nom-du-projet.{{PSEUDO-GITHUB}}-server.eddi.cloud
        # Chemin de l'application (racine du serveur web)
        # ATTENTION, bien remplacer {{PSEUDO-GITHUB}} par votre pseudo GitHub !
        DocumentRoot /var/www/html/{{le nom du dossier du projet}}/public
    
        # Emplacement logs Apache
        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
    ```
4. Démarrer le virtual host et relancer Apache :
    ```bash
    sudo a2ensite nom-du-dossier-projet
    sudo systemctl reload apache2
    ```
5. Tester la page de démarrage dans le navigateur : nom-du-projet.{{PSEUDO-GITHUB}}-server.eddi.cloud
6. En cas de problème d'accès, gérer les droits : 
   - `sudo chown -R student:www-data .`
   - `sudo chmod g+x public/index.php`
7. Relancer Apache pour éviter les soucis de cache : `sudo systemctl reload apache2`