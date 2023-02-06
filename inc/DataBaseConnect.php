<?php
function getDataBase()
{
    static $bdd = null;
    if ($bdd == null) {
        $bdd = mysqli_connect("sql100.iceiy.com", "icei_33539791", "grocery2000", "icei_33539791_grocery");
    }
    return $bdd;
}
mysqli_set_charset(getDataBase(), "utf8");
