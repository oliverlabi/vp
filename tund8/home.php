<!DOCTYPE html>
<?php
  session_start();
  
  //logime välja
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: page.php");
	  exit();
  }
  //kas on sisseloginud, kui pole, saadame sisselogimise lehele
  if(!isset($_SESSION["userid"])){
	  header("Location: page.php");
	  exit();
  }
  require("../../../config.php");
  //$username = "Oliver Labi";
  $fulltimenow = date("d.m.Y H:i:s");
  $partialtimenow = date("H:i:s");
  $currentday = date("d. ");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $weekdaynow = date("N");
  $monthnow = date("m");
  //loeme kataloogist piltide nimekirja
  $allfiles = scandir("../../vp_pics/");
  //echo $allfiles - echoda ei saa sest massiiv;
  //var_dump($allfiles) - ei toimi sest valib kõik, kaasa arvatud peidetud kaustad;
  $picfiles = array_slice($allfiles, 2);
  $imghtml = "";
  $imghtmlrand = "";
  //tsüklid
  $piccount = count($picfiles);
  //$i = $i + 1; ->
  //$i ++;
  //$i += 3
  //for($i = 0;$i < $piccount; $i ++){
	  //<img src="../img/pildifail" alt="tekst">
	  //$imghtml .= '<img src="../../vp_pics/' .$picfiles[$i] . '" alt="Tallinna Ülikool">';
  //}
  $imghtmlrand .=  '<img src="../../vp_pics/'  .$picfiles[rand(0, $piccount - 1)] . '" alt="Tallinna Ülikool">';
  require("header.php");  
?>
  <img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
<body>
  <ul>
	<li><a href="m%c3%b5tted.php">Salvesta mõte</a></li>
	<li><a href="m%c3%b5ttelist.php">Salvestatud mõtted</a></li>
	<li><a href="filmlist.php">Filmide nimekiri</a></li>
	<li><a href="addfilmrelations.php">Filmide relatsioonid</a></li>
	<li><a href="userprofile.php">Minu kasutajaprofiil</a></li>
	<li><a href="photoupload.php">Galeriipiltide üleslaadimine</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <?php echo $imghtmlrand; ?>
</body>
</html>