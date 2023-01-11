<?php

    // on importe le contenu du fichier "db.php"
    include "db.php";
    // on exécute la méthode de connexion à notre BDD
    $db = connexion();

    // on lance une requête pour chercher touts les disques
    $requete = $db->query("SELECT * FROM disc INNER JOIN artist ON disc.artist_id = artist.artist_id");
    // on récupère tous les résultats trouvés dans une variable
    $tableau = $requete->fetchAll(PDO::FETCH_OBJ);
    // on clôt la requête en BDD
    $requete->closeCursor();

    $test = $db->query("SELECT COUNT(disc_id) AS total FROM disc");
    // on récupère tous les résultats trouvés dans une variable
    $calcul = $test->fetch();
    $nb = $calcul['total'];
    // on clôt la requête en BDD
?>


<?php include("header.php"); ?>

<section>
    <a href="disc_new.php"><button type="button" class="btn btn-primary float-right" id="aj">Ajouter</button></a>

    <div class="container">
        <h2><p class="font-weight-bold">Nombres de disques (<?= $nb ?>)</p></h2>    
        <div class="row">
            <?php foreach ($tableau as $disc): ?>
            <div class="card col-lg-5 col-12 m-4" style="width:18rem;"id="card">
                <div class="row">
                    <img src="jaquettes/<?= $disc->disc_picture ?>" style="max-width:auto;height:auto"  class="card-img-top col-6 w-25" id="imgcard" alt="<?= $disc->disc_picture ?>">
                    <div class="card-body col-6">
                        <p class="text-right font-weight-bold"><?= $disc->disc_title ?>
                        <p class="text-right font-weight-bold"><?= $disc->artist_name ?>
                        <p class="text-right">Label : <?= $disc->disc_label ?>
                        <p class="text-right">Year : <?= $disc->disc_year ?>
                        <p class="text-right">Genre :<?= $disc->disc_genre ?>
                        <p class="text-right"><a href="disc_detail.php?id=<?= $disc->disc_id ?>" class="btn btn-primary stretched-link">Détails</a>
                    </div>
                </div>        
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>