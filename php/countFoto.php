<?php

require_once('DatabaseHelper.php');     //include DatabaseHelper.php file
$database = new DatabaseHelper();   //instantiate DatabaseHelper class


$standort = '';
if(isset($_POST['standort'])){
    $standort = $_POST['standort'];
}
     
$count = $database->countFoto($standort);
?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body style="background-size:cover">
    <h2 style="color:white;"> <?php echo $count ?> Fotos in <?php echo $standort ?> </h2>
    <a href="index.php#Kamera" style="color:white;">  
        Go back
    </a>
</body>
</html>