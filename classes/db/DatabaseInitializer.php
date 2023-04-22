<?php

class DatabaseInitializer
{
    private DBConnection $db;

    public function initialize(DBConnection $db): void
    {
        $this->db = $db;
        $this->createTable_cash_register();
        $this->createTable_revenues();
    }

    private function createTable_cash_register(): int|false
    {
        return $this->db->exec("
            CREATE TABLE `tbl_cash-register` 
            (
                `id_cash-register` int(11) NOT NULL AUTO_INCREMENT,
                `description` int(11) DEFAULT NULL,
                PRIMARY KEY (`id_cash-register`)
            ) 
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");
    }

    private function createTable_revenues(): int|false
    {
        return $this->db->exec("
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
    }
}