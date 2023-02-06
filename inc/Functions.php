<?php
include("DataBaseConnect.php");

// about category
function getAllCategories()
{
    $result = mysqli_query(getDataBase(), "SELECT categoryID FROM Category WHERE isVisible='YES'");
    $resp = array();
    while ($data = mysqli_fetch_assoc($result)) {
        $resp[] = $data["categoryID"];
    }
    return $resp;
}

function getCategoryName($categoryID)
{
    $result = mysqli_query(getDataBase(), "SELECT name FROM Category WHERE categoryID=" . $categoryID);
    return mysqli_fetch_assoc($result)["name"];
}

function getAllCategorysProduct($categoryID)
{
    $resp = array();
    $result = mysqli_query(getDataBase(), "SELECT productID FROM Product WHERE categoryID=" . $categoryID . " AND isVisible='YES'");
    while ($data = mysqli_fetch_assoc($result)) {
        $resp[] = $data["productID"];
    }
    return $resp;
}

function categoryAlreadyExists($name)
{
    if (mysqli_num_rows(mysqli_query(getDataBase(), "SELECT categoryID FROM Category WHERE name='" . $name . "'")) > 0) {
        return true;
    }
    return false;
}

function addNewCategory($name)
{
    mysqli_query(getDataBase(), "INSERT INTO Category VALUES(NULL, '" . $name . "', 'YES')");
}

function removeCategory($categoryID)
{
    mysqli_query(getDataBase(), "UPDATE Product SET isVisible='NO' WHERE categoryID=" . $categoryID);
    mysqli_query(getDataBase(), "UPDATE Category SET isVisible='NO' WHERE categoryID=" . $categoryID);
}

function restoreCategory($categoryID)
{
    mysqli_query(getDataBase(), "UPDATE Category SET isVisible='YES' WHERE categoryID=" . $categoryID);
}

//-----------------------------------------\\

// about product
function getAllProducts()
{
    $products = array();
    $result = mysqli_query(getDataBase(), "SELECT productID FROM Product WHERE isVisible='YES'");
    while ($data = mysqli_fetch_assoc($result)) {
        $products[] = $data["productID"];
    }
    return $products;
}

function getProductName($productID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT name FROM Product WHERE productID=" . $productID))["name"];
}

function getProductCategory($productID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT categoryID FROM Product WHERE productID=" . $productID))["categoryID"];
}

function getProductSellingPrice($productID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT sellingPrice FROM Product WHERE productID=" . $productID))["sellingPrice"];
}

function getProductPurchasingPrice($productID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT purchasingPrice FROM Product WHERE productID=" . $productID))["purchasingPrice"];
}

function getProductProfit($productID)
{
    return getProductSellingPrice($productID) - getProductPurchasingPrice($productID);
}

function getProductStock($productID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT stock FROM Product WHERE productID=" . $productID))["stock"];
}

function getProductPhoto($productID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT photo FROM Product WHERE productID=" . $productID))["photo"];
}

// for interface searching
function searchProductByName($motif)
{
    $resp = array();
    $result = mysqli_query(getDataBase(), "SELECT productID FROM Product WHERE name LIKE '%" . $motif . "%' AND isVisible='YES'");
    while ($data = mysqli_fetch_assoc($result)) {
        $resp[] = $data["productID"];
    }
    return $resp;
}

// for server searching
function findProductByName($name)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT productID FROM Product WHERE name='" . $name . "'"))["productID"];
}

function productAlreadyExist($name)
{
    return mysqli_num_rows(mysqli_query(getDataBase(), "SELECT productID FROM Product WHERE name='" . $name . "'")) > 0 ? true : false;
}

function addNewProduct($categ, $name, $purchasingPrice, $sellingPrice, $stock, $photo)
{
    mysqli_query(getDataBase(), "INSERT INTO Product VALUES(NULL, " . $categ . ", '" . $name . "', " . $purchasingPrice . ", " . $sellingPrice . ", " . $stock . ", '" . $photo . "', 'YES')");
}

function deleteProduct($productID)
{
    mysqli_query(getDataBase(), "UPDATE Product SET isVisible='NO' WHERE productID=" . $productID);
}

function editProduct($productID, $purchasingPrice, $sellingPrice, $stock)
{
    mysqli_query(getDataBase(), "UPDATE Product SET purchasingPrice=" . $purchasingPrice . ",sellingPrice=" . $sellingPrice . ",stock=" . $stock . ",isVisible='YES' WHERE productID=" . $productID);
}

//-----------------------------------------\\

