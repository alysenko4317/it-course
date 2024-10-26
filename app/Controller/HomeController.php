<?php

namespace Controller;

use Database\Connect; // Правильний простір імен для класу Connect
use Repository\BookRepository;

class HomeController extends Controller {

    private $repository;

    public function __construct()
    {
        $connect = Connect::getInstance(); // Отримуємо з'єднання через синглтон
        $this->repository = new BookRepository($connect); // Передаємо з'єднання в репозиторій
    }

    public function index()
    {
        // Встановлюємо привітальне повідомлення і кількість книг
        $this->data("message", "Welcome to the Book Library!");
        $this->data("book_count", count($this->repository->getTopBooks()));

        // Отримуємо список топ-10 книг з репозиторія
        $books = $this->repository->getTopBooks();
        $this->data("books", $books);

        $this->display("home");   // рендеринг представлення (view)
    }
}
