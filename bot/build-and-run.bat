@echo off

echo Building Docker image for the Telegram bot...
docker build -t telegram-bot .

echo Stopping existing container if running...
docker stop telegram-bot-container > nul 2>&1

echo Running Docker container with .env file...
docker run -d --rm --name telegram-bot-container -v %cd%:/app --env-file .env telegram-bot

echo Docker container started successfully.

