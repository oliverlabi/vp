<?php
  $username = "Oliver Labi";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  if($hournow < 7){
	  $partofday = "uneaeg";
  } 
  if($hournow >= 8 and $hournow < 18){
	  $partofday = "akadeemilise aktiivsuse aeg";
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
  $fromsemesterdurationdays = "Semester on alanud.";
  if($today < $semesterdurationdays){
	  $fromsemesterdurationdays = "Semester pole veel peale hakanud.";
  }
  $semesterpercentage = round(($semesterdayssofar / $semesterdurationdays) * 100, 1) . "%";
?>
<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title><?php echo $username; ?> programmeerib veebi</title>

</head>
<body>
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise hetkel oli kuupäev ja kell: <?php echo $fulltimenow;?>.</p>
  <p><?php echo "Parajasti on " .$partofday ."."; ?> </p>
  <p>1. nädala kodutöö - 17:34 02/09/20<p>
  <p>2. nädala kodutöö - <?php echo $semesterpercentage;?> semestrist on läbitud.<p>
</body>