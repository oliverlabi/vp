<!DOCTYPE html>
<?php
  require("usesession.php");
  require("../../../config.php");
  require("fnc_common.php");
  require("fnc_filmrelations.php");
  $database = "if20_oliver_l_2";
//----------------------
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $birthday = null;
  $birthmonth = null;
  $birthyear = null;
  $birthdate = null;
  $birthdaynotice = "";
  $birthmonthnotice = "";
  $birthyearnotice = "";
//----------------------
  $rolenotice = "";
  $addrolenotice = "";
  $genrenotice = "";
  $studionotice = "";
  $movienotice = "";
  $titlenotice = "";
  $yearnotice = "";
  $durationnotice = "";
  $studiotitlenotice = "";
  $addstudionotice = "";
  $firstnamenotice = "";
  $lastnamenotice = "";
  $addpersonnotice = "";
  $quotenotice = "";
//----------------------
  $selectedfilm = "";
  $selectedgenre = "";
  $selectedstudio = "";
  $selectedposition = "";
  $selectedperson = "";
  $selectedpersoninmovie = "";
  $selectedrole = "";
  
 //kui vajutati stuudio nuppu
  if(isset($_POST["filmstudiorelationsubmit"])){
    if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$studionotice = " Vali film!";
	}
	if(!empty($_POST["filmstudioinput"])){
		$selectedstudio = intval($_POST["filmstudioinput"]);
	} else {
		$studionotice = " Vali stuudio!";
	}
	if(!empty($selectedfilm) and !empty($selectedstudio)){
		$studionotice = storenewstudiorelation($selectedfilm, $selectedstudio);
	}
  }	  
  
  //kui vajutati zanri nuppu
  if(isset($_POST["filmgenrerelationsubmit"])){
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$genrenotice = " Vali film!";
	}
	if(!empty($_POST["filmgenreinput"])){
		$selectedgenre = intval($_POST["filmgenreinput"]);
	} else {
		$genrenotice .= " Vali žanr!";
	}
	if(!empty($selectedfilm) and !empty($selectedgenre)){
		$genrenotice = storenewgenrerelation($selectedfilm, $selectedgenre);
	}
  }
  
  //kui vajutati filmi lisamise nuppu
  if(isset($_POST["moviesubmit"])){
	  if(!empty($_POST["titleinput"])){
		  $titleinput = $_POST["titleinput"];
	  } else {
		  $titlenotice = "Filmi tiitel lisamata!";
	  }
	  if($_POST["yearinput"] < 1895 or $_POST["yearinput"] > date("Y")){
		  $yearnotice = "Ebareaalne valmimisaasta";
	  } else {
		  $productionyear = $_POST["yearinput"];
	  }
	  if(!empty($titleinput) and !empty($productionyear)){
		  $duration = $_POST["durationinput"];
		  $movienotice = storefilminfo($titleinput, $productionyear, $duration);
	  }
  }

  //kui vajutati stuudio lisamise nuppu
  if(isset($_POST["studiosubmit"])){
	  if(!empty($_POST["studioinput"])){
		  $studioname = $_POST["studioinput"];
		  $addstudionotice = storestudioinfo($studioname);
	  } else {
		  $studiotitlenotice = "Stuudio nimi lisamata!";
	  }
  }

  //kui vajutati inimese lisamise nuppu
  if(isset($_POST["personsubmit"])){
	  if(!empty($_POST["firstnameinput"])){
		  $firstname = $_POST["firstnameinput"];
	  } else {
		  $firstnamenotice = "Eesnimi lisamata!";
	  }
	  if(!empty($_POST["lastnameinput"])){
		  $lastname = $_POST["lastnameinput"];
	  } else {
		  $lastnamenotice = "Perekonnanimi lisamata!";
	  }
	  if(empty($_POST["birthdayinput"])){
		  $birthdaynotice = "Sünnipäev valimata!";
	  }
	  if(empty($_POST["birthmonthinput"])){
		  $birthmonthnotice = "Sünnikuu valimata!";
	  }
	  if(empty($_POST["birthyearinput"])){
		  $birthyearnotice = "Sünniaasta valimata!";
	  }
	  $birthdate = strval($_POST["birthyearinput"] ."-" .$_POST["birthmonthinput"] ."-" .$_POST["birthdayinput"]);
	  if(!empty($_POST["firstnameinput"]) and (!empty($_POST["lastnameinput"])) and ($birthdate != "--")){
		  $addpersonnotice = storepersoninfo($firstname, $lastname, $birthdate);
	  }
  }
  
  //kui vajutati rolli lisamise nuppu
  if(isset($_POST["rolesubmit"])){
	  if(!empty($_POST["filmpersoninput"])){
		  $selectedperson = $_POST["filmpersoninput"];
	  } else {
		  $rolenotice .= "Inimene valimata!";
	  }
	  if(!empty($_POST["filminput"])){
		  $selectedfilm = $_POST["filminput"];
	  } else {
		  $rolenotice = "Film valimata!";
	  }
      if(!empty ($_POST["filmpositioninput"])){
          $selectedposition = intval($_POST["filmpositioninput"]);
      } else {
          $rolenotice .= "Vali, kas isik on näitleja või režisöör!";
	  }
      if(!empty($_POST["roleinput"])){
          $selectedrole = $_POST["roleinput"];
	  }
	  if(!empty($_POST["filmpersoninput"]) and !empty($_POST["filminput"]) and !empty($_POST["filmpositioninput"])){
		  $rolenotice = storenewrolerelation($selectedfilm, $selectedperson, $selectedposition, $selectedrole);
	 }
  }
  //kui vajutati tsitaadi submit nuppu
  if(isset($_POST["quotesubmit"])){
	  if(!empty($_POST["filmpersoninmovieinput"])){
		  $quoterole = $_POST["filmpersoninmovieinput"];
	  } else {
		  $quotenotice .= "Roll valimata!";
	  }
	  if(!empty($_POST["quoteinput"])){
		  $quotetext = $_POST["quoteinput"];
	  } else {
		  $quotenotice = "Tsitaat lisamata!";
	  }
	  if(!empty($_POST["filmpersoninmovieinput"]) and !empty($_POST["quoteinput"])){
		  $quotenotice = storenewquoterelation($quotetext, $quoterole);
	  }
  }
  
  //dropdownid htmli
  $roleselecthtml = readpersoninmovietoselect($selectedpersoninmovie);
  $positionselecthtml = readpositiontoselect($selectedposition);
  $personselecthtml = readpersontoselect($selectedperson);
  $filmselecthtml = readmovietoselect($selectedfilm);
  $filmgenreselecthtml = readgenretoselect($selectedgenre);
  $filmstudioselecthtml = readstudiotoselect($selectedstudio);
  require("header.php");
