<?php
  require("../../../config.php");
  $database = "if20_oliver_l_2";

//---------------------------------------------------------------------------------------------------------------------------------------------------
//rolli dropdown tsitaadi jaoks / kuvab rolle, väljastab person_in_movie_id
function readpersoninmovietoselect($selectedpersoninmovie){
    $notice = "<p>Kahjuks rolle ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $stmt=$conn->prepare("SELECT person_in_movie_id, role FROM person_in_movie");
    echo $conn->error;
    $stmt->bind_result($idfromdb, $personinmoviefromdb);
    $stmt->execute();
    $personinmovies = "";
    while($stmt->fetch()){
		if($personinmoviefromdb != null){
			$personinmovies .= '<option value="' .$idfromdb .'"';
			if($idfromdb == $selectedpersoninmovie){
				$personinmovies .= " selected";
			}
			$personinmovies .= ">" .$personinmoviefromdb ."</option> \n";
		}
    }
    if(!empty($personinmovies)){
        $notice = '<select name="filmpersoninmovieinput">' ."\n";
        $notice .= '<option value="" selected disabled>Vali roll</option>' ."\n";
        $notice .= $personinmovies;
        $notice .= "</select> \n";
    }
    $stmt->close();
    $conn->close();
    return $notice;
}

//position dropdown
function readpositiontoselect($selectedposition){
    $notice = "<p>Kahjuks rolle ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT position_id, position_name FROM position");
    echo $conn->error;
    $stmt->bind_result($idfromdb, $positionfromdb);
    $stmt->execute();
    $position = "";
    while($stmt->fetch()){
        $position .= '<option value="' .$idfromdb .'"';
        if(intval($idfromdb) == $selectedposition){
            $position .=" selected";
        }
        $position .= ">" .$positionfromdb ."</option> \n";
    }
    if(!empty($position)){
        $notice = '<select name="filmpositioninput" id="filmpositioninput">' ."\n";
        $notice .= '<option value="" selected disabled>Vali roll</option>' ."\n";
        $notice .= $position;
        $notice .= "</select> \n";
    }
    $stmt->close();
    $conn->close();
    return $notice;
}

//inimese dropdown
function readpersontoselect($selectedperson){

    $notice = "<p>Kahjuks inimesi ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT person_id, first_name, last_name FROM person");
    echo $conn->error;
    $stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
    $stmt->execute();
    $person = "";
    while($stmt->fetch()){
        $person .= '<option value="' .$idfromdb .'"';
        if(intval($idfromdb) == $selectedperson){
            $person .=" selected";
        }
        $person .= ">" .$firstnamefromdb ." " .$lastnamefromdb ."</option> \n";
    }
    if(!empty($person)){
        $notice = '<select name="filmpersoninput" id="filmpersoninput">' ."\n";
        $notice .= '<option value="" selected disabled>Vali inimene</option>' ."\n";
        $notice .= $person;
        $notice .= "</select> \n";
    }
    $stmt->close();
    $conn->close();
    return $notice;
}

