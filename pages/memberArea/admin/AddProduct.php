<?php $categories = getAllCategories(); ?>
<div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">

            <?php if (isset($_GET["error"])) { ?>
            <p class="text-center text-danger"><?php echo $_GET["error"]; ?></p>
            <?php } ?>
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Remplissez le formulaire</h2>
            </div>

            <div class="modal-body p-5 pt-0">
                <form action="Treatment.php?selectedPage=<?php echo $_GET["selectedPage"]; ?>&newProduct=1"
                    method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <select class="form-control rounded-3" id="select" name="category" required>
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                            <option value="<?php echo $categories[$i]; ?>">
                                <?php echo getCategoryName($categories[$i]); ?></option>
                            <?php } ?>
                        </select>
                        <label for="select">Categorie</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Nom"
                            name="name" required>
                        <label for="floatingInput">Nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3" id="floatingInput"
                            placeholder="Prix d'achat" name="purchasingPrice" required>
                        <label for="floatingInput">Prix d'achat</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3" id="floatingInput"
                            placeholder="Prix de vente" name="sellingPrice" required>
                        <label for="floatingInput">Prix de vente</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3" id="floatingInput" placeholder="Stock"
                            name="stock" required>
                        <label for="floatingInput">Stock</label>
                    </div>
                    <div class="mb-3">
                        <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
                        <input type="file" class="form-control rounded-3" id="customFile" name="avatar" required>
                    </div>
                    <input class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit" value="Confirmer">
                    <hr class="my-4">
                </form>
            </div>

        </div>
    </div>
</div>