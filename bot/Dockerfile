# Use the official Python slim image
FROM python:3.9-slim

# Install the required dependencies
RUN pip install python-telegram-bot requests aiohttp

# Set the working directory
WORKDIR /app

# Command to run the bot
CMD ["python", "bot.py"]

