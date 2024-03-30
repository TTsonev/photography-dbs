<?php
require_once('DatabaseHelper.php');     //include DatabaseHelper.php file
$database = new DatabaseHelper();       //instantiate DatabaseHelper class

$typ = '';
if (isset($_POST['typ'])) {
    $typ = $_POST['typ'];
}

$aufloesungen = '';
if (isset($_POST['aufloesungen'])) {
    $aufloesungen = $_POST['aufloesungen'];
}

$success = $database->insertKamera($typ, $aufloesungen);

?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body style="background-size:cover">
    <?php if ($success) : ?>
        <h2 style="color:white;"> <?php echo $typ ?> Kamera  mit <?php echo $aufloesungen ?> Aufloesungen successfully added! </h2>

    <?php else :?>
        <h2 style="color:white;">  Error: can't insert Kamera <?php echo $typ ?> <?php echo $aufloesungen ?> </h2> 
    
    <?php endif; ?>
    <a href="index.php#Kamera" style="color:white;">  
        Go back
    </a>
</body>
</html>