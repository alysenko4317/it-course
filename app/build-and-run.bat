@echo off
REM Build Docker images
echo Building Docker images...
docker-compose build

REM Start the Docker containers
echo Starting Docker containers...
docker-compose up -d

REM Wait for a few seconds to ensure containers are started
timeout /t 10 >nul

REM Open the default browser and navigate to the specified URL
echo Opening browser...

REM start "" "http://localhost:8200?route=HomeController/index"
start "" "http://localhost:8200/home/"

echo Done.
