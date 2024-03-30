<?php

require_once('DatabaseHelper.php');  
$database = new DatabaseHelper();       

$id = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}

$vorname = '';
if (isset($_GET['vorname'])) {
    $vorname = $_GET['vorname'];
}

$nachname = '';
if (isset($_GET['nachname'])) {
    $nachname = $_GET['nachname'];
}

$objnr = '';
if (isset($_GET['objnr'])) {
    $objnr = $_GET['objnr'];
}

$min_blende = '';
if (isset($_GET['min_blende'])) {
    $min_blende = $_GET['min_blende'];
}

$max_blende = '';
if (isset($_GET['max_blende'])) {
    $max_blende = $_GET['max_blende'];
}

$kameranr = '';
if (isset($_GET['kameranr'])) {
    $kameranr = $_GET['kameranr'];
}

$typ = '';
if (isset($_GET['typ'])) {
    $typ = $_GET['typ'];
}

$aufloesungen = '';
if (isset($_GET['aufloesungen'])) {
    $aufloesungen = $_GET['aufloesungen'];
}

$farbe = '';
if (isset($_GET['farbe'])) {
    $farbe = $_GET['farbe'];
}

$zustand = '';
if (isset($_GET['zustand'])) {
    $zustand = $_GET['zustand'];
}

$modelnr = '';
if (isset($_GET['modelnr'])) {
    $modelnr = $_GET['modelnr'];
}

$kennzahl = '';
if (isset($_GET['kennzahl'])) {
    $kennzahl = $_GET['kennzahl'];
}

$standort = '';
if (isset($_GET['standort'])) {
    $standort = $_GET['standort'];
}

$zeit = '';
if (isset($_GET['zeit'])) {
    $zeit = $_GET['zeit'];
}

$exposition = '';
if (isset($_GET['exposition'])) {
    $exposition = $_GET['exposition'];
}

$alter = '';
if (isset($_GET['alter'])) {
    $alter = $_GET['alter'];
}

$geschlecht = '';
if (isset($_GET['geschlecht'])) {
    $geschlecht = $_GET['geschlecht'];
}

$fotograf_array = $database->selectAllFotografen($id, $nachname, $vorname);
$objektiv_array = $database->selectAllObjektiv($objnr, $min_blende, $max_blende);
$kamera_array = $database->selectAllKamera($kameranr, $typ, $aufloesungen);
$sony_array = $database->selectAllSony($kameranr, $farbe, $zustand, $typ, $aufloesungen);
$haben_array = $database->selectAllHaben($id, $kameranr, $objnr);
$zeigen_array = $database->selectAllZeigen($modelnr, $kennzahl, $id);
$foto_array = $database->selectAllFoto($kennzahl, $id, $exposition, $zeit, $standort);
$model_array = $database->selectAllModel($modelnr, $alter, $geschlecht);

?>

<html>
<head>
    <title> Fotoklub DBS </title>
    <link rel="stylesheet" type="text/css" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="flaticon-camera.png">
</head>

<body>

<ul class="navbar">
  <li><a href="#Fotograf">Fotograf</a></li>
  <li><a href="#Objektiv">Objektiv</a></li>
  <li><a href="#Kamera">Kamera</a></li>
  <li><a href="#Sony">Sony (IS-A)</a></li>
  <li><a href="#Foto">Foto (1:m)</a></li>
  <li><a href="#Haben">Haben (1:1:m)</a></li>
  <li><a href="#Model">Model</a></li>
  <li><a href="#Zeigen">Zeigen (m:n)</a></li>
  <li><a href="#ER">ER Diagramm</a></li>
</ul> 

<button class="return">
    <a href="#top">Scroll to Top</a>
</button>

<button class="refresh">
    <a href="https://wwwlab.cs.univie.ac.at/~trayant21/">Refresh</a>
</button>


<h1 id="top">Fotoklub</h1>

<iframe name="placeholder" id="placeholder" style="display: none;"></iframe>

