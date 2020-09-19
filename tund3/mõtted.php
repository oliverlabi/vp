<?php

  //var_dump($_POST);
  require("../../../config.php");
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
	  $database = "if20_oliver_l_2";
	  //loome andmebaasiga ühenduse
	  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	  //valmistan ette SQL käsu andmete kirjutamiseks - prepare sql keel databaasi päringute jaoks
	  $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES(?)");
	  echo $conn->error;
	  //i - integer, d - decimal, s - string
	  $stmt->bind_param("s", $_POST["ideainput"]);
	  $stmt->execute();
	  $stmt->close();
	  $conn->close();
  }

?>

<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Mõtted!</title>
</head>
<body>
  <hr>
  <form method="POST">
	<label>Kirjutage oma esimene pähe tulev mõte!</label>
	<input type="text" name="ideainput" placeholder="mõttekoht">
	<input type="submit" name="ideasubmit" value="Saada mõte teele!">
  </form>
  </hr>
    <p><a href="http://greeny.cs.tlu.ee/~oliver/vp/tund3/m%c3%b5ttelist.php">Mõtete nimekiri.</a></p>
</body>