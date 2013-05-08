// JavaScript Document

var messageObj = new DHTML_modalMessage();	 
messageObj.setShadowOffset(10);	 
		
function displayMessage(url){
    messageObj = new DHTML_modalMessage();	 
messageObj.setShadowOffset(10);
	messageObj.setSource(url);
	messageObj.setCssClassMessageBox(false);
	messageObj.setSize(300,150);
	messageObj.setShadowDivVisible(true); 
	messageObj.display();
}

function closeMessage()	{
	messageObj.close();	
}
	
function soulignerRow(elem, laClass){
	elem.className=laClass; 
}