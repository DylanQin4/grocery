<?php
if (isset($_GET["del"])) {
    deleteClient($_GET["del"]);
}
$foundClients = getAllClients();
$defaultHeader = "Liste de tous les clients";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET["clientSearch"])) {
    $defaultHeader = "Liste des clients trouvés";
    $foundClients = searchClients($_POST["search"]);
}
?>

<form class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow" action="./AdminSpace.php?selectedPage=4&clientSearch=1" method="POST">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Tranom-barotra</a>
    <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Rechercher un client..." aria-label="Search" name="search">
    <button class="nav-link px-3 btn btn-dark text-white" href="#">Rechercher</button>
</form>
<?php if (count($foundClients) > 0) { ?>
    <h2 class="mt-5"><?php echo $defaultHeader; ?> : </h2>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">ID Client</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prenom</th>
                    <th scope="col">Contact</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foundClients as $client) { ?>
                    <tr>
                        <td></td>
                        <td><?php echo $client; ?></td>
                        <td><?php echo getClientName($client); ?></td>
                        <td><?php echo getClientFirstName($client); ?></td>
                        <td><?php echo getClientContact($client); ?></td>
                        <td><a href="./Treatment.php?del=<?php echo $client; ?>&selectedPage=4" class="btn btn-danger"><i class="fas fa-times"></i></a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <p class="text-danger text-center mt-5">Aucun client trouvé</p>
<?php } ?>