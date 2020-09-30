<!DOCTYPE html>

<?php
//kodutöö loo uue kasutaja konto loomise leht - nagu filmiinfo sisestamise leht - sünniaega ei pane, tahan eesnime, perekonnanime, kasutajatunnus nagu meil, sugu, parool 2x,
//mõtle välja kontrollid, span muutuja, parool vähemalt 8 märki, säilitada info mis sai pandud errori puhul
  require("../../../config.php");
  require("fnc_film.php");
  
  $inputerror = "";
  $filmhtml = "";
  //kas vajutati salvestusnuppu
  if(isset($_POST["filmsubmit"])){
	  if(empty($_POST["filmsubmit"]) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
		  $inputerror .= "Osa infot on sisestamata!";
	  }
	  if($_POST["yearinput"] < 1895 or $_POST["yearinput"] > date("Y")){
		  $inputerror .= "Ebareaalne valmimisaasta";
	  }
	  if(empty($inputerror)){
		  $storeinfo = storefilminfo($_POST["titleinput"], $_POST["yearinput"], $_POST["durationinput"], $_POST["genreinput"], $_POST["studioinput"], $_POST["directorinput"]);
		  if($storeinfo == 1){
			  $filmhtml = readfilms(1);
		  } else {
			  $filmhtml = "<p>Kahjuks fiilmiinfo salvestamine seekord ebaõnnestus!</p>";
		  }
	  }
  }
  
  require("header.php")
?>
<img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Filmide loend</title>
</head>
<body>
  <p>Filmide loend<p>
  <ul>
   <li><a href="home.php">Avaleht</a></li>
   <li><a href="listfilms.php">Filmide nimekirja vaatamine</a></li>
  </ul>
  <form method="POST">
    <label for="titleinput">Filmi pealkiri:</label>
	<input type="text" name="titleinput" id="titleinput" placeholder="Filmi pealkiri">
	<br>
    <label for="yearinput">Filmi valmimisaasta:</label>
	<input type="number" name="yearinput" id="yearinput" value="<?php echo date("Y"); ?>">
	<br>
	<label for="durationinput">Filmi kestus minutites:</label>
	<input type="number" name="durationinput" id="durationinput" value="90">
	<br>
	<label for="genreinput">Filmi zanr:</label>
	<input type="text" name="genreinput" id="genreinput" placeholder="Filmi zanr">
	<br>
	<label for="studioinput">Filmi tootja:</label>
	<input type="text" name="studioinput" id="studioinput" placeholder="Filmi tootja/stuudio">
	<br>
	<label for="directorinput">Filmi lavastaja:</label>
	<input type="text" name="directorinput" id="directorinput" placeholder="Filmi lavastaja">
	<br>
	<input type="submit" name="filmsubmit" value="Salvesta filmi info">
  </form>
  <p><?php echo $inputerror; ?>
     <?php echo $filmhtml; ?>
</body>
</html>