FROM php:8.2-alpine

# Inštalácia SQLite a potrebných závislostí
RUN apk add --no-cache sqlite sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Nastavenie pracovného adresára
WORKDIR /var/www/html

# Inštalácia lightweight PHP servera
RUN echo "alias serve='php -S 0.0.0.0:8080'" >> /root/.bashrc

# Exposnutie portu
EXPOSE 8080

# Spustenie PHP servera pri štarte kontajnera
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www/html"]
