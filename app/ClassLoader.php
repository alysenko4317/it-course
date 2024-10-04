<?php

// When you use this ClassLoader, any time a class is called, PHP will attempt to load it based
// on the logic in the load() function. Be sure that all your files are correctly named and that
// the directory structure matches the namespaces of the classes.

class ClassLoader {

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ClassLoader();
            spl_autoload_register([self::$instance, "load"]);
        }
        return self::$instance;
    }

    public function load($name) {
        
        // Use the directory of ClassLoader.php as the base directory
        $baseDir = __DIR__ . "/";

        // Replace namespace separators with directory separators
        $path = $baseDir . str_replace("\\", "/", $name) . ".php";

        // a simple file existence check in the load() method to make sure the file exists
        // before attempting to include it; this helps prevent potential errors;
        if (file_exists($path)) {
            include_once($path);
        } else {
            // Optional: error handling
            throw new Exception("File not found for class: $name at $path");
        }
    }
}
