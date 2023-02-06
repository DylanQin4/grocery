<div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">

            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Donnez nom à la nouvelle categorie</h2>
            </div>

            <div class="modal-body p-5 pt-0">
                <form action="Treatment.php?selectedPage=<?php echo $_GET["selectedPage"]; ?>&newCategory=1"
                    method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Nom..."
                            name="categoryName" required>
                        <label for="floatingInput">Nom de la categorie</label>
                    </div>
                    <input class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit" value="Confirmer">
                    <hr class="my-4">
                </form>
            </div>

        </div>
    </div>
</div>