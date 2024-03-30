<?php
require_once('DatabaseHelper.php'); 
$database = new DatabaseHelper(); 

$min_blende = '';
if (isset($_POST['min_blende'])) {
    $min_blende = $_POST['min_blende'];
}

$max_blende = '';
if (isset($_POST['max_blende'])) {
    $max_blende = $_POST['max_blende'];
}

$success = $database->insertObjektiv($min_blende, $max_blende);

?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body style="background-size:cover">
    <?php if ($success) : ?>
        <h2 style="color:white;">  Objektiv f/<?php echo $min_blende ?> - f/<?php echo $max_blende ?> successfully added! </h2>

    <?php else :?>
        <h2 style="color:white;">  Error: can't insert Objektiv f/<?php echo $min_blende ?> - f/<?php echo $max_blende ?> </h2> 
    
    <?php endif; ?>
    <a href="index.php#Objektiv" style="color:white;">  
        Go back
    </a>
</body>