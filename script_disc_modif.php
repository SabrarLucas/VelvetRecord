<?php
    // Récupération des infos
    $id = (isset($_POST['id_modif']) && $_POST['id_modif'] != "") ? $_POST['id_modif'] : Null;

    $titre = (isset($_POST['title_modif']) && $_POST['title_modif'] != "") ? $_POST['title_modif'] : Null;
    $year = (isset($_POST['year_modif']) && $_POST['year_modif'] != "") ? $_POST['year_modif'] : Null;
    $img = $_FILES['img_modif']['name'];
    $label = (isset($_POST['label_modif']) && $_POST['label_modif'] != "") ? $_POST['label_modif'] : Null;
    $genre = (isset($_POST['genre_modif']) && $_POST['genre_modif'] != "") ? $_POST['genre_modif'] : Null;
    $price = (isset($_POST['price_modif']) && $_POST['price_modif'] != "") ? $_POST['price_modif'] : Null;
    $artist_id = (isset($_POST['artist_id_modif']) && $_POST['artist_id_modif'] != "") ? $_POST['artist_id_modif'] : Null;


    // Vérifier si le formulaire a été soumis
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Vérifie si le fichier a été uploadé sans erreur.
        if(isset($_FILES["img_modif"]) && $_FILES["img_modif"]["error"] == 0){
            $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
            $filename = $_FILES["img_modif"]["name"];
            $filetype = $_FILES["img_modif"]["type"];
            $filesize = $_FILES["img_modif"]["size"];

            // Vérifie l'extension du fichier
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

            // Vérifie la taille du fichier - 5Mo maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

            // Vérifie le type MIME du fichier
            if(in_array($filetype, $allowed)){
                echo "image ".$img;

                // Vérifie si le fichier existe avant de le télécharger.
                if(file_exists("./jaquettes/" . $_FILES["img_modif"]["name"])){
                    echo $_FILES["img_modif"]["name"] . " existe déjà.";
                } else{
                    move_uploaded_file($_FILES["img_modif"]["tmp_name"], "upload/" . $_FILES["img_modif"]["name"]);
                    echo "Votre fichier a été téléchargé avec succès.";
                } 
            } else{
                echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
            }
        } else{
            echo "Error: " . $_FILES["img_modif"]["error"];
        }
    }

    // En cas d'erreur, on renvoie vers le formulaire
    if ($titre == Null || $artist_id == Null || $year == Null || $genre == Null || $label == Null || $price == Null || $img == Null) {
        header("Location: disc_form.php");
        
        exit;
    }

    // Si la vérification des données est ok :
    require "db.php"; 
    $db = connexion();

    try {
        // Construction de la requête UPDATE sans injection SQL :
        $requete = $db->prepare("UPDATE disc
                                SET disc_title = :titre, disc_year = :annee, disc_picture = :img, disc_label = :label, disc_genre = :genre, disc_price = :price, artist_id = :artist_id
                                WHERE disc_id = :id;");

        // Association des valeurs aux paramètres via bindValue() :
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
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

    catch (Exception $e) {
        echo "Erreur : " . $requete->errorInfo()[2] . "<br>";
        die("Fin du script (script_disc_modif.php)");
    }

    // Si OK: redirection vers la page disc_detail.php
    header("Location: disc_detail.php?id=" . $id);

    exit;
?>