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
        <div class="col-md-4">
            <label for="description-input" class="form-label">Beschreibung</label>
            <input class="form-control" id="description-input" placeholder="Beschreibung">
        </div>
        <div class="col-md-2">
            <label for="amount-input" class="form-label">Betrag</label>
            <input class="form-control" id="amount-input" value="0.00" type="number" step='0.01'>
        </div>
        <div class="col-md-2">
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
        <div class="col-md-11"></div>
        <div class="col-md-1">
            <button class="btn btn-success" onclick="createRevenue()" style="width: 100%">Anlegen</button>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Kasse</th>
                    <th scope="col">Datum</th>
                    <th scope="col">Beschreibung</th>
                    <th scope="col">Betrag</th>
                    <th scope="col">Steuer</th>
                    <th class="center" scope="col">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($revenues as $revenue): ?>
                    <tr>
                        <td><?= $revenue['cash_register'] ?></td>
                        <td><?= date('d.m.Y', strtotime($revenue['date'])) ?></td>
                        <td><?= $revenue['description'] ?></td>
                        <td style="text-align: right"><?= $revenue['amount'] ?> €</td>
                        <td><?= $revenue['tax'] ?></td>
                        <td class="center clickable" onclick="deleteRevenue('<?= $revenue['id_revenue']?>')">
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
    document.getElementById('date-input').value = new Date().toJSON().slice(0,10);
    function createRevenue() {

        let cash_register_select = document.getElementById('cash-register-select');
        let date_input = document.getElementById('date-input');
        let description_input = document.getElementById('description-input');
        let amount_input = document.getElementById('amount-input');
        let tax_rate_select = document.getElementById('tax-rate-select');
        console.log(date_input.value)
        if (validateInputs(cash_register_select, date_input, description_input, tax_rate_select) & validateCashAmount(amount_input)) {
            let postData = {
                id_cash_register: cash_register_select.value,
                date: date_input.value,
                description: description_input.value,
                amount: amount_input.value,
                id_tax_rate: tax_rate_select.value,
            }
            $.ajax({
                method: 'POST',
                url: '<?= URI->getURI("new-revenue")?>',
                data: {postData: postData},
                success: function () {
                    date_input.value = '';
                    description_input.value = '';
                    amount_input.value = '';
                    location.reload();
                },
                error: function (e) {

                }
            });
        }
    }

    function deleteRevenue(id_revenue) {
        $.ajax({
            method: 'POST',
            url: '<?= URI->getURI("delete-revenue")?>',
            data: {id_revenue: id_revenue},
            success: function (){
                location.reload();
            }
        })
    }
</script>
