<?php
	class Photoupload{
		private $photoinput;
		private $imagetype;
		private $mytempimage;
		private $mynewtempimage;
		public $filename;
		
		function __construct($photoinput, $filetype){
			$this->photoinput = $photoinput;
			$this->imagetype  = $filetype;
		}
		
		function __destruct(){
			if($this->mytempimage != null){
				imagedestroy($this->mytempimage);
			}
		}
		
		public function ifFileTypeImage($allowedImageTypes){
			$notice = null;
			$fileinfo = getimagesize($this->photoinput["tmp_name"]);
			if(in_array($fileinfo["mime"], $allowedImageTypes)){
				if($fileinfo["mime"] == "image/jpeg"){
					$this->imagetype = "jpg";
					$this->mytempimage = imagecreatefromjpeg($this->photoinput["tmp_name"]);
				}
				if($fileinfo["mime"] == "image/png"){
					$this->imagetype = "png";
					$this->mytempimage = imagecreatefrompng($this->photoinput["tmp_name"]);
				}
				if($fileinfo["mime"] == "image/gif"){
					$this->imagetype = "gif";
					$this->mytempimage = imagecreatefromgif($this->photoinput["tmp_name"]);
				}
			} else {
				$notice = 1;
			}
			return $notice;
		}
		
		public function checkFileSizeLimit($fileSizeLimit){
			$notice = null;
			if($this->photoinput["size"] > $fileSizeLimit){
				$notice = 1;
			}
			return $notice;
		}
		
		public function createFileName($prefix, $timestamp){
			$filename = $prefix .$timestamp ."." .$this->imagetype;
			return $filename;
		}
		
		public function resizePhoto($w, $h, $keeporigproportion = true){
			$imagew = imagesx($this->mytempimage);
			$imageh = imagesy($this->mytempimage);
			$neww = $w;
			$newh = $h;
			$cutx = 0;
			$cuty = 0;
			$cutsizew = $imagew;
			$cutsizeh = $imageh;
			
			if($w == $h){
				if($imagew > $imageh){
					$cutsizew = $imageh;
					$cutx = round(($imagew - $cutsizew) / 2);
				} else {
					$cutsizeh = $imagew;
					$cuty = round(($imageh - $cutsizeh) / 2);
				}	
			} elseif($keeporigproportion){//kui tuleb originaaproportsioone säilitada
				if($imagew / $w > $imageh / $h){
					$newh = round($imageh / ($imagew / $w));
				} else {
					$neww = round($imagew / ($imageh / $h));
				}
			} else { //kui on vaja kindlasti etteantud suurust, ehk pisut ka kärpida
				if($imagew / $w < $imageh / $h){
					$cutsizeh = round($imagew / $w * $h);
					$cuty = round(($imageh - $cutsizeh) / 2);
				} else {
					$cutsizew = round($imageh / $h * $w);
					$cutx = round(($imagew - $cutsizew) / 2);
				}
			}
			
			//loome uue ajutise pildiobjekti
			$this->mynewtempimage = imagecreatetruecolor($neww, $newh);
			//kui on läbipaistvusega png pildid, siis on vaja säilitada läbipaistvusega
			imagesavealpha($this->mynewtempimage, true);
			$transcolor = imagecolorallocatealpha($this->mynewtempimage, 0, 0, 0, 127);
			imagefill($this->mynewtempimage, 0, 0, $transcolor);
			imagecopyresampled($this->mynewtempimage, $this->mytempimage, 0, 0, $cutx, $cuty, $neww, $newh, $cutsizew, $cutsizeh);
		}
		
		public function addWatermark($wmf){
			if(isset($this->mynewtempimage)){
				$watermark = imagecreatefrompng($wmf);
				$wmw = imagesx($watermark);
				$wmh = imagesy($watermark);
				$wmx = imagesx($this->mynewtempimage) - $wmw - 10;
				$wmy = imagesy($this->mynewtempimage) - $wmh - 10;
				//kopeerin vesimärgi pildile
				imagecopy($this->mynewtempimage, $watermark, $wmx, $wmy, 0, 0, $wmw, $wmh);
				imagedestroy($watermark);
			}
		}
		
		public function savePhotoFile($target){
			$notice = null;
			if($this->imagetype == "jpg"){
				if(imagejpeg($this->mynewtempimage, $target, 90)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			if($this->imagetype == "png"){
				if(imagepng($this->mynewtempimage, $target, 6)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			if($this->imagetype == "gif"){
				if(imagegif($this->mynewtempimage, $target)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			imagedestroy($this->mynewtempimage);
			return $notice;
		}
		
		public function saveOriginalPhoto($target){
			$notice = null;
			if(move_uploaded_file($this->photoinput["tmp_name"], $target)){
				$notice = 1;
			} else {
				$notice = 0;
			}
			return $notice;
		}
		
	}//class lõppeb
?>