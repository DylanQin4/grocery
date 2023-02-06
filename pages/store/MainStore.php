<?php
if (isset($_GET["alert"])) { ?>
    <script>
        alert("Le nombre de cet article depasse le nombre du stock. Reduisez-la");
    </script>
<?php }
session_start();
require("../../inc/Functions.php");
include("../../inc/Pages.php");
if (isset($_SESSION["clientID"])) {
    $categories = getAllCategories();
    $defaultPage = $pages[0];
    $foundProducts = array();
    if (isset($_GET["selectedPage"])) {
        $defaultPage = $pages[$_GET["selectedPage"]];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $defaultPage[0] = $searchPage;
        $defaultPage[1] = $defaultPage[0];
        $foundProducts = searchProductByName($_POST["search"]);
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../assets/css/MainStore.css">
        <title><?php echo $defaultPage[0]; ?></title>
    </head>

    <body>
        <nav class="container-fluid py-3 bg-dark text-white">
            <div class="header row d-flex flex-nowrap align-items-center">
                <div class="searchBar col-md-5 d-flex flex-nowrap justify-content-evenly align-items-center">
                    <img src="../../assets/photos/icones/sarety.png" width="150px" height="55px">
                    <form class="inline-form" action="<?php echo $_SERVER["SCRIPT_NAME"]; ?>" method="POST">
                        <input type="text" name="search">
                        <button class="btn btn-secondary">Rechercher</button>
                    </form>
                </div>
                <div class="navigator col-md-4">
                    <ul class="d-flex m-0 justify-content-evenly list-unstyled">
                        <?php for ($i = 0; $i < count($pages); $i++) {
                            if ($pages[$i][1] == $defaultPage[1]) { ?>
                                <li class="active"><a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>?selectedPage=<?php echo $i; ?>"><?php echo $pages[$i][0]; ?></a>
                                </li>
                            <?php } else { ?>
                                <li><a href="<?php echo $_SERVER["SCRIPT_NAME"]; ?>?selectedPage=<?php echo $i; ?>"><?php echo $pages[$i][0]; ?></a>
                                </li>
                        <?php }
                        } ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown">
                                <?php foreach ($categories as $category) { ?>
                                    <li><a class="dropdown-item" href="<?php $_SERVER["SCRIPT_NAME"]; ?>?selectedCategory=<?php echo $category; ?>"><?php echo getCategoryName($category); ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="disconnectBtn col-md-3 d-flex justify-content-end btn-group">
                    <button class="btn btn-secondary"><a href="../../index.php?onlyClient=1">Sortie(Client)</a></button>
                    <button class="btn btn-danger"><a href="../../index.php">Se deconnecter</a></button>
                </div>
            </div>
        </nav>

        <!-- main page -->

        <?php include($defaultPage[1] . ".php"); ?>

        <script src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>

<?php } else {
    header("Location: ../clientArea/ClientLogIn.php");
} ?>