<!DOCTYPE html>
<?php
  require("../../../config.php");
  require("usesession.php");
  require("classes/Generic_class.php");
  require("classes/Photoupload_class.php");
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