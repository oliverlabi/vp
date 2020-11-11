<?php
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_user.php");
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $firstname= "";
  $lastname = "";
  $gender = "";
  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  $birthdate = null;
  $email = "";
    
  $firstnameerror = "";
  $lastnameerror = "";
  $gendererror = "";
  $birthdayerror = null;
  $birthmontherror = null;
  $birthyearerror = null;
  $birthdateerror = null;
  $emailerror = "";
  $passworderror = "";
  $passwordsecondaryerror = "";
  
  $notice = "";

  //Submit nupu kontroll
  if(isset($_POST["submituserdata"])){
	  if (!empty($_POST["firstnameinput"])){
		$firstname = test_input($_POST["firstnameinput"]);
	  } else {
		  $firstnameerror = "Palun sisesta eesnimi!";
	  }
	  if (!empty($_POST["lastnameinput"])){
		$lastname = test_input($_POST["lastnameinput"]);
	  } else {
		  $lastnameerror = "Palun sisesta perekonnanimi!";
	  }
	  if(isset($_POST["genderinput"])){
		$gender = intval($_POST["genderinput"]);
	  } else {
		  $gendererror = "Palun märgi sugu!";
	  }
	  if(isset($_POST["birthdayinput"])){
		  $birthday = intval($_POST["birthdayinput"]);
	  } else {
		  $birthdayerror = "Palun vali sünnikuupäev!";
	  }
	  if(isset($_POST["birthmonthinput"])){
		  $birthmonth = intval($_POST["birthmonthinput"]);
	  } else {
		  $birthmontherror = "Palun vali sünnikuu!";
	  }
	  if(isset($_POST["birthyearinput"])){
		  $birthyear = intval($_POST["birthyearinput"]);
	  } else {
		  $birthyearerror = "Palun vali sünniaasta!";
	  }
	  if(empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror)){
		  if(checkdate($birthmonth, $birthday, $birthyear)){
			  $tempdate = new DateTime($birthyear ."-" .$birthmonth . "-" .$birthday);
			  $birthdate = $tempdate->format("Y-m-d");
		  } else {
			  $birthdateerror = "Valitud kuupäev on ebareaalne!";
		  }
	  }
	  if (!empty($_POST["emailinput"])){
		$email = test_input($_POST["emailinput"]);
	  } else {
		  $emailerror = "Palun sisesta e-postiaadress!";
	  }
	  if (empty($_POST["passwordinput"])){
		$passworderror = "Palun sisesta salasõna!";
	  } else {
		  if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["passwordinput"]) ." märki).";
		  }
	  }
	  if (empty($_POST["passwordsecondaryinput"])){
		$passwordsecondaryerror = "Palun sisestage salasõna kaks korda!";  
	  } else {
		  if($_POST["passwordsecondaryinput"] != $_POST["passwordinput"]){
			  $passwordsecondaryerror = "Sisestatud salasõnad ei olnud ühesugused!";
		  }
	  }
	  if(empty($firstnameerror) and empty($lastnameerror) and empty($gendererror ) and empty($birthdayerror) and empty($birthmontherror) and empty($birthyearerror) and empty($birthdateerror) and empty($emailerror) and empty($passworderror) and empty($passwordsecondaryerror)){
		$result = signup($firstname, $lastname, $email, $gender, $birthdate, $_POST["passwordinput"]);
		if($result == "ok"){
			$notice = "Kasutaja on edukalt loodud!";
			$firstname= "";
			$lastname = "";
			$gender = "";
			$birthday = null;
			$birthmonth = null;
			$birthyear = null;
			$birthdate = null;
			$email = "";
		} else {
			$notice = "Kahjuks tekkis tehniline viga: " .$result;
		}
	  }
  }
  
?>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Kasutaja loomine</title>
</head>
<body>
  <p>Kasutaja loomine<p>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     <label for="firstnameinput">Eesnimi:</label>
	  <input name="firstnameinput" id="firstnameinput" type="text" value="<?php echo $firstname; ?>"><span><?php echo $firstnameerror; ?></span>
	  <br>
      <label for="lastnameinput">Perekonnanimi:</label>
	  <input name="lastnameinput" id="lastnameinput" type="text" value="<?php echo $lastname; ?>"><span><?php echo $lastnameerror; ?></span>
	  <br>
	  <input type="radio" name="genderinput" id="genderfemaleinput" value="2" <?php if($gender == "2"){		echo " checked";} ?>><label for="genderfemaleinput">Naine</label>
	  <input type="radio" name="genderinput" id="gendermaleinput" value="1" <?php if($gender == "1"){		echo " checked";} ?>><label for="gendermaleinput">Mees</label>
	  <span><?php echo "&nbsp; &nbsp; &nbsp;" .$gendererror; ?></span>
	  <br>
	  <label for="birthdayinput">Sünnipäev: </label>
		  <?php
			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
			echo '<option value="" selected disabled>päev</option>' ."\n";
			for ($i = 1; $i < 32; $i ++){
				echo '<option value="' .$i .'"';
				if ($i == $birthday){
					echo " selected ";
				}
				echo ">" .$i ."</option> \n";
			}
			echo "</select> \n";
		  ?>
	  <label for="birthmonthinput">Sünnikuu: </label>
	  <?php
	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo '<option value="" selected disabled>kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label for="birthyearinput">Sünniaasta: </label>
	  <?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>aasta</option>' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
	  <br>
	  <label for="emailinput">E-mail (kasutajatunnus):</label>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
	  <br>
	  <label for="passwordinput">Salasõna (min 8 tähemärki):</label>
	  <input name="passwordinput" id="passwordinput" type="password"><span><?php echo $passworderror; ?></span>
	  <br>
	  <label for="passwordsecondaryinput">Korrake salasõna:</label>
	  <input name="passwordsecondaryinput" id="passwordsecondaryinput" type="password"><span><?php echo $passwordsecondaryerror; ?></span>
	  <br>
	  <input name="submituserdata" type="submit" value="Loo kasutaja"><span><?php echo "&nbsp;" .$notice; ?></span>
  </form>
  <hr>
  <ul>
   <li><a href="page.php">Avaleht</a></li>
  </ul>
</body>
</html>