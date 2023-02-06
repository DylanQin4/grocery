<?php
if (isset($_GET["del"])) {
    deleteProduct($_GET["del"]);
}
$categories = getAllCategories();
$foundProducts = getAllProducts();
$defaultHeader = "Liste de tous les produits";
if (isset($_GET["selectedCategory"])) {
    $foundProducts = getAllCategorysProduct($_GET["selectedCategory"]);
    $defaultHeader = "Categorie " . getCategoryName($_GET["selectedCategory"]);
}
if (isset($_GET["productSearch"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $foundProducts = searchProductByName($_POST["search"]);
    $defaultHeader = "Resultat de '" . $_POST["search"] . "'";
}
?>

<form class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow"
    action="./AdminSpace.php?selectedPage=1&productSearch=1" method="POST">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Tranom-barotra</a>
    <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text"
        placeholder="Rechercher un produit..." aria-label="Search" name="search">
    <button class="nav-link px-3 btn btn-dark text-white" href="#">Rechercher</button>
</form>
<div class="add d-flex justify-content-between mt-5">
    <div class="dropdown">
        <a href="" class="btn btn-secondary mx-4" id="dropdown" data-bs-toggle="dropdown"><i
                class="fas fa-bars"></i></a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
            <li><a class="dropdown-item" href="./AdminSpace.php?selectedPage=1">Tous les produits</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <?php for ($i = 0; $i < count($categories); $i++) { ?>
            <li><a class="dropdown-item"
                    href="./AdminSpace.php?selectedPage=1&selectedCategory=<?php echo $categories[$i]; ?>"><?php echo getCategoryName($categories[$i]); ?></a>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="btn-group mx-4">
        <a class="btn btn-success" href="./Treatment.php?new=2&selectedPage=1"><i class="fas fa-plus"></i> produit</a>
        <a class="btn btn-primary" href="./Treatment.php?new=1&selectedPage=1">categorie <i class="fas fa-plus"></i></a>
    </div>
</div>
<?php if (count($foundProducts) > 0) { ?>
<h2 class="mt-5"><?php echo $defaultHeader; ?> : </h2>
<div class="container">
    <div class="row shadow d-flex align-items-center mb-1 pt-3">
        <p class="col-md-1"></p>
        <p class="col-md-2"><u>Nom</u></p>
        <p class="col-md-2"><u>Categorie</u></p>
        <p class="col-md-2"><u>Prix d'achat</u></p>
        <p class="col-md-2"><u>Prix de vente</u></p>
        <p class="col-md-1"><u>Stock</u></p>
        <p class="col-md-2"></p>
    </div>
    <?php foreach ($foundProducts as $product) { ?>
    <div class="row shadow d-flex align-items-center mb-1">
        <img src="../../../assets/photos/products/<?php echo getProductPhoto($product); ?>" class="col-md-1">
        <p class="col-md-2"><?php echo getProductName($product); ?></p>
        <p class="col-md-2"><?php echo getCategoryName(getProductCategory($product)); ?></p>
        <p class="col-md-2"><?php echo getProductPurchasingPrice($product); ?> Ar</p>
        <p class="col-md-2"><?php echo getProductSellingPrice($product); ?> Ar</p>
        <p class="col-md-1"><?php echo getProductStock($product); ?></p>
        <div class="col-md-2 btn-group">
            <a href="./Treatment.php?edit=<?php echo $product; ?>&selectedPage=1" class="btn btn-warning"><i
                    class="fas fa-cog"></i></a>
            <a href="./Treatment.php?del=<?php echo $product; ?>&selectedPage=1" class="btn btn-danger"><i
                    class="fas fa-times"></i></a>
        </div>
    </div>
    <?php } ?>
</div>
<?php } else { ?>
<p class="text-danger text-center mt-5">Aucun produit trouvé</p>
<?php } ?>