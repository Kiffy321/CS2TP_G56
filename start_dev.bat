@echo off
echo ============================================
echo  Starting Laravel Development Server
echo ============================================
cd /d "C:\xampp\htdocs\CS2TP_G56"

echo.
echo Starting PHP server at http://localhost:8000
echo Starting Vite dev server...
echo.
echo Press Ctrl+C to stop.
echo.

:: Run both servers concurrently
start "Vite Dev Server" cmd /k "npm run dev"
php artisan serve
