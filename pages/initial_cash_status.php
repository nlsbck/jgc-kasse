<?php
/** @var array $initial_cash_status */
?>
<head>
<?php
require 'pages/include/head.php';
?>
</head>
<body>
<h1 style="text-align: center">Initiale Kassenstände pflegen</h1>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Kasse</th>
                    <th scope="col">Datum</th>
                    <th scope="col">Betrag</th>
                    <th class="center" scope="col">Bearbeiten</th>
                    <th class="center" scope="col">Löschen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($initial_cash_status as $ics): ?>
                    <tr>
                        <td><?= $ics['cash_register']?></td>
                        <td><?= date('d.m.Y', strtotime($ics['date'])) ?></td>
                        <td><?= is_null($ics['amount']) ? "" : $ics['amount'] . " €"?></td>
                        <td class="center clickable" onclick="editModal('<?= $ics['id_cash_register']?>')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </td>
                        <td class="center clickable" onclick="deleteCashStatus('<?= $ics['id_cash_status']?>')">
                            <i class="fa-solid fa-trash-can"></i>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php foreach ($initial_cash_status as $ics): ?>
<div class="modal fade" id="editModal<?= $ics['id_cash_register']?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel"><?= $ics['cash_register']?> editieren</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="date-input<?= $ics['id_cash_register']?>" class="form-label">Datum</label>
                        <input class="form-control" id="date-input<?= $ics['id_cash_register']?>" type="date" value="<?= $ics['date']?>">
                    </div>
                    <div class="col-md-6">
                        <label for="amount-input<?= $ics['id_cash_register']?>" class="form-label">Betrag</label>
                        <input class="form-control" id="amount-input<?= $ics['id_cash_register']?>" value="<?= $ics['amount']?>" type="number" step='0.01'>
                    </div>
                    <input id="id_cash_status<?= $ics['id_cash_register']?>" value="<?= $ics['id_cash_status']?>" hidden>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-primary" onclick="editCashStatus('<?= $ics['id_cash_register']?>')">Änderungen speichern</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach ?>
<br>
</body>
<script src="../js/validateInputs.js"></script>
<script>
    document.querySelectorAll('td').forEach(td => {
        if (td.innerHTML === '') {
            td.innerHTML = "nicht gepflegt";
        }
    })

    function editModal(id_cash_register) {
        $('#editModal' + id_cash_register).modal('show');
    }

    function deleteCashStatus(id_cash_status) {
        $.ajax({
            method: "POST",
            url: '<?= URI->getURI('delete-cash-status')?>',
            data: {id_cash_status: id_cash_status },
            success: function() {

            }
        })
    }

    function editCashStatus(id_cash_register) {
        let date_input = document.getElementById('date-input' + id_cash_register);
        let amount_input = document.getElementById('amount-input' + id_cash_register);
        let id_cash_status_input = document.getElementById('id_cash_status' + id_cash_register);
        if (validateInputs(date_input) & validateCashAmount(amount_input)) {
            let date_ger = date_input.value;
            let date_new = date_ger.substring(0, 4) + "-" + date_ger.substring(5, 7)+ "-" + date_ger.substring(8)

            let postData = {
                id_cash_status: id_cash_status_input.value,
                id_cash_register: id_cash_register,
                date: date_new,
                amount: amount_input.value
            }
            $.ajax({
                method: "POST",
                url: '<?= URI->getURI('edit-cash-status')?>',
                data: {postData: postData},
                success: function () {
                   location.reload();
                }
            })
        }
    }
</script>