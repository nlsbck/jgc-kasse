<?php

class Helper
{
   public static function get_amount_for_month(array $monthly_amounts, $month, $year = '')
   {
       if ($year === '') {
           $year = date('Y');
       }
       foreach ($monthly_amounts as $ma) {
           if ($ma['month'] === $month) {
               return $ma['amount'];
           }
       }
       return false;
   }
}