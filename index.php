<?php

// If upload button is clicked ...
if (isset($_POST['upload'])) {
 
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./image/" . $filename;
 
    $db = mysqli_connect("localhost", "root", "", "geeksforgeeks");
    $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);

    // Get all the submitted data from the form
    if (($filename == null) || ($filename == "")) {
        echo "<h3>Pas d'image à télécharger</h3>";
    }
    else if ($extension!=='jpg' && $extension!=='jpeg' && $extension!=='png' && $extension!=='gif') { // A corriger
        echo "Le fichier sélectionné n'est pas au format jpg, jpeg, png ou gif.";
    }
    else {
        $sql = "INSERT INTO image (filename) VALUES ('$filename')";
        // Execute query
        mysqli_query($db, $sql);
     
        // Now let's move the uploaded image into the folder: image
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>Image téléchargée avec succès!</h3>";
        } else {
            echo "<h3>Echec du téléchargement de l'image!</h3>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload image and display</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="content">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <input class="form-control" type="file" name="uploadfile" value="" />
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
            </div>
        </form>
    </div>
    <div id="display-image">
    <?php
        $query = " select * from image ";
        $result = mysqli_query($db, $query);
 
        while ($data = mysqli_fetch_assoc($result)) {
    ?>
        <img src="./image/<?php echo $data['filename']; ?>">
    <?php
        }
    ?>
    </div>
    
</body>
</html>