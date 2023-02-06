<?php
$methods = getAllPaymentMethod();
if (isset($_GET["dec"])) {
    $_SESSION["cart"] = decrementProductQuantity($_SESSION["cart"], $_GET["dec"]);
}
if (isset($_GET["del"])) {
    $_SESSION["cart"] = removeFromCart($_SESSION["cart"], $_GET["del"]);
}
if (isset($_GET["clear"])) {
    $_SESSION["cart"] = array();
}
$carts = getCart($_SESSION["cart"]);
?>
<div class="cart container mt-5">
    <?php
    if ($carts != null) { ?>
    <div class="clearCart d-flex justify-content-end mb-4" style="margin-right: 2em;">
        <a class="btn btn-dark" href="./MainStore.php?selectedPage=Cart&clear=1">Vider le panier</a>
    </div>
    <?php for ($i = 0; $i < count($carts); $i++) { ?>
    <div class="row shadow d-flex align-items-center mb-1">
        <img src="../../assets/photos/products/<?php echo getProductPhoto($carts[$i][0]); ?>" class="col-md-1">
        <p class="col-md-3"><?php echo getProductName($carts[$i][0]); ?> (x<?php echo $carts[$i][1]; ?>)</p>
        <p class="col-md-3"><?php echo getCategoryName(getProductCategory($carts[$i][0])); ?></p>
        <p class="col-md-2"><?php echo getProductSellingPrice($carts[$i][0]); ?> Ar</p>
        <div class="btn-group col-md-2">
            <a class="btn btn-warning" href="./MainStore.php?selectedPage=1&dec=<?php echo $i; ?>">Accepter</a>
            <a class="btn btn-danger" href="./MainStore.php?selectedPage=1&del=<?php echo $i; ?>">Decliner</a>
        </div>
    </div>
    <?php } ?>
    <form class="confirmation mt-4 d-flex justify-content-between align-items-center"
        action="./Transaction.php?confirmTransaction=1" method="POST">
        <div class="form-floating">
            <select name="paymentID">
                <?php for ($i = 0; $i < count($methods); $i++) { ?>
                <option value="<?php echo $methods[$i]; ?>"><?php echo getPaymentMethod($methods[$i]); ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="btn-group">
            <button class="btn btn-secondary">Total : <?php echo getTotalPrice($carts); ?> Ar</button>
            <button class="btn btn-success">Confirmer commande</button>
        </div>
    </form>
    <?php } else { ?>
    <p class="text-danger text-center">Aucun produit au panier</p>
    <?php } ?>
</div>