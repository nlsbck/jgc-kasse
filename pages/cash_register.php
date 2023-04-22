<?php /** @var array $cash_registers */?>
<head>
    <?php
    require 'pages/include/head.php';
    ?>
</head>
<body>
<h1 style="text-align: center">Kassen</h1>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-2">
            <label for="cash-register-input"></label>
            <input class="form-control" id="cash-register-input" placeholder="Name der Kasse">
        </div>
        <div class="col-md-2">
            <button class="btn btn-success">Kasse anlegen</button>
        </div>
    </div>
    <br>
    <br>
    <br>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <td>Vorhandene Kassen</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cash_registers as $cr):?>
                    <tr>
                        <td><?=$cr['description']?></td>
                    </tr>
                <?php endforeach?>
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>


