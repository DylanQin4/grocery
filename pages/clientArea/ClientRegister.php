<?php
require("../../inc/Functions.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["clientID"] = createClientAccount($_POST["name"], $_POST["firstName"], $_POST["contact"]);
    $_SESSION["cart"] = array();
    header("Location: ../store/MainStore.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/ClientLogIn.css">
    <title>Enregistrement client</title>
</head>

<body class="text-center">
    <a class="bouton" href="./ClientLogIn.php">S'identifier</a>
    <form class="form-signin w-100 m-auto" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" method="POST">
        <img class="mb-3" src="../../assets/photos/icones/grocery.jpg" alt="grocery icone" width="150" height="110">
        <p class="h3 mb-3 fw-normal">Inscription</p>
        <div class="form-floating">
            <input type="text" class="form-control" id="nameInput" placeholder="Nom" name="name">
            <label for="nameInput">Nom</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" id="firstNameInput" placeholder="Prénom" name="firstName">
            <label for="firstNameInput">Prénom</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" id="firstNameInput" placeholder="Contact" name="contact">
            <label for="firstNameInput">Contact</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">S'inscrire</button>
    </form>
</body>

</html>