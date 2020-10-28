<?php
  require("usesession.php");
  require("../../../config.php");
  
  $inputerror = "";
  $notice = "";
  $fileuploadsizelimit = 1048576;
  $fileuploaddir_orig = "../photoupload_orig/";
  $fileuploaddir_normal = "../photoupload_normal/";
  $filename = "";
  $filenameprefix = "vp_";
  $photomaxw = 600;
  $photomaxh = 400;
  //kas vajutati salvestusnuppu
  //kas on üldse pilt
  //var_dumpiga saan info:
  if(isset($_POST["photosubmit"])){
	$check = getimagesize($_FILES["photoinput"]["tmp_name"]);
    if($check !== false){
	   if($check["mime"] == "image/jpeg"){
		   $filetype = "jpg";
	   }
	   if($check["mime"] == "image/png"){
		   $filetype = "png";
	   }
	   if($check["mime"] == "image/gif"){
		   $filetype = "gif";
	   }
    } else {
	    $inputerror = "Valitud fail ei ole pilt!";
    }
    //ega pole liiga suur fail
    if($_FILES["photoinput"]["size"] > $fileuploadsizelimit){
	    $inputerror .= " Valitud fail on liiga suur!";
    }
    
	//genereerime failinime
	$timestamp = microtime(1) * 10000;
	$filename = $filenameprefix .$timestamp ."." .$filetype;
	
	//kas fail on olemas
    if(file_exists($fileuploaddir_orig .$filename)){
	    $inputerror .= " Sellise nimega fail on juba olemas!";
    }
    if(empty($inputerror)){
		//teen väiksemaks
		//loome image objekti ehk pikslikogumi
		if($filetype == "jpg"){
			$mytempimage = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "png"){
			$mytempimage = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
		}
		if($filetype == "gif"){
			$mytempimage = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
		}
		//pildi originaalsuurus
		$imagew = imagesx($mytempimage);
		$imageh = imagesy($mytempimage);
		//kas lähtuda laiusest või kõrgusest ja leian vähendamise kordaja
		if($imagew / $photomaxw > $imageh / $photomaxh){
			$photosizeratio = $imagew / $photomaxw;
		} else{
			$photosizeratio = $imageh / $photomaxh;
		}
		//arvutan uued mõõdud
		$neww = round($imagew / $photosizeratio);
		$newh = round($imageh / $photosizeratio);
		//loon uue suurusega pildiobjekti
		$mynewtempimage = imagecreatetruecolor($neww, $newh);
		//säilitamaks png piltide läbipaistvat osa
		imagesavealpha($mynewtempimage, true);
		$transparentcolor = imagecolorallocatealpha($mynewtempimage, 0,0,0,127);
		imagefill($mynewtempimage, 0,0, $transparentcolor);
		
		imagecopyresampled($mynewtempimage, $mytempimage, 0, 0, 0, 0, $neww, $newh,$imagew, $imageh);
		
		//vähendatud pilt faili
		if($filetype == "jpg"){
			if(imagejpeg($mynewtempimage, $fileuploaddir_normal .$filename, 90)){
				$notice = "Vähendatud pildi salvestamine õnnestus";
			} else {
				$notice = "Vähendatud pildi salvestamine ebaõnnestus";
			}
		}
		if($filetype == "png"){
			if(imagepng($mynewtempimage, $fileuploaddir_normal .$filename, 6)){
				$notice = "Vähendatud pildi salvestamine õnnestus";
			} else {
				$notice = "Vähendatud pildi salvestamine ebaõnnestus";
			}
		}	
		if($filetype == "gif"){
			if(imagegif($mynewtempimage, $fileuploaddir_normal .$filename)){
				$notice = "Vähendatud pildi salvestamine õnnestus";
			} else {
				$notice = "Vähendatud pildi salvestamine ebaõnnestus";
			}
		}
		imagedestroy($mynewtempimage);
		imagedestroy($mytempimage);
		
		if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $fileuploaddir_orig .$filename)){
			$notice .= " Originaalpildi üleslaadimine õnnestus \n";
		} else {
			$notice .= " Originaalpildi üleslaadimisel tekkis viga";
		}
    }
  }
  
  //avalikult nii teha ei tohi, teeme ainult sest greeny ei ole avalik. Muudame õigused kataloogi muutmiseks kõigile saadavaks

  
  //$username = "Andrus Rinde";
  require("header.php");
?>
  <img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>Pildi üleslaadimine</p>
  <ul>
   <li><a href="home.php">Avaleht</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
	<label for="photoinput">Vali pildifail:</label>
	<input id="photoinput" name="photoinput" type="file" required>
	<br>
	<label for="altinput">Lisa pildi lühikirjeldus (alternatiivtekst)</label>
	<input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ...">
	<br>
	<label>Määra privaatsustase:</label>
	<br>
	<input id="privinput1" name="privinput" type="radio" value="1">
	<label for="privinput1">Privaatne (ise näed)</label>
	<input id="privinput2" name="privinput" type="radio" value="2">
	<label for="privinput2">Sisseloginud kasutajatele</label>
	<input id="privinput3" name="privinput" type="radio" value="3">
	<label for="privinput3">Avalik</label>
	<br>
	<br>
	<input type="submit" name="photosubmit" value="Lae pilt üles">
  </form>
  <p>
  <?php
	echo $inputerror;
	echo $notice
	?></p>
</body>
</html>