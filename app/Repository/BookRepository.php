<?php

namespace Repository;

use Model\Book;
use Model\Author;

class BookRepository extends BaseRepository {
    public function __construct($connect) {
        parent::__construct($connect, 'book');  // Вказуємо таблицю 'book'
    }

    // Метод для отримання топ-N книг разом з авторами
    public function getTopBooks($limit = 10) {
        return $this->getBooksWithAuthors("ORDER BY b.release_date DESC LIMIT $1", [$limit]);
    }

    // Метод для отримання всіх книг разом з авторами
    public function getAllWithAuthors() {
        return $this->getBooksWithAuthors(""); // Без обмеження за кількістю
    }

    // Універсальний метод для отримання книг і авторів
    private function getBooksWithAuthors($extraSql = "", $params = []) {
        // Формуємо SQL-запит для вибору книг і їх авторів
        $sql = "SELECT b.*, a.first_name, a.last_name, a.id as author_id
                FROM book b
                LEFT JOIN writtenby wb ON b.id = wb.book_id
                LEFT JOIN author a ON wb.author_id = a.id
                $extraSql";
        $results = $this->connect->exec($sql, $params);

        // Мапимо результати на моделі Book
        $books = [];
        foreach ($results as $row) {
            $bookId = $row['id'];
            if (!isset($books[$bookId])) {
                // Якщо книга ще не додана, створюємо модель книги
                $books[$bookId] = $this->mapResult($row);
            }
            // Додаємо автора до книги
            if ($row['author_id']) {
                $author = new Author();
                $author->id = $row['author_id'];
                $author->firstName = $row['first_name'];
                $author->lastName = $row['last_name'];
                $books[$bookId]->authors[] = $author;
            }
        }

        return array_values($books); // Повертаємо масив книг
    }

    // Реалізуємо мапінг рядка бази даних в модель Book (з авторами)
    protected function mapResult($row) {
        $book = new Book();
        $book->id = $row['id'];
        $book->code = $row['code'];
        $book->name = $row['name'];
        $book->releaseDate = $row['release_date'];
        $book->authors = [];  // Ініціалізуємо масив авторів
        return $book;
    }
}
