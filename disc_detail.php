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

    <h2>Détails</h2>
    <a href="discs.php?id=<?= $myDisc->disc_id ?>" class="btn btn-primary">Retour</a><br><br>
    <div class="row align-items-center"> 
        <div class="col-6">
            Titre <br>
            <ol class="breadcrumb p-2">
                <li class="breadcrumb-item active" aria-current="page"><?= $myDisc->disc_title ?></li><br>
            </ol>
        </div>
        <div class="col-6">
            Artist<br>
            <ol class="breadcrumb p-2">
                <li class="breadcrumb-item active" aria-current="page"><?= $myDisc->artist_name ?></li><br>
            </ol>
        </div>
    </div>
    <div class= "row align-items-center">
        <div class="col-6">
            Year<br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><?= $myDisc->disc_year ?></li><br>
            </ol>
        </div>
        <div class="col-6">
            Genre<br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><?= $myDisc->disc_genre ?></li><br>
            </ol>
        </div>
    </div>
    <div class= "row align-items-center">
        <div class="col-6">
            Label<br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><?= $myDisc->disc_label ?></li><br>
            </ol>
        </div>
        <div class="col-6">
            Price<br>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><?= $myDisc->disc_price ?><br></li><br>
            </ol>
        </div>
    </div>
    Picture <br>
    <img src="jaquettes/<?= $myDisc->disc_picture ?>" alt="<?= $myDisc->disc_picture ?>" width="30%"><br><br>
    <a href="disc_form.php?id=<?= $myDisc->disc_id ?>" class="btn btn-primary">Modifer</a>
    <a href="script_disc_delete.php?id=<?= $myDisc->disc_id ?>" id="supp" class="btn btn-primary">Supprimer</a><br><br>

<?php include("footer.php"); ?>