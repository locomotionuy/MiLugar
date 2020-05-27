document.currentScript = document.currentScript || (function() {
  var scripts = document.getElementsByTagName('script');
  return scripts[scripts.length - 1];
})();

var param_id = document.currentScript.getAttribute('id');
var param_height = document.currentScript.getAttribute('height');

var divwrap = document.createElement("div");
divwrap.style.float = "left";
divwrap.style.width = "100%";

if ($(window).height() < 737) {
   divwrap.style.height = 400+"px";
}
else {
   divwrap.style.height = param_height+"px";
}

divwrap.style.position = "relative";
divwrap.style.zIndex = "10000";
divwrap.id = "dimension360";
document.currentScript.parentElement.appendChild(divwrap);

var panel = document.createElement("div");
panel.style.textAlign = "center";
panel.style.display = "inline-block";
panel.style.margin = "0 auto";
panel.style.maxWidth = "1060px";
panel.style.position = "absolute";
panel.style.top = "auto";
panel.style.left = "0px";
panel.style.right = "0px";
panel.style.bottom = "0";
panel.style.zIndex = "1000";
panel.style.width = "100%";
panel.style.backgroundColor = "rgba(0,0,0,1)";
panel.id = "dim360panel";
document.getElementById("dimension360").appendChild(panel);

var poweredby = document.createElement("a");
var createAText = document.createTextNode("Ciu.org.uy");
poweredby.setAttribute('href', "https://ciu.org.uy");
poweredby.setAttribute('target', "_blank");
poweredby.style.display = "inline-block";
poweredby.style.position = "absolute";
poweredby.style.left = "50%";
poweredby.style.margin = "0 0 0 -65px";
poweredby.style.top = "0";
poweredby.style.zIndex = "3000";
poweredby.style.backgroundColor = "rgba(0,0,0,0.3)";
poweredby.style.padding = "3px 6px";
poweredby.style.borderBottomLeftRadius = "3px";
poweredby.style.borderBottomRightRadius = "3px";
poweredby.style.color = "#ccc";
poweredby.style.fontSize = "10px";
poweredby.style.fontFamily = "Arial, Helvetica, sans-serif";
poweredby.appendChild(createAText);
document.getElementById("dimension360").appendChild(poweredby);

var iframe = document.createElement("iframe");
iframe.src = "inc-visor.php?id="+param_id;
iframe.width = "100%";
iframe.height = "100%";
iframe.frameborder = "0";
iframe.style.border = "0";
iframe.setAttribute('allowFullScreen', '')
document.getElementById("dimension360").appendChild(iframe);

var btn = document.createElement("img");
btn.src = "images/btn-maximizar.png";
btn.srcset = "images/btn-maximizar.svg";
btn.style.width = "30px";
btn.style.height = "30px";
btn.style.position = "absolute";
btn.style.bottom = "13px";
btn.style.right = "10px";
btn.style.zIndex = "1000";
btn.style.cursor = "Pointer";
btn.style.opacity = "1";
btn.id = "d360btn";

document.getElementById("dim360panel").appendChild(btn);

/*if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
{
    var iOS = !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
	if(iOS==true) document.getElementById("dim360panel").appendChild(btn);
	
	document.getElementById("dim360panel").appendChild(btn);
}
else
{
	document.getElementById("dim360panel").appendChild(btn);	
}*/

document.getElementById("d360btn").onmouseover = btnScale;
document.getElementById("d360btn").onmouseout = btnScale;
function btnScale()
{
	var btnChange = document.getElementById("d360btn");
	if(btnChange.style.opacity === "1")
	{
		btnChange.style.transform = "scale(1.1)";
		btnChange.style.opacity = "0.7";
	}
	else
	{
		btnChange.style.transform = "scale(1)";
		btnChange.style.opacity = "1";
	}
}
document.getElementById('d360btn').onclick = d360togglestyle;
function d360togglestyle()
{
	var wrap = document.getElementById("dimension360");
	if (wrap.style.float === "left")
	{
		btn.src = "images/btn-minimizar.png";
		btn.srcset = "images/btn-minimizar.svg";
		wrap.style.float = "none";
		wrap.style.position = "fixed";
		wrap.style.top = "0";
		wrap.style.bottom = "0";
		wrap.style.left = "0";
		wrap.style.right = "0";
		wrap.style.height = "auto";
		wrap.style.zIndex = "100000";
		wrap.style.backgroundColor = "#eaeaea";
	} 
	else
	{
		btn.src = "images/btn-maximizar.png";
		btn.srcset = "images/btn-maximizar.svg";
		wrap.style.float = "left";
		wrap.style.width = "100%";
		wrap.style.height = param_height+"px";
		wrap.style.position = "relative";
		wrap.style.zIndex = "10000";
	}
}