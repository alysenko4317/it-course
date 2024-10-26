<?php

namespace Repository;

use Model\Book;

class BookRepository extends BaseRepository {
    public function __construct($connect) {
        parent::__construct($connect, 'book');  // Вказуємо таблицю 'book'
    }

    // Метод для отримання топ-N книг за датою випуску
    public function getTopBooks($limit = 9) {
        // Формуємо SQL-запит для вибору топ-N книг
        $sql = "SELECT * FROM book ORDER BY release_date DESC LIMIT $1";
        $results = $this->connect->exec($sql, [$limit]);

        // Мапимо результати на моделі Book
        $books = [];
        foreach ($results as $row) {
            $books[] = $this->mapResult($row);
        }

        return $books;
    }
	
    // Реалізуємо мапінг рядка бази даних в модель Book
    protected function mapResult($row) {
        $book = new Book();
        $book->id = $row['id'];
        $book->code = $row['code'];
        $book->name = $row['name'];
        $book->releaseDate = $row['release_date'];
        return $book;
    }
}
