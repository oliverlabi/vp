<?php
  require("usesession.php");
  require("../../../config.php");
  require("../../../config_photo.php");
  require("fnc_photo.php");
  
  $notice = "";
  $page = 1;
  $photocount = countPublicPhotos(2);
  
  $tolink = '<link rel="stylesheet" type="text/css" href="style/gallery.css">' ."\n";
  $tolink .= '<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n";
  $tolink .= '<script src="javascript/modal.js" defer></script>' ."\n";

  
  if(!isset($_GET["page"]) or $_GET["page"] < 1){
	  $page = 1;
  } elseif((intval($_GET["page"]) - 1) * $gallerypagelimit >= $photocount){
	  $page = ceil($photocount/$galleypagelimit);
  } else {
	  $page = intval($_GET["page"]);
  }
  
  $publicphotothumbshtml = readAllPublicPhotoThumbsPage(2, $gallerypagelimit, $page);
  

  
  require("header.php");
?>
  <p>Avalikud galeriipildid<p>
  <ul>
    <li><a href="home.php">Avaleht</a></li>
    <li><a href="photoupload.php">Galeriipiltide üleslaadimine</a></li>
  </ul>
  <p><a href="?logout=1">Logi välja!</a></p>
  
  <!--Modaalaken fotogalerii jaoks-->
  <div id="modalarea" class="modalarea">
   <!--Sulgemisnupp-->
    <span id="modalclose" class="modalclose">&times;</span>
   <!--Pildikoht-->
    <div class="modalhorizontal">
		<div class="modalvertical">
			<p id="modalcaption"></p>
			<img id="modalimg" src="../../img/empty.png" alt="galeriipilt">
			
			<br>
			<div id="rating" class="modalRating">
				<label><input id="rate1" name="rating" type="radio" value="1">1</label>
				<label><input id="rate2" name="rating" type="radio" value="2">2</label>
				<label><input id="rate3" name="rating" type="radio" value="3">3</label>
				<label><input id="rate4" name="rating" type="radio" value="4">4</label>
				<label><input id="rate5" name="rating" type="radio" value="5">5</label>
				<button id="storeRating">Salvesta hinnang!</button>
				<br>
				<p id="avgRating"></p>
			</div>
		</div>
    </div>
  </div>
 
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