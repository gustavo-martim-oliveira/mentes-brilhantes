<?php

namespace Models;

use Config\Database;
use PDO;

class Builder {
    
    private $pdo;
    private $select = '*';
    private $from;
    private $where = [];
    private $orderBy;
    private $limit;
    private $offset;

    public function __construct()
    {
        $database = new Database;
        $this->pdo = $database->connect();
    }

    public function select(string $columns)
    {
        $this->select = $columns;
        return $this;
    }

    public function from(string $table)
    {
        $this->from = $table;
        return $this;
    }

    public function where(string $column, string $operator, $value)
    {
        $this->where[] = [$column, $operator, $value];
        return $this;
    }

    public function orderBy(string $column, string $direction = 'asc')
    {
        $this->orderBy = [$column, $direction];
        return $this;
    }

    public function limit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset)
    {
        $this->offset = $offset;
        return $this;
    }

    public function get()
    {
        $query = "SELECT {$this->select} FROM {$this->from}";

        if ($this->where) {
            $query .= " WHERE";
            $whereValues = [];
            foreach ($this->where as $where) {
                $query .= " {$where[0]} {$where[1]} :{$where[0]} AND";
                $whereValues[$where[0]] = $where[2];
            }
            $query = rtrim($query, " AND");
        }

        if ($this->orderBy) {
            $query .= " ORDER BY {$this->orderBy[0]} {$this->orderBy[1]}";
        }

        if ($this->limit) {
            $query .= " LIMIT {$this->limit}";
        }

        if ($this->offset) {
            $query .= " OFFSET {$this->offset}";
        }

        $statement = $this->pdo->prepare($query);
        if (isset($whereValues) && is_array($whereValues)) {
            $statement->execute($whereValues);
        } else {
            $statement->execute();
        }

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    public function create(array $data) {
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_map(function ($value) {
            return ":$value";
        }, array_keys($data)));
        $query = $this->pdo->prepare("INSERT INTO {$this->from} ($columns) VALUES ($values)");
        $query->execute($data);
        $lastId = $this->pdo->lastInsertId();
        return $lastId;
    }



    public function update(int $id, array $data) {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = :$key";
            $data[":$key"] = $value;
        }
        $updates = implode(',', $updates);
        $query = $this->pdo->prepare("UPDATE {$this->from} SET $updates WHERE id = $id");
        $query->execute($data);

        return $this->where('id', '=', $id)->get()[0];
    }

    public function delete(){
        
        if ($this->where) {
            $query = " WHERE";
            $whereValues = [];
            foreach ($this->where as $where) {
                $query .= " {$where[0]} {$where[1]} :{$where[0]} AND";
                $whereValues[$where[0]] = $where[2];
            }
            $query = rtrim($query, " AND");

            $query = "DELETE FROM {$this->from} $query";

            $statement = $this->pdo->prepare($query);
            if (isset($whereValues) && is_array($whereValues)) {
                return $statement->execute($whereValues);
            } else {
               return $statement->execute();
            }
        }
    }
}