<!-- Fotograf -->
<div class="segment" id="Fotograf">
    <div class="float-left">

        <!-- Insert Fotograf -->
        <div class="float-left-child">
            <h2>Add Fotograf: </h2>
            <form method="post" action="addFotograf.php">
                <div>
                    <label for="new_vorname">Vorname:</label>
                    <input id="new_vorname" name="vorname" type="text" maxlength="30" style="float:right;" required>
                </div>
                <br>

                <div>
                    <label for="new_nachname">Nachname:</label>
                    <input id="new_nachname" name="nachname" type="text" maxlength="30" style="float:right;" required>
                </div>
                <br>

                <div>
                    <button type="submit">
                        Add Fotograf
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Fotograf Search Form -->
        <div class="float-left-child">
            <h2>Fotograf Search:</h2>
            <form method="get">
                <div>
                    <label for="id">ID:</label>
                    <input id="id" name="id" type="number" value='<?php echo $id; ?>' min="0" style="float:right;">
                </div>
                <br>

                <div>
                    <label for="vorname">Vorame:</label>
                    <input id="vorname" name="vorname" type="text" value='<?php echo $vorname; ?>' maxlength="30" style="float:right;">
                </div>
                <br>

                <div>
                    <label for="nachname">Nachname:</label>
                    <input id="nachname" name="nachname" type="text" value='<?php echo $nachname; ?>' maxlength="30" style="float:right;"> 
                </div>
                <br>
            
                <div>
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Fotograf -->
        <div class="float-left-child">
            <h2>Delete Fotograf: </h2>
            <form method="post" action="deleteFotograf.php">
                <!-- ID Textbox -->
                <div>
                    <label for="del_name">ID:</label>
                    <input id="del_name" name="id" type="number" min="0" style="float:right;"  required>
                </div>
                <br>

                <!-- Submit button -->
                <div>
                    <button type="submit">
                        Delete Fotograf
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Fotograf Search Result -->
    <div class = "container-table">
        <h2>Fotograf Search Result:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Vorname</th>
                <th>Nachname</th>
            </tr>
            <?php foreach ($fotograf_array as $fotograf) : ?>
                <tr>
                    <td><?php echo $fotograf['ID']; ?>  </td>
                    <td><?php echo $fotograf['VORNAME']; ?>  </td>
                    <td><?php echo $fotograf['NACHNAME']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<br>
</div>


<!-- Objektiv -->
<div class="segment" id="Objektiv">
    <div class="float-left">
        
        <!-- Insert Objektiv -->
        <div class="float-left-child">
            <h2>Add Objektiv: </h2>
            <form method="post" action="addObjektiv.php">
                <div>
                    <label for="new_min_blende">Minimale Blende:</label>
                    <input id="new_min_blende" name="min_blende" type="number" min="1" max="9.9" step="0.1" style="float:right;"  required>
                </div>
                <br>

                <div>
                    <label for="new_max_blende">Maximale Blende:</label>
                    <input id="new_max_blende" name="max_blende" type="number" min="1" max="9.9" step="0.1" style="float:right;"  required>
                </div>
                <br>
                <div>
                    <button type="submit">
                        Add Objektiv
                    </button>
                </div>
            </form>
        </div>

        <!-- Objektiv Search Form -->
        <div class="float-left-child">
            <h2>Objektiv Search:</h2>
            <form method="get">
                <div>
                    <label for="objnr">ID:</label>
                    <input id="objnr" name="objnr" type="number" value='<?php echo $objnr; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="min_blende">Minimale Blende:</label>
                    <input id="min_blende" name="min_blende" type="number" value='<?php echo $min_blende; ?>' min="1" max="9.9" step="0.1" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="max_blende">Maximale Blende:</label>
                    <input id="max_blende" name="max_blende" type="number" value='<?php echo $max_blende; ?>' min="1" max="9.9" step="0.1" style="float:right;"> 
                </div>
                <br>
                <div>
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Objektiv -->
        <div class="float-left-child">
            <h2>Delete Objektiv: </h2>
            <form method="post" action="deleteObjektiv.php">
                <!-- ObjNr Textbox -->
                <div>
                    <label for="del_objnr">ObjektivNr:</label>
                    <input id="del_objnr" name="objnr" type="number" min="0" style="float:right;"  required>
                </div>
                <br>

                <!-- Submit button -->
                <div>
                    <button type="submit">
                        Delete Objektiv
                    </button>
                </div>
            </form>
        </div>

    </div>

    <div class = "container-table">
        <h2>Objektiv Search Result:</h2>
        <table>
            <tr>
                <th>ObjektivNr</th>
                <th>Min Blende</th>
                <th>Max Blende</th>
            </tr>
            <?php foreach ($objektiv_array as $objektiv) : ?>
                <tr>
                    <td><?php echo $objektiv['OBJNR']; ?>  </td>
                    <td><?php echo $objektiv['MIN_BLENDE']; ?>  </td>
                    <td><?php echo $objektiv['MAX_BLENDE']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>


