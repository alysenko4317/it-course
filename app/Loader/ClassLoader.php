<?php

namespace Loader;

class ClassLoader {

    private static $instance;

    // Конструктор є приватним для реалізації паттерну синглтон
    private function __construct()
    {
    }

    // Створюємо єдиний екземпляр класу ClassLoader
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new ClassLoader();
        }

        return self::$instance;
    }

    // Реєструємо автозавантажувач
    public function init() {
        spl_autoload_register([self::$instance, "load"]);
    }

    // Автозавантаження класів
    public function load($name) {
        // Формуємо шлях до файлу на основі простору імен
        $filePath = $_SERVER["DOCUMENT_ROOT"] . "/" . str_replace("\\", "/", $name) . ".php";

        // Логування шляху до завантаженого файлу
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/logs/loaders.log", $filePath . "\n", FILE_APPEND);

        // Перевіряємо, чи існує файл перед його включенням
        if (file_exists($filePath)) {
            include_once($filePath);
        } else {
            // Логування у випадку відсутності файлу
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/logs/loaders.log", "File not found: " . $filePath . "\n", FILE_APPEND);
        }
    }
}
