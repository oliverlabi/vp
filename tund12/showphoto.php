<?php
	require("usesession.php");
	require("../../../config.php");
	require("../../../config_photo.php");
	$database = "if20_oliver_l_2";
	$selectedphotoid = $_REQUEST["photo"];
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT filename, userid, privacy FROM vpphotos WHERE vpphotos_id = ?");
	echo $conn->error;
	$stmt->bind_param("i", $selectedphotoid);
	$stmt->bind_result($filenamefromdb, $useridfromdb, $privacyfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		if(substr($filenamefromdb, -3) == "jpg"){
			$filetype = "image/jpeg";
		} elseif(substr($filenamefromdb, -3) == "png"){
			$filetype = "image/png";
		} elseif(substr($filenamefromdb, -3) == "gif"){
			$filetype = "image/gif";
		} else {
			$filetype = "image/jpeg";
		}
	}
	$stmt->close();
	$conn->close();
	header("Content-type: ". $filetype);
	readfile($fileuploaddir_normal .$filenamefromdb);