<!-- Kamera -->
<div class="segment" id="Kamera">
    
    <div class="float-left">
        
        <!-- Insert Kamera -->
        <div class="float-left-child">
            <h2>Add Kamera: </h2>
            <form method="post" action="addKamera.php" >
                <div>
                <label for="new_typ">Typ:</label>
                    <select id="new_typ" name="typ" style="float:right;" required>                      
                        <option value="DSLR">DSLR</option>
                        <option value="Mirrorless">Mirrorless</option>
                        <option value="Analog">Analog</option>
                        <option value="Instant">Instant</option>
                    </select>
                </div>
                <br>

                <div>
                    <label for="new_aufloesungen">Aufloesungen:</label>
                    <input id="new_aufloesungen" name="aufloesungen" type="number" min="0" style="float:right;" required>
                </div>
                <br>
                <div>
                    <button type="submit">
                        Add Kamera
                    </button>
                </div>
            </form>
        </div>

        <!-- Kamera Search Form -->
        <div class="float-left-child">
            <h2>Kamera Search:</h2>
            <form method="get">
                <div>
                    <label for="kameranr">ID:</label>
                    <input id="kameranr" name="kameranr" type="number" value='<?php echo $kameranr; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="typ">Typ:</label>
                    <select id="new_typ" name="typ" style="float:right;">                      
                        <option value=""> Select Type </option>
                        <option value="DSLR">DSLR</option>
                        <option value="Mirrorless">Mirrorless</option>
                        <option value="Analog">Analog</option>
                        <option value="Instant">Instant</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="aufloesungen">Max Aufloesungen:</label>
                    <input id="aufloesungen" name="aufloesungen" type="number" value='<?php echo $aufloesungen; ?>' min="0" style="float:right;"> 
                </div>
                <br>
                <div>
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Kamera -->
        <div class="float-left-child">
            <h2>Update Kamera (Trigger): </h2>
            <form method="post" action="updateKamera.php">
                <div>
                    <label for="kameranr">KameraNr:</label>
                    <input id="kameranr" name="kameranr" type="number"  min="100000" style="float:right;" required>
                </div>
                <br>
                <div>
                    <label for="aufloesungen">Neue Aufloesungen:</label>
                    <input id="aufloesungen" name="aufloesungen" type="number" min="0" style="float:right;" required>
                </div>
                <br>

                <div>
                    <button type="submit">
                        Update Kamera
                    </button>
                </div>
            </form>
        </div>
            
    </div>

    <div class = "container-table">
        <h2>Kamera Search Result:</h2>
        <table>
            <tr>
                <th>KameraNr</th>
                <th>Typ</th>
                <th>Aufloesungen</th>
            </tr>
            <?php foreach ($kamera_array as $kamera) : ?>
                <tr>
                    <td><?php echo $kamera['KAMERANR']; ?>  </td>
                    <td><?php echo $kamera['TYP']; ?>  </td>
                    <td><?php echo $kamera['AUFLOESUNGEN']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>


