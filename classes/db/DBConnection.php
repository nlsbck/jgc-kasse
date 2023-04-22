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
        $stmt = $this->connection->prepare("SELECT table_name FROM information_schema.tables WHERE TABLE_SCHEMA = ?");
        $stmt->execute([$this->database]);
        $fetched = $stmt->fetchAll();
        $tables = array();
        foreach ($fetched as $item) {
            $tables[] = $item[0];
        }
        return $tables;
    }
}