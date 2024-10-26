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
        // Start the session to access session variables
        session_start();

        // Check if the user is logged in
        $isLoggedIn = isset($_SESSION['reader_id']);

        // Set the message and book count
        $this->data("message", "Welcome to the Book Library!");
        $this->data("book_count", count($this->repository->getTopBooks()));

        // Get the list of top-10 books from the repository
        $books = $this->repository->getTopBooks();
        $this->data("books", $books);

        // Pass the login status to the view
        $this->data("isLoggedIn", $isLoggedIn);

        // Render the home view
        $this->display("home");
    }
}
