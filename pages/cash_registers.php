<?php /** @var array $cash_registers */ ?>
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
        <div class="col-md-3">
            <label for="cash-register-input"></label>
            <input class="form-control" id="cash-register-input" placeholder="Name der Kasse">
        </div>
        <div class="col-md-1">
            <button class="btn btn-success" onclick="createCashRegister()" style="width: 100%">Anlegen</button>
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
                    <th scope="col">Vorhandene Kassen</th>
                    <th class="center" scope="col">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($cash_registers as $cr): ?>
                    <tr>
                        <td><?= $cr['description'] ?></td>
                        <td class="center clickable" onclick="deleteCashRegister('<?= $cr['id_cash_register']?>')">
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
    function createCashRegister() {
        let cash_register_input = document.getElementById('cash-register-input');
        if (validateInputs(cash_register_input)) {
            $.ajax({
                method: 'POST',
                url: '<?= URI->getURI("new-cash-register")?>',
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

    function deleteCashRegister(id_cash_register) {
        console.log(id_cash_register);
        $.ajax({
            method: 'POST',
            url: '<?= URI->getURI("delete-cash-register")?>',
            data: {id_cash_register: id_cash_register},
            success: function (){
                location.reload();
            }
        })
    }
</script>
