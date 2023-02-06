    <div class="content container mt-4">
        <div class="mb-3 d-flex justify-content-between align-items-end">
            <h2>Resultat de : <?php echo $_POST["search"]; ?></h2>
            <p>0 : article(s) au panier</p>
        </div>
        <div class="mainContent">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-6 g-3">

                <?php
                $none = true;
                foreach ($foundProducts as $foundProduct) {
                    if (getProductStock($foundProduct) != 0) {
                ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <img src="../../assets/photos/products/<?php echo getProductPhoto($foundProduct); ?>">
                                <div class="card-body">
                                    <div class="card-text">
                                        <h5><?php echo getProductName($foundProduct); ?> :
                                            <?php echo getProductSellingPrice($foundProduct); ?> Ar</h5>
                                        <p>Stock : <?php echo getProductStock($foundProduct); ?></p>
                                    </div>
                                    <form class="inline-form d-flex align-items-center justify-content-end" action="./Transaction.php?purchase=1&productID=<?php echo $foundProduct; ?>" method="POST">
                                        <select name="quantite">
                                            <?php for ($i = 0; $i < getProductStock($foundProduct); $i++) { ?>
                                                <option value="<?php echo ($i + 1); ?>"><?php echo ($i + 1); ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="submit" class="btn btn-secondary mx-1" value="Ajouter">
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php $none = false;
                    }
                }
                if ($none) { ?>
                    <div class="content container w-100">
                        <div class="mainContent">
                            <p class="text-danger text-center py-5">Aucun produit trouvé</p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>