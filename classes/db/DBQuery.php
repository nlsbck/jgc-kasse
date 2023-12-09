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
            JOIN tbl_tax_rates ttr ON r.fk_tax_rate = ttr.id_tax_rate
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
    public static function create_expense($description, $date, $amount, $fk_cash_register, $fk_tax_rate): bool
    {
        global $db;
        return $db->insert('tbl_expenses', array("description" => $description, "date" => $date,
            "amount" => $amount, "fk_cash_register" => $fk_cash_register, "fk_tax_rate" => $fk_tax_rate));
    }

    public static function delete_revenue($id_revenue): bool
    {
        global $db;
        return $db->delete('tbl_revenues', array("id_revenue" => $id_revenue));
    }

    public static function delete_expense($id_expense): bool
    {
        global $db;
        return $db->delete('tbl_expense', array("id_expense" => $id_expense));
    }

    public static function get_tax_rates(): array
    {
        global $db;
        return $db->executeSelect("
            SELECT * 
            FROM tbl_tax_rates
        ");
    }

    public static function create_tax_rate($tax_rate, $description): bool
    {
        global $db;
        return $db->insert('tbl_tax_rates', array("tax_rate" => $tax_rate, "description" => $description));
    }

    public  static function delete_tax_rate($id_tax_rate): bool
    {
        global $db;
        return $db->delete('tbl_tax_rates', array('id_tax_rate' => $id_tax_rate));
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

    public static function get_cash_status_last_year($currentYear): array
    {
        global $db;
        return $db->executeSelect("
        select sum(amount) AS amount, max(date) AS date
        from tbl_cash_status cs
       where date IN (select max(date) from tbl_cash_status where year(date) < ? GROUP BY fk_cash_register)
        
        ", $currentYear);
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

    public static function get_revenues_with_tax_rate($id_tax_rate): int
    {
        global $db;
        return $db->executeSelect("
            SELECT COUNT(id_revenue) AS count
            FROM tbl_revenues
            where fk_tax_rate = ?
        ", $id_tax_rate)[0]['count'];
    }

    public static function get_revenues_grouped_by_month($year = "%"): array
    {
        global $db;
        return $db->executeSelect("
        SELECT SUM(amount) AS amount,
           MONTH(date) AS month,
            YEAR(date) AS year,
            SUM(amount * tr.tax_rate) AS tax
        FROM tbl_revenues r
        join tbl_tax_rates tr ON r.fk_tax_rate = tr.id_tax_rate
        WHERE YEAR(date) like ?
        GROUP BY MONTH(date), YEAR(date)
        ", $year);
    }

    public static function get_expenses_grouped_by_month($year = "%"): array
    {
        global $db;
        return $db->executeSelect("
        SELECT SUM(amount) AS amount,
           MONTH(date) AS month,
           YEAR(date) AS year,
           SUM(amount * (tr.tax_rate / 1 + tr.tax_rate)) AS tax
        FROM tbl_expenses e 
        join tbl_tax_rates tr on e.fk_tax_rate = tr.id_tax_rate
        WHERE YEAR(date) like ?
        GROUP BY MONTH(date), YEAR(date)
        ", $year);
    }

    public static function get_yearly_overview($year): array
    {
        global $db;
        return $db->executeSelect("
            SELECT r.id_revenue, cr.description AS cash_register,
       r.description AS revenue, r.date, '+' AS prefix, r.amount,
       tr.description AS tax, amount*tr.tax_rate AS tax_share,
       tr.tax_rate, MONTH(date) AS month
FROM tbl_revenues r
         join tbl_cash_registers cr on r.fk_cash_register = cr.id_cash_register
         join tbl_tax_rates tr on tr.id_tax_rate = r.fk_tax_rate
WHERE YEAR(r.date) = ?

UNION

SELECT r.id_expense, cr.description AS cash_register,
       r.description AS expense, r.date, '-' AS prefix, r.amount,
       tr.description AS tax, amount*tr.tax_rate AS tax_share,
       tr.tax_rate, MONTH(date) AS month
FROM tbl_expenses r
         join tbl_cash_registers cr on r.fk_cash_register = cr.id_cash_register
         join tbl_tax_rates tr on tr.id_tax_rate = r.fk_tax_rate
WHERE YEAR(r.date) = ?
ORDER BY date
        ", $year, $year);
    }

}