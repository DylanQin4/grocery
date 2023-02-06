<div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">

            <?php if (isset($_GET["error"])) { ?>
            <p class="text-danger text-center">Code deja utilisé. Veuillez-en trouver un autre</p>
            <?php } ?>
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h2 class="fw-bold mb-0">Remplissez le formulaire</h2>
            </div>

            <div class="modal-body p-5 pt-0">
                <form action="Treatment.php?selectedPage=<?php echo $_GET["selectedPage"]; ?>&newMember=1"
                    method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Code membre"
                            name="codeMember" required>
                        <label for="floatingInput">Code membre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Nom"
                            name="name" required>
                        <label for="floatingInput">Nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Prenom"
                            name="firstName" required>
                        <label for="floatingInput">Prenom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Contact"
                            name="contact" required>
                        <label for="floatingInput">Contact</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3" id="floatingInput"
                            placeholder="nom@exemple.com" name="mail" required>
                        <label for="floatingInput">Addresse email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="floatingPassword"
                            placeholder="Mot de passe" name="password" required>
                        <label for="floatingPassword">Mot de passe</label>
                    </div>
                    <input class="w-100 mb-2 btn btn-lg rounded-3 btn-success" type="submit" value="Confirmer">
                    <small class="text-muted">En confirmant, vous acceptez nos termes et conditions.</small>
                    <hr class="my-4">
                </form>
            </div>

        </div>
    </div>
</div>