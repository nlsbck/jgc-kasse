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
       return 0;
   }

   public static function sum_amounts(array $monthly_amounts, $year = '')
   {
       if ($year === '') {
           $year = date('Y');
       }
       $sum = 0;
       foreach ($monthly_amounts as $amount) {
           if ($amount['year'] == $year) {
               $sum += $amount['amount'];
           }
       }
       return $sum;
   }
}