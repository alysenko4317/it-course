<?php

// This PHP code implements a simple framework-like structure with a singleton pattern
// and dynamic class loading using an autoloader.
//
// 1. The ClassLoader is a singletone responsible for automatically loading class files
//    when they are needed, avoiding the need to manually include or require each class file.
//    The getInstance() method checks if an instance already exists. If not, it creates a new
//    one and registers an autoloader using spl_autoload_register.
//
//    The function spl_autoload_register in PHP is used to register one or more autoload functions,
//    which are automatically called whenever you try to instantiate a class or interface that hasn't
//    been defined or included yet. It allows PHP to automatically load classes without the need for
//    manually including or requiring the class files. In our case PHP will call ClassLoader::load()
//
// 2. The Route class represents the entry point of the application. It is also a singleton,
//    ensuring that only one instance is created. The init() method is where the routing and request
//    handling happen.

include_once(__DIR__ . "/Loader/ClassLoader.php");

// Security Risks: In a production environment, it’s a best practice to turn off displaying
//    errors to end-users. Exposing error messages to users can reveal sensitive information
//    about your codebase or server configuration.
//    Use display_errors=0 in production to ensure that errors are logged but not shown on the webpage.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

\Loader\ClassLoader::getInstance()->init();

\Loader\Route::getInstance()->init();