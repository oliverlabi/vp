<!DOCTYPE html>
<?php
  require("../../../config.php");
  require("usesession.php");
  //testime klassi kasutamist
  //$myfirstclass = new Generic(8);
  //echo $myfirstclass->mysecret; - salajat muutujat klassist ei saa kutsuda
  //echo " Oluliselt avalikum saladus on ".$myfirstclass->yoursecret;
  //$myfirstclass->showValue();
  //unset($myfirstclass);
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
  $imghtmlrand .=  '<img src="../../vp_pics/'  .$picfiles[rand(0, $piccount - 1)] . '" alt="Tallinna Ülikool">';
  //tegeleme küpsistega
  //setcookie peab olema enne html algust
  //määrame: nimi, väärtus, aegumine, veebikataloog (vaikimisi "/"), domeen, kas https, http only ehk ainult üle veebi
  setcookie("vpvisitor", $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"], time() + (86400 * 8), "/~oliver/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
  //kustutamiseks antakse aegumistähtaeg minevikus, näiteks time() - 3600
  require("header.php");  
?>
  <ul>
	<li><a href="m%c3%b5tted.php">Salvesta mõte</a></li>
	<li><a href="m%c3%b5ttelist.php">Salvestatud mõtted</a></li>
	<li><a href="filmlist.php">Filmide nimekiri</a></li>
	<li><a href="addfilmrelations.php">Filmide relatsioonid</a></li>
	<li><a href="userprofile.php">Minu kasutajaprofiil</a></li>
	<li><a href="photoupload.php">Galeriipiltide üleslaadimine</a></li>
	<li><a href="photogallery_public.php">Avalike fotode galerii</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <?php echo $imghtmlrand; ?>
  <hr>
  <?php
	if(count($_COOKIE) > 0){
		echo "<p>Küpsised on lubatud! Leidsin: " .count($_COOKIE) ." küpsist.</p>";
		var_dump($_COOKIE);
	} else {
		echo "<p>Küpsised pole lubatud!</p>";
	}
	if(isset($_COOKIE["vpvisitor"])){
		echo "<p>Küpsisest selgus viimase külastaja nimi: " .$_COOKIE["vpvisitor"] .". \n";
	} else {
		echo "<p>Viimase kasutaja nime ei leitud!</p> \n";
	}
  ?>
</body>
</html>