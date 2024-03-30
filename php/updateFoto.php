<?php
require_once('DatabaseHelper.php');     
$database = new DatabaseHelper();       

$id = '';
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

$kennzahl = '';
if (isset($_POST['kennzahl'])) {
    $kennzahl = $_POST['kennzahl'];
}

$exposition = '';
if (isset($_POST['exposition'])) {
    $exposition = $_POST['exposition'];
}

$success = $database->updateFoto($id, $kennzahl, $exposition);

?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body style="background-size:cover">
    <?php if ($success) : ?>
        <h2 style="color:white;"> Exposition beim Foto <?php echo $kennzahl ?> vom Fotografen <?php echo $id ?> gesetzt auf <?php echo $exposition ?> </h2>

    <?php else :?>
        <h2 style="color:white;"> Error: can't update Exposition beim Foto <?php echo $kennzahl ?> vom Fotografen <?php echo $id ?>  </h2> 
    
    <?php endif; ?>
    <a href="index.php#Foto" style="color:white;">  
        Go back
    </a>
</body>
</html>
