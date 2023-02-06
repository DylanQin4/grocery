<?php
require("../../inc/Functions.php");
session_start();
if (isset($_GET["purchase"])) {
    if (addToCart($_SESSION["cart"], $_GET["productID"], $_POST["quantite"]) == -1) {
        header("Location: MainStore.php?alert=1&selectedCategory" . $_GET["selectedCategory"]);
    } else {
        $_SESSION["cart"] = addToCart($_SESSION["cart"], $_GET["productID"], $_POST["quantite"]);
        $plus = "";
        if (isset($_GET["selectedCategory"])) {
            $plus = "?selectedCategory=" . $_GET["selectedCategory"];
        }
        header("Location: MainStore.php" . $plus);
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["confirmTransaction"])) {
    if (getPaymentMethod($_POST["paymentID"]) == "Mobile money") {
        header("Location: ../clientArea/Invoice.php?paymentID=" . $_POST["paymentID"]);
    } else {
        header("Location: ../clientArea/Invoice.php?invoiceConfirmed=" . confirmPurchases($_SESSION["cart"], $_SESSION["clientID"], $_SESSION["memberID"], $_POST["paymentID"], null));
    }
}
