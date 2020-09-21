<!DOCTYPE html>
<?php
  require("../../../config.php");
  $database = "if20_oliver_l_2";
  $ideahtml = "";
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn->prepare("SELECT idea FROM myideas");
  //seon tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  while($stmt->fetch()){
	  $ideahtml .= "<p>" .$ideafromdb ."</p>";
  }
  $stmt->close();
  $conn->close();

  require("header.php");  
?>
<img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Mõtted!</title>
</head>
<body>
  <p>Kirjutatud mõtted<p>
  <li><a href="http://greeny.cs.tlu.ee/~oliver/vp/tund3/m%c3%b5tted.php">Salvesta mõte</a></li>
  <li><a href="http://greeny.cs.tlu.ee/~oliver/vp/tund3/home.php">Avaleht</a></li>
  <hr>
   <?php echo $ideahtml; ?>
  </hr>
</body>