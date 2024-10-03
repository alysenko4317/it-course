@echo off

:: Build the Docker image
docker build -t lab2 .\

:: Run the Docker container with a custom port and auto-remove on shutdown
docker run -d --rm -p 5442:5432/tcp --name lab2-container lab2

:: Wait a moment to ensure the container starts properly
timeout /t 5 /nobreak >nul

:: Run psql inside the running Docker container
docker exec -it lab2-container psql -U khpi -d khpi

:: Pause to keep the command prompt open (optional)
pause