<!-- Sony -->
<div class="segment" id="Sony">

    <div class="float-left">    

        <!-- Sony Search Form -->
        <div class="float-left-child">
            <h2>Sony (IS-A) Search:</h2>
            <form method="get">
                <div>
                    <label for="kameranr">ID:</label>
                    <input id="kameranr" name="kameranr" type="number" value='<?php echo $kameranr; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="typ">Typ:</label>
                    <select id="new_typ" name="typ" style="float:right;">                      
                        <option value=""> Select Type </option>
                        <option value="DSLR">DSLR</option>
                        <option value="Mirrorless">Mirrorless</option>
                        <option value="Analog">Analog</option>
                        <option value="Instant">Instant</option>
                    </select>
                </div>
                <br>
                <div>
                    <label for="aufloesungen">Max Aufloesungen:</label>
                    <input id="aufloesungen" name="aufloesungen" type="number" value='<?php echo $aufloesungen; ?>' min="0" style="float:right;"> 
                </div>
                <br>

                <div>
                    <label for="zustand">Zustand:</label>
                    <select id="new_zustand" name="zustand" style="float:right;">                      
                        <option value=""> Select Zustand </option>
                        <option value="gut">gut</option>
                        <option value="mittelmaessig">mittelmaessig</option>
                        <option value="schlecht">schlecht</option>
                    </select>
                </div>
                <br>
                
                <div>
                <label for="farbe">Farbe:</label>
                <select id="new_farbe" name="farbe" style="float:right;">                      
                        <option value=""> Select Farbe </option>
                        <option value="schwarz">schwarz</option>
                        <option value="weiss">weiss</option>
                        <option value="grau">grau</option>
                </select>
                </div>
                <br>
                
                <div>
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sony Search Result -->
    <div class = "container-table">
        <h2>Sony (IS-A) Search Result:</h2>
        <table>
            <tr>
                <th>KameraNr</th>
                <th>Zustand</th>
                <th>Typ</th>
                <th>Farbe</th>
                <th>Aufloesungen</th>
            </tr>

            <?php foreach ($sony_array as $sony) : ?>
                <tr>
                    <td><?php echo $sony['KAMERANR']; ?>  </td>
                    <td><?php echo $sony['ZUSTAND']; ?>  </td>
                    <td><?php echo $sony['TYP']; ?>  </td>
                    <td><?php echo $sony['FARBE']; ?>  </td>
                    <td><?php echo $sony['AUFLOESUNGEN']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>


<!-- Foto -->
<div class="segment" id="Foto">

    <div class="float-left">    
    
        <!-- Foto Search Form -->
        <div class="float-left-child">
            <h2>Foto Search:</h2>
            <form method="get">
                <div>
                    <label for="id_foto">ID:</label>
                    <input id="id_foto" name="id" type="number" value='<?php echo $id; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="kennzahl_foto">Kennzahl:</label>
                    <input id="kennzahl_foto" name="kennzahl" type="number" value='<?php echo $kennzahl; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="exposition">Exposition:</label>
                    <input id="exposition" name="exposition" type="number" value='<?php echo $exposition; ?>' min="-3" max="3" step="0.1" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="standort">Standort:</label>
                    <input id="standort" name="standort" type="text" value='<?php echo $standort; ?>' maxlength="30" style="float:right;">
                </div>
                <div>
                    <button id='submit' type='submit' style="margin-top:15px">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Count Fotos -->
        <div class="float-left-child">
            <h2>Count Fotos (Procedure): </h2>
            <form method="post" action="countFoto.php">
                <div>
                    <label for="count_foto">Standort:</label>
                    <input id="count_foto" name="standort" type="text" style="float:right;">
                </div>
                <br>

                <div>
                    <button type="submit">
                        Count Fotos
                    </button>
                </div>
            </form>
        </div>

        <!-- Update Foto -->
        <div class="float-left-child">
            <h2>Update Foto: </h2>
            <form method="post" action="updateFoto.php">
                <div>
                    <label for="id_foto">ID:</label>
                    <input id="id_foto" name="id" type="number"  min="0" style="float:right;" required>
                </div>
                <br>
                <div>
                    <label for="kennzahl_foto">Kennzahl:</label>
                    <input id="kennzahl_foto" name="kennzahl" type="number" min="0" style="float:right;" required>
                </div>
                <br>
                <div>
                    <label for="exposition">Neue Exposition:</label>
                    <input id="exposition" name="exposition" type="number"  min="-3" max="3"  step="0.1"  style="float:right;" required>
                </div>
                <br>
                <div>
                    <button type="submit">
                        Update Foto
                    </button>
                </div>
            </form>
        </div>

    </div>

    <!-- Foto Search Result -->
    <div class = "container-table">
        <h2>Foto Search Result:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Kennzahl</th>
                <th>Exposition</th>
                <th>Zeit</th>
                <th>Standort</th>
            </tr>

            <?php foreach ($foto_array as $foto) : ?>
                <tr>
                    <td><?php echo $foto['ID']; ?>  </td>
                    <td><?php echo $foto['KENNZAHL']; ?>  </td>
                    <td><?php echo $foto['EXPOSITION']; ?>  </td>
                    <td><?php echo str_replace('.', ':', substr($foto['ZEIT'], 0, 18)) . substr($foto['ZEIT'], 25, 29);?>  </td>
                    <td><?php echo $foto['STANDORT']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>


