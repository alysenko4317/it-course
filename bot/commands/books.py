from telegram import Update
from telegram.ext import ContextTypes
from services.api_client import get_books_from_api  # Импорт временной функции для получения книг


async def books(update: Update, context: ContextTypes.DEFAULT_TYPE):
    books_list = get_books_from_api()  # Getting the list of books from your API

    if books_list:
        message = ""
        for book in books_list:
            # Join the authors' names
            if book['authors']:
                authors = ", ".join([f"{author['firstName']} {author['lastName']}" for author in book['authors']])
            else:
                authors = "Unknown Author"

            # Extract the year from releaseDate if available
            release_year = f" ({book['releaseDate'][:4]})" if book['releaseDate'] else ""

            # Format each book
            message += f"*{book['name']}*\n"  # Bold for the book title
            message += f"_{authors}{release_year}_\n\n"  # Italic for authors with year in parentheses (if available)
    else:
        message = "No books available."

    # Use parse_mode='Markdown' to send the message with markdown formatting
    await update.message.reply_text(message, parse_mode='Markdown')

