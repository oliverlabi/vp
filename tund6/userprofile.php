<?php
  require("usesession.php");
  require("../../../config.php");
  //var_dump($_POST);
  $database = "if20_oliver_l_2";
  require("fnc_common.php");
  require("fnc_user.php");
  
  $notice = "";
  $userdescription = ""; //edaspidi püüate andmebaasist lugeda, kui on, kasutate seda väärtust
  
  if(isset($_POST["profilesubmit"])){
	  $description = test_input($_POST["descriptioninput"]);
	  $result = storeuserprofile($description, $_POST["bgcolorinput"], $_POST["txtcolorinput"]);
	  //sealt peaks tulema kas "ok" või mingi error!
	  if($result == "ok"){
		  $notice = "Kasutajaprofiil on salvestatud!";
		  $_SESSION["userbgcolor"] = $_POST["bgcolorinput"];
		  $_SESSION["usertxtcolor"] = $_POST["txtcolorinput"];
	  } else {
		  $notice = "Profiili salvestamine ebaõnnestus!";
	  }
	  
  }
  require("header.php");  
?>
<!DOCTYPE html>
<img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<html lang="et">
<head>
  <meta charset="utf-8">
</head>
<body>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>Kasutajaprofiil</p>
  <ul>
  	<li><a href="home.php">Avaleht</a></li>
    <li><a href="m%c3%b5ttelist.php">Salvestatud mõtted</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="descriptioninput">Minu lühitutvustus</label>
	<br>
	<textarea name="descriptioninput" id="descriptioninput" rows="10" cols="80" placeholder="Minu tutvustus ..."><?php echo $userdescription; ?></textarea><br>
	<label for="bgcolorinput">Minu valitud taustavärv: </label>
	<input type="color" name="bgcolorinput" id="bgcolorinput" value="<?php echo $_SESSION["userbgcolor"];?>"><br><br>
	<label for="bgcolorinput">Minu valitud taustavärv: </label>
	<input type="color" name="txtcolorinput" id="txtcolorinput" value="<?php echo $_SESSION["usertxtcolor"];?>"><br><br>
	<input type="submit" name="profilesubmit" value="Salvesta profiil!">
	<span><?php echo $notice; ?></span>
  </form>
  </hr>

</body>