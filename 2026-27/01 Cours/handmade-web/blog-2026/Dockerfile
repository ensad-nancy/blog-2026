# Dockerfile pour un site PHP simple
FROM php:8.2-cli

# Installer les extensions PHP si besoin
RUN docker-php-ext-install pdo pdo_mysql

# Copier tout le projet dans le conteneur
COPY . /var/www/html

# Définir le dossier de travail
WORKDIR /var/www/html

# Exposer le port que Render va utiliser
EXPOSE 10000

# Lancer le serveur PHP
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]