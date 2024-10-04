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

    public function init()
    {
        // Check if we're using the simpler route-based system
        if (isset($_GET['route'])) {
            $this->handleRouteFromGet();
        } else {
            $this->handleTraditionalRouting();
        }
    }

    public function handleTraditionalRouting()
    {
        // Get the request URI (e.g., /home or /home/index)
        $uri = $_SERVER['REQUEST_URI'];
    
        // Dynamically calculate the base path using the script location
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        $uri = str_replace($scriptName, '', $uri);
    
        // Remove any query string (e.g., ?param=value) from the URI
        $uri = parse_url($uri, PHP_URL_PATH);
    
        // Remove index.php from the URI if it exists
        $uri = str_replace('/index.php', '', $uri);
    
        // Remove the /it-proj/ subfolder from the URI if it exists
        $uri = str_replace('/it-proj', '', $uri); 
    
        // Split the URI into parts (e.g., /home or /home/index)
        $uriParts = explode('/', trim($uri, '/'));
    
        // Default controller and method
        $controller = 'HomeController';  // Default to HomeController
        $method = 'index';  // Default method is index
    
        // Check if we have a controller in the URI
        if (isset($uriParts[0]) && !empty($uriParts[0])) {
            $controller = ucfirst($uriParts[0]) . 'Controller'; // e.g., HomeController
        }

        // Check if a method is provided, otherwise default to 'index'
        if (isset($uriParts[1]) && !empty($uriParts[1])) {
            $method = $uriParts[1];  // e.g., index or another method
        }
    
        // Build the fully qualified controller class (with the correct namespace)
        $controllerClass = "\\Controller\\" . $controller;
    
        // Check if the controller class exists
        if (!class_exists($controllerClass)) {
            http_response_code(404);
            exit("Controller '$controllerClass' not found.");
        }
    
        // Instantiate the controller
        $controllerObject = new $controllerClass();
    
        // Check if the method exists in the controller
        if (!method_exists($controllerObject, $method)) {
            http_response_code(404);
            exit("Method '$method' not found in controller '$controllerClass'.");
        }
    
        // Call the method
        call_user_func([$controllerObject, $method]);
    }
    
    public function handleRouteFromGet() {
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