//filmide dropdown
function readmovietoselect($selectedfilm){
	$notice = "<p>Kahjuks filme ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_id, title FROM movie");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $titlefromdb);
	$stmt->execute();
	$films = "";
	while($stmt->fetch()){
		$films .= '<option value="' .$idfromdb .'"';
		if(intval($idfromdb) == $selectedfilm){
			$films .=" selected";
		}
		$films .= ">" .$titlefromdb ."</option> \n";
	}
	if(!empty($films)){
		$notice = '<select name="filminput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali film</option>' ."\n";
		$notice .= $films;
		$notice .= "</select> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

//zanrite dropdown
function readgenretoselect($selectedgenre){
	$notice = "<p>Kahjuks žanre ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $genrefromdb);
	$stmt->execute();
	$genres = "";
	while($stmt->fetch()){
		$genres .= '<option value="' .$idfromdb .'"';
		if(intval($idfromdb) == $selectedgenre){
			$genres .=" selected";
		}
		$genres .= ">" .$genrefromdb ."</option> \n";
	}
	if(!empty($genres)){
		$notice = '<select name="filmgenreinput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali žanr</option>' ."\n";
		$notice .= $genres;
		$notice .= "</select> \n";
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

//stuudiote dropdown
function readstudiotoselect($selectedstudio){
	$notice = "<p>Kahjuks stuudioid ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt=$conn->prepare("SELECT production_company_id, company_name FROM production_company");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $companyfromdb);
	$stmt->execute();
	$studios = "";
	while($stmt->fetch()){
		$studios .= '<option value="' .$idfromdb .'"';
		if($idfromdb == $selectedstudio){
			$studios .= " selected";
		}
		$studios .= ">" .$companyfromdb ."</option> \n";
	}
	if(!empty($studios)){
		$notice = '<select name="filmstudioinput">' ."\n";
		$notice .= '<option value="" selected disabled>Vali stuudio</option>' ."\n";
		$notice .= $studios;
		$notice .= "</select> \n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

//---------------------------------------------------------------------------------------------------------------------------------------------------

//filmi ja zanri seostamine
function storenewgenrerelation($selectedfilm, $selectedgenre){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_genre_id FROM movie_genre WHERE movie_id = ? AND genre_id = ?");
	echo $conn->error;
	$stmt->bind_param("ii", $selectedfilm, $selectedgenre);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline seos on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES(?,?)");
		echo $conn->error;
		$stmt->bind_param("ii", $selectedfilm, $selectedgenre);
		if($stmt->execute()){
			$notice = "Uus seos edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

//filmi ja stuudio seostamine
function storenewstudiorelation($selectedfilm, $selectedstudio){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_by_production_company_id FROM movie_by_production_company WHERE movie_movie_id = ? AND production_company_id = ?");
	echo $conn->error;
	$stmt->bind_param("ii", $selectedfilm, $selectedstudio);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline seos on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO movie_by_production_company (movie_movie_id, production_company_id) VALUES(?,?)");
		echo $conn->error;
		$stmt->bind_param("ii", $selectedfilm, $selectedstudio);
		if($stmt->execute()){
			$notice = "Uus seos edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}

//filmi, inimese ja rolli seostamine
function storenewrolerelation($selectedfilm, $selectedperson, $selectedposition, $selectedrole){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT person_in_movie_id FROM person_in_movie WHERE movie_id = ? AND person_id = ? AND position_id = ? AND role = ?");
	echo $conn->error;
	$stmt->bind_param("iiis", $selectedfilm, $selectedperson, $selectedposition, $selectedrole);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline roll on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO person_in_movie (person_in_movie_id, person_id, movie_id, position_id, role) VALUES(?,?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("iiiis", $personinmovieid, $selectedperson, $selectedfilm, $selectedposition, $selectedrole);
		if($stmt->execute()){
			$notice = "Uus roll on edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}
//-------------------------------------------------------------------------------------------------------
//filmi info salvestamine
function storefilminfo($titleinput, $productionyear, $duration){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT movie_id FROM movie WHERE movie_id = ? AND title = ?");
	echo $conn->error;
	$stmt->bind_param("is", $movieidfromdb, $titlefromdb);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline film on juba lisatud!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO movie (movie_id, title, production_year, duration) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("isii", $movieid, $titleinput, $productionyear, $duration);
		if($stmt->execute()){
			$notice = "Uus film on edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
}
//stuudioinfo lisamine
function storestudioinfo($studioname){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT production_company_id FROM production_company WHERE company_name = ?");
	echo $conn->error;
	$stmt->bind_param("s", $studionamefromdb);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
				$notice = "Selline stuudio on juba lisatud!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO production_company (production_company_id, company_name) VALUES(?,?)");
		echo $conn->error;
		$stmt->bind_param("is", $studioid, $studioname);
		if($stmt->execute()){
			$notice = " Uus stuudio on edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

//inimese info lisamine
function storepersoninfo($firstname, $lastname, $birthdate){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("SELECT person_id FROM person WHERE first_name = ? AND last_name = ? AND birth_date = ?");
	echo $conn->error;
	$stmt->bind_param("sss", $firstnamefromdb, $lastnamefromdb, $birthdate);
	$stmt->bind_result($idfromdb);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = "Selline inimene on juba lisatud!";
	} else {
		$stmt->close();
		$stmt = $conn->prepare("INSERT INTO person (person_id, first_name, last_name, birth_date) VALUES(?,?,?,?)");
		echo $conn->error;
		$stmt->bind_param("isss", $personid, $firstname, $lastname, $birthdate);
		if($stmt->execute()){
			$notice = " Uus inimene on edukalt salvestatud!";
		} else {
			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
		}
	}
	$stmt->close();
	$conn->close();
	return $notice;
}

//tsitaadi salvestamine
function storenewquoterelation($quotetext, $quoterole){
    $notice = "";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $stmt = $conn->prepare("SELECT quote_text FROM quote WHERE quote_id = ? AND person_in_movie_id = ?");
    echo $conn->error;
    $stmt->bind_param("ii", $quotefromdb, $rolefromdb);
    $stmt->bind_result($idfromdb);
    $stmt->execute();
    if($stmt->fetch()){
        $notice = "Selline tsitaat on juba olemas!";
    } else {
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO quote (quote_id, quote_text, person_in_movie_id) VALUES(?,?,?)");
        echo $conn->error;
        $stmt->bind_param("isi", $quoteid, $quotetext, $quoterole);
        if($stmt->execute()){
            $notice = "Uus seos on edukalt salvestatud!";
        } else {
            $notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
        }
    }
    $stmt->close();
    $conn->close();
    return $notice;
}
//---------------------------------------------------------------------------------------------------------------------------------------------------

//filmi naitleja lugemine
function readpersoninmovie($sortby, $sortorder){
	$notice = "<p>Kahjuks ei leidnud filmitegelasi!</p>";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$sqlphrase = "SELECT first_name, last_name, role, title, quote_text FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id LEFT JOIN quote ON quote.person_in_movie_id = person_in_movie.person_in_movie_id WHERE position_id = 1";
	if($sortby == 0){
		$stmt=$conn->prepare($sqlphrase);
	}
	if($sortby == 2){
		if($sortorder == 2){
			$stmt=$conn->prepare($sqlphrase ." ORDER BY first_name DESC");
		} else {
			$stmt=$conn->prepare($sqlphrase ." ORDER BY first_name");
		}
	}
	if($sortby == 3){
		if($sortorder == 2){
			$stmt=$conn->prepare($sqlphrase ." ORDER BY role DESC");
		} else {
			$stmt=$conn->prepare($sqlphrase ." ORDER BY role");
		}
	}
	if($sortby == 4){
		if($sortorder == 2){
			$stmt=$conn->prepare($sqlphrase ." ORDER BY title DESC");
		} else {
			$stmt=$conn->prepare($sqlphrase ." ORDER BY title");
		}
	}
	if($sortby == 5){
		if($sortorder == 2){
			$stmt=$conn->prepare($sqlphrase ." ORDER BY quote_text DESC");
		} else {
			$stmt=$conn->prepare($sqlphrase ." ORDER BY quote_text");
		}
	}
	
	echo $conn->error;
	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb, $quotefromdb);
	$stmt->execute();
	$lines = "";
	while($stmt->fetch()){
		$lines .= "\t <tr> \n";
		$lines .= "\t \t <td>" .$firstnamefromdb ." " .$lastnamefromdb ."</td>";
		$lines .= "<td>" .$rolefromdb ."</td>";
		$lines .= "<td>" .$titlefromdb ."</td>";
		$lines .= "<td>" .$quotefromdb ."</td>";
		$lines .= "\t </tr> \n";
	}
	if(!empty($lines)){
        $notice = "<table> \n";
		$notice .= "\t \t" .'<th>Isik <a href="?sortby=2&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=2&sortorder=2">&darr;</a></th>' ." \t ";
		$notice .= "\t \t" .'<th>Roll <a href="?sortby=3&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=3&sortorder=2">&darr;</a></th>' ." \t ";
		$notice .= "\t \t" .'<th>Film <a href="?sortby=4&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=4&sortorder=2">&darr;</a></th>' ." \t ";
        $notice .= "\t \t" .'<th>Tsitaat <a href="?sortby=5&sortorder=1">&uarr;</a>&nbsp;<a href="?sortby=5&sortorder=2">&darr;</a></th>' ."\n \t </tr> \n";
        $notice .= $lines;
        $notice .= "</table> \n";
    }
	
	$stmt->close();
	$conn->close();
	return $notice;
}


function old_version_readpersoninmovie(){
	$notice = "";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
	$stmt=$conn->prepare("SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id");
	echo $conn->error;
	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
	$stmt->execute();
	while($stmt->fetch()){
		$notice .= "<p>" .$firstnamefromdb ." " .$lastnamefromdb;
		if(!empty($rolefromdb)){
			$notice .= " tegelane " .$rolefromdb;
		}
		$notice .= ' filmis "' .$titlefromdb .'"' ."\n";
	}
	
	$stmt->close();
	$conn->close();
	return $notice;
}
?>