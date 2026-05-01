@echo off
echo Starting FPAS Development Environment...

:: Start the local PHP web server
start "FPAS Server" cmd /c "php artisan serve"

:: Start the Tailwind CSS / Vite compiler
::start "Vite Asset Compiler" cmd /c "npm run dev"

:: Start the automated Task Scheduler
start "FPAS Scheduler" cmd /c "php artisan schedule:work"

echo All background services are running!