<?php
$days = getThisWeekDates();
?>
<h1 class="my-4">Revenu hebdomadaire :</h1>
<div class="container text-center">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Jour</th>
                <th scope="col">Article(s)</th>
                <th scope="col">Revenu (Ar)</th>
                <th scope="col">Profit (Ar)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($days as $date) { ?>
                <tr>
                    <td><?php echo getDateWeekDaysName($date); ?></td>
                    <td><?php echo getSoldProducts($date); ?></td>
                    <td><?php echo getIncome($date); ?></td>
                    <td><?php echo getProfit($date); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3 class="mt-5">Total</h3>

    <div class="row shadow mt-5" style="border-radius: 10px;">
        <div class="col-md-4" style="border-right: 1px solid black">
            <h3>Articles vendus</h3>
            <p><?php echo getSoldProductsSinceMonday(); ?></p>
        </div>
        <div class="col-md-4" style="border-right: 1px solid black">
            <h3>Revenu</h3>
            <p>Ar <?php echo getInconeSinceMonday(); ?></p>
        </div>
        <div class="col-md-4">
            <h3>Profit</h3>
            <p>Ar <?php echo getProfitSinceMonday(); ?></p>
        </div>
    </div>
    <p class="text-center text-warning mt-5">Consulter l'historique des commandes pour plus de detail</p>
</div>