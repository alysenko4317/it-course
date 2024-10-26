<?php

namespace Controller\api;

use Database\Connect;
use Repository\BookRepository;

class BookController extends Controller
{
    private $repository;

    public function __construct()
    {
        $connect = Connect::getInstance();
        $this->repository = new BookRepository($connect);
    }

    public function getAllBooks()
    {
        $books = $this->repository->getAllWithAuthors();
        $this->jsonResponse($books);
    }
	
    public function getTopBooks()
    {
        $books = $this->repository->getTopBooks();
        $this->jsonResponse($books);
    }
}