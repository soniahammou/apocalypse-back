### installation

1. se mettre a la racine : cd /var/www/html 
2. cloner le repo : git clone 
3. creation de la BDD a la racine du projet : 
   - `cp .env .env.local` 
   - `nano .env.local` -> le APP_Secret a modifier  :
   -`APP_ENV=prod`si on le passe en prod : on ne verra pas les dump 
   -`APP_SECRET=4d1eca570a0ec1d6204668b540a2762b` : c'est unique donc il faut modifier avc d'autres chaine de caractere au hasard
   -`DATABASE_URL` : se créer un utilisateur et un mdp sécurisé et verifier la version du serveur
4. créer un utilisateur et un MDP : mysql est deja installé donc : `sudo mysql` 
6. ensuite : `CREATE USER 'apocalypse'@'localhost' IDENTIFIED BY '6q595XmCKm';`
7. ensuite :`GRANT ALL PRIVILEGES ON *.* TO 'apocalypse'@'localhost' WITH GRANT OPTION;`
8. on sort : `exit`
9. en faisant un `composer install` : ne pas faire de composer update car si on a developper des fonctionnalités qui ne fonctionne pas dans une autre version ca risque de crashé ( le code sur la machine sera en php8.3 et pas le code qu'on a testé): liste les paquets existant, puis il va filtrer avec grep pour garder toutes les lignes avec php dedans, et tee va ecrire dans un fichier  : `dpkg -l | grep php | tee packages.txt`
10. sauvegarge tout les paquet de la machine ou php est ecrit dedans `cat packages.txt`
11. on dit a apt qu'on veut rajouter` sudo add-apt-repository ppa:ondrej/php`
12. commande pour s'assurer que tout les paquets soient à jour `sudo apt update`
14.` sudo apt install libapache2-mod-php8.3`
15. `sudo a2enmod php8.3`
16. je regarde les module installer : puis je desactive `sudo a2dismod php8.1`
17. 13. on relance acpache : `sudo systemctl restart apache2`
18. php --version : on regarde si c'est bien installé 
19. composer install 
20. si on a un message d'erreur nous demandant d'installer quelque chose on l'install ex : ext-xml : `sudo apt install php8.3-xml`
21. `sudo apt install php8.3-mysql` 
22. php bin/console database:doctrine:create 
23. php bin/console do:mi:mi 
24. php bin/console do:fi:lo : on est en environnement de prod donc les fixtures sont installé que en dev il faut : 
    cahrger un script sql. pour utiliser les fixtures on reste en dev dans le nano .env.local 
25. `sudo mysql` si dans notre adminer on a " extension introuvable" `show databases` `show tables`

ensuite on créer un virtual host : 
1. `cd /etc/apache2/site-availables`
2. on rajoute le projet qu'on veut sudo nano le nom de notre dossier :` apo-calypse-back.conf`  
3. on ecrit : 

```bash
<VirtualHost *:80>
    # Adresse (nom de domaine) sur laquelle on va aller pour accéder à l'application
    # ATTENTION, bien remplacer {{PSEUDO-GITHUB}} par votre pseudo GitHub !
    ServerName back.{{PSEUDO-GITHUB}}-server.eddi.cloud
    # Chemin de l'application (racine du serveur web)
    # ATTENTION, bien remplacer {{PSEUDO-GITHUB}} par votre pseudo GitHub !
    DocumentRoot /var/www/html/{{le nom du dossier du projet}}/public

    # Emplacement logs Apache
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```
4. cd vers le nom de notre projet : puis wd et on aurra le chemin d'acces : c'est 
ici qu'on devra mettre le chemin dans le virtual host DocumentRoot /var/www/html/{{le nom du dossier du projet}}/public
5.`sudo a2ensite nom du dossier repo` puis 
`sudo systemctl reload apache2`
6. si on a un probeleme d'acces :( sur la page http on a forbudden) : `sudo chmod -R student:www-data .` ca change le prorprietaire de maniere recursive, on fait un `ll ` sur le projet pour que ça change 
7. sudo chmod g+x public/index.php si le index.php n'a pas les droit
8. sudo nano /etc/apache2/sites-availables/nomdudossier
9. si on fait un ll sur le dossier et qu'on a student student : on a un pb de droit : il faut faire un `sudo chmown -R student:www-data .`
10. si on a un probleme de cache on fait un 