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
        // Check if we're using the simpler route-based system (via get-parameter like ?route=controller/action)
        if (isset($_GET['route'])) {
            $this->handleRouteFromGet();
        } else {
            $this->handleTraditionalRouting();
        }
    }

    // Handle traditional routing using URI segments (like controller/action)
    private function handleTraditionalRouting()
    {
        // Get the request URI (e.g., /home or /home/index)
        $uri = $_SERVER['REQUEST_URI'];

        // Dynamically calculate the base path using the script location (to support placing the app in subfolder like /var/www/html/it-proj)
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);

        // If the script is in the root, set base path accordingly
        if ($scriptName !== '/') {
            $uri = str_replace($scriptName, '', $uri);
        }

        // Remove any query string (e.g., ?param=value) from the URI
        $uri = parse_url($uri, PHP_URL_PATH);

        // Remove index.php from the URI if it exists
        $uri = str_replace('/index.php', '', $uri);

        // Split the URI into parts (e.g., /home or /home/index)
        $uriParts = explode('/', trim($uri, '/'));

        // Default controller and method
        $controller = 'HomeController';
        $method = 'index';

        // Check if we have a controller in the URI
        if (isset($uriParts[0]) && !empty($uriParts[0])) {
            $controller = ucfirst($uriParts[0]) . 'Controller'; // e.g., HomeController
        }

        // Check if a method is provided, otherwise default to 'index'
        if (isset($uriParts[1]) && !empty($uriParts[1])) {
            $method = $uriParts[1];  // e.g., index or another method
        }

        $this->dispatch($controller, $method);  // Call the controller and method
    }

    // Handle simpler routing using the "route" GET parameter (like ?route=controller/action)
    private function handleRouteFromGet()
    {
        // The code assumes that $_GET["route"] contains a controller name and a method name, separated by a /.
        if (!isset($_GET["route"])) {
            exit('No route provided.');
        }
    
        // Sanitize and process the route (to avoid security risks)
        $route = htmlspecialchars($_GET['route'], ENT_QUOTES, 'UTF-8');
        $data = explode("/", $route);
    
        // Ensure we have both controller and method in the route
        if (count($data) < 2) {
            exit('Invalid route format.');
        }
    
        // Do not append "Controller" again, just use what is provided in the ?route= parameter
        $controller = ucfirst($data[0]);  // e.g., HomeController
        $method = $data[1];               // e.g., index
    
        $this->dispatch($controller, $method);   // Call the controller and method
    }

    // Dispatch the request to the appropriate controller and method
    private function dispatch($controller, $method)
    {
        // Build the fully qualified controller class name (with the correct namespace)
        $controllerClass = "\\Controller\\" . $controller;

        // Check if the controller class exists
        if (!class_exists($controllerClass)) {
            http_response_code(404);
            exit("Controller '$controllerClass' not found.");
        }

        // Instantiate the controller object
        $controllerObject = new $controllerClass();

        // Check if the method exists in the controller
        if (!method_exists($controllerObject, $method)) {
            http_response_code(404);
            exit("Method '$method' not found in controller '$controllerClass'.");
        }

        // Call the method
        try {
            call_user_func([$controllerObject, $method]);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
