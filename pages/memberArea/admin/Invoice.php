<?php
if (isset($_GET["view"])) {
    require("../../../inc/Functions.php");
    $memberID = getCommand_s_Member(getAllCommands($_GET["invoiceID"])[0]);
    $clientID = getInvoiceClient($_GET["invoiceID"]);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
        <title>Facture</title>
    </head>

    <body>
        <div class="container">
            <header class="d-flex justify-content-between align-items-end mt-3">
                <img src="../../../assets/photos/icones/sarety.png" width="200px" height="70px">
                <div class="aboutInvoice">
                    <p><?php getInvoiceDate($_GET["invoiceID"]) ?></p>
                    <h3>Facture ID : <?php echo $_GET["invoiceID"]; ?></h3>
                </div>
            </header>
            <div class="aboutClient d-flex justify-content-between mt-3">
                <div class="member">
                    <h4>Fait(e) par : </h4>
                    <p>Nom : <?php echo getMemberName($memberID); ?></p>
                    <p>Prenom : <?php echo getMemberFirstName($memberID); ?></p>
                    <p>Contact : <?php echo getMemberContact($memberID); ?></p>
                    <p>Email : <?php echo getMemberMail($memberID); ?></p>
                </div>
                <div class="client">
                    <h4>De : </h4>
                    <p>Client ID : <?php echo $clientID; ?></p>
                    <p>Nom : <?php echo getClientName($clientID); ?></p>
                    <p>Prenom : <?php echo getClientFirstName($clientID); ?></p>
                    <p>Contact : <?php echo getClientContact($clientID); ?></p>
                </div>
            </div>

            <h3 class="my-3">Payement par :
                <?php echo getPaymentMethod(getCommandPaymentMethod(getAllCommands($_GET["invoiceID"])[0])); ?>
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
                    $commands = getAllCommands($_GET["invoiceID"]);
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

            <h2 class="text-end">Montant total : <?php echo getTotalCommands($_GET["invoiceID"]); ?> Ar</h2>

            <a href="../admin/AdminSpace.php?selectedPage=<?php echo $_GET["selectedPage"]; ?>" class="btn btn-secondary">Retour</a>
        </div>
    </body>

    </html>
<?php } ?>