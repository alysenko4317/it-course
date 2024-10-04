<?php

namespace Repository;

use Model\Book;

class BookRepository
{
    public function getTopBooks()
    {
        // Simulating a list of top books (in the future, you may fetch this from a database)
        return [
            new Book("The Great Gatsby", "F. Scott Fitzgerald", 1925),
            new Book("To Kill a Mockingbird", "Harper Lee", 1960),
            new Book("1984", "George Orwell", 1949),
            new Book("Pride and Prejudice", "Jane Austen", 1813),
            new Book("The Catcher in the Rye", "J.D. Salinger", 1951),
            new Book("Moby Dick", "Herman Melville", 1851),
            new Book("War and Peace", "Leo Tolstoy", 1869),
            new Book("The Odyssey", "Homer", "8th Century BC"),
            new Book("Crime and Punishment", "Fyodor Dostoevsky", 1866),
            new Book("The Lord of the Rings", "J.R.R. Tolkien", 1954),
        ];
    }
}
