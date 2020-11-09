<!DOCTYPE html>
<?php
  require("usesession.php");
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
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Mõtted!</title>
</head>
<body>
  <p>Kirjutatud mõtted!<p>
  <ul>
	<li><a href="home.php">Avaleht</a></li>
	<li><a href="m%c3%b5tted.php">Salvesta mõte</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <?php echo $ideahtml; ?>
</body>