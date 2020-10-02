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
?>