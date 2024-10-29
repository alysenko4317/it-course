<?php

namespace Config;

class Config {

    private function __construct()
    {
    }

    public static function getDatabase() {
        return [
			"class" => "\\Database\\PgConnect",
			"host" => "postgres-db",  // ім'я відповідного контейнера
			"database" => "khpi",
			"port" => 5432,  // це внутрішній порт, що відображений на 8432 для доступа з хоста
			"username" => "khpi",
			"password" => "khpi",
			"charset" => "utf8mb4",
        ];
    }

    public static function getRoutes() {
        return [
        "GET" => [
            [
                "uri" => "details",
                "controller" => "\\Controller\\AboutController",
                "action" => "details",
                "params" => "",
            ], [
                "uri" => "about",
                "controller" => "\\Controller\\AboutController",
                "action" => "index",
                "params" => "",
            ], [
                "uri" => "",
                "controller" => "\\Controller\\HomeController",
                "action" => "index",
                "params" => "",
            ], [
                "uri" => "auth/telegram",
                "controller" => "\\Controller\\ReaderController",
                "action" => "auth",
                "params" => "",
            ], [
                "uri" => "logout",
                "controller" => "\\Controller\\ReaderController",
                "action" => "logout",
                "params" => "",
            ], [
                "uri" => "cabinet",
                "controller" => "\\Controller\\ReaderController",
                "action" => "cabinet",
                "params" => "",
            ], [
                "uri" => "login",
                "controller" => "\\Controller\\ReaderController",
                "action" => "login",
                "params" => "",
            ], [
                "uri" => "register",
                "controller" => "\\Controller\\ReaderController",
                "action" => "register",
                "params" => "",
            ], [
                "uri" => "forgot-password",
                "controller" => "\\Controller\\ReaderController",
                "action" => "forgotPassword",
                "params" => "",
            ],
			
			[
                "uri" => "api/books",
                "controller" => "\\Controller\\api\\BookController",
                "action" => "getAllBooks",
                "params" => "",
            ],
			
			[
                "uri" => "api/top-books",
                "controller" => "\\Controller\\api\\BookController",
                "action" => "getTopBooks",
                "params" => "",
            ],
			
			[
                "uri" => "link-account",
                "controller" => "\\Controller\\ReaderController",
                "action" => "linkTelegramAccount",
                "params" => "",
            ],
        ],
        "POST" => [
            [
                "uri" => "login",
                "controller" => "\\Controller\\ReaderController",
                "action" => "loginPost",
                "params" => "",
            ], [
                "uri" => "register",
                "controller" => "\\Controller\\ReaderController",
                "action" => "registerPost",
                "params" => "",
            ], [
                "uri" => "forgot-password",
                "controller" => "\\Controller\\ReaderController",
                "action" => "forgotPasswordPost",
                "params" => "",
            ], [
                "uri" => "reset-password",
                "controller" => "\\Controller\\ReaderController",
                "action" => "resetPasswordPost",
                "params" => "",
            ],
			
			[
                "uri" => "api/link",
                "controller" => "\\Controller\\api\\TelegramController",
                "action" => "linkTelegramAccountPost",
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