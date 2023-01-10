<?php
    // Récupération des infos
    $titre = (isset($_POST['titre']) && $_POST['titre'] != "") ? $_POST['titre'] : Null;
    $year = (isset($_POST['year']) && $_POST['year'] != "") ? $_POST['year'] : Null;
    $img = $_FILES['img']['name'];
    $label = (isset($_POST['label']) && $_POST['label'] != "") ? $_POST['label'] : Null;
    $genre = (isset($_POST['genre']) && $_POST['genre'] != "") ? $_POST['genre'] : Null;
    $price = (isset($_POST['price']) && $_POST['price'] != "") ? $_POST['price'] : Null;
    $artist_id = (isset($_POST['artist_id']) && $_POST['artist_id'] != "") ? $_POST['artist_id'] : Null;

    // Vérifier si le formulaire a été soumis
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Vérifie si le fichier a été uploadé sans erreur.
        if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["img"]["name"];
            $filetype = $_FILES["img"]["type"];
            $filesize = $_FILES["img"]["size"];

            // Vérifie l'extension du fichier
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

            // Vérifie la taille du fichier - 5Mo maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

            // Vérifie le type MIME du fichier
            if(in_array($filetype, $allowed)){
                // Vérifie si le fichier existe avant de le télécharger.
                if(file_exists("upload/" . $_FILES["photo"]["name"])){
                    echo $_FILES["photo"]["name"] . " existe déjà.";
                } else{
                    move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" . $_FILES["photo"]["name"]);
                    echo "Votre fichier a été téléchargé avec succès.";
                } 
            } else{
                echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
            }
        } else{
            echo "Error: " . $_FILES["photo"]["error"];
        }
    }

    // En cas d'erreur, on renvoie vers le formulaire
    if ($titre == Null || $artist_id == Null || $year == Null || $genre == Null || $label == Null || $price == Null || $img == Null) {
        header("Location: disc_new.php");
        
        exit;
    }

    // S'il n'y a pas eu de redirection vers le formulaire (= si la vérification des données est ok) :
    require "db.php"; 
    $db = connexion();

    try {
        // Construction de la requête INSERT sans injection SQL :
        $requete = $db->prepare("INSERT INTO disc (disc_title, disc_year, disc_picture, disc_label, disc_genre, disc_price, artist_id)
                                VALUES (:titre, :annee, :img, :label, :genre, :price, :artist_id)");

        // Association des valeurs aux paramètres via bindValue() :
        $requete->bindValue(":titre", $titre, PDO::PARAM_STR);
        $requete->bindValue(":annee", $year, PDO::PARAM_INT);
        $requete->bindValue(":img", $img, PDO::PARAM_STR);
        $requete->bindValue(":label", $label, PDO::PARAM_STR);
        $requete->bindValue(":genre", $genre, PDO::PARAM_STR);
        $requete->bindValue(":price", $price, PDO::PARAM_INT);
        $requete->bindValue(":artist_id", $artist_id, PDO::PARAM_INT);

        // Lancement de la requête :
        $requete->execute();

        // Libération de la requête (utile pour lancer d'autres requêtes par la suite) :
        $requete->closeCursor();
    }

    // Gestion des erreurs
    catch (Exception $e) {
        var_dump($requete->queryString);
        var_dump($requete->errorInfo());
        echo "Erreur : " . $requete->errorInfo()[2] . "<br>";
        die("Fin du script (script_disc_ajout.php)");
    }

    // Si OK: redirection vers la page discs.php
    header("Location: discs.php");

    // Fermeture du script
    exit;
?>