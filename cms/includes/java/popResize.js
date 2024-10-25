var checkW;

function checkSize() { 
	
	var wPop = (checkW) ? checkW : 300;
	var hPop = (navigator.appName.search("Microsoft") == -1) ? document.body.offsetHeight : document.body.scrollHeight;
	
	parent.sizePop(wPop,hPop);
}
onload = checkSize;