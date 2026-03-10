@echo off
echo Running Laravel setup (XAMPP + MySQL)...
cd /d "C:\xampp\htdocs\CS2TP_G56"

echo.
echo Checking XAMPP MySQL is running...
C:\xampp\mysql\bin\mysqladmin.exe -u root ping >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: XAMPP MySQL is not running.
    echo Please start MySQL from the XAMPP Control Panel and try again.
    pause
    exit /b 1
)
echo XAMPP MySQL is running.

echo.
echo Checking PHP extensions...
php -r "echo extension_loaded('pdo_mysql') ? 'pdo_mysql: YES' : 'pdo_mysql: NO (Enable extension=pdo_mysql in C:\xampp\php\php.ini)'; echo PHP_EOL; echo extension_loaded('fileinfo') ? 'fileinfo: YES' : 'fileinfo: NO';"

echo.
echo Setting up environment file...
if not exist ".env" (
    copy ".env.example" ".env"
    echo Created .env from .env.example
    php artisan key:generate
)

echo.
echo Creating database if not exists...
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS regulus_jewelry CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo.
echo Running migrations...
php artisan migrate --force

echo.
echo Setup complete!
pause
