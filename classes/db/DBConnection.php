<?php

class DBConnection
{
    private $database;
    private $connection;
    public function __construct(string $server, string $database, string $user, string $password)
    {
        $this->database = $database;
        try {
            $this->connection = new PDO("mysql:host=$server;db=$database", $user, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connections to Database failed.";
            echo $e;
        }
    }

    public function get_tables(): array
    {
        return $this->executeSelect("SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA = ?", [$this->database]);
    }

    public function executeSelect(string $query, array $parameters = []): array
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($parameters);
        $fetched = $stmt->fetchAll();
        $tables = array();
        foreach ($fetched as $item) {
            $tables[] = $item[0];
        }
        return $tables;
    }

    public function exec($sql): int|false
    {
        return $this->connection->exec($sql);
    }
}