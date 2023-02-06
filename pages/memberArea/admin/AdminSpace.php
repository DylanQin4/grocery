<?php
require("../../../inc/Functions.php");
include("../../../inc/Pages.php");
if (isset($_GET["dropCateg"])) {
    removeCategory($_GET["dropCateg"]);
}
$defaultPage = $page[0];
if (isset($_GET["selectedPage"])) {
    $defaultPage = $page[$_GET["selectedPage"]];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../assets/fonts/fontawesome-5/css/all.css">
    <link rel="stylesheet" href="../../../assets/css/AdminSpace.css">
    <title>Espace administrateur</title>
</head>

<body class="container-fluid">
    <div class="row">
        <div class="col-md-3 d-flex flex-column flex-shrink-0 p-3 text-white bg-dark">
            <div class="d-flex align-items-center justify-content-center mb-3 mb-md-0">
                <img src="../../../assets/photos/icones/sarety.png" width="155px" height="60px">
            </div>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <?php for ($i = 0; $i < count($page); $i++) {
                    if ($page[$i][1] == $defaultPage[1]) { ?>
                <li>
                    <a href="./AdminSpace.php?selectedPage=<?php echo $i; ?>" class="nav-link text-white active">
                        <i class="<?php echo $icones[$i]; ?>" width="16" height="16">
                        </i> <?php echo $defaultPage[0]; ?>
                    </a>
                </li>
                <?php } else { ?>
                <li>
                    <a href="./AdminSpace.php?selectedPage=<?php echo $i; ?>" class="nav-link text-white">
                        <i class="<?php echo $icones[$i]; ?>" width="16" height="16">
                        </i> <?php echo $page[$i][0]; ?>
                    </a>
                </li>
                <?php }
                } ?>
            </ul>

            <hr>

            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../../assets/photos/icones/admin.png" alt="" width="32" height="32"
                        class="rounded-circle me-2">
                    <strong>Admin</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="./Treatment.php?dropCateg=1">Supprimer une categorie</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="../../../index.php">Deconnexion</a></li>
                </ul>
            </div>
        </div>

        <div class="col-md-9">

            <?php include($defaultPage[1] . ".php"); ?>

        </div>
    </div>
    <script src="../../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>