// transaction
function getCart($session_cart)
{
    if (count($session_cart) == 0) {
        return $session_cart;
    }
    $cart[0][0] = intval(explode(",", $session_cart[0])[0]);
    $cart[0][1] = intval(explode(",", $session_cart[0])[1]);
    for ($i = 1; $i < count($session_cart); $i++) {
        $cart[$i][0] = intval(explode(",", $session_cart[$i])[0]);
        $cart[$i][1] = intval(explode(",", $session_cart[$i])[1]);
    }
    return $cart;
}

function getTotalPrice($cart)
{
    $sum = 0;
    for ($i = 0; $i < count($cart); $i++) {
        $sum += getProductSellingPrice($cart[$i][0]) * $cart[$i][1];
    }
    return $sum;
}

function removeFromCart($cart, $elementID)
{
    if ($elementID == count($cart) - 1) {
        array_pop($cart);
        return $cart;
    }
    $temp_cart = array();
    for ($i = 0; $i < count($cart); $i++) {
        if ($i == $elementID) {
            for ($j = $i; $j + 1 < count($cart); $j++) {
                $cart[$j] = $cart[$j + 1];
                $temp_cart[] = $cart[$j];
            }
            break;
        }
        $temp_cart[] = $cart[$i];
    }
    return $temp_cart;
}

function addToCart($cart, $productID, $prodQuantity)
{
    for ($i = 0; $i < count($cart); $i++) {
        $temp_arr = explode(",", $cart[$i]);
        if ($temp_arr[0] == $productID) {
            $newProd = intval($temp_arr[1]) + intval($prodQuantity);
            $cart[$i] = $productID . "," . $newProd;
            return $newProd > getProductStock($productID) ? -1 : $cart;
        }
    }
    $cart[] = $productID . "," . $prodQuantity;
    return $cart;
}

function decrementProductQuantity($cart, $elementID)
{
    $tempProd = explode(",", $cart[$elementID]);
    $q = intval($tempProd[1]) - 1;
    if ($q == 0) {
        return removeFromCart($cart, $elementID);
    }
    $cart[$elementID] = $tempProd[0] . "," . $q;
    return $cart;
}

function confirmPurchases($cart, $clientID, $memberID, $paymentID, $contact)
{
    getInvoice($clientID);
    $invoiceID = getLastInvoiceID();
    for ($i = 0; $i < count($cart); $i++) {
        $temp_prod = explode(",", $cart[$i]);
        confirmCommand($invoiceID, intval($temp_prod[0]), intval($temp_prod[1]), $memberID, $paymentID, $contact);
    }
    return $invoiceID;
}

//-----------------------------------------\\

// about member
function logIn($memberCode, $password)
{
    $request = "SELECT memberID FROM Member WHERE memberCode='" . $memberCode . "' AND password='" . $password . "'";
    $result = mysqli_query(getDataBase(), $request);
    return mysqli_num_rows($result) > 0 ? mysqli_fetch_assoc($result)["memberID"] : -1;
}

function isAdmin($memberID)
{
    $request = "SELECT isAdmin FROM Member WHERE memberID=" . $memberID;
    $result = mysqli_query(getDataBase(), $request);
    return mysqli_fetch_assoc($result)["isAdmin"] == 1 ? true : false;
}

function addNewMember($codeMember, $name, $firstName, $contact, $mail, $password)
{
    mysqli_query(getDataBase(), "INSERT INTO Member VALUES(NULL, '" . $codeMember . "', '" . $name . "', '" . $firstName . "', '" . $contact . "', '" . $mail . "', '" . $password . "', 0)");
}

function getMemberCode($memberID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT memberCode FROM Member WHERE memberID=" . $memberID))["memberCode"];
}

function getMemberName($memberID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT name FROM Member WHERE memberID=" . $memberID))["name"];
}

function getMemberFirstName($memberID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT firstName FROM Member WHERE memberID=" . $memberID))["firstName"];
}

function getMemberContact($memberID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT contact FROM Member WHERE memberID=" . $memberID))["contact"];
}

function getMemberMail($memberID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT mail FROM Member WHERE memberID=" . $memberID))["mail"];
}

function getAllMembers()
{
    $members = array();
    $result = mysqli_query(getDataBase(), "SELECT memberID FROM Member WHERE isAdmin=0");
    while ($data = mysqli_fetch_assoc($result)) {
        $members[] = $data["memberID"];
    }
    return $members;
}

function searchMembers($motif)
{
    $found = array();
    $result = mysqli_query(getDataBase(), "SELECT memberID FROM Member WHERE (name LIKE '%" . $motif . "%' OR firstName LIKE '%" . $motif . "%' OR memberCODE='" . $motif . "') AND isAdmin=0");
    while ($data = mysqli_fetch_assoc($result)) {
        $found[] = $data["memberID"];
    }
    return $found;
}

function deleteMember($memberID)
{
    mysqli_query(getDataBase(), "DELETE FROM Member WHERE memberID=" . $memberID);
}

