<?php
require("../../../inc/Functions.php");
include("../../../inc/Pages.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["newMember"])) {
    if (codeNotUsed($_POST["codeMember"])) {
        addNewMember($_POST["codeMember"], $_POST["name"], $_POST["firstName"], $_POST["contact"], $_POST["mail"], $_POST["password"]);
        header("Location: AdminSpace.php?selectedPage=" . $_GET["selectedPage"]);
    } else {
        header("Location: ./Treatment.php?new=0&error=1&selectedPage=" . $_GET["selectedPage"]);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["newCategory"])) {
    addNewCategory($_POST["categoryName"]);
    header("Location: AdminSpace.php?selectedPage=" . $_GET["selectedPage"]);
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["newProduct"])) {
    if (productAlreadyExist($_POST["name"])) {
        restoreCategory(getProductCategory(findProductByName($_POST["name"])));
        editProduct(findProductByName($_POST["name"]), $_POST["purchasingPrice"], $_POST["sellingPrice"], $_POST["stock"]);
        header("Location: AdminSpace.php?selectedPage=" . $_GET["selectedPage"]);
    } else {
        $fichier = basename($_FILES["avatar"]["name"]);
        $taille_maxi = 10000000;
        $taille = filesize($_FILES["avatar"]["tmp_name"]);
        $extensions = array(".png", ".gif", ".jpg", ".JPG", ".jpeg");
        $extension = strrchr($_FILES["avatar"]["name"], '.');
        $dossier = "../../../assets/photos/products/";

        if (!in_array($extension, $extensions)) {
            $erreur = "Vous ne pouvez pas uploader ce genre de fichier";
        }
        if ($taille > $taille_maxi) {
            $erreur = "Le fichier est trop volumineux...";
        }
        if (isset($erreur)) {
            header("Location: Treatment.php?new=2&error=" . $erreur . "&selectedPage=" . $_GET["selectedPage"]);
        }
        $fichier = strtr(
            $fichier,
            "ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ",
            "AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy"
        );
        $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $dossier . $fichier)) {
            addNewProduct($_POST["category"], $_POST["name"], $_POST["purchasingPrice"], $_POST["sellingPrice"], $_POST["stock"], $fichier);
            header("Location: AdminSpace.php?selectedPage=" . $_GET["selectedPage"]);
        } else {
            header("Location: Treatment.php?new=2&error=Erreur d'upload&selectedPage=" . $_GET["selectedPage"]);
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["editProduct"])) {
    editProduct($_GET["editProduct"], $_POST["purchasingPrice"], $_POST["sellingPrice"], $_POST["stock"]);
    header("Location: AdminSpace.php?selectedPage=" . $_GET["selectedPage"]);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../assets/bootstrap/css/bootstrap.min.css">
    <title>...</title>
</head>

<style>
    html,
    body {
        height: 100%;
    }
</style>

<body>
    <?php
    if (isset($_GET["del"])) { ?>
        <div class="modal modal-alert position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalChoice">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-3 shadow">
                    <div class="modal-body p-4 text-center">
                        <h5 class="mb-0">Êtes-vous sûr de vouloir continuer ?</h5>
                        <p class="mb-0">Cette action est irreversible</p>
                    </div>
                    <div class="modal-footer flex-nowrap p-0">
                        <?php $redirect = isset($_POST["toDropCateg"]) ? "dropCateg=" .  $_POST["toDropCateg"] : "selectedPage=" . $_GET["selectedPage"] . "&del=" . $_GET["del"]; ?>
                        <?php $redirect2 = isset($_POST["toDropCateg"]) ? "" : "selectedPage=" . $_GET["selectedPage"]; ?>
                        <a type="button" href="./AdminSpace.php?<?php echo $redirect; ?>" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end"><strong>Continuer</strong></a>
                        <a type="button" href="./AdminSpace.php?<?php echo $redirect2; ?>" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0" data-bs-dismiss="modal">Annuler</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if (isset($_GET["new"])) {
        include($add[$_GET["new"]] . ".php");
    } else if (isset($_GET["edit"])) {
        include("./EditProduct.php");
    } else if (isset($_GET["dropCateg"])) {
        include("./DropCategory.php");
    } ?>
</body>

</html>