<?php
/** @var array $revenues */
/** @var array $cash_registers */
/** @var array $tax_rates */
?>
<head>
    <?php
    require 'pages/include/head.php';
    ?>
</head>
<body>
<h1 style="text-align: center">Umsätze</h1>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <label for="cash-register-select" class="form-label">Kasse</label>
            <select class="form-select" id="cash-register-select">
                <?php foreach ($cash_registers as $cr): ?>
                    <option value="<?= $cr['id_cash_register'] ?>"><?= $cr['description'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="date-input" class="form-label">Datum</label>
            <input class="form-control" id="date-input" type="date">
        </div>
        <div class="col-md-3">
            <label for="description-input" class="form-label">Beschreibung</label>
            <input class="form-control" id="description-input" placeholder="Beschreibung">
        </div>
        <div class="col-md-1">
            <label for="amount-input" class="form-label">Betrag</label>
            <input class="form-control" id="amount-input" value="0.00" type="number" step='0.01'>
        </div>
        <div class="col-md-3">
            <label for="tax-rate-select" class="form-label">Steuer</label>
            <select class="form-select" id="tax-rate-select">
                <?php foreach ($tax_rates as $tax_rate): ?>
                    <option value="<?= $tax_rate['id_tax_rate'] ?>"><?= $tax_rate['description'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-1">
            <button class="btn btn-success" onclick="createRevenue()" style="width: 100%">Anlegen</button>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Vorhandene Umsätze</th>
                    <th class="center" scope="col">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($revenues as $revenue): ?>
                    <tr>
                        <td><?= $revenue['description'] ?></td>
                        <td class="center clickable" onclick="deleteRevenue('<?= $revenue['id_cash_register']?>')">
                            <i class="fa-solid fa-trash-can"></i>
                        </td>
                    </tr>

                <?php endforeach ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
</body>
<script src="../js/validateInputs.js"></script>
<script>
    function createRevenue() {
        let cash_register_input = document.getElementById('cash-register-input');
        if (validateInputs(cash_register_input)) {
            $.ajax({
                method: 'POST',
                url: '',
                data: {description: cash_register_input.value},
                success: function () {
                    cash_register_input.value = ''
                    location.reload();
                },
                error: function (e) {

                }
            });
        }
    }

    function deleteRevenue(id_cash_register) {
        console.log(id_cash_register);
        $.ajax({
            method: 'POST',
            url: '',
            data: {id_cash_register: id_cash_register},
            success: function (){
                location.reload();
            }
        })
    }
</script>
