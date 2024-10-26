<?php

namespace Repository;

abstract class BaseRepository {
    protected $connect;
    protected $table;
    protected $primaryKey = 'id';  // Default PRIMARY KEY

    public function __construct($connect, $table) {
        $this->connect = $connect;
        $this->table = $table;
    }

    // Fetch all records
    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->mapResults($this->connect->exec($sql));
    }

    // Fetch a record by primary key
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = $1";
        $result = $this->connect->execOne($sql, [$id]);
        return $this->mapResult($result);
    }

    // Create a new record
    public function create(array $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(function($k){ return '$' . $k; }, range(1, count($data))));
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $this->connect->exec($sql, $values);

        return $this->connect->getLastId("{$this->table}_{$this->primaryKey}_seq");
    }

    // Update a record by primary key
    public function update($id, array $data) {
        $set = [];
        foreach (array_keys($data) as $index => $field) {
            $set[] = "{$field} = $" . ($index + 2); // $2, $3, etc.
        }

        $setSql = implode(', ', $set);
        $values = array_values($data);
        array_unshift($values, $id); // Prepend ID to the values array

        $sql = "UPDATE {$this->table} SET {$setSql} WHERE {$this->primaryKey} = $1";
        return $this->connect->exec($sql, $values);
    }

    // Delete a record by primary key
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = $1";
        return $this->connect->exec($sql, [$id]);
    }

    // Map one result to the specific model (abstract)
    protected abstract function mapResult($row);

    // Map multiple results to the specific model
    protected function mapResults($rows) {
        $results = [];
        foreach ($rows as $row) {
            $results[] = $this->mapResult($row);
        }
        return $results;
    }
}
