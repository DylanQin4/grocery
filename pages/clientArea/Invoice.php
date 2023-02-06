<?php
require("../../inc/Functions.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: " . $_SERVER["SCRIPT_NAME"] . "?invoiceConfirmed=" . confirmPurchases($_SESSION["cart"], $_SESSION["clientID"], $_SESSION["memberID"], $_GET["paymentID"], $_POST["contact"]));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <title>Facture</title>
</head>
<style>
    html,
    body {
        height: 100%;
    }
</style>

<body>
    <?php if (isset($_GET["paymentID"])) { ?>
        <div class="modal modal-alert position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalChoice">
            <div class="modal-dialog" role="document">
                <form class="modal-content rounded-3 shadow" action="<?php $_SERVER["SCRIPT_NAME"]; ?>" method="POST">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Entrer votre numero</h5>
                        <input type="text" class="mb-0" name="contact" required>
                        <input type="hidden" value="<?php echo $_GET["paymentID"]; ?>" name="paymentID">
                    </div>
                    <div class="modal-footer flex-nowrap p-0">
                        <input type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end" value="Confirmer">
                        <a type="button" href="../store/MainStore.php?selectedPage=1" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Retour</a>
                    </div>
                </form>
            </div>
        </div>
    <?php } else if (isset($_GET["invoiceConfirmed"])) { ?>
        <div class="container">
            <header class="d-flex justify-content-between align-items-end mt-3">
                <img src="../../assets/photos/icones/sarety.png" width="200px" height="70px">
                <div class="aboutInvoice">
                    <p><?php getInvoiceDate($_GET["invoiceConfirmed"]) ?></p>
                    <h3>Facture ID : <?php echo $_GET["invoiceConfirmed"]; ?></h3>
                </div>
            </header>
            <div class="aboutClient d-flex justify-content-between mt-3">
                <div class="member">
                    <h4>Fait(e) par : </h4>
                    <p>Nom : <?php echo getMemberName($_SESSION["memberID"]); ?></p>
                    <p>Prenom : <?php echo getMemberFirstName($_SESSION["memberID"]); ?></p>
                    <p>Contact : <?php echo getMemberContact($_SESSION["memberID"]); ?></p>
                    <p>Email : <?php echo getMemberMail($_SESSION["memberID"]); ?></p>
                </div>
                <div class="client">
                    <h4>De : </h4>
                    <p>Client ID : <?php echo $_SESSION["clientID"]; ?></p>
                    <p>Nom : <?php echo getClientName($_SESSION["clientID"]); ?></p>
                    <p>Prenom : <?php echo getClientFirstName($_SESSION["clientID"]); ?></p>
                    <p>Contact : <?php echo getClientContact($_SESSION["clientID"]); ?></p>
                </div>
            </div>

            <h3 class="my-3">Payement par :
                <?php echo getPaymentMethod(getCommandPaymentMethod(getAllCommands($_GET["invoiceConfirmed"])[0])); ?>
            </h3>

            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th scope="col">Produit</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Prix unitaire (Ar)</th>
                        <th scope="col">Total (Ar)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $commands = getAllCommands($_GET["invoiceConfirmed"]);
                    foreach ($commands as $command) { ?>
                        <tr>
                            <td><?php echo getProductName(getCommandProduct($command)); ?></td>
                            <td><?php echo getCommandProductQuantity($command); ?></td>
                            <td><?php echo getProductSellingPrice(getCommandProduct($command)); ?></td>
                            <td><?php echo getCommandProductQuantity($command) * getProductSellingPrice(getCommandProduct($command)); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <h2 class="text-end">Montant total : <?php echo getTotalCommands($_GET["invoiceConfirmed"]); ?> Ar</h2>

            <a href="../../index.php?onlyClient=1" class="btn btn-secondary">Retour</a>
        </div>
    <?php } ?>
</body>

</html>