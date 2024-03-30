<?php
require_once('DatabaseHelper.php'); 
$database = new DatabaseHelper();       

$kameranr = '';
if (isset($_POST['kameranr'])) {
    $kameranr = $_POST['kameranr'];
}

$aufloesungen = '';
if (isset($_POST['aufloesungen'])) {
    $aufloesungen = $_POST['aufloesungen'];
}

$success = $database->updateKamera($kameranr, $aufloesungen);

?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body style="background-size:cover">
    <?php if ($success && $aufloesungen < 200000) : ?>
        <h2 style="color:white;"> Kamera  <?php echo $kameranr ?> set to <?php echo $aufloesungen ?> Aufloesungen</h2>
    
    <?php elseif ($success && $aufloesungen >= 200000) : ?>
        <h2 style="color:white;"> Kamera  <?php echo $kameranr ?> set to 200000 Aufloesungen</h2>

    <?php else :?>
        <h2 style="color:white;"> Error! </h2> 
    
    <?php endif; ?>
    <a href="index.php#Kamera" style="color:white;">  
        Go back
    </a>
</body>
</html>