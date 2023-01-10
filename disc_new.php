<?php

    // on importe le contenu du fichier "db.php"
    include "db.php";
    // on exécute la méthode de connexion à notre BDD
    $db = connexion();

    // on lance une requête pour chercher touts les disques
    $requete = $db->query("SELECT artist_name, artist_id FROM artist");
    // on récupère tous les résultats trouvés dans une variable
    $tableau = $requete->fetchAll(PDO::FETCH_OBJ);
    // on clôt la requête en BDD
    $requete->closeCursor();
?>

<?php include("header.php"); ?>


    <h1>Ajout d'un nouveau disque</h1>

    <a href="discs.php"><button>Retour à la liste</button></a>

    <br>
    <br>

    <form action ="script_disc_ajout.php" method="post" enctype="multipart/form-data">

        <label for="titre_disc">Title</label><br>
        <input type="text" name="titre" id="titre_disc">
        <br><br>

        <label for="artist_disc">Artist</label><br>
        <select id="artist_disc" name="artist_id"> 
                    <option value="selection" selected>Choisissez un artiste</option>
                    <?php foreach ($tableau as $disc): ?>
                        <option value=<?=$disc->artist_id?>><?= $disc->artist_name ?></option>
                    <?php endforeach; ?>
                </select>

                
        <br><br>

        <label for="year_disc">Year</label><br>
        <input type="text" name="year" id="year_disc">
        <br><br>

        <label for="genre_disc">Genre</label><br>
        <input type="text" name="genre" id="genre_disc">
        <br><br>

        <label for="label_disc">Label</label><br>
        <input type="text" name="label" id="label_disc">
        <br><br>

        <label for="price_disc">Price</label><br>
        <input type="text" name="price" id="price_disc">
        <br><br>

        <label for="pic_disc">Picture</label><br>
        <input type="file" name="img" id="pic_disc">
        <br><br>

        <input type="submit" value="Ajouter">
        <input type="reset" value="Retour">

    </form>

<?php include("footer.php"); ?>