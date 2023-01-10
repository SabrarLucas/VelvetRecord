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
    <a href="disc_new.php"><button>Ajouter</button></a><br>

    <h1>Nombre de diques (<?= $nb ?>)</h1>

    <table>
        <?php foreach ($tableau as $disc): ?>
        <tr>
            <td><img src="jaquettes/<?= $disc->disc_picture ?>" alt="<?= $disc->disc_picture ?>" width="40%"></td>
            <td><?= $disc->disc_title ?></td>
            <td aria-sort="descending"><?= $disc->artist_name ?></td>
            <td>Label : <?= $disc->disc_label ?></td>
            <td>Year : <?= $disc->disc_year ?></td>
            <td>Genre : <?= $disc->disc_genre ?></td>
            <td><a href="disc_detail.php?id=<?= $disc->disc_id ?>"><button>Détail</button></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>

<?php include("footer.php"); ?>