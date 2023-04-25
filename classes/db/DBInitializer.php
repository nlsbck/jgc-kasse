<?php

class DBInitializer
{
    private DBConnection $db;

    public function initialize(DBConnection $db): void
    {
        $this->db = $db;
        $success = true;
        if (!$this->createTable_cash_registers($db->getDatabase())) {
            echo "Error while trying to create table tbl_cash_register<br>";
            $success = false;
        }
        if (!$this->createTable_tax_rate($db->getDatabase())) {
            echo "Error while trying to create table tbl_revenues<br>";
            $success = false;
        }
        if (!$this->createTable_cash_status($db->getDatabase())) {
            echo "Error while trying to create table tbl_revenues<br>";
            $success = false;
        }
        if (!$this->createTable_revenues($db->getDatabase())) {
            echo "Error while trying to create table tbl_revenues<br>";
            $success = false;
        }
        if (!$this->createTable_expenses($db->getDatabase())) {
            echo "Error while trying to create table tbl_revenues<br>";
            $success = false;
        }
        if ($success) {
            echo "All tables created.";
        }
    }

    private function createTable_cash_registers(string $dbName): int|false
    {
        try {
            return $this->db->exec("
            USE `$dbName`;
            CREATE TABLE `tbl_cash_registers` (
              `id_cash_register` int(11) NOT NULL AUTO_INCREMENT,
              `description` varchar(50) DEFAULT NULL,
              PRIMARY KEY (`id_cash_register`)
            ) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


        ");
        } catch (PDOException $e) {
            //echo $e;
            return false;
        }

    }

    private function createTable_revenues(string $dbName): int|false
    {
        try {
            return $this->db->exec("
            USE `$dbName`;
   CREATE TABLE `tbl_revenues` (
  `id_revenue` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `fk_cash_register` int(11) NOT NULL,
  `fk_tax_rate` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_revenue`),
  KEY `tbl_revenues_tbl_cash_register_id_cash_register_fk` (`fk_cash_register`),
  KEY `tbl_revenues_tbl_tax_rate_id_tax_rate_fk` (`fk_tax_rate`),
  CONSTRAINT `tbl_revenues_tbl_cash_register_id_cash_register_fk` FOREIGN KEY (`fk_cash_register`) REFERENCES `tbl_cash_registers` (`id_cash_register`),
  CONSTRAINT `tbl_revenues_tbl_tax_rate_id_tax_rate_fk` FOREIGN KEY (`fk_tax_rate`) REFERENCES `tbl_tax_rates` (`id_tax_rate`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


        ");

        } catch (PDOException) {
            return false;
        }
    }
    private function createTable_expenses(string $dbName): int|false
    {
        try {
            return $this->db->exec("
            USE `$dbName`;
  CREATE TABLE `tbl_expenses` (
                                `id_expense` int(11) NOT NULL AUTO_INCREMENT,
                                `description` varchar(50) DEFAULT NULL,
                                `date` date DEFAULT NULL,
                                `amount` decimal(10,2) DEFAULT NULL,
                                `fk_cash_register` int(11) NOT NULL,
                                `fk_tax_rate` int(11) DEFAULT NULL,
                                PRIMARY KEY (`id_expense`),
                                KEY `tbl_expenses_tbl_cash_register_id_cash_register_fk` (`fk_cash_register`),
                                KEY `tbl_expenses_tbl_tax_rate_id_tax_rate_fk` (`fk_tax_rate`),
                                CONSTRAINT `tbl_expenses_tbl_cash_register_id_cash_register_fk` FOREIGN KEY (`fk_cash_register`) REFERENCES `tbl_cash_registers` (`id_cash_register`),
                                CONSTRAINT `tbl_expenses_tbl_tax_rate_id_tax_rate_fk` FOREIGN KEY (`fk_tax_rate`) REFERENCES `tbl_tax_rates` (`id_tax_rate`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

        ");

        } catch (PDOException) {
            return false;
        }
    }

    private function createTable_cash_status(string $dbName): int|false
    {
        try {
            return $this->db->exec("
            USE `$dbName`;
            CREATE TABLE `tbl_cash_status` (
  `id_cash_status` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fk_cash_register` int(11) NOT NULL,
  PRIMARY KEY (`id_cash_status`),
  KEY `cash_status_tbl_cash_register_id_cash_register_fk` (`fk_cash_register`),
  CONSTRAINT `cash_status_tbl_cash_register_id_cash_register_fk` FOREIGN KEY (`fk_cash_register`) REFERENCES `tbl_cash_registers` (`id_cash_register`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci


        ");

        } catch (PDOException) {
            return false;
        }
    }
    private function createTable_tax_rate(string $dbName): int|false
    {
        try {
            return $this->db->exec("
            USE `$dbName`;
             CREATE TABLE `tbl_tax_rates` (
  `id_tax_rate` int(11) NOT NULL AUTO_INCREMENT,
  `tax_rate` decimal(10,9) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_tax_rate`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ");

        } catch (PDOException) {
            return false;
        }
    }
}