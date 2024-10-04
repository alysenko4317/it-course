<?php

namespace Controller;

use Repository\BookRepository;

class HomeController extends Controller {

    private $repository;

    public function __construct()
    {
        $this->repository = new BookRepository();
    }

    public function index()
    {
        // Set welcome message and book count
        $this->data("message", "Welcome to the Book Library!");
        $this->data("book_count", count($this->repository->getTopBooks()));

        // Get the list of top-10 books from the repository
        $books = $this->repository->getTopBooks();
        $this->data("books", $books);

        $this->display("home");   // render the view
    }
}