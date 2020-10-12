<?php
  require("usesession.php");
  require("../../../config.php");
  require("fnc_film.php");
  //loen andmebaasist filmide info
  //$filmhtml = readfilms();
  
  require("header.php")
?>
<img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Filmide loend</title>
</head>
<body>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>Filmide loend<p>
  <ul>
   <li><a href="home.php">Avaleht</a></li>
   <li><a href="addfilms.php">Filmiinfo lisamine</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
     <?php echo readfilms(0); ?>
  </hr>
</body>
</html>