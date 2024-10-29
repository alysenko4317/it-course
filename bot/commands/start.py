import os
import uuid
import aiohttp
from telegram import Update
from telegram.ext import ContextTypes

# Get environment variables
BASE_URL = os.getenv("BASE_URL")
PUBLIC_URL = os.getenv("PUBLIC_URL")
SECRET_TOKEN = os.getenv("SECRET_TOKEN")

async def start(update: Update, context: ContextTypes.DEFAULT_TYPE):
    telegram_id = update.message.chat_id
    user = update.message.from_user
    binding_token = str(uuid.uuid4())  # Generate a unique token

    # Extract user data from Telegram
    first_name = user.first_name
    last_name = user.last_name
    username = user.username
    phone = None  # Optionally, can be retrieved if available

    # URL of the internal API to save the binding token and Telegram user data
    api_url = f"{BASE_URL}/api/link"

    # Payload to be sent to the server
    payload = {
        "telegram_id": telegram_id,
        "binding_token": binding_token,
        "first_name": first_name,
        "last_name": last_name,
        "username": username,
        "phone": phone  # Optional: if available
    }
    headers = {
        "Authorization": f"{SECRET_TOKEN}"
    }

    # Send a request to the server to save the binding token and Telegram user data
    async with aiohttp.ClientSession() as session:
        try:
            async with session.post(api_url, json=payload, headers=headers) as response:

                # Log the HTTP response status code
                print(f"Response status: {response.status}")

                # Log the response body
                response_text = await response.text()  # Get response body as text
                print(f"Response body: {response_text}")


                if response.status == 200:
                    # Generate a link for the user to bind their account (using PUBLIC_URL)
                    link = f"{PUBLIC_URL}/link-account?token={binding_token}"
                    print(link)

                    # Form a message to send to the user
                    message = (
                        "Hello! This is the Library 51 bot.\n\n"
                        "To link your account on the library's website, please click on the following link: "
                        f"[Link your account]({link})"
                    )

                    # Send the user a message with a clickable link
                    await update.message.reply_text(
                        message,
                        parse_mode='Markdown'
                    )
                else:
                    # Handle error if the server failed to save the data
                    await update.message.reply_text(
                        'An error occurred while linking the account. Please try again later.'
                    )
        except aiohttp.ClientError as e:
            # Handle network errors
            await update.message.reply_text(
                'An error occurred while connecting to the server. Please try again later.'
            )
