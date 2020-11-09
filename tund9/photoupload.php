<?php
  require("usesession.php");
  require("../../../config.php");
  require("../../../config_photo.php");
  require("fnc_photo.php");
  require("fnc_common.php");
  require("classes/Photoupload_class.php");
    
  $inputerror = "";
  $notice = "";
  $filename = "";
  $privacy = 1;
  $alttext = null;
  
  //kas vajutati salvestusnuppu
  $filetype = "";
  if(isset($_POST["photosubmit"])){
	//var_dump($_POST);
	//var_dump($_FILES);
	$privacy = intval($_POST["privinput"]);
	$alttext = test_input($_POST["altinput"]);
	
	//failitüübi kontroll
	$myphoto = new Photoupload($_FILES["photoinput"], $filetype);
	$result = $myphoto->ifFileTypeImage($photoFileTypes);
	if($result != null){
		$inputerror .= " Valitud failitüüp ei ole lubatud!";
	}
	
	//failisuuruse kontroll
	$result = $myphoto->checkFileSizeLimit($fileuploadsizelimit);
	if($result != null){
		$inputerror .= " Valitud fail on liiga suur!";
	}
	
	if(empty($inputerror)){
		$filename = $myphoto->createFileName($filenameprefix, $timestamp);
		
		$myphoto->resizePhoto($photomaxw, $photomaxh, true);
		
		$myphoto->addWatermark($watermark);
		//salvestame vähendatud pildi faili
		$result = $myphoto->savePhotoFile($fileuploaddir_normal .$filename);
		if($result == 1){
			$notice .= " Vähendatud pildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
		}
				
		//pisipilt
		//$mynewimage = resizePhoto($mytempimage, $thumbsize, $thumbsize);
		$myphoto->resizePhoto($thumbsize, $thumbsize);
		//$result = savePhotoFile($mynewimage, $filetype, $fileuploaddir_thumb .$filename);
		$result = $myphoto->savePhotoFile($fileuploaddir_thumb .$filename);
		if($result == 1){
			$notice .= " Pisipildi salvestamine õnnestus!";
		} else {
			$inputerror .= "Pisipildi salvestamisel tekkis tõrge!";
		}
		
		//kui vigu pole, salvestame originaalpildi
		if(empty($inputerror)){
			$result = $myphoto->saveOriginalPhoto($fileuploaddir_orig .$filename);
			if($result == 1){
				$notice .= " Originaalpildi salvestamine õnnestus!";
			} else {
				$inputerror .= " Originaalpildi salvestamisel tekkis viga!";
			}
		}
		
		//kui vigu pole, salvestame info andmebaasi
		if(empty($inputerror)){
			$result = storePhotoData($filename, $alttext, $privacy);
			if($result == 1){
				$notice .= " Pildi info lisati andmebaasi!";
				$privacy = 1;
				$alttext = null;
			} else {
				$inputerror .= " Pildi info andmebaasi salvestamisel tekkis tõrge!";
			}
		} else {
			$inputerror .= " Tekkinud vigade tõttu pildi andmeid ei salvestatud!";
		}
		
		unset($myphoto);
	}
  }
  
  require("header.php");
?>
  <p>Galeriipiltide üleslaadimine<p>
  <ul>
   <li><a href="home.php">Avaleht</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="photoinput">Vali pildifail!</label>
	<input id="photoinput" name="photoinput" type="file" required>
	<br>
	<label for="altinput">Lisa pildi lühikirjeldus (alternatiivtekst)</label>
	<input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus ..." value="<?php echo $alttext; ?>">
	<br>
	<label>Määra privaatsustase</label>
	<br>
	<input id="privinput1" name="privinput" type="radio" value="1" <?php if($privacy == 1){echo " checked";} ?>>
	<label for="privinput1">Privaatne (ise näed)</label>
	<input id="privinput2" name="privinput" type="radio" value="2" <?php if($privacy == 2){echo " checked";} ?>>
	<label for="privinput2">Sisseloginud kasutajatele</label>
	<input id="privinput3" name="privinput" type="radio" value="3" <?php if($privacy == 3){echo " checked";} ?>>
	<label for="privinput3">Avalik</label>
	
	<br>
	<input type="submit" name="photosubmit" value="Lae pilt üles">
  </form>
  <p>
  <?php
	echo $inputerror;
	echo $notice;
  ?>
	</p>
</body>
</html>