// JavaScript Document

function getCurrentTime() {
	var now = new Date();
	
	var date = (now.toLocaleString());
	document.getElementById('footTime').innerHTML= date;
}
