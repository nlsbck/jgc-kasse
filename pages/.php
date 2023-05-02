<?php
/** @var array $daily */
/** @var array $monthly_expenses */
/** @var array $monthly_revenues */
/** @var array $year */
include 'classes/Helper.php';
?>
<head>
    <?php
    require 'pages/include/head.php';
    ?>
</head>

<body>
<h1 style="text-align: center">Ein- und Ausgaben <?= $year?></h1>
<br>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table w-auto center">
                <thead>
                <tr>
                    <th></th>
                    <th scope="col">Datum</th>
                    <th>Kasse</th>
                    <th class="center" scope="col">Zweck</th>
                    <th>Ausgaben</th>
                    <th>Einnahmen</th>
                    <th>Saldo</th>
                    <th>Steuer</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < count($daily); $i++):
                    $revenues_current_month = Helper::get_amount_for_month($monthly_revenues, $daily[$i]['month'], $year);
                    $expenses_current_month = Helper::get_amount_for_month($monthly_expenses, $daily[$i]['month'], $year);
                    $saldo_current_month = $revenues_current_month - $expenses_current_month;
                ?>

                    <tr>
                        <td></td>
                        <td><?= date('d.m.Y', strtotime($daily[$i]['date'])) ?></td>
                        <td><?= $daily[$i]['cash_register'] ?></td>
                        <td><?= $daily[$i]['revenue'] ?></td>
                        <?php if ($daily[$i]['prefix'] === '-'): ?>
                            <td class="currency text-danger"><?=$daily[$i]['prefix'] . $daily[$i]['amount'] ?> €</td>
                            <td></td>
                        <?php else:?>
                            <td></td>
                            <td class="currency text-success"><?=$daily[$i]['prefix'] . $daily[$i]['amount'] ?> €</td>
                        <?php endif?>
                        <td></td>
                        <td><?= $daily[$i]['tax'] ?></td>
                    </tr>
                    <?php if ($i === count($daily) - 1):
                        $expenses_year = Helper::sum_amounts($monthly_expenses, $year);
                        $revenues_year = Helper::sum_amounts($monthly_revenues, $year);
                        $saldo_year = $revenues_year - $expenses_year;
                    ?>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr>
                            <td><?= substr($daily[$i]['date'], 0, 7)?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="currency text-danger"><?= $expenses_current_month === 0 ? 0 : "-" . $expenses_current_month?> €</td>
                            <td class="currency text-success"><?= $revenues_current_month === 0 ? 0 : "+" . $revenues_current_month?> €</td>
                            <td class="currency <?= $saldo_current_month < 0 ? 'text-danger' : ($saldo_current_month > 0 ? 'text-success' : '') ?>"><?= $saldo_current_month > 0 ? '+' . $saldo_current_month : $saldo_current_month ?> €</td>
                            <td></td>
                        </tr>
                        <tr><td></td><td></td><td></td><td><td></td><td></td><td></td><td></td></tr>
                        <tr>
                            <td><?= $year?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="currency text-danger"><?= $expenses_year === 0 ? 0 : "-" . $expenses_year?> €</td>
                            <td class="currency text-success"><?= $revenues_year === 0 ? 0 : "+" . $revenues_year?> €</td>
                            <td class="currency <?= $saldo_year < 0 ? 'text-danger' : ($saldo_year > 0 ? 'text-success' : '')?>"><?= $saldo_year > 0 ? '+' . $saldo_year : $saldo_year ?> €</td>
                            <td></td>
                        </tr>
                    <?php else: ?>
                        <?php if ($daily[$i]['month'] !== $daily[$i + 1]['month']): ?>
                        <tr><td></td><td></td><td></td><td><td></td><td></td><td></td><td></td></tr>
                            <tr>
                                <td><?= substr($daily[$i]['date'], 0, 7)?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="currency text-danger"><?= $expenses_current_month === 0 ? 0 : "-" . $expenses_current_month?> €</td>
                                <td class="currency text-success"><?= $revenues_current_month === 0 ? 0 : "+" . $revenues_current_month?> €</td>
                                <td class="currency <?= $saldo_current_month < 0 ? 'text-danger' : ($saldo_current_month > 0 ? 'text-success' : '') ?>"><?= $saldo_current_month > 0 ? '+' . $saldo_current_month : $saldo_current_month ?> €</td>
                                <td></td>
                            </tr>
                        <tr><td></td><td></td<td></td><td><td></td><td></td><td></td><td></td><td></td></tr>
                        <?php endif ?>
                    <?php endif ?>
                <?php endfor ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
<script>
</script>
