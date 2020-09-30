<?php
  require("../../../config.php");
  require("fnc_film.php");
  $database = "if20_oliver_l_2";
  //loen andmebaasist filmide info
  
  $filmhtml = "";
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  //$stmt = $conn->prepare("SELECT pealkiri, aasta, kestus, zanr, tootja, lavastaja FROM film");
  $stmt = $conn->prepare("SELECT * FROM film");
  //seon tulemuse muutujaga
  $stmt->bind_result($filmfromdb);
  $stmt->execute();
  while($stmt->fetch()){
	  $filmhtml .= "<p>" .$filmfromdb ."</p>";
  }
  $stmt->close();
  $conn->close();
  
  require("header.php");  
?>
<!DOCTYPE html>
<img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Mõtted!</title>
</head>
<body>
  <p>Kirjutatud mõtted<p>
  <hr>
   <?php echo $filmhtml; ?>
  </hr>
  <ul>
   <li><a href="home.php">Avalehele.</a></li>
  </ul>
</body>