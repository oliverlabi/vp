<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Veebiprogrammeerimine</title>
  <style>
  <?php
    echo "body { \n";
	if(isset($_SESSION["userbgcolor"])){
		echo "\t \t background-color: " .$_SESSION["userbgcolor"] ."; \n";
	} else {
		echo "\t \t background-color: #CCCCCC; \n";
	}
	if(isset($_SESSION["userbgcolor"])){
		echo "\t \t color: " .$_SESSION["usertxtcolor"] ."; \n";
	} else {
		echo "\t \t color: #000066; \n";
	}
	echo "\t } \n";
  ?>
  </style>
</head>
<img src="../../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse logo">
<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
<body>