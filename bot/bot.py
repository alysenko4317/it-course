import os
import sys

# Add the current directory to the module search path
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from telegram.ext import Application, CommandHandler
from commands.start import start  # Import the /start command handler
from commands.books import books  # Import the /books command handler

# Get the token from environment variables
TOKEN = os.getenv('TOKEN')


def main():
    # Check if the token is loaded correctly
    if TOKEN is None:
        raise ValueError("Token not found in environment variables")

    # Create the application for the bot
    application = Application.builder().token(TOKEN).build()

    # Add command handlers
    application.add_handler(CommandHandler("start", start))
    application.add_handler(CommandHandler("books", books))

    # Start the bot and begin polling for updates
    application.run_polling()


if __name__ == '__main__':
    main()
