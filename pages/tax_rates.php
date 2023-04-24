<?php
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
        <div class="col-md-3">
        </div>
        <div class="col-md-4">
            <label for="description-input" class="form-label">Beschreibung</label>
            <input class="form-control" id="description-input" placeholder="Beschreibung">
        </div>
        <div class="col-md-2">
            <label for="tax-rate-input" class="form-label">Steuersatz</label>
            <input class="form-control" id="tax-rate-input" value="0.00" type="number"
                   step='0.01' min="0" max="10" placeholder="Steuersatz">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-1">
            <button class="btn btn-success" onclick="createTaxRate()" style="width: 100%">Anlegen</button>
        </div>
    </div>
    <br>
    <br>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Beschreibung</th>
                    <th scope="col">Steuer</th>
                    <th class="center" scope="col">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tax_rates as $tax_rate): ?>
                    <tr>
                        <td><?= $tax_rate['description'] ?></td>
                        <td><?= $tax_rate['tax_rate'] ?></td>
                        <td class="center clickable" onclick="deleteTaxRate('<?= $tax_rate['id_tax_rate']?>')">
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
    function createTaxRate() {
        let description_input = document.getElementById('description-input');
        let tax_rate_input = document.getElementById('tax-rate-input')
        if (validateInputs(description_input) & validateCashAmount(tax_rate_input)) {
            let postData = {
                description: description_input.value,
                tax_rate: tax_rate_input.value
            }
            $.ajax({
                method: 'POST',
                url: '<?= URI->getURI("new-tax-rate")?>',
                data: {postData: postData},
                success: function () {
                    location.reload();
                },
            });
        }
    }

    function deleteTaxRate(id_tax_rate) {
        $.ajax({
            method: 'POST',
            url: '<?= URI->getURI("delete-tax-rate")?>',
            data: {id_tax_rate: id_tax_rate},
            success: function (response){
                response = JSON.parse(response);
                if (response['success']) {
                    location.reload();
                }
                //todo tax could not be deleted
            }
        })
    }
</script>
