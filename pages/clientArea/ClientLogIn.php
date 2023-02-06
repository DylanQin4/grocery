<?php
// need to be logged as a client to access the store

require("../../inc/Functions.php");
session_start();
if (isset($_SESSION["memberID"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isClient($_POST["clientID"])) {
            $_SESSION["clientID"] = $_POST["clientID"];
            $_SESSION["cart"] = array();
            header("Location: ../store/MainStore.php");
        } ?>
        <script>
            alert("Vous n'avez pas encore de compte client, veuillez-en creer un");
        </script>
    <?php }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="../../assets/css/ClientLogIn.css">
        <title>Inserer votre ID client</title>
    </head>

    <body class="text-center">
        <a class="connect" href="../memberArea/<?php echo isAdmin($_SESSION["memberID"]) ? "admin/AdminSpace" : "../../index"; ?>.php">
            Espace membre
            (admin)
        </a>
        <a class="bouton" href="./ClientRegister.php">
            <img src="../../assets/photos/icones/plus-icone.png" width=50px>
        </a>
        <form class="form-signin w-100 m-auto" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" method="POST">
            <img class="mb-3" src="../../assets/photos/icones/grocery.jpg" alt="grocery icone" width="150" height="110">
            <p class="h3 mb-3 fw-normal">Vérification</p>
            <div class="form-floating">
                <input type="text" class="form-control" id="nameInput" placeholder="Prénom">
                <label for="nameInput">Prénom</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" id="idInput" name="clientID" placeholder="ID Client" required>
                <label for="idInput">ID Client</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Confirmer</button>
        </form>
    </body>

    </html>
<?php } else {
    header("Location: ../memberArea/MemberLogIn.php");
} ?>