function codeNotUsed($codeMember)
{
    return mysqli_num_rows(mysqli_query(getDataBase(), "SELECT * FROM Member WHERE memberCode='" . $codeMember . "'")) > 0 ? false : true;
}

//-----------------------------------------\\

// about client
function isClient($clientID)
{
    $request = "SELECT clientID FROM Client WHERE clientID=" . $clientID;
    $result = mysqli_query(getDataBase(), $request);
    return mysqli_num_rows($result) > 0 ? true : false;
}

function createClientAccount($name, $firstName, $contact)
{
    mysqli_query(getDataBase(), "INSERT INTO Client VALUES(NULL, '" . $name . "', '" . $firstName . "', '" . $contact . "')");
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT MAX(clientID) FROM Client"))["MAX(clientID)"];
}

function getAllClients()
{
    $clients = array();
    $result = mysqli_query(getDataBase(), "SELECT clientID FROM Client");
    while ($data = mysqli_fetch_assoc($result)) {
        $clients[] = $data["clientID"];
    }
    return $clients;
}

function searchClients($motif)
{
    $found = array();
    $result = mysqli_query(getDataBase(), "SELECT clientID FROM Client WHERE name LIKE '%" . $motif . "%' OR firstName LIKE '%" . $motif . "%'");
    while ($data = mysqli_fetch_assoc($result)) {
        $found[] = $data["clientID"];
    }
    return $found;
}

function getClientName($clientID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT name FROM Client WHERE clientID=" . $clientID))["name"];
}

function getClientFirstName($clientID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT firstName FROM Client WHERE clientID=" . $clientID))["firstName"];
}

function getClientContact($clientID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT contact FROM Client WHERE clientID=" . $clientID))["contact"];
}

function deleteClient($clientID)
{
    mysqli_query(getDataBase(), "DELETE FROM Client WHERE clientID=" . $clientID);
}

//-----------------------------------------\\

// about invoice
function getLastInvoiceID()
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT MAX(invoiceID) FROM Invoice"))["MAX(invoiceID)"];
}

function getInvoiceClient($invoiceID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT clientID FROM Invoice WHERE invoiceID=" . $invoiceID))["clientID"];
}

function getInvoice($clientID)
{
    mysqli_query(getDataBase(), "INSERT INTO Invoice VALUES(NULL, " . $clientID . ", NOW(), 'YES')");
}

function getInvoiceDate($invoiceID)
{
    $day = mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT DAY(date) FROM Invoice WHERE invoiceID=" . $invoiceID))["DAY(date)"];
    $month = mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT MONTH(date) FROM Invoice WHERE invoiceID=" . $invoiceID))["MONTH(date)"];
    $year = mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT YEAR(date) FROM Invoice WHERE invoiceID=" . $invoiceID))["YEAR(date)"];
    return $day . "/" . $month . "/" . $year;
}

function getAllCommands($invoiceID)
{
    $commands = array();
    $result = mysqli_query(getDataBase(), "SELECT commandID FROM Command WHERE invoiceID=" . $invoiceID);
    while ($data = mysqli_fetch_assoc($result)) {
        $commands[] = $data["commandID"];
    }
    return $commands;
}

function getTotalCommands($invoiceID)
{
    $sum = 0;
    $commands = getAllCommands($invoiceID);
    for ($i = 0; $i < count($commands); $i++) {
        $sum += (getCommandProductQuantity($commands[$i])) * getProductSellingPrice(getCommandProduct($commands[$i]));
    }
    return $sum;
}
// for admin
function getTotalCommandProfits($invoiceID)
{
    $sum = 0;
    $commands = getAllCommands($invoiceID);
    for ($i = 0; $i < count($commands); $i++) {
        $sum += (((getCommandProductQuantity($commands[$i])) * getProductSellingPrice(getCommandProduct($commands[$i]))) - (getCommandProductQuantity($commands[$i]) * getProductPurchasingPrice(getCommandProduct($commands[$i]))));
    }
    return $sum;
}

function getAllInvoices()
{
    $invoices = array();
    $result = mysqli_query(getDataBase(), "SELECT invoiceID FROM Invoice WHERE isVisible='YES' ORDER BY date DESC");
    while ($data = mysqli_fetch_assoc($result)) {
        $invoices[] = $data["invoiceID"];
    }
    return $invoices;
}

function deleteInvoice($invoiceID)
{
    mysqli_query(getDataBase(), "UPDATE Invoice SET isVisible='NO' WHERE invoiceID=" . $invoiceID);
}

function searchInvoices($date)
{
    $result = mysqli_query(getDataBase(), "SELECT invoiceID FROM Invoice WHERE date='" . $date . "' AND isVisible='YES'");
    $invoices = array();
    while ($data = mysqli_fetch_assoc($result)) {
        $invoices[] = $data["invoiceID"];
    }
    return $invoices;
}

