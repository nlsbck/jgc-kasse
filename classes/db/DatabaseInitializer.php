<?php

class DatabaseInitializer
{
    private DBConnection $db;

    public function initialize(DBConnection $db): void
    {
        $this->db = $db;
        if (!$this->createTable_cash_register($db->getDatabase())){
            echo "Error while trying to create table tbl_cash-register<br>";
        }
        if (!$this->createTable_revenues($db->getDatabase())){
            echo "Error while trying to create table tbl_revenues<br>";
        }
    }

    private function createTable_cash_register(string $dbName): int|false
    {
        try {
            return $this->db->exec("
            USE `$dbName`;
            CREATE TABLE `tbl_cash-register` 
            (
                `id_cash-register` int(11) NOT NULL AUTO_INCREMENT,
                `description` int(11) DEFAULT NULL,
                PRIMARY KEY (`id_cash-register`)
            ) 
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
        } catch (PDOException) {
            return false;
        }

    }

    private function createTable_revenues(string $dbName): int|false
    {
        try {
            return $this->db->exec("
            USE `$dbName`;
            CREATE TABLE `tbl_revenues` 
            (
              `id_revenue` int(11) NOT NULL AUTO_INCREMENT,
              `description` varchar(50) DEFAULT NULL,
              `date` date DEFAULT NULL,
              `amount` decimal(10,0) DEFAULT NULL,
              `fk_cash-register` int(11) NOT NULL,
              PRIMARY KEY (`id_revenue`),
              KEY `tbl_revenues_tbl_cash-register_id_cash-register_fk` (`fk_cash-register`),
              CONSTRAINT `tbl_revenues_tbl_cash-register_id_cash-register_fk` FOREIGN KEY (`fk_cash-register`) REFERENCES `tbl_cash-register` (`id_cash-register`)
            ) 
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");

        } catch (PDOException) {
            return false;
        }
    }
}