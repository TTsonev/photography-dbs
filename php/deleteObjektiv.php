<?php

require_once('DatabaseHelper.php'); 
$database = new DatabaseHelper();  

$objnr = '';
if(isset($_POST['objnr'])){
    $objnr = $_POST['objnr'];
}
     
$error_code = $database->deleteObjektiv($objnr);

?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body>
    <?php if ($error_code == 1) : ?>
        <h2 style="color:white;">  Objektiv <?php echo $objnr ?> successfully deleted! </h2>

    <?php else :?>
        <h2 style="color:white;">  Error can't delete Objektiv <?php echo $objnr ?> (Errorcode: <?php echo $error_code ?>) </h2> 
    
    <?php endif; ?>
    <a href="index.php#Objektiv" style="color:white;">  
        Go back
    </a>
</body>
</html>