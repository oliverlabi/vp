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
?>

<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Mõtted!</title>
</head>
<body>
  <p>Kirjutatud mõtted<p>
  <hr>
   <?php echo $ideahtml; ?>
  </hr>
</body>