function getstyle(el,styleProp)
{
	if (el.currentStyle)
		var y = el.currentStyle[styleProp];
	else if (window.getComputedStyle)
		var y = document.defaultView.getComputedStyle(el,null).getPropertyValue(styleProp);
	return y;
}
