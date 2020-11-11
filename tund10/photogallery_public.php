<?php
  require("usesession.php");
  require("../../../config.php");
  require("../../../config_photo.php");
  require("fnc_photo.php");
  
  $notice = "";
  $page = 1;
  $photocount = countPublicPhotos(2);
  
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif((intval($_GET["page"]) - 1) * $gallerypagelimit >= $photocount){
	  $page = ceil($photocount/$galleypagelimit);
  } else {
	  $page = intval($_GET["page"]);
  }
  
  $publicphotothumbshtml = readAllPublicPhotoThumbsPage(2, $gallerypagelimit, $page);
  
  $tolink = '<link rel="stylesheet" type="text/css" href="style/gallery.css">' ."\n";
  
  require("header.php");
?>
  <p>Avalikud galeriipildid<p>
  <ul>
    <li><a href="home.php">Avaleht</a></li>
    <li><a href="photoupload.php">Galeriipiltide üleslaadimine</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  <hr>
  <h2>Fotogalerii</h2>
  <p>
	<?php
		if($page > 1){
			echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a></span> | ' ."\n";
		} else {
			echo '<span>Eelmine leht</span> | ' ."\n";
		}
		if($page * $gallerypagelimit < $photocount){
			echo '<span><a href="?page=' .($page + 1) .'">Järgmine leht</a></span> ' ."\n";
		} else {
			echo '<span>Järgmine leht</span> ' ."\n";
		}
	?>
  </p>
  <?php
	echo $publicphotothumbshtml;
  ?>
</body>
</html>