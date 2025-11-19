<?php
session_start(); 
require 'database.php';
$pdo = connectToDBandGetPDOdb();

// Check if file is sent and there are no upload errors
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    
    // 1. On définit le nom du dossier
    $dossier = "photo de profil/";
    
    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true); // Added permissions and recursive flag
    }

    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    
    // Security: Verify extension (Optional but recommended)
    // if(!in_array($extension, ['jpg', 'jpeg', 'png'])) { die("Format invalid"); }

    // 2. On récupère le nom original ou on renomme
    $nomFichier = $_SESSION['user_name'] . '.' . $extension;

    // 3. On construit le chemin final
    $destination = $dossier . $nomFichier;

    // 4. On déplace le fichier
    if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
        echo "Succès ! L'image est dans le dossier '$dossier'.";
        
        
        $sql = "UPDATE users SET photo_profil = ? WHERE id_user = ?";
        $stmt = $pdo->prepare($sql);
        
        // Execute with both the path and the ID
        $stmt->execute([$destination, $_SESSION['user_id']]); 
        
        echo " Base de données mise à jour !";

    } else {
        echo "Erreur lors de l'upload.";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="image" accept=".jpg, .jpeg, .png, .svg, image/jpeg, image/png, image/svg+xml">
    <input type="submit" value="Uploader">
</form>