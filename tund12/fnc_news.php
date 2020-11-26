<?php
function storeNewsPhotoData($filename){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vpnewsphotos (userid, filename) VALUES (?, ?)");
	$stmt->bind_param("is", $_SESSION["userid"], $filename);
	if($stmt->execute()){
		$notice = 1;
	} else {
		//echo $stmt->error;
		$notice = 0;
	}
	$stmt->close();
	$conn->close();
	return $notice;
}
	
function newsUpload($newstitle, $news, $expire, $photoinput){
	$notice = "";
	$nopicture = null;
	$firstname = $_SESSION["userfirstname"];
	$lastname = $_SESSION["userlastname"];
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT vpnews_id FROM vpnews WHERE title = ? OR content = ?");
	$stmt->bind_param("ss", $newstitle, $news);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = " Selline uudis on juba lisatud!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("SELECT vpusers_id, newsphotos_id FROM(SELECT vpnp.newsphotos_id, vpu.vpusers_id, vpu.firstname, vpu.lastname, vpn.vpnews_id, vpnp.filename, vpn.deleted FROM vpusers vpu LEFT JOIN vpnewsphotos vpnp ON vpu.vpusers_id = vpnp.userid LEFT JOIN vpnews vpn ON vpnp.userid = vpn.userid UNION SELECT vpnp.newsphotos_id, vpu.vpusers_id, vpu.firstname, vpu.lastname, vpn.vpnews_id, vpnp.filename, vpn.deleted FROM vpusers vpu RIGHT JOIN vpnewsphotos vpnp ON vpu.vpusers_id = vpnp.userid LEFT JOIN vpnews vpn ON vpnp.userid = vpn.userid UNION SELECT vpnp.newsphotos_id, vpu.vpusers_id, vpu.firstname, vpu.lastname, vpn.vpnews_id, vpnp.filename, vpn.deleted FROM vpusers vpu RIGHT JOIN vpnewsphotos vpnp ON vpu.vpusers_id = vpnp.userid RIGHT JOIN vpnews vpn ON vpnp.userid = vpn.userid) AS T WHERE T.firstname = ? AND T.lastname = ? ORDER BY filename DESC");
		$stmt->bind_param("ss", $firstname, $lastname);
		if($photoinput != $nopicture){
			$stmt->bind_result($userid, $photoidfromdb);
		} else {
			$stmt->bind_result($userid, $nopicture);
			$photoidfromdb = $nopicture;
		}
		$stmt->execute();
		if($stmt->fetch()){
			$stmt->close();
			$stmt = $conn->prepare("INSERT INTO vpnews (vpnews_id, userid, photoid, title, content, expire) VALUES(?,?,?,?,?,?)");
			$stmt->bind_param("iiisss", $vpnewsid, $userid, $photoidfromdb, $newstitle, $news, $expire);
			if($stmt->execute()){
				$notice = " Uudis on edukalt salvestatud!";
			} else {
				$notice = " Uudise salvestamisel tekkis tehniline tõrge: ";
			}
		} else {
			$notice = " Kasutaja või pildi valimisega andmebaasist tekkis tekkis tehniline tõrge: ";
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

function readNews(){
	$i = 0;
	$listnotice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT vpu.firstname, vpu.lastname, vpn.title, vpn.content, vpnp.filename FROM vpusers vpu RIGHT JOIN vpnews vpn ON vpn.userid = vpu.vpusers_id LEFT JOIN vpnewsphotos vpnp ON vpn.userid = vpnp.userid AND vpn.photoid = vpnp.newsphotos_id WHERE vpn.vpnews_id > (SELECT MAX(vpnews_id) FROM vpnews WHERE deleted IS NULL) - 5 ORDER BY vpn.vpnews_id DESC;");
	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $newstitlefromdb, $newsfromdb, $filenamefromdb);
	$stmt->execute();
	$temphtml = null;
	while($stmt->fetch()){
		$temphtml = '<img src="' .$GLOBALS["fileuploaddir_news"] .$filenamefromdb.'">' ."\n";
		$listnotice .= "<h2>" .$newstitlefromdb ."</h2> \n";
		$listnotice .= "<p>Uudise avaldaja: " .$firstnamefromdb ." " .$lastnamefromdb ."</p> \n \n";
		$listnotice .= "<p>" .$newsfromdb ."</p> \n";
		if(!empty($temphtml)){
			$listnotice .= "<div> \n" .$temphtml ."</div> \n \n";
		}
	}
	$stmt->close();
	$conn->close();
	return $listnotice;
}
?>