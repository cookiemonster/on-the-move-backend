# OnTheMove-Backend
Dit project is gebaseerd op [dit](https://github.com/francescomalatesta/laravel-api-boilerplate-jwt) github project.
De JWT authenticatie is eruit en vervangen door authenticatie d.m.v RocketChat en is de backend voor de #on-the-move-client

[![BCH compliance](https://bettercodehub.com/edge/badge/cookiemonster/on-the-move-backend?branch=master)](https://bettercodehub.com/)


## Installatie
De backend is geïnstalleerd op een kale Ubuntu Machine. Hieronder de instructies stap voor stap.

```
sudo apt-get install -y php7.1 php7.1-curl php7.1-common php7.1-cli php7.1-mysql php7.1-mbstring php7.1-fpm php7.1-xml php7.1-zip

systemctl start php7.1-fpm
systemctl enable php7.1-fpm

sudo apt-get install -y mariadb-server mariadb-client
systemctl start mysql
systemctl enable mysql
mysql_secure_installation

sudo apt-get install -y composer

cd /etc/nginx/
sudo nano sites-available/onthemove-backend
```
```
server {
        listen 80;
        listen [::]:80 ipv6only=on;

        # Log files for Debugging
        access_log /var/log/nginx/onthemove-backend-access.log;
        error_log /var/log/nginx/onthemove-backend-error.log;

        # Webroot Directory for Laravel project
        root /home/beheerder/onthemove-backend/public;
        index index.php index.html index.htm;

        # Your Domain Name
        server_name otm-backend.innovatie.ml;

        location / {
                try_files $uri $uri/ /index.php?$query_string;
        }

        # PHP-FPM Configuration Nginx
        location ~ \.php$ {
                try_files $uri =404;
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
                fastcgi_index index.php;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                include fastcgi_params;
        }
}
```
```
sudo ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/
systemctl restart nginx

cd /home/beheerder
git clone --nieuwe url---
sudo chown -R www-data:root /home/beheerder/onthemove-backend
sudo chmod 755 /home/otm/onthemove-backend/storage/
cd onthemove-backend
composer install
```
Mysql
    CREATE USER “USERNAME”
    CREATE DATABASE “DATABASENAME”
    GRANT ALL PRIVILEGES ON “USERNAME”.* to “DATABASENAME”

cd /home/otm/onthemove-backend
cp .env.example .env
php artisan key:generate


Nu moeten de gegevens worden ingevuld in een `.env` file. Zie ook `.env.example`

cd /home/otm/onthemove-backend
php artisan migrate
