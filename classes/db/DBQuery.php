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

    public static function delete_cash_register($id_cash_register)
    {
        global $db;
        return $db->delete('tbl_cash_registers', array("id_cash_register" => $id_cash_register));
    }
}