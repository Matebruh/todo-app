<?php

class Database
{
    private string $host = 'localhost';
    private string $dbName = 'todo_app';
    private string $username = 'root';
    private string $password = '';

    private ?PDO $connection = null;

    public function getConnection(): PDO
    {
        if ($this->connection === null) {

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=utf8mb4',
                $this->host,
                $this->dbName
            );

            $this->connection = new PDO(
                $dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return $this->connection;
    }
}