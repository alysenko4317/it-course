<?php

namespace Model;

class Book {
    public $id;
    public $code;
    public $name;
    public $releaseDate;
    public $authors = []; // Array of Author objects
}

