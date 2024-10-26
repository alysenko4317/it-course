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
    protected function display($title, $viewData = []) {
        // Ensure $this->data is an array (avoid null)
        if (!is_array($this->data)) {
            $this->data = []; // Initialize to empty array if it's null
        }

        if (is_array($viewData)) {
            $this->data = array_merge($this->data, $viewData);
        }
        
        // Extract data safely to variables
        foreach ($this->data as $variable => $data) {
            $$variable = $data; // Dynamically create variables from $this->data array
        }

        // Build the view path using __DIR__ to locate the view folder dynamically
        $viewPath = __DIR__ . "/../View/" . $title . ".php";

        // Check if the view file exists before including it
        if (file_exists($viewPath)) {
            include_once($viewPath);
        } else {
            throw new \Exception("View $title not found.");
        }
    }
    
    protected function redirect($url) {
        // Ensure that no headers have been sent before attempting to redirect
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit();  // Ensure no further code is executed
        } else {
            // If headers are already sent, use JavaScript as a fallback
            echo "<script>window.location.href = '" . htmlspecialchars($url) . "';</script>";
            echo "<noscript><meta http-equiv='refresh' content='0;url=" . htmlspecialchars($url) . "'></noscript>";
            exit();
        }
    }
    
}