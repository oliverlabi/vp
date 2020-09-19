<?php

  $username = "Oliver Labi";
  $fulltimenow = date("d.m.Y H:i:s");
  $partialtimenow = date("H:i:s");
  $currentday = date("d. ");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $weekdaynow = date("N");
  $monthnow = date("m");
  if($hournow < 7){
	  $partofday = "uneaeg";
  } 
  if($hournow >= 8 and $hournow < 17){
	  $partofday = "akadeemilise aktiivsuse aeg";
  }
  if($hournow > 18 and $hournow < 20){
	  $partofday = "trenni aeg";
  }
  if($hournow > 20 and $hournow < 23){
	  $partofday = "puhkamise aeg";
  }
  
  //vaatame semestri kulgemist
  $semesterstart = new DateTime("2020-8-31"); 
  $semesterend = new DateTime("2020-12-13");
  //selgitame välja nende vahe ehk erinevuse
  $semesterduration = $semesterstart->diff($semesterend);
  //leiame selle päevade arvuna
  $semesterdurationdays = $semesterduration->format("%r%a");
  //tänane päev
  $today = new DateTime("now");
  $semesterdays = $semesterstart->diff($today);
  $semesterdayssofar = $semesterdays->format("%r%a");
  //if($fromsemesterstartdays < 0){semester pole peale hakanud}
  //arvuta välja mitu protsenti õppetööst on tehtud nt: 9/105 * 100
  $fromsemesterdurationdays = "Semester pole veel alanud.";
  if($semesterdayssofar < $semesterdurationdays){
	  $fromsemesterdurationdays = "Semester on alanud.";
  } elseif($semesterdayssofar > $semesterdurationdays){
	  $fromsemesterdurationdays = "2020/2021 1. semester on lõppenud.";
  }
  $semesterpercentage = round(($semesterdayssofar / $semesterdurationdays) * 100, 1) . "%";
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
  for($i = 0;$i < $piccount; $i ++){
	  //<img src="../img/pildifail" alt="tekst">
	  $imghtml .= '<img src="../../vp_pics/' .$picfiles[$i] . '" alt="Tallinna Ülikool">';
  }
  $imghtmlrand .=  '<img src="../../vp_pics/'  .$picfiles[rand(0, $piccount - 1)] . '" alt="Tallinna Ülikool">';
  require("header.php");  
?>
  
  <img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise hetkel oli: <?php echo $weekdaynameset[$weekdaynow - 1] .", ".$currentday .$monthnameset[$monthnow - 1] .", kell " .$partialtimenow;?>.</p>
  <p><?php echo "Parajasti on " .$partofday ."."; ?> </p>
  <p><?php echo $fromsemesterdurationdays;?> <?php echo $semesterdayssofar;?> päeva on möödunud semestri algusest.<p>
  <p><?php echo $semesterpercentage;?> semestrist on läbitud.<p>
  <p><a href="http://greeny.cs.tlu.ee/~oliver/vp/tund3/m%c3%b5tted.php">Üles kirjutatud mõtted.</a></p>
  <hr>
  <?php echo $imghtmlrand; ?>
</body>