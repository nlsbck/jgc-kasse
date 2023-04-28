<?php
/** @var array $daily */
/** @var array $monthly_expenses */
/** @var array $monthly_revenues */
include 'classes/Helper.php';
?>
<head>
    <?php
    require 'pages/include/head.php';
    ?>
</head>

<body>
<h1 style="text-align: center">Ein- und Ausgaben <?= date('Y')?></h1>
<br>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table w-auto center">
                <thead>
                <tr>
                    <th></th>
                    <th scope="col">Datum</th>
                    <th class="center" scope="col">Zweck</th>
                    <th>Ausgaben</th>
                    <th>Einnahmen</th>
                    <th>Saldo</th>
                    <th>Steuer</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < count($daily); $i++): ?>
                    <tr>
                        <td></td>
                        <td><?= date('d.m.Y', strtotime($daily[$i]['date'])) ?></td>
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
                    <?php if ($i === count($daily) - 1): ?>
                        <tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                        <tr>
                            <td><?= substr($daily[$i]['date'], 0, 7)?></td>
                            <td></td>
                            <td></td>
                            <td class="currency text-danger"><?= Helper::get_amount_for_month($monthly_expenses, $daily[$i]['month'], date('Y'))?> €</td>
                            <td class="currency text-success"><?= Helper::get_amount_for_month($monthly_revenues, $daily[$i]['month'], date('Y'))?> €</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr><td></td><td></td><td><td></td><td></td><td></td><td></td></tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="currency text-danger"><?= Helper::get_amount_for_month($monthly_expenses, $daily[$i]['month'], date('Y'))?> €</td>
                            <td class="currency text-success"><?= Helper::get_amount_for_month($monthly_revenues, $daily[$i]['month'], date('Y'))?> €</td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php else: ?>
                        <?php if ($daily[$i]['month'] !== $daily[$i + 1]['month']): ?>
                        <tr><td></td><td></td><td><td></td><td></td><td></td><td></td></tr>
                            <tr>
                                <td><?= substr($daily[$i]['date'], 0, 7)?></td>
                                <td></td>
                                <td></td>
                                <td class="currency text-danger"><?= Helper::get_amount_for_month($monthly_expenses, $daily[$i]['month'], date('Y'))?> €</td>
                                <td class="currency text-success"><?= Helper::get_amount_for_month($monthly_revenues, $daily[$i]['month'], date('Y'))?> €</td>
                                <td></td>
                                <td></td>
                            </tr>
                        <tr><td></td><td></td><td><td></td><td></td><td></td><td></td></tr>
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
