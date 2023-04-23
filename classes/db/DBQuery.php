<?php

class DBQuery
{
    public static function get_cash_registers(): array
    {
        global $db;
        return $db->executeSelect("
            SELECT * 
            FROM tbl_cash_registers
        ");
    }

    public static function create_cash_register($description): bool
    {
        global $db;
        return $db->insert('tbl_cash_registers', array("description" => $description));
    }

    public static function delete_cash_register($id_cash_register): bool
    {
        global $db;
        return $db->delete('tbl_cash_registers', array("id_cash_register" => $id_cash_register));
    }

    public static function get_revenues_last10(): array
    {
        global $db;
        return $db->executeSelect("
            SELECT * 
            FROM tbl_revenues
            ORDER BY date desc
            LIMIT 10
        ");
    }

    public static function create_revenue($description, $date, $amount, $fk_cash_register, $fk_tax_rate): bool
    {
        global $db;
        return $db->insert('tbl_revenues', array("description" => $description, "date" => $date,
            "amount" => $amount, "fk_cash_register" => $fk_cash_register, "fk_tax_rate" => $fk_tax_rate));
    }

    public static function delete_revenue($id_revenue): bool
    {
        global $db;
        return $db->delete('tbl_revenues', array("id_revenue" => $id_revenue));
    }

    public static function get_tax_rates(): array
    {
        global $db;
        return $db->executeSelect("
            SELECT * 
            FROM tbl_tax_rate
        ");
    }
}