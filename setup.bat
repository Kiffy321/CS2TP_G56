@echo off
echo ============================================
echo  Laravel Project Setup
echo ============================================
cd /d "C:\xampp\htdocs\CS2TP_G56"

echo.
echo [1/3] Running database migrations...
php artisan migrate --force
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Migrations failed.
    echo Make sure pdo_sqlite is enabled in your php.ini:
    echo   C:\Program Files\php-8.4.6\php.ini
    echo Uncomment the line: ;extension=pdo_sqlite
    pause
    exit /b 1
)

echo.
echo [2/3] Installing npm dependencies...
npm install
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: npm install failed.
    pause
    exit /b 1
)

echo.
echo [3/3] Building frontend assets...
npm run build
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: npm build failed.
    pause
    exit /b 1
)

echo.
echo ============================================
echo  Setup complete! Run start_dev.bat to start.
echo ============================================
pause
