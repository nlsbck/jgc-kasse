<?php

class DBConnection
{
    private $database;
    private $connection;
    public function __construct(string $server, string $database, string $user, string $password)
    {
        $this->setDatabase($database);
        try {
            $this->connection = new PDO("mysql:host=$server;db=$database", $user, $password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("USE `$database`");
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
        return $stmt->fetchAll();
    }

    public function exec($sql): int|false
    {
        return $this->connection->exec($sql);
    }

    /**
     * @return string
     */
    public function getDatabase(): string
    {
        return $this->database;
    }

    /**
     * @param string $database
     */
    public function setDatabase(string $database): void
    {
        $this->database = $database;
    }


}