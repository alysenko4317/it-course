<?php

namespace Framework;

class Session {

    /**
     * Start the session
     */
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Set a session value
     */
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session value
     */
    public static function get($key) {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Destroy the session
     */
    public static function destroy() {
        session_start();
        session_unset();
        session_destroy();
    }

    /**
     * Regenerate session ID for security
     */
    public static function regenerate() {
        session_regenerate_id(true);
    }

    /**
     * Set session cookie params (Optional)
     */
    public static function setCookieParams($lifetime = 3600, $path = "/", $domain = "", $secure = false, $httponly = true) {
        session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
    }
}
