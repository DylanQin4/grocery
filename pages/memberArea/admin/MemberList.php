<?php
if (isset($_GET["del"])) {
    deleteMember($_GET["del"]);
}
$foundMembers = getAllMembers();
$defaultHeader = "Liste de tous les membres";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["memberSearch"])) {
    $defaultHeader = "Liste des membres trouvés";
    $foundMembers = searchMembers($_POST["search"]);
}
?>

<form class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" action="./AdminSpace.php?selectedPage=3&memberSearch=1" method="POST">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Tranom-barotra</a>
    <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Rechercher un membre..." aria-label="Search" name="search">
    <button class="nav-link px-3 btn btn-dark text-white" href="#">Rechercher</button>
</form>
<div class="add d-flex justify-content-end mt-5">
    <a class="btn btn-success mx-4" href="./Treatment.php?new=0&selectedPage=3"><i class="fas fa-user-plus"></i></a>
</div>
<?php if (count($foundMembers) > 0) { ?>
    <h2 class="my-2"><?php echo $defaultHeader; ?> : </h2>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Code membre</th>
                <th scope="col">Nom</th>
                <th scope="col">Prenom</th>
                <th scope="col">Contact</th>
                <th scope="col">E-mail</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($foundMembers as $member) { ?>
                <tr>
                    <td><?php echo getMemberCode($member); ?></td>
                    <td><?php echo getMemberName($member); ?></td>
                    <td><?php echo getMemberFirstName($member); ?></td>
                    <td><?php echo getMemberContact($member); ?></td>
                    <td><?php echo getMemberMail($member); ?></td>
                    <td><a href="./Treatment.php?del=<?php echo $member; ?>&selectedPage=3" class="btn btn-danger"><i class="fas fa-times"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <p class="text-danger text-center mt-5">Aucun membre trouvé</p>
<?php } ?>