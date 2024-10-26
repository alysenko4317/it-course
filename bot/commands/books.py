from telegram import Update
from telegram.ext import ContextTypes
from services.api_client import get_books_from_api  # Импорт временной функции для получения книг

async def books(update: Update, context: ContextTypes.DEFAULT_TYPE):
    books_list = get_books_from_api()  # Getting the list of books (temporarily static)

    if books_list:
        message = ""
        for book in books_list:
            message += f"{book['title']}, Author: {book['author']}, Year: {book['year']}\n"
    else:
        message = "No books available."

    await update.message.reply_text(message)

