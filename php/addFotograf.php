<?php
require_once('DatabaseHelper.php');     
$database = new DatabaseHelper();  

$vorname = '';
if(isset($_POST['vorname'])){
    $vorname = $_POST['vorname'];
}

$nachname = '';
if(isset($_POST['nachname'])){
    $nachname = $_POST['nachname'];
}

$success = $database->insertFotograf($vorname, $nachname);
?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body style="background-size:cover">
    <?php if ($success) : ?>
        <h2 style="color:white;">  Fotograf <?php echo $vorname ?> <?php echo $nachname ?> successfully added! </h2>

    <?php else :?>
        <h2 style="color:white;">  Error: can't insert Fotograf <?php echo $vorname ?> <?php echo $nachname ?> </h2> 
    
    <?php endif; ?>
    <a href="index.php#Fotograf" style="color:white;">  
        Go back
    </a>
</body>
</html>
