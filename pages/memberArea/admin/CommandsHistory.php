<?php
if (isset($_GET["del"])) {
    deleteInvoice($_GET["del"]);
}
$defaultHeader = "Toutes les commandes existantes";
$foundInvoices = getAllInvoices();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["commandSearch"])) {
    if ($_POST["dateEnd"] != "") {
        $foundInvoices = searchingInvoices($_POST["dateBegin"], $_POST["dateEnd"]);
    } else {
        $foundInvoices = searchInvoices($_POST["dateBegin"]);
    }
    $defaultHeader = "Toutes les commandes trouvées";
}
?>
<form class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" action="./AdminSpace.php?selectedPage=2&commandSearch=1" method="POST">
    <div class="dateSearch d-flex justify-content-between align-items-center w-100 text-white my-2">
        <div class="limit">
            <label for="headDate" class="px-2">Date debut : </label>
            <input type="date" id="headDate" class="mx-2" name="dateBegin" required>
        </div>
        <div class="searchBtn">
            <input type="submit" value="Rechercher" class="btn btn-outline-light">
        </div>
        <div class="limit">
            <label for="tailDate" class="px-2">Date fin : </label>
            <input type="date" id="tailDate" class="mx-2" name="dateEnd">
        </div>
    </div>
</form>

<?php if (count($foundInvoices) > 0) { ?>

    <h2 class="mt-5"><?php echo $defaultHeader; ?> : </h2>

    <table class="table table-striped table-sm mt-3">
        <thead>
            <tr>
                <th scope="col">ID Facture</th>
                <th scope="col">Article(s)</th>
                <th scope="col">Membre</th>
                <th scope="col">Client</th>
                <th scope="col">Payement</th>
                <th scope="col">Contact client</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($foundInvoices as $invoice) { ?>
                <tr>
                    <?php $commandNumber = count(getAllCommands($invoice)); ?>
                    <td><?php echo $invoice; ?></td>
                    <td><?php echo $commandNumber; ?></td>
                    <td><?php echo getMemberName(getCommand_s_Member(getAllCommands($invoice)[0])) . " " . getMemberFirstName(getCommand_s_Member(getAllCommands($invoice)[0])); ?></td>
                    <td><?php echo getClientName(getInvoiceClient($invoice)) . " " . getClientFirstName(getInvoiceClient($invoice)); ?></td>
                    <td><?php echo getPaymentMethod(getCommandPaymentMethod(getAllCommands($invoice)[0])); ?></td>
                    <td><?php echo getClientContact(getInvoiceClient($invoice)); ?></td>
                    <td><?php echo getInvoiceDate($invoice); ?></td>
                    <td class="btn-group">
                        <a href="./Invoice.php?invoiceID=<?php echo $invoice; ?>&view=1&selectedPage=2" class="btn btn-success"><i class="fas fa-eye"></i></a>
                        <a href="./Treatment.php?del=<?php echo $invoice; ?>&selectedPage=2" class="btn btn-danger"><i class="fas fa-times"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="text-danger text-center mt-5">Aucune commande trouvée</p>
<?php } ?>
