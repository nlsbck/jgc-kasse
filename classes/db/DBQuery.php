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
            SELECT r.id_revenue, r.description, r.date, r.amount, r.fk_cash_register, r.fk_tax_rate,
                tcr.description AS cash_register, ttr.description AS tax, ttr.tax_rate
            FROM tbl_revenues r
            JOIN tbl_cash_registers tcr ON r.fk_cash_register = tcr.id_cash_register
            JOIN tbl_tax_rate ttr ON r.fk_tax_rate = ttr.id_tax_rate
            ORDER BY r.id_revenue DESC
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

    public static function initial_cash_status(): array
    {
        global $db;
        return $db->executeSelect("
            SELECT cs.id_cash_status, MIN(cs.date) AS date, cs.amount, cr.id_cash_register, cr.description AS cash_register
            FROM tbl_cash_status cs
            RIGHT JOIN tbl_cash_registers cr ON cr.id_cash_register = cs.fk_cash_register
            GROUP BY id_cash_register
        ");
    }

    public static function edit_initial_cash_status($id_cash_status, $date, $amount, $id_cash_register = '-1'): bool
    {
        global $db;
        if ($id_cash_status === '') {
            return $db->insert('tbl_cash_status', array("date" => $date, "amount" => $amount, "fk_cash_register" => $id_cash_register));
        } else {
            return $db->update('tbl_cash_status', array("date" => $date, "amount" => $amount), array("id_cash_status" => $id_cash_status));
        }
    }

}