?>
<html>
<body>
  <p>Filmide lisamine/relatsioonid<p>
  <ul>
    <li><a href="home.php">Avaleht</a></li>
	<li><a href="filmlist.php"> Filmide nimekiri </a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <h2>Filmiinfo</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="titleinput">Filmi pealkiri:</label>
	<input type="text" name="titleinput" id="titleinput" placeholder="Filmi pealkiri"><span><?php echo $titlenotice; ?></span>
	<br>
    <label for="yearinput">Filmi valmimisaasta:</label>
	<input type="number" name="yearinput" id="yearinput" value="<?php echo date("Y"); ?>"><span><?php echo $yearnotice; ?></span>
	<br>
	<label for="durationinput">Filmi kestus minutites:</label>
	<input type="number" name="durationinput" id="durationinput" value="90"><span><?php echo $durationnotice; ?></span>
	<br>
	<br>
	<input type="submit" name="moviesubmit" value="Salvesta filmi info"><span><?php echo $movienotice; ?></span>
  </form>
  <hr>
  <h2>Filmistuudio info</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <p>Stuudio lisamine<p>
	<label for="studioinput">Stuudio nimi:</label>
	<input type="text" name="studioinput" id="studioinput" placeholder="Stuudio nimi"><span><?php echo $studiotitlenotice; ?></span>
	<br>
	<br>
	<input type="submit" name="studiosubmit" value="Salvesta stuudio"><span><?php echo $addstudionotice; ?></span>
	<p>Stuudio seostamine filmiga<p>
    <?php
	  echo $filmselecthtml;
	  echo $filmstudioselecthtml;
	?>
	<br>
	<br>
	<input type="submit" name="filmstudiorelationsubmit" value="Salvesta filmiinfo"><span><?php echo $studionotice; ?></span>
  </form>
  
  <hr>
  <h2>Filmi zanr</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmgenreselecthtml;
	?>
  <br>
  <br>
  <input type="submit" name="filmgenrerelationsubmit" value="Salvesta filmiinfo"><span><?php echo $genrenotice; ?></span>
  </form>
  <hr>
  <h2>Inimese lisamine</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label for="firstnameinput">Eesnimi:</label>
	<input type="text" name="firstnameinput" id="firstnameinput" placeholder="Eesnimi"><span><?php echo $firstnamenotice; ?></span>
	<br>
	<label for="lastnameinput">Perekonnanimi:</label>
	<input type="text" name="lastnameinput" id="lastnameinput" placeholder="Perekonnanimi"><span><?php echo $lastnamenotice; ?></span>
	<br>
	<label for="birthdayinput">Sünnipäev: </label><span><?php echo $birthdaynotice; ?></span>
	<?php
		echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
		echo '<option value="" selected disabled>Päev</option>' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthday){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	?>
	<label for="birthmonthinput">Sünnikuu: </label><span><?php echo $birthmonthnotice; ?></span>
	<?php
	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
		echo '<option value="" selected disabled>Kuu</option>' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthmonth){
				echo " selected ";
			}
			echo ">" .$monthnameset[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	?>
	<label for="birthyearinput">Sünniaasta: </label><span><?php echo $birthyearnotice; ?></span>
	<?php
	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
		echo '<option value="" selected disabled>Aasta</option>' ."\n";
		for ($i = date("Y"); $i >= date("Y") - 110; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthyear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	?>
	<br>
	<br>
	<input type="submit" name="personsubmit" value="Salvesta inimene"><span><?php echo $addpersonnotice; ?></span>
  </form>
  <hr>
  <h2>Rolli lisamine</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $personselecthtml;
		echo $positionselecthtml;
	?>
    <label for="roleinput">Isiku roll:</label>
	<input type="text" name="roleinput" id="roleinput" placeholder="Roll">
	<br>
	<br>
	<input type="submit" name="rolesubmit" value="Salvesta roll"><span><?php echo $rolenotice; ?></span>
  </form>
  <hr>
  <h2>Tsitaadi lisamine</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<p>Roll:</p><?php echo $roleselecthtml; ?>
	<br>
	<br>
	<label for="quoteinput">Tsitaat:</label>
	<br>
	<br>
	<textarea name="quoteinput" id="quoteinput" rows="5" cols="80" placeholder="Tsitaat"></textarea><br>
	<br>
	<input type="submit" name="quotesubmit" value="Salvesta tsitaat"><span><?php echo $quotenotice; ?></span>
  </form>
</body>
</html>