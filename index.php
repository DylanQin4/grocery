<?php
if (isset($_GET["onlyClient"])) {
    session_start();
    $tempMember = $_SESSION["memberID"];
    session_destroy();
    session_start();
    $_SESSION["memberID"] = $tempMember;
    header("Location: ./pages/clientArea/ClientLogIn.php");
} else {
    session_destroy();
    header("Location: ./pages/memberArea/MemberLogIn.php");
}
