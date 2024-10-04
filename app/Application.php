<?php

class Application {

    private static $instance;

    // The singleton pattern implementation.
    // The class is instantiated only once via getInstance() and cannot be instantiated
    // directly due to the private constructor.
    private function __construct() {
    }

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new Application();
        }

        return self::$instance;
    }

    public function init() {
        // The code assumes that $_GET["route"] contains a controller name and a method name, separated by a /.
        if (!isset($_GET["route"])) {
            exit('No route provided.');
        }
    
        // The htmlspecialchars() function in PHP is used to convert special characters to their corresponding
        // HTML entities, which prevents them from being interpreted as HTML or JavaScript code. This is important
        // for outputting user input safely on web pages, protecting against cross-site scripting (XSS) attacks.
        $route = htmlspecialchars($_GET['route'], ENT_QUOTES, 'UTF-8');

        $data = explode("/", $route);
    
        // It’s a good idea to validate the explode() result to make sure it contains both
        // parts (controller and method). Otherwise, if the URL doesn't match the expected
        // format, you may get a Notice: Undefined offset error when accessing $data[1].
        if (count($data) < 2) {
            exit('Invalid route format.');
        }
    
        // Dynamically instantiating a class and invoking a method based on URL parameters
        // is powerful but can also be dangerous, as it opens the door to potential security
        // vulnerabilities like remote code execution. We should ensure that:
        //   - The classes and methods being called exist.
        //   - The classes and methods are allowed to be accessed this way (i.e., not private or internal methods).

        $class = "\\Controller\\" . $data[0];
    
        if (!class_exists($class)) {
            exit("Controller $class not found.");
        }
    
        $controller = new $class();
    
        if (!method_exists($controller, $data[1])) {
            exit("Method {$data[1]} not found in $class.");
        }
    
        try {
            echo $controller->{$data[1]}();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
