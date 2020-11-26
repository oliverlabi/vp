<?php
  require("usesession.php");
  require("../../../config.php");
  require("../../../config_photo.php");
  require("fnc_common.php");
  require("fnc_news.php");
  require("classes/Photoupload_class.php");
  
  $database = "if20_oliver_l_2";
  //require("fnc_photo.php");
  //require("classes/Photoupload_class.php");
  
  $tolink = "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
  $tolink .= "\t" .'<script>tinymce.init({selector:"textarea#newsinput", plugins: "link", menubar: "edit",});</script>' ."\n";
  
  $photomaxw = 600;
  $photomaxh = 400;
  $inputerror = "";
  $notice = "";
  $news = null;
  $newstitle = "";
  $expire = null;
  $filename = "";
  $filetype = "";
  $filenameprefix = "vpnews_";
  $photoFileTypes = ["image/jpeg", "image/png", "image/gif"];
  //kas vajutati salvestusnuppu
  if(isset($_POST["newssubmit"])){
	if(strlen($_POST["newstitleinput"]) == 0){
		$inputerror = "Uuudise pealkiri on puudu!";
	} else {
		$newstitle = test_input($_POST["newstitleinput"]);
	}
	if(strlen($_POST["newsinput"]) == 0){
		$inputerror .= " Uudise sisu on puudu!";
	} else {
		$news = test_input($_POST["newsinput"]);
		//htmlspecialchars teisendab html noolsulud.
		//nende tagasisaamiseks htmlspecialchars_decode(uudis) homework!
	}
	if($_POST["expirationinput"] == null){
		$inputerror .= " Aegumiskuupäev on lisamata!";
	} else {
		$expire = $_POST["expirationinput"];
	}
	
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT vpnews_id FROM vpnews WHERE title = ? OR content = ?");
	echo $conn->error;
	$stmt->bind_param("ss", $newstitle, $news);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$inputerror .= " Selline uudis on juba lisatud!";
	}
	$stmt->close();
	$conn->close();
	//-------------------------------------------------------------pildi töötlemine-------------------------------------------------------------
	if(empty($inputerror) and !empty($_FILES["newsphotoinput"]["tmp_name"])){
		$myphoto = new Photoupload($_FILES["newsphotoinput"], $filetype);
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
			$result = $myphoto->savePhotoFile($fileuploaddir_news .$filename);
			if($result == 1){
				$notice .= " Vähendatud pildi salvestamine õnnestus!";
			} else {
				$inputerror .= "Vähendatud pildi salvestamisel tekkis tõrge!";
			}
			
			//kui vigu pole, salvestame originaalpildi
			if(empty($inputerror)){
				$result = $myphoto->saveOriginalPhoto($fileuploaddir_orig_news .$filename);
				if($result == 1){
					$notice .= " Originaalpildi salvestamine õnnestus!";
				} else {
					$inputerror .= " Originaalpildi salvestamisel tekkis viga!";
				}
			}
		}
			if(empty($inputerror)){
				$result = storeNewsPhotoData($filename);
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
	}
	//-------------------------------------------------------------pildi töötlemine, salvestamine lõppes-------------------------------------------------------------
	
	//salvesta uudis pildiga
	if(empty($inputerror)){
		if(!empty($_FILES["newsphotoinput"]["name"])){
			$photoinput = $_FILES["newsphotoinput"]["name"];
		} else {
			$photoinput = null;
		}
		$notice .= newsUpload($newstitle, $news, $expire, $photoinput);
	}
	unset($myphoto);
  }
  require("header.php");
?>
  <p>Sisesta uudis<p>
  <ul>
	<li><a href="home.php">Avaleht</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="newstitleinput">Sisesta uudise pealkiri:</label>
	<input id="newstitleinput" name="newstitleinput" type="text" value="<?php echo $newstitle; ?>" required>
	<br>
	<label for="newsinput">Kirjuta uudis:</label>
	<textarea id="newsinput" name="newsinput" placeholder="Uudise sisu"><?php echo $news; ?></textarea>
	<br>
	<label for="expirationinput">Aegumiskuupäev:</label>
	<input id="expirationinput" name="expirationinput" type="date">
	<br>
    <label for="newsphotoinput">Vali pildifail:</label>
	<input id="newsphotoinput" name="newsphotoinput" type="file">
	<br>
	<br>
	<input type="submit" id="newssubmit" name="newssubmit" value="Salvesta uudis">
  </form>
  <p id="notice">
  <?php
	echo $inputerror;
	echo $notice;
  ?>
	</p>
</body>
</html>