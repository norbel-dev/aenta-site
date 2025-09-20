#!/bin/bash

# Configuración
APP_DIR="/var/www/aentasite"
BRANCH="main"
LOG_FILE="/var/www/aentasite/storage/logs/deploy.log"

echo "===== [$(date)] Iniciando despliegue =====" >> $LOG_FILE

cd $APP_DIR || exit

# Obtener últimos cambios
echo "→ Haciendo git pull..." >> $LOG_FILE
git reset --hard >> $LOG_FILE 2>&1
git clean -df >> $LOG_FILE 2>&1
git pull origin $BRANCH >> $LOG_FILE 2>&1

# Instalar dependencias PHP
echo "→ Ejecutando composer install..." >> $LOG_FILE
composer install --no-dev --optimize-autoloader >> $LOG_FILE 2>&1

# Migraciones
echo "→ Ejecutando migraciones..." >> $LOG_FILE
php artisan migrate --force >> $LOG_FILE 2>&1

# Compilar assets
echo "→ Ejecutando npm install & build..." >> $LOG_FILE
npm install >> $LOG_FILE 2>&1
npm run build >> $LOG_FILE 2>&1

# Limpiar caches
echo "→ Limpiando cachés..." >> $LOG_FILE
php artisan config:clear >> $LOG_FILE 2>&1
php artisan cache:clear >> $LOG_FILE 2>&1
php artisan route:clear >> $LOG_FILE 2>&1

echo "===== [$(date)] Despliegue finalizado =====" >> $LOG_FILE
