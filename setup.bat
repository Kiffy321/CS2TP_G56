@echo off
echo ============================================
echo  Laravel Project Setup (XAMPP + MySQL)
echo ============================================
cd /d "C:\xampp\htdocs\CS2TP_G56"

echo.
echo [0/5] Checking XAMPP MySQL is running...
C:\xampp\mysql\bin\mysqladmin.exe -u root ping >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: XAMPP MySQL is not running.
    echo Please start MySQL from the XAMPP Control Panel and try again.
    pause
    exit /b 1
)
echo XAMPP MySQL is running.

echo.
echo [1/5] Setting up environment file...
if not exist ".env" (
    copy ".env.example" ".env"
    echo Created .env from .env.example
) else (
    echo .env already exists, skipping.
)

echo.
echo [2/5] Generating application key...
php artisan key:generate
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Failed to generate application key.
    echo Make sure PHP is in your PATH and vendor directory exists.
    echo Run: composer install
    pause
    exit /b 1
)

echo.
echo [3/5] Creating MySQL database if it does not exist...
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE IF NOT EXISTS regulus_jewelry CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Could not create database. Check your MySQL credentials in .env
    pause
    exit /b 1
)
echo Database ready.

echo.
echo [4/5] Running database migrations and seeders...
php artisan migrate --force
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Migrations failed.
    echo Make sure pdo_mysql is enabled in your XAMPP php.ini:
    echo   C:\xampp\php\php.ini
    echo The line "extension=pdo_mysql" must NOT be commented out.
    pause
    exit /b 1
)
php artisan db:seed --force
if %ERRORLEVEL% NEQ 0 (
    echo WARNING: Seeding failed. You can run it manually: php artisan db:seed
)

echo.
echo [5/5] Installing npm dependencies and building frontend...
npm install
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: npm install failed.
    pause
    exit /b 1
)
npm run build
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: npm build failed.
    pause
    exit /b 1
)

echo.
echo ============================================
echo  Setup complete! Run start_dev.bat to start.
echo  Visit: http://localhost:8000
echo ============================================
pause
