<?php

class DBQuery
{
    public static function get_cash_registers(): array
    {
            global $db;
            return $db->executeSelect("
                SELECT * 
                FROM tbl_cash_register
            ");
    }
}