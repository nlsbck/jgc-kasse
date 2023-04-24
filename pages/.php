<?php
/** @var array $yearly_overview */
?>
<head>
    <?php
    require 'pages/include/head.php';
    ?>
</head>

<body>
<h1 style="text-align: center">Startseite</h1>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th scope="col">Datum</th>
                    <th class="center" scope="col">Beschreibung</th>
                    <th>Betrag</th>
                    <th>Steuer</th>
                </tr>
                </thead>
                <tbody>
                <?php for ($i = 0; $i < count($yearly_overview); $i++): ?>
                    <tr>
                        <td></td>
                        <td><?= date('d.m.Y', strtotime($yearly_overview[$i]['date'])) ?></td>
                        <td><?= $yearly_overview[$i]['revenue'] ?></td>
                        <td class="currency"><?= $yearly_overview[$i]['amount'] ?> €</td>
                        <td><?= $yearly_overview[$i]['tax'] ?></td>
                    </tr>
                    <?php if ($i === count($yearly_overview) - 1): ?>
                        <tr>
                            <td>Monatssaldo</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Gesamtsaldo</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php else: ?>
                        <?php if (substr($yearly_overview[$i]['date'], 5, 2) !== substr($yearly_overview[$i + 1]['date'], 5, 2)): ?>
                        <tr><td></td><td></td><td></td><td></td><td></td></tr>
                            <tr>
                                <td>Monatssaldo <?= DateTime::createFromFormat('!m', substr($yearly_overview[$i]['date'], 5, 2))->format('F')?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        <tr><td></td><td></td><td></td><td></td><td></td></tr>
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
    document.querySelectorAll('.currency').forEach(td => {
        let value = td.innerText;
        if (value < '0') {
            td.classList.add('text-danger');
        } else {
            td.classList.add('text-success');
        }
    })
</script>
