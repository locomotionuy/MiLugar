<?php 
// Antes del include:
//$slide_tabla = "novedades"; 
//$slide_url = "novedades";
//$sldnum = 1;
//$duracion_slide = 3000; // 1000 = 1seg
?>
<style type="text/css">
.slides-content {
	width: 100%;
	float: left;
	display: block;
	position: relative;
	background-repeat: no-repeat;
	background-position: center center;
	background-color: #ABABAB;
	position: relative;
	height: 550px;
}
.btn-full{
	position: absolute;
	bottom: 16px;
	right: 10px;
	width: 37px;
	height: 35px;
	padding: 9px 0 0 7px;
	z-index: 100000;
	font-size: 30px;
	text-align: center;
	cursor: pointer;
}
.btn-full img{
	width: 30px;
	height: auto;
}
.btn-full:hover{
	opacity: 0.7;
}
.slides<?php echo $sldnum ?> {
	height: 100%;
}
@media only screen and (max-width : 870px) {
.slides-content, .slides<?php echo $sldnum ?> {
	width: 100%;
	height: 550px;
	background-size: auto 100%;
}
.btn-full{
	bottom: 10px;
	right: 10px;
}
.btn-full img{
	width: 30px;
}
}
.slides<?php echo $sldnum ?> {
	width: 100%;
	position: absolute;
	top: 0;
	left: 0;
	background-size: auto 100%;
	background-repeat: no-repeat;
	background-position: center;
	opacity: 0;
	z-index: 1;
	-webkit-transition: opacity 1s;
	-moz-transition: opacity 1s;
	-o-transition: opacity 1s;
	transition: opacity 1s;
}
.slides<?php echo $sldnum ?>-dot {
	display: inline-block;
	margin: 3px 5px 0 5px;
	width: 14px;
	height: 14px;
	background-color: rgba(255,255,255,1);
	background-size: 0px 0px;
	background-repeat: no-repeat;
	cursor: pointer;
    transition: .3s ease-in-out;
	opacity: 0.7;
	position: relative;
	text-align: center;
}
.slides<?php echo $sldnum ?>-dot:hover {
	color: #000;
    -ms-transform: scale(2); /* IE 9 */
    -webkit-transform: scale(2); /* Safari */
    transform: scale(2);
	margin: 0 10px 0 10px;
	background-size: auto 100%;
}
.showing {
	opacity: 1;
	z-index: 2;
}
.slides-left, .slides-right {
	position: absolute;
	left: 0;
	top: 50%;
	cursor: pointer;
	background-color: rgba(255,255,255,0.7);
	border: none;
	color: #fff;
	margin-top: -50px;
	height: 60px;
	width: 33px;
	font-size: 50px;
	z-index: 3;
	transition: .2s ease-in-out;
	text-align: left;
}
.slides-left img, .slides-right img{
	width: 35px;
	margin-top: 12px;
}
.slides-left:hover, .slides-right:hover {
	background-color: rgba(255,255,255,1);
}
.slides-right {
	left: auto;
	right: 0;
}
.slides-right img{
	transform: rotate(180deg);
}
@media only screen and (max-width : 767px) {
.slides-content, .slides<?php echo $sldnum ?> {
	width: 100%;
	height: 300px;
	background-size: auto 100%;
}
}
.slides-nav {
	width: 100%;
	position: absolute;
	bottom: 0;
	z-index: 3;
	text-align: center;
	background-color: rgba(74,75,79,0.9);
	height: 55px;
	padding: 16px 0 0 0;
}
.slides-dot-selected{
    -ms-transform: scale(2); /* IE 9 */
    -webkit-transform: scale(2); /* Safari */
    transform: scale(2);
	margin: 0 10px 0 10px;
	background-size: auto 100%;
	opacity:1;
}
.slides-play {
	position: absolute;
	bottom: 16px;
	left: 16px;
	cursor: pointer;
	display: inline-block;
	z-index: 3;
	font-size: 23px;
	line-height: 20px;
	color: #FFF;
	opacity: 0.7;
}
.slides-play:hover {
	opacity: 1;
}
#img_minimizar {
	display: none;	
}
@media only screen and (max-width : 1000px) {
.slides<?php echo $sldnum ?>-dot {
	display: inline-block;
	margin: 6px 3px 0 3px;
	width: 12px;
	height: 10px;
	background-color: rgba(255,255,255,1);
	border: solid 1px rgba(255,255,255,1);
	border-radius: 2px;
	background-size: 1px 1px;
	background-repeat: no-repeat;
	cursor: pointer;
    transition: .3s ease-in-out;
	opacity: 0.7;
	position: relative;
	text-align: center;
}
.slides-dot-selected{
    -ms-transform: scale(2); /* IE 9 */
    -webkit-transform: scale(2); /* Safari */
    transform: scale(2);
	margin: 0 5px 0 5px;
	background-size: auto 100%;
	opacity:1;
}
}
</style>
<div class="slides-content" id="slide_content<?php echo $sldnum ?>" style="float: left">
<div class="btn-full" id="btn_full<?php echo $sldnum ?>">
	<img id="img_maximizar" src="images/btn-maximizar.png" alt="Full" />
    <img id="img_minimizar" src="images/btn-minimizar.png" alt="Full" />
