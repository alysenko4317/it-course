<?php

namespace Repository;

abstract class BaseRepository {
    protected $connect;
    protected $table;
    protected $primaryKey = 'id';  // за замовчуванням PRIMARY KEY - 'id'

    public function __construct($connect, $table) {
        $this->connect = $connect;
        $this->table = $table;
    }

    // Метод для отримання всіх записів
    public function getAll() {
        $sql = "SELECT * FROM {$this->table}";
        return $this->mapResults($this->connect->exec($sql));
    }

    // Метод для отримання запису за первинним ключем
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = $1";
        $result = $this->connect->execOne($sql, [$id]);
        return $this->mapResult($result);
    }

    // Метод для створення нового запису
    public function create(array $data) {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(function($k){ return '$' . $k; }, range(1, count($data))));
        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
        $this->connect->exec($sql, $values);

        return $this->connect->getLastId("{$this->table}_{$this->primaryKey}_seq");
    }

    // Метод для оновлення запису за первинним ключем
    public function update($id, array $data) {
        $set = [];
        foreach (array_keys($data) as $index => $field) {
            $set[] = "{$field} = $" . ($index + 2); // $2, $3, і т.д.
        }

        $setSql = implode(', ', $set);
        $values = array_values($data);
        array_unshift($values, $id); // Додаємо ID на перше місце

        $sql = "UPDATE {$this->table} SET {$setSql} WHERE {$this->primaryKey} = $1";
        return $this->connect->exec($sql, $values);
    }

    // Метод для видалення запису за первинним ключем
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = $1";
        return $this->connect->exec($sql, [$id]);
    }

    // Метод для мапінгу одного результату (для конкретних класів)
    protected abstract function mapResult($row);

    // Метод для мапінгу масиву результатів (для конкретних класів)
    protected function mapResults($rows) {
        $results = [];
        foreach ($rows as $row) {
            $results[] = $this->mapResult($row);
        }
        return $results;
    }
}
