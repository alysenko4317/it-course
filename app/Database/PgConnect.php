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
            throw new \Exception("Failed PostgreSQL connection.");
        }

        // Set client encoding (charset)
        pg_set_client_encoding($this->connect, $config["charset"]);
    }

    public function exec($sql, $prepare = []) {
        // Check if there are parameters to prepare
        if (!empty($prepare)) {
            // Generate unique name for the prepared statement
            $queryName = uniqid('pg_query_');

            // Prepare the query (using numbered placeholders $1, $2, ...)
            $prepared = pg_prepare($this->connect, $queryName, $sql);
            if (!$prepared) {
                throw new \Exception(pg_last_error($this->connect));
            }

            // Execute the prepared query with the provided values
            $result = pg_execute($this->connect, $queryName, array_values($prepare));
        } else {
            // Execute the query without parameters
            $result = pg_query($this->connect, $sql);
        }

        if (!$result) {
            throw new \Exception(pg_last_error($this->connect));
        }

        $data = [];

        // If SELECT query, fetch results
        if (pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $data[] = $row;
            }
        } else {
            // For non-SELECT queries, return the number of affected rows
            $data = pg_affected_rows($result);
        }

        pg_free_result($result);

        return $data;
    }

    // Method to execute a single result query
    public function execOne($sql, $prepare = []){
        $result = $this->exec($sql, $prepare);

        if(!isset($result[0])) {
            return null;
        }

        return $result[0];
    }

    // Prepare values to escape potentially harmful characters
    public function prepare($value){
        return pg_escape_string($this->connect, trim($value));
    }

    // Get the last inserted ID using a sequence
    public function getLastId($sequenceName = null){
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
