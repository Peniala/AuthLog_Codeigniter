# AuthLog_Codeigniter

Page web à partir de Codeigniter sur un programme de visualisation et d'insertion dans la base de donnée du contenu du fichier /var/log/auth.log.
- Utilisation d'un script php à lancer à partir du crontab ( insertion de la tâche "cron.txt" dans /etc/crontab )
- Utilisation de la base de donnée mit et application du tableau session ( avec la source "session.sql" )

Modification nécessaire :

#Projet
- la baseUrl du programme dans Projet/app/Config/App.php ( selon le ServerName de votre programme );
- la valeur de l'utilisateur, le mot de passe et la base de donnée dans Projet/app/Config/Database.php;

#Script  PHP
- l'utilisateur et le mot de passe pour se connecter à la base de donnée sur le script auth.php ( valeur par défaut : "root" , "" );

#Crontab
- le chemin vers l'emplacement du script PHP;
