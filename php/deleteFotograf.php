<?php

require_once('DatabaseHelper.php');
$database = new DatabaseHelper();   


$id = '';
if(isset($_POST['id'])){
    $id = $_POST['id'];
}
     
$error_code = $database->deleteFotograf($id);
?>

<html>
<head>
    <title>Fotoklub DBS</title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>
<body>
    <?php if ($error_code == 1) : ?>
        <h2 style="color:white;">  Fotograf <?php echo $id ?> successfully deleted! </h2>

    <?php else :?>
        <h2 style="color:white;">  Error: can't delete Fotograf <?php echo $id ?> (Errorcode: <?php echo $error_code ?>) </h2> 
    
    <?php endif; ?>
    <a href="index.php#Fotograf" style="color:white;">  
        Go back
    </a>
</body>
</html>