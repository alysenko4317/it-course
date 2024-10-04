<?php

namespace Controller;

class Controller {

    private $data;

    public function __construct()
    {
        $this->data = [];
    }

    // Method to load model dynamically
    public function loadModel($title) {
        $path = $_SERVER["DOCUMENT_ROOT"] . "/Model/" . $title . ".php";
        if (file_exists($path)) {
            include_once($path);
            $this->$title = new $title(); // Create an instance of the model dynamically
        } else {
            // Handle error if model is not found
            throw new \Exception("Model $title not found.");
        }
    }

    // Function to set data for the view
    protected function data($variable, $data) {
        $this->data[$variable] = $data;
    }

    // Function to render the view
    protected function display($title) {
        // Extract data safely to variables
        foreach ($this->data as $variable => $data) {
            $$variable = $data; // Dynamically create variables from $this->data array
        }

        // Include the view file. Use __DIR__ to dynamically locate the View folder
        $viewPath = __DIR__ . "/../View/" . $title . ".php";
        
        //$viewPath = $_SERVER["DOCUMENT_ROOT"] . "/View/" . $title . ".php";
        if (file_exists($viewPath)) {
            include_once($viewPath);
        } else {
            throw new \Exception("View $title not found.");
        }
    }
}