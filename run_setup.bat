@echo off
echo Running Laravel setup...
cd /d "C:\xampp\htdocs\CS2TP_G56"

echo Checking PHP extensions...
php -r "echo extension_loaded('pdo_sqlite') ? 'pdo_sqlite: YES' : 'pdo_sqlite: NO'; echo PHP_EOL; echo extension_loaded('fileinfo') ? 'fileinfo: YES' : 'fileinfo: NO';"

echo.
echo Running migrations...
php artisan migrate --force

echo.
echo Setup complete!
pause