<!-- Haben -->
<div class="segment" id="Haben">

    <div class="float-left">    
        <!-- Haben Search Form -->
        <div class="float-left-child">
            <h2>Haben (1:1:m) Search:</h2>
            <form method="get">
                <div>
                    <label for="id">ID:</label>
                    <input id="id" name="id" type="number" value='<?php echo $id; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="kameranr">Kameranummer:</label>
                    <input id="kameranr" name="kameranr" type="number" value='<?php echo $kameranr; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="objnr">Objektivnummer:</label>
                    <input id="objnr" name="objnr" type="number" value='<?php echo $objnr; ?>' min="0" style="float:right;"> 
                </div>
                <br>
                <div>
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Haben Search Result -->
    <div class = "container-table">
        <h2>Haben (1:1:m) Result:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>KameraNr</th>
                <th>ObjektivNr</th>
            </tr>
            <?php foreach ($haben_array as $haben) : ?>
                <tr>
                    <td><?php echo $haben['ID']; ?>  </td>
                    <td><?php echo $haben['KAMERANR']; ?>  </td>
                    <td><?php echo $haben['OBJNR']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>


<!-- Model -->
<div class="segment" id="Model">

    <div class="float-left">    

        <!-- Model Search Form -->
        <div class="float-left-child">
            <h2>Model Search:</h2>
            <form method="get">
                <div>
                    <label for="modelnr">ModelNr:</label>
                    <input id="modelnr" name="modelnr" type="number" value='<?php echo $modelnr; ?>' min="1000" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="alter">Alter:</label>
                    <input id="alter" name="alter" type="number" value='<?php echo $alter; ?>' min="1" max="99" style="float:right;"> 
                </div>
                <br>
                <div>
                    <label for="geschlecht">Geschlecht:</label>
                    <select id="geschlecht" name="geschlecht" style="float:right;">
                        <option value="">Select Geschlecht</option>                      
                        <option value="W">Weiblich</option>
                        <option value="M">Maenlich</option>
                    </select>
                </div>
                <br>
                <div>
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Model Search Result -->
    <div class = "container-table">
        <h2>Model Search Result:</h2>
        <table>
            <tr>
                <th>ModelNr</th>
                <th>Alter</th>
                <th>Geschlecht</th>
            </tr>

            <?php foreach ($model_array as $model) : ?>
                <tr>
                    <td><?php echo $model['MODELNR']; ?>  </td>
                    <td><?php echo $model['alter']; ?>  </td>
                    <td><?php echo $model['GESCHLECHT']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>

<!-- Zeigen -->
<div class="segment" id="Zeigen">

    <div class="float-left">    
        <!-- Zeigen Search Form -->
        <div class="float-left-child">
            <h2>Zeigen (m:n) Search:</h2>
            <form method="get">
                <div>
                    <label for="id">ID:</label>
                    <input id="id" name="id" type="number" value='<?php echo $id; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="kennzahl">Kennzahl:</label>
                    <input id="kennzahl" name="kennzahl" type="number" value='<?php echo $kennzahl; ?>' min="0" style="float:right;">
                </div>
                <br>
                <div>
                    <label for="modelnr">ModelNr:</label>
                    <input id="modelnr" name="modelnr" type="number" value='<?php echo $modelnr; ?>' min="0" style="float:right;">
                </div>
                <br>
                
                <div>
                    <button id='submit' type='submit'>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Zeigen Search Result -->
    <div class = "container-table">
        <h2>Zeigen (m:n) Search Result:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Kennzahl</th>
                <th>ModelNr</th>
            </tr>

            <?php foreach ($zeigen_array as $zeigen) : ?>
                <tr>
                    <td><?php echo $zeigen['ID']; ?>  </td>
                    <td><?php echo $zeigen['KENNZAHL']; ?>  </td>
                    <td><?php echo $zeigen['MODELNR']; ?>  </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>


<div class="segment" id="ER">
    <img src="FotoklubER.png">
</div>


</body>
</html>
