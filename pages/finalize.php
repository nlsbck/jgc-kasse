<?php
/** @var array $daily */
/** @var array $initial_cash_status */
/** @var array $monthly_expenses */
/** @var array $monthly_revenues */
include 'classes/Helper.php';
$expenses_year = Helper::sum_amounts($monthly_expenses, $year);
$revenues_year = Helper::sum_amounts($monthly_revenues, $year);
$saldo_year = $revenues_year - $expenses_year;

?>
<head>
    <?php
    require 'pages/include/head.php';
    ?>
</head>

<body>
<h1 style="text-align: center">Abschluss <?= $year?></h1>
<br>
<div class="container">
    <div class="row">
        <div class="col">
            <p>Kassenstand vom <?= date('d.m.Y', strtotime($initial_cash_status[0]['date'])) ?>: <?= $initial_cash_status[0]['amount']?> €</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Einnahmen <?= $year?>:
        </div>
        <div class="col-md-3">
            <p class="currency"><?= $revenues_year?> €</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Ausgaben <?= $year?>:
        </div>
        <div class="col-md-3">
            <p class="currency"><?= $expenses_year?> €</p>
        </div>
    </div>
    <div class="row">
    <div class="col-md-6">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            Gewinn <?= $year?>:
        </div>
        <div class="col-md-3">
            <p class="currency"><?= $saldo_year?> €</p>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            <b>Neuer Kassenstand <?= $year?>:</b>
        </div>
        <div class="col-md-3">
            <p class="currency"><b><?=$initial_cash_status[0]['amount'] + $saldo_year?> €</b></p>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-success">Kassenstand speichern</button>
        </div>
    </div>
</div>