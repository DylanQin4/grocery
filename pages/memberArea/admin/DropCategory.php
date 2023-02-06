<?php $categories = getAllCategories(); ?>
<div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0 text-danger">Selectionnez le categorie à supprimer</h2>
            </div>

            <div class="modal-body p-5 pt-0">
                <form action="Treatment.php?del=1" method="POST">
                    <div class="form-floating mb-3">
                        <select class="form-control rounded-3" id="select" name="toDropCateg" required>
                            <?php for ($i = 0; $i < count($categories); $i++) { ?>
                            <option value="<?php echo $categories[$i]; ?>">
                                <?php echo getCategoryName($categories[$i]); ?></option>
                            <?php } ?>
                        </select>
                        <label for="select">Categorie</label>
                    </div>
                    <input class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" type="submit" value="Supprimer">
                    <hr class="my-4">
                </form>
            </div>

        </div>
    </div>
</div>