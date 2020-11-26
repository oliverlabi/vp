let fileuploadsizelimit = 2097152;
window.onload = function(){
	//window.alert("See töötab!");
	//console.log(fileuploadsizelimit);
	document.getElementById("photosubmit").disabled = true;
	document.getElementById("photoinput").addEventListener("change", checkSize);
}

function checkSize(){
	if(document.getElementById("photoinput").files[0].size <= fileuploadsizelimit){
		document.getElementById("photosubmit").disabled = false;
		document.getElementById("notice").innerHTML = "";
	} else {
		document.getElementById("photosubmit").disabled = true;
		document.getElementById("notice").innerHTML = "Valitud fail on liiga suur!";
	}
}