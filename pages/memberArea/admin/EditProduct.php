<?php $categories = getAllCategories(); ?>
<div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Modifier : <?php echo getProductName($_GET["edit"]); ?></h2>
            </div>

            <div class="modal-body p-5 pt-0">
                <form action="Treatment.php?selectedPage=<?php echo $_GET["selectedPage"]; ?>&editProduct=<?php echo $_GET["edit"]; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3" id="floatingInput" placeholder="Prix d'achat" name="purchasingPrice" value="<?php echo getProductPurchasingPrice($_GET["edit"]); ?>">
                        <label for="floatingInput">Prix d'achat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3" id="floatingInput" placeholder="Prix de vente" name="sellingPrice" value="<?php echo getProductSellingPrice($_GET["edit"]); ?>">
                        <label for="floatingInput">Prix de vente</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3" id="floatingInput" placeholder="Stock" name="stock" value="<?php echo getProductStock($_GET["edit"]); ?>">
                        <label for="floatingInput">Stock</label>
                    </div>
                    <input class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit" value="Confirmer">
                    <hr class="my-4">
                </form>
            </div>

        </div>
    </div>
</div>