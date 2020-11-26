<!DOCTYPE html>
<?php
  //session_start();
  require("classes/SessionManager.class.php");
  //sessioonihaldus
  SessionManager::sessionStart("vp", 0, "~/oliver/", "greeny.cs.tlu.ee");
  
  require("fnc_user.php");
  require("fnc_common.php");
  require("../../../config.php");
  $email = "";
  $username = "";
  $emailerror = "";
  $result = "";
  $passworderror = "";
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
  $semesterduration = $semesterstart->diff($semesterend);
  $semesterdurationdays = $semesterduration->format("%r%a");
  $today = new DateTime("now");
  $semesterdays = $semesterstart->diff($today);
  $semesterdayssofar = $semesterdays->format("%r%a");
  $fromsemesterdurationdays = "Semester pole veel alanud.";
  if($semesterdayssofar < $semesterdurationdays){
	  $fromsemesterdurationdays = "Semester on alanud.";
  } elseif($semesterdayssofar > $semesterdurationdays){
	  $fromsemesterdurationdays = "2020/2021 1. semester on lõppenud.";
  }
  $semesterpercentage = round(($semesterdayssofar / $semesterdurationdays) * 100, 1) . "%";
  //pildid
  $allfiles = scandir("../../vp_pics/");
  $picfiles = array_slice($allfiles, 2);
  $imghtml = "";
  $imghtmlrand = "";
  $piccount = count($picfiles);
  $imghtmlrand .=  '<img src="../../vp_pics/'  .$picfiles[rand(0, $piccount - 1)] . '" alt="Tallinna Ülikool">';
  //sisselogimine
  if(isset($_POST["submituserdata"])){
	  if(!empty($_POST["emailinput"])){
		$email = test_input($_POST["emailinput"]);
	  } else {
		  $emailerror = "Palun sisesta e-postiaadress!";
	  }
	  if(empty($_POST["passwordinput"])){
		$passworderror = "Palun sisesta salasõna!";
	  } else {
		  if(strlen($_POST["passwordinput"]) < 8){
			  $passworderror = "Liiga lühike salasõna (sisestasite ainult " .strlen($_POST["passwordinput"]) ." märki, miinimum 8).";
	        }
	  }
	  if(empty($emailerror) and empty($passworderror)){
		  $result = signin($email, $_POST["passwordinput"]);
	  }
  }
  
?>
  <img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<body>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursuse raames <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise hetkel oli: <?php echo $weekdaynameset[$weekdaynow - 1] .", ".$currentday .$monthnameset[$monthnow - 1] .", kell " .$partialtimenow;?>.</p>
  <p><?php echo "Parajasti on " .$partofday ."."; ?> </p>
  <p><?php echo $fromsemesterdurationdays;?> <?php echo $semesterdayssofar;?> päeva on möödunud semestri algusest.<p>
  <p><?php echo $semesterpercentage;?> semestrist on läbitud.<p>
  <hr>
  <p>Logi sisse</p>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <br>
	  <label for="emailinput">E-mail:</label>
	  <input type="email" name="emailinput" id="emailinput" value="<?php echo $email; ?>" placeholder="E-posti aadress"><span><?php echo "&nbsp;" .$emailerror; ?></span>
	  <br>
	  <br>
	  <label for="passwordinput">Salasõna:</label>
	  <input name="passwordinput" id="passwordinput" type="password" placeholder="Parool"><span><?php echo "&nbsp;" .$passworderror; ?></span>
	  <br>
	  <br>
	  <input name="submituserdata" type="submit" value="Logi sisse"><span><?php echo "&nbsp;" .$result; ?></span>
	  <br>
  <ul>
	<li><a href="accountcreation.php">Konto loomine</a></li>
  </ul>
  <?php echo $imghtmlrand; ?>
  <style>
  body { 
	 	 background-color: #CCCCCC; 
	 	 color: #000066; 
	 } 
  </style>
</body>
</html>