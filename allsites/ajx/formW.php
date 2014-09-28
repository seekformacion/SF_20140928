<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />




<meta name="viewport" content="width=device-width" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />

<title>Solicitud de información gratuita</title>







<?php




foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};







global $v;



include('/www/dbA.php');  

#print_R($_POST);

#print_R($_GET);

$v['debug']=0;
$v['admin']=0;

$v['conf']['state']=2; # 1=test 2=produccion
$v['conf']['mode']=1; # 1=local 2=cloud

$v['where']['view']='categorias';
$v['where']['id']=1; 

########################################################### VARIABLES DE ENTORNO
//$v['where']['idp']=						1; #### ID DEL PORTAL PARA TABLA urls

$v['where']['site']=					$_SERVER['SERVER_NAME'];
//$v['path']['repo']=						"/www/repositorios";
$v['path']['bin']=$v['path']['repo'] .	"/SF_20121104";
$v['path']['fw']=$v['path']['repo'] .	"/FrameW_1";
$v['path']['img']=$v['path']['repo'] .	"/SeekFormacion_images";
$v['path']['httpd']=					"/www/httpd/" . $v['where']['site'];

$v['path']['baseURLskin'][1]=""; ## baseURL del SKIN local
$v['path']['baseURLskin'][2]="http://s3-eu-west-1.amazonaws.com/seekf"; ## baseURL del SKIN en CLOUD


#######################################################  INICIO DE APLICACION


require_once $v['path']['fw'] . '/core/templates/paths.php';



includeINIT('vars');
includeINIT('provins');
includeINIT('config');
includeCORE('db/dbfuncs');
includeCORE('templates/templates');
includeCORE('funcs/general');

$idp=$v['vars']['equiport'][$_SERVER['SERVER_NAME']];
$v['where']['idp']=$idp;




includeCORE('css/css');
includeCORE('js/js');
includeFUNC('funcmetas');

loadCSS('objt','colores');
loadCSS('objt','pagina');
loadCSS('objt','carrito');
loadJS('objt','carrito');

createCSS();

$cssG=$v['linksCSS'];
$cssI=$v['linksCSSIE'];
$imgI=loadIMG("iconos.png");

createJS();
$ljs=$v['linksjS'];

$gaccounts[1]="UA-36119979-1"; $gaccountsN[1]="cursodecursos.com";
$gaccounts[2]="UA-36119979-2"; $gaccountsN[2]="masterenmasters.com";
$gaccounts[3]="UA-36119979-3"; $gaccountsN[3]="fp-formacionprofesional.com";
$gaccounts[4]="UA-36119979-4"; $gaccountsN[4]="oposicionesa.com";

$analytics=$gaccounts[$v['where']['idp']];
$analyticsN=$gaccountsN[$v['where']['idp']];




echo "

<style>
.iconos {background-image: url(\"$imgI\");background-repeat: no-repeat;}
</style>


<link rel='stylesheet' type='text/css' href='/fonts/stylesheet.css' />

<!--[if IE]>$cssI<![endif]-->

<![if !IE]>
$cssG
<![endif]>

<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js'></script>

$ljs



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '$analytics', '$analyticsN');
  ga('send', 'pageview');

</script>


<script>
window.top.idport=$idp;
</script>

";


?>

<script>

function setCookie(c_name,value,exdays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate() + exdays);
if(exdays==0){
var c_value=escape(value);
}else{
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());	
}

document.cookie=c_name + "=" + c_value + '; path=/';
}


function getCookie(w){
	cName = "";
	pCOOKIES = new Array();
	pCOOKIES = document.cookie.split('; ');
	for(bb = 0; bb < pCOOKIES.length; bb++){
		NmeVal  = new Array();
		NmeVal  = pCOOKIES[bb].split('=');
		if(NmeVal[0] == w){
			cName = unescape(NmeVal[1]);
		}
	}
	return cName;
}
</script>



<?php
echo '



<html>
<body>

<div class="carrito_m">
<div onclick="closeW();" class="iconos close2"></div>
<div id="formdinamico">

';


$file = fopen ("http://cursodecursos.com:8080/ajx/form.php?uid=$uid&idc=$idc&idp=$idp", "r");
while (!feof ($file)) { $form = fgets ($file);};
fclose($file);

//echo $form;
$form2=json_decode($form, true);
//print_r($form2);

$html=$form2['html'];

echo $html;


?>

</div>

<div class="clean"></div>
	
</div>	



<div id="cupOK" style="display: none">

<div style="position:absolute; top:30px; left: 20px; width:460px; height:300px; z-index: 800" class="color2_BG"></div>
<img style="position:absolute; top:30px; left: 236px; z-index: 810" src="/img/global/allviews/form/students.png">
<div style="position:absolute; top:133px; left: 67px; width:361px; height:160px; z-index: 805" class="bloque shadow">

<div style="position:relative; width:300; margin:30px 0px 0px 30px; font-family: Arial; font-size: 19px; color:#888888;">
Tus datos han sido enviados correctamente.
</div>

<div style="position:relative; width:300; margin:10px 0px 0px 30px; font-family: Arial; font-size: 19px; color:#888888;">
En breve te será facilitada más información detallada.	
</div>

</div>


<div style="position:absolute; top:373px; left: 20px; width:460px; height:110px; z-index: 800; background-color: #dddddd"></div>
<img style="position:absolute; top:383px; left: 64px; z-index: 810" src="/img/global/allviews/form/capple.png">
<img style="position:absolute; top:347px; left: 336px; z-index: 810" src="/img/global/allviews/form/papple.png">
<div style="position:absolute; width:236px; top:430px; left: 64px; z-index: 815; font-family: Arial; font-size: 11px; color:#666666;">
Participa en nuestro concurso de <strong>Facebook</strong> y gana uno de estos productos Apple.
</div>
<img onclick="goContest();" style="position:absolute; top:461px; left: 145px; z-index: 820; cursor:pointer;" src="/img/global/allviews/form/participa.png">
	
</div>