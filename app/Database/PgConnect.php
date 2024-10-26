<?php

namespace Database;

use \Config\Config;

class PgConnect implements Connectable {

    private $connect;

    public function __construct(){
        $config = Config::getDatabase();

        // Create the connection string
        $connStr = "host=" . $config["host"] . " dbname=" . $config["database"] . 
                   " user=" . $config["username"] . " password=" . $config["password"] .
                   " port=" . $config["port"];

        // Connect to PostgreSQL
        $this->connect = pg_connect($connStr);

        if(!$this->connect){
            throw new \Exception("Failed PostgreSQL connect.");
        }

        // Set client encoding (charset)
        pg_set_client_encoding($this->connect, $config["charset"]);
    }

public function exec($sql, $prepare = []) {
    // Якщо є параметри для підстановки
    if (!empty($prepare)) {
        // Генеруємо унікальне ім'я для підготовленого запиту
        $queryName = uniqid('pg_query_');

        // Підготовка запиту
        $prepared = pg_prepare($this->connect, $queryName, $sql);
        if (!$prepared) {
            throw new \Exception(pg_last_error($this->connect));
        }

        // Виконання запиту з параметрами
        $result = pg_execute($this->connect, $queryName, $prepare);
    } else {
        // Виконання запиту без параметрів
        $result = pg_query($this->connect, $sql);
    }

    if (!$result) {
        throw new \Exception(pg_last_error($this->connect));
    }

    $data = [];

    // Якщо це SELECT запит, то отримуємо результати
    if (pg_num_rows($result) > 0) {
        while ($row = pg_fetch_assoc($result)) {
            $data[] = $row;
        }
    } else {
        // Якщо це маніпулятивний запит (INSERT, UPDATE, DELETE), повертаємо кількість рядків
        $data = pg_affected_rows($result);
    }

    pg_free_result($result);

    return $data;
}

    public function execOne($sql, $prepare = []){
        $result = $this->exec($sql, $prepare);

        if(!isset($result[0])) {
            return null;
        }

        return $result[0];
    }

    public function prepare($value){
        return pg_escape_string($this->connect, trim($value));
    }

    public function getLastId($sequenceName = null){
        // PostgreSQL does not have an equivalent of `mysqli_insert_id`.
        // You need to provide the sequence name explicitly to get the last inserted ID.
        if ($sequenceName) {
            $result = $this->execOne("SELECT currval('$sequenceName')");
            return $result['currval'];
        }

        return null;
    }

    public function close(){
        return pg_close($this->connect);
    }
}
