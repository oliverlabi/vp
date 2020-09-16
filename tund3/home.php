<?php
  //var_dump($_POST);
  require("../../../config.php");
  $database = "if20_oliver_l_2";
  if(isset($_POST["ideasubmit"]) and !empty($_POST["ideainput"])){
	  //loome andmebaasiga ühenduse
	  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
	  //valmistan ette SQL käsu andmete kirjutamiseks - prepare sql keel databaasi päringute jaoks
	  $stmt = $conn->prepare("INSERT INTO myideas (idea) VALUES(?)");
	  echo $conn->error;
	  //i - integer, d - decimal, s - string
	  $stmt->bind_param("s", $_POST["ideainput"]);
	  $stmt->execute();
	  $stmt->close();
	  $conn->close();
  }
  
  //loen andmebaasist senised mõtted
  $ideahtml = "";
  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn->prepare("SELECT idea FROM myideas");
  //seon tulemuse muutujaga
  $stmt->bind_result($ideafromdb);
  $stmt->execute();
  while($stmt->fetch()){
	  $ideahtml .= "<p>" .$ideafromdb ."</p>";
  }
  $stmt->close();
  $conn->close();
  
  $username = "Oliver Labi";
  $fulltimenow = date("d.m.Y H:i:s");
  $hournow = date("H");
  $partofday = "lihtsalt aeg";
  $weekdaynameset = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthnameset = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];
  $weekdaynow = date("N");
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
  //tsüklid
  $piccount = count($picfiles);
  //$i = $i + 1; ->
  //$i ++;
  //$i += 3
  for($i = 0;$i < $piccount; $i ++){
	  //<img src="../img/pildifail" alt="tekst">
	  $imghtml .= '<img src="../../vp_pics/' .$picfiles[$i] . '" alt="Tallinna Ülikool">';
  }
  require("header.php");
?>
  
  <img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $username; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise hetkel oli: <?php echo $weekdaynameset[$weekdaynow - 1] .", " .$fulltimenow;?>.</p>
  <p><?php echo "Parajasti on " .$partofday ."."; ?> </p>
  <p><?php echo $fromsemesterdurationdays;?> <?php echo $semesterdayssofar;?> päeva on möödunud semestri algusest.<p>
  <p><?php echo $semesterpercentage;?> semestrist on läbitud.<p>
  <hr>
  <?php echo $imghtml; ?>
  <hr>
  <form method="POST">
	<label>Kirjutage oma esimene pähe tulev mõte!</label>
	<input type="text" name="ideainput" placeholder="mõttekoht">
	<input type="submit" name="ideasubmit" value="Saada mõte teele!">
  </form>
  </hr>
  <?php echo $ideahtml; ?>
</body>