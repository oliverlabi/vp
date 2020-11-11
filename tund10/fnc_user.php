<?php 
  $database = "if20_oliver_l_2";
  function signup($firstname, $lastname, $email, $gender, $birthdate, $password){
	$result = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
	echo $conn->error;
		
		//krüpteerime parooli
	$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
		
	$stmt->bind_param("sssiss", $firstname, $lastname, $birthdate, $gender, $email, $pwdhash);
		
	if($stmt->execute()){
		$result = "ok";
	} else {
		$result = $stmt->error;
	}
	$stmt->close();
	$conn->close();
	return $result;
	} //funktsioon signup lõpp
	
	function signin($email, $password){
		$result = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT password from vpusers WHERE email = ?");
		echo $conn->error;
		$stmt -> bind_param("s", $email);
		$stmt -> bind_result($passwordfromdb);
		if($stmt->execute()){
			//kui käsu täitmine õnnestus
			if($stmt->fetch()){
				//kui tuli vaste, kasutaja on olemas
				if(password_verify($password, $passwordfromdb)){
					//parool õige, sisselogimine
					$stmt->close();
					//loen sisse loginud kasutaja nime ja id
					$stmt = $conn->prepare("SELECT vpusers_id, firstname, lastname FROM vpusers WHERE email = ?");
					echo $conn->error;
					//s - string, võtab "email = ?"
					$stmt->bind_param("s", $email);
					$stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
					$stmt->execute();
					$stmt->fetch();
					//salvestan saadud info sessioonimuutujatesse - tekkis sessiooni tekitamisega (massiiv)
					$_SESSION["userid"] = $idfromdb;
					$_SESSION["userfirstname"] = $firstnamefromdb;
					$_SESSION["userlastname"] = $lastnamefromdb;
					$stmt->close();
					
					//kasutajaprofiil, tausta ja tekstivärv
					//lugeda andmebaasist kasutajaprofiili, kui saab fetch käsuga värvid, siis need, muidu must 000000 ja valge ffffff
					$_SESSION["userbgcolor"] = "#CCCCCC";
					$_SESSION["usertxtcolor"] = "#000066";
					
					$conn->close();
					header("Location: home.php");
					exit();
					
				} else {
					$result = "Kahjuks vale parool!";
				}
			} else {
				$result = "Kasutajat (" .$email .") pole olemas!";
			}
		} else {
			$result = $stmt->error;
		}
		if (!empty($_POST["emailinput"])) {

		$email = trim(htmlspecialchars($_POST["emailinput"]));
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);

		if ($email === false) {
			exit("Vale E-posti aadress!");
		}

		}
		$stmt->close();
		$conn->close();
		return $result;
	}
	
	function storeuserprofile($description, $bgcolor, $txtcolor){
	$notice = null;
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	//vaatame, kas on profiil olemas
	$stmt = $conn->prepare("SELECT vpuserprofiles_id FROM vpuserprofiles WHERE userid = ?");
	echo $conn->error;
	$stmt->bind_param("i", $_SESSION["userid"]);
	$stmt->execute();
	if($stmt->fetch()){
		$stmt->close();
		//uuendame profiili
		$stmt= $conn->prepare("UPDATE vpuserprofiles SET description = ?, bgcolor = ?, txtcolor = ? WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("sssi", $description, $bgcolor, $txtcolor, $_SESSION["userid"]);
	} else {
		$stmt->close();
		//tekitame uue profiili
		$stmt = $conn->prepare("INSERT INTO vpuserprofiles (userid, description, bgcolor, txtcolor) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("isss", $_SESSION["userid"], $description, $bgcolor, $txtcolor);
	}
	if($stmt->execute()){
		$notice = "ok";
	} else {
		$notice = $stmt->error;
	}
	$stmt->close();
	$conn->close();
	return $notice;
	}
	
	function readuserdescription(){
		//kui profiil on olemas, loeb kasutaja lühitutvustuse
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//vaatame, kas on profiil olemas
		$stmt = $conn->prepare("SELECT description FROM vpuserprofiles WHERE userid = ?");
		echo $conn->error;
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($descriptionfromdb);
		$stmt->execute();
		if($stmt->fetch()){
			$notice = $descriptionfromdb;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>