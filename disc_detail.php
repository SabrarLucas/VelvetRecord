<?php
    // On se connecte à la BDD via notre fichier db.php :
    require "db.php";
    $db = connexion();

    // On récupère l'ID passé en paramètre :
    $id = $_GET["id"];

    // On crée une requête préparée avec condition de recherche :
    $requete = $db->prepare("SELECT * FROM disc INNER JOIN artist ON disc.artist_id = artist.artist_id WHERE disc_id=?");
    // on ajoute l'ID du disque passé dans l'URL en paramètre et on exécute :
    $requete->execute(array($id));

    // on récupère le 1e (et seul) résultat :
    $myDisc = $requete->fetch(PDO::FETCH_OBJ);

    // on clôt la requête en BDD
    $requete->closeCursor();
?>

<?php include("header.php"); ?>

    <a href="discs.php?id=<?= $myDisc->disc_id ?>"><button>Retour</button></a><br><br>
    Titre <?= $myDisc->disc_title ?><br>
    Artist <?= $myDisc->artist_name ?><br>
    Year <?= $myDisc->disc_year ?><br>
    Genre <?= $myDisc->disc_genre ?><br>
    Label <?= $myDisc->disc_label ?><br>
    Price <?= $myDisc->disc_price ?><br>
    Picture <br><img src="jaquettes/<?= $myDisc->disc_picture ?>" alt="<?= $myDisc->disc_picture ?>" width="30%"><br>
    <a href="disc_form.php?id=<?= $myDisc->disc_id ?>"><button>Modifer</button></a>
    <a href="script_disc_delete.php?id=<?= $myDisc->disc_id ?>" id="supp"><button>Supprimer</button></a>

<?php include("footer.php"); ?>