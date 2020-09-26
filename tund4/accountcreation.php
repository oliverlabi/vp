<?php
  require("../../../config.php");
  
  $firstnameerror = "";
  $lastnameerror = "";
  $gendererror = "";
  $emailerror = "";
  $passworderror = "";
  $error = "";
  $accounthtml = "";
  
  $firstnameinput = "";
  $lastnameinput = "";
  $emailinput = "";
  $genderinput = "";

    //kas vajutati salvestusnuppu
  if(isset($_POST["accountsubmit"])){
	  if(empty($_POST["firstnameinput"])){
		  $firstnameerror .= " Eesnimi on sisestamata!";
	  }
	  if(empty($_POST["lastnameinput"])){
		  $lastnameerror .= " Perekonnanimi on sisestamata!";
	  }
	  if(empty($_POST["genderinput"])){
		  $gendererror .= " | Sugu on valimata!";
	  }
	  if(empty($_POST["emailinput"])){
		  $emailerror .= " E-posti aadress on sisestamata!";
	  }
	  if(strlen($_POST["passwordinput"]) < 8){
		  $passworderror .= " Salasõna pikkus peab olema kuni 8 märki! ";
	  }
	  if(($_POST["passwordinput"])!=($_POST["passwordsecondaryinput"])){
		  $passworderror .= " Salasõnad ei ühti!";
	  }
  }
  
?>

<img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Kasutaja loomine</title>
</head>
<body>
  <p>Kasutaja loomine<p>
  <ul>
   <li><a href="home.php">Avaleht</a></li>
  </ul>
  <form method="POST">
    <label for="firstnameinput">Eesnimi:</label>
	<input type="text" name="firstnameinput" id="firstname" value="<?php echo isset($_POST["firstnameinput"]) ? $_POST["firstnameinput"] : ''; ?>" placeholder="Eesnimi"><span><?php echo $firstnameerror; ?></span>
	<br>
    <label for="lastnameinput">Perekonnanimi:</label>
	<input type="text" name="lastnameinput" id="lastname" value="<?php echo isset($_POST["lastnameinput"]) ? $_POST["lastnameinput"] : ''; ?>" placeholder="Perekonnanimi"><span><?php echo $lastnameerror; ?></span>
	<br>
	<label for="genderinput">Sugu:</label>
	<input type="radio" name="genderinput" id="gendermale" value="1" <?php if (isset($_POST["genderinput"]) && $_POST["genderinput"] == "1") echo "checked"; ?>><label for="gendermale">Mees</label>
	<input type="radio" name="genderinput" id="genderfemale" value="2" <?php if (isset($_POST["genderinput"]) && $_POST["genderinput"] == "2") echo "checked"; ?>><label for="genderfemale">Naine</label><span><?php echo $gendererror; ?></span>
	<br>
	<label for="emailinput">E-posti aadress:</label>
	<input type="email" name="emailinput" id="email" value="<?php echo isset($_POST["emailinput"]) ? $_POST["emailinput"] : ''; ?>" placeholder="E-post"><span><?php echo $emailerror; ?></span>
	<br>
	<label for="passwordinput">Salasõna:</label>
	<input type="password" name="passwordinput" id="password" placeholder="Salasõna"><span><?php echo $passworderror; ?></span>
	<br>
	<label for="passwordsecondaryinput">Korda salasõna:</label>
	<input type="password" name="passwordsecondaryinput" id="password" placeholder="Salasõna teist korda"><span><?php echo $passworderror; ?></span>
	<br>
	<input type="submit" name="accountsubmit" value="Salvesta kasutaja info">
  </form>
</body>
</html>