</div>
<?php
    $i = 1; 
    $stmt1 = $conn->prepare("SELECT * FROM $slide_tabla WHERE id_referencia=$id_referencia and tipo = 'foto' ORDER BY orden ASC");
    $stmt1->execute();
    while( $row1 = $stmt1->fetch() ) 
    {
		
		echo '<a href="'.$slide_url.'.php?id='.$row1['id'].'" class="slides'.$sldnum.'';

		if($i==1) echo ' showing';
		
		// Check if file exists
		$handle = @fopen($row1['foto'], 'r');
		if($handle)
		{
			echo '" style="background-image: url('.$row1['foto'].')"></a>';
		}
		else
		{
			echo '" style="background-image: url(images/sinfoto.jpg)"></a>';
		}
		$i++;
		
    }
    ?>
  <div class="slides-left" onclick="plusDivs<?php echo $sldnum ?>(-1,1)"><img src="images/btn-arrow.png" alt="&lt;" /></div>
    <div class="slides-right" onclick="plusDivs<?php echo $sldnum ?>(+1,1)"><img src="images/btn-arrow.png" alt="&lt;" /></div>
    <div class="slides-nav">
    <?php
    $i = 1; 
    $stmt2 = $conn->prepare("SELECT * FROM $slide_tabla WHERE id_referencia=$id_referencia and tipo = 'foto' ORDER BY orden ASC");
    $stmt2->execute();
    while( $row2 = $stmt2->fetch() ) 
    {
        echo '<div style="background-image: url('.$row2['foto_thumb'].')" class="slides'.$sldnum.'-dot';
        if($i==1) echo ' slides-dot-selected';
        echo '" onclick="currentDiv'.$sldnum.'('.$i.',1)"></div>';
        $i++;
    }
    ?>
  </div>
  <div class="slides-play" id="slides<?php echo $sldnum ?>-play" onclick="timeout_init<?php echo $sldnum ?>()"><i class="fas fa-play-circle"></i></div>
</div>
<script type="text/javascript">
<?php echo '
var slideIndex'.$sldnum.' = 1;

function plusDivs'.$sldnum.'(n'.$sldnum.',pause'.$sldnum.') { showDivs'.$sldnum.'(slideIndex'.$sldnum.' += n'.$sldnum.',pause'.$sldnum.'); }
function currentDiv'.$sldnum.'(n'.$sldnum.',pause'.$sldnum.') { showDivs'.$sldnum.'(slideIndex'.$sldnum.' = n'.$sldnum.',pause'.$sldnum.'); }

function timeout_init'.$sldnum.'() {
    timeout'.$sldnum.' = setTimeout("plusDivs'.$sldnum.'(+1)", '.$duracion_slide.');
	document.getElementById("slides'.$sldnum.'-play").style.display = "none";
}
function timeout_clear'.$sldnum.'() {
    clearTimeout(timeout'.$sldnum.');
	document.getElementById("slides'.$sldnum.'-play").style.display = "block";
}
function showDivs'.$sldnum.'(n'.$sldnum.',pause'.$sldnum.') {
	timeout_clear'.$sldnum.'();
	var i'.$sldnum.';
	var x'.$sldnum.' = document.getElementsByClassName("slides'.$sldnum.'");
	var dots'.$sldnum.' = document.getElementsByClassName("slides'.$sldnum.'-dot");
	
	if (n'.$sldnum.' > x'.$sldnum.'.length) {slideIndex'.$sldnum.' = 1}    
	if (n'.$sldnum.' < 1) {slideIndex'.$sldnum.' = x'.$sldnum.'.length}
	
	for (i'.$sldnum.' = 0; i'.$sldnum.' < x'.$sldnum.'.length; i'.$sldnum.'++) {
	 x'.$sldnum.'[i'.$sldnum.'].className = "slides'.$sldnum.'";
	}
	for (i'.$sldnum.' = 0; i'.$sldnum.' < dots'.$sldnum.'.length; i'.$sldnum.'++) {
	 dots'.$sldnum.'[i'.$sldnum.'].className = dots'.$sldnum.'[i'.$sldnum.'].className.replace(" slides-dot-selected", "");
	}
	x'.$sldnum.'[slideIndex'.$sldnum.'-1].className += " showing";  
	dots'.$sldnum.'[slideIndex'.$sldnum.'-1].className += " slides-dot-selected";
	if(pause'.$sldnum.'==1) {} else { timeout_init'.$sldnum.'(); }
}
window.addEventListener("load", function() { timeout_init'.$sldnum.'(); });
';
?>
</script>
<script type="text/javascript">
document.getElementById('btn_full<?php echo $sldnum ?>').onclick = togglestyle<?php echo $sldnum ?>;

function togglestyle<?php echo $sldnum ?>()
{
	var wrap = document.getElementById("slide_content<?php echo $sldnum ?>");
	var btnfull = document.getElementById("btn_full<?php echo $sldnum ?>");
	
	if (wrap.style.float === "left")
	{
		wrap.style.float = "none";
		wrap.style.position = "fixed";
		wrap.style.top = "0";
		wrap.style.bottom = "0";
		wrap.style.left = "0";
		wrap.style.right = "0";
		wrap.style.height = "auto";
		wrap.style.zIndex = "100000";
		btnfull.style.color = "#fff";
		document.getElementById("img_maximizar").style.display = "none";
		document.getElementById("img_minimizar").style.display = "block";
	} 
	else
	{
		wrap.style.width = "100%";
		wrap.style.float = "left";
		wrap.style.display = "block";
		wrap.style.position = "relative";
		wrap.style.backgroundRepeat = "no-repeat";
		wrap.style.backgroundPosition = "center center";
		wrap.style.backgroundColor = "#ABABAB";
		wrap.style.position = "relative";
		wrap.style.height = "500px";
		btnfull.style.color = "#000";
		document.getElementById("img_maximizar").style.display = "block";
		document.getElementById("img_minimizar").style.display = "none";
	}
	
}
</script>