<?php

namespace Config;

class Config {

    private function __construct()
    {
    }

    public static function getDatabase() {
        return [
			"class" => "\\Database\\PgConnect",
			"host" => "postgres-db",  // Використовуйте ім'я контейнера
			"database" => "khpi",
			"port" => 5432,  // Це внутрішній порт, що відображений на 8432 для хоста
			"username" => "khpi",
			"password" => "khpi",
			"charset" => "utf8mb4",
        ];
    }

    public static function getRoutes() {
        return [
            "GET" => [
              [
                  "uri" => "",
                  "controller" => "\\Controller\\HomeController",
                  "action" => "index",
                  "params" => "",
              ], [
                    "uri" => "auth/telegram",
                    "controller" => "\\Controller\\UserController",
                    "action" => "auth",
                    "params" => "",
                ], [
                    "uri" => "logout",
                    "controller" => "\\Controller\\UserController",
                    "action" => "logout",
                    "params" => "",
                ], [
                    "uri" => "cabinet",
                    "controller" => "\\Controller\\CabinetController",
                    "action" => "index",
                    "params" => "",
                ],
            ],
            "CONSOLE" => [
                [
                    "uri" => "remove/auth/innactive",
                    "controller" => "\\Controller\\ConsoleController",
                    "action" => "removeAuth",
                    "params" => "",
                ],
            ],
        ];
    }
}