import os
import requests

# Get the base URL from the environment variables, with a fallback to localhost
BASE_URL = os.getenv("BASE_URL", "http://localhost:8200")

# Function to get the list of books via the API
def get_books_from_api():
    try:
        # Send a GET request to the /api/books endpoint
        response = requests.get(f"{BASE_URL}/api/top-books")
        response.raise_for_status()  # Raise an exception if the request failed
        
        # Parse the JSON response (assuming the API returns books as a JSON array)
        books = response.json()
        return books
    
    except requests.RequestException as e:
        # Log the error and return an empty list if the request fails
        print(f"Error fetching books from API: {e}")
        return []
