<?php
    // On charge l'enregistrement correspondant à l'ID passé en paramètre :
    require "db.php";
    $db = connexion();
    $requete = $db->prepare("SELECT * FROM disc WHERE disc_id=?");
    $requete->execute(array($_GET["id"]));
    $myDisc = $requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();

    $lesArtistes = $db->query("SELECT artist_name, artist_id FROM artist");
    // on récupère tous les résultats trouvés dans une variable
    $tableau = $lesArtistes->fetchAll(PDO::FETCH_OBJ);
    // on clôt la requête en BDD
    $lesArtistes->closeCursor();
?>

<?php include("header.php"); ?>


    <h1>Disque n°<?= $myDisc->disc_id ?></h1>

    <a href="discs.php?id=<?= $myDisc->disc_id ?>"><button>Retour</button></a><br>
    <br>

    <form action ="script_disc_modif.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id_modif" value="<?= $myDisc->disc_id ?>">

        <label for="disc_titre_modif">Title</label><br>
        <input type="text" name="title_modif" id="disc_titre_modif" value="<?= $myDisc->disc_title ?>">
        <br><br>

        <label for="nom_artiste_modif">Artist</label><br>        
        <select id="nom_artiste_modif" name="artist_id_modif"> 
            <?php foreach ($tableau as $disc): ?>
                <option value=<?=$disc->artist_id ?>><?= $disc->artist_name ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="disc_year_modif">Year</label><br>
        <input type="text" name="year_modif" id="disc_year_modif" value="<?= $myDisc->disc_year ?>">
        <br><br>

        <label for="disc_genre_modif">Genre</label><br>
        <input type="text" name="genre_modif" id="disc_genre_modif" value="<?= $myDisc->disc_genre ?>">
        <br><br>

        <label for="disc_label_modif">Label</label><br>
        <input type="text" name="label_modif" id="disc_label_modif" value="<?= $myDisc->disc_label ?>">
        <br><br>

        <label for="disc_price_modif">Price</label><br>
        <input type="text" name="price_modif" id="disc_price_modif" value="<?= $myDisc->disc_price ?>">
        <br><br>

        <label for="disc_picture_modif">Picture</label><br>
        <input type="file" name="img_modif" id="disc_picture_modif"><br>
        <img src="jaquettes/<?= $myDisc->disc_picture ?>" alt="<?= $myDisc->disc_picture ?>" width="20%">

        <br><br>

        <input type="reset" value="Annuler">
        <input type="submit" value="Modifier">

    </form>

<?php include("footer.php"); ?>