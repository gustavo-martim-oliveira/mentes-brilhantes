<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    private $host = 'localhost:3307';
    private $dbname = 'teste_backend';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->dbname,
                $this->username,
                $this->password,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Bad connection with database: ' . $e->getMessage();
            die();
        }

        return $this->conn;
    }
}