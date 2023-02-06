<?php
session_start();
require("../../inc/Functions.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (logIn($_POST["codeMember"], $_POST["password"]) != -1) {
        $_SESSION["memberID"] = logIn($_POST["codeMember"], $_POST["password"]);
        header("Location: ../clientArea/ClientLogIn.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../assets/css/MemberLogIn.css">
    <title>Membre LogIn</title>
    <script src="../../assets/js/script.js"></script>
</head>

<body>
    <div class="page">
        <div class="container">
            <div class="left">
                <img src="../../assets/photos/icones/sarety.png" class="login" width="250px" height="100px">
                <div class="eula">En vous connectant, vous acceptez les termes de condition blablabla que vous vous en
                    foutez de lire</div>
            </div>
            <div class="right">
                <form action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" class="form" method="POST">
                    <label for=" codeMember">Code membre</label>
                    <input type="password" id="codeMember" name="codeMember" required>
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                    <input type="submit" id="submit" value="Connexion">
                </form>
            </div>
        </div>
    </div>
</body>

</html>