function searchingInvoices($date1, $date2)
{
    $result = mysqli_query(getDataBase(), "SELECT invoiceID FROM Invoice WHERE date>='" . $date1 . "' AND date<='" . $date2 . "' AND isVisible='YES'");
    $invoices = array();
    while ($data = mysqli_fetch_assoc($result)) {
        $invoices[] = $data["invoiceID"];
    }
    return $invoices;
}

//-----------------------------------------\\

// about command
function confirmCommand($invoiceID, $productID, $prodQuantity, $memberID, $paymentID, $contact)
{
    mysqli_query(getDataBase(), "INSERT INTO Command VALUES(NULL, " . $invoiceID . ", " . $productID . ", " . $prodQuantity . ", " . $memberID . ", " . $paymentID . ", '" . $contact . "')");
    mysqli_query(getDataBase(), "UPDATE Product SET stock=" . (getProductStock($productID) - $prodQuantity) . " WHERE productID=" . $productID);
}
// if paid with mobile money
function getCommandClientContact($commandID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT clientContact FROM Command WHERE commandID=" . $commandID))["clientContact"];
}

function getCommandPaymentMethod($commandID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT paymentMethodID FROM Command WHERE commandID=" . $commandID))["paymentMethodID"];
}

function getLastCommandID()
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT MAX(commandID) FROM Command"))["MAX(commandID)"];
}

function getCommandProduct($commandID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT productID FROM Command WHERE commandID=" . $commandID))["productID"];
}

function getCommandProductQuantity($commandID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT productQuantity FROM Command WHERE commandID=" . $commandID))["productQuantity"];
}

function getCommand_s_Member($commandID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT memberID FROM Command WHERE commandID=" . $commandID))["memberID"];
}

//-----------------------------------------\\

// about payment
function getPaymentMethod($paymentID)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT method FROM PaymentMethod WHERE paymentMethodID=" . $paymentID))["method"];
}

function getAllPaymentMethod()
{
    $methods = array();
    $result = mysqli_query(getDataBase(), "SELECT paymentMethodID FROM PaymentMethod");
    while ($data = mysqli_fetch_assoc($result)) {
        $methods[] = $data["paymentMethodID"];
    }
    return $methods;
}

//-----------------------------------------\\

function getSoldProducts($date)
{
    $sum = 0;
    $foundInvoices = searchInvoices($date);
    for ($i = 0; $i < count($foundInvoices); $i++) {
        $sum += mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT COUNT(productID) FROM Command GROUP BY invoiceID HAVING invoiceID=" . $foundInvoices[$i]))["COUNT(productID)"];
    }
    return $sum;
}

function getIncome($date)
{
    $sum = 0;
    $foundInvoices = searchInvoices($date);
    for ($i = 0; $i < count($foundInvoices); $i++) {
        $sum += getTotalCommands($foundInvoices[$i]);
    }
    return $sum;
}

function getProfit($date)
{
    $sum = 0;
    $foundInvoices = searchInvoices($date);
    for ($i = 0; $i < count($foundInvoices); $i++) {
        $sum += getTotalCommandProfits($foundInvoices[$i]);
    }
    return $sum;
}
// week profit
function getProfitSinceMonday()
{
    $dates = getThisWeekDates();
    $sum = 0;
    for ($i = 0; $i < count($dates); $i++) {
        $sum += getProfit($dates[$i]);
    }
    return $sum;
}

function getInconeSinceMonday()
{
    $dates = getThisWeekDates();
    $sum = 0;
    for ($i = 0; $i < count($dates); $i++) {
        $sum += getIncome($dates[$i]);
    }
    return $sum;
}

function getSoldProductsSinceMonday()
{
    $dates = getThisWeekDates();
    $sum = 0;
    for ($i = 0; $i < count($dates); $i++) {
        $sum += getSoldProducts($dates[$i]);
    }
    return $sum;
}

//-----------------------------------------\\

// utilities
function getThisWeekDates(/*todayDate*/)
{
    $dates = array();
    $today = mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT WEEKDAY(NOW())"))["WEEKDAY(NOW())"];
    for ($i = 0; $i != $today && $i < 7; $i++) {
        $dates[] = mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT ADDDATE(NOW(), " . ($i - $today) . ")"))["ADDDATE(NOW(), " . ($i - $today) . ")"];
    }
    // today
    $dates[] = mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT DATE(NOW())"))["DATE(NOW())"];
    return $dates;
}

function getDateWeekDaysName($date)
{
    return mysqli_fetch_assoc(mysqli_query(getDataBase(), "SELECT DAYNAME('" . $date . "')"))["DAYNAME('" . $date . "')"];
}