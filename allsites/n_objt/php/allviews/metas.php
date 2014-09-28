<?php 
includeCORE('css/css');
includeCORE('js/js');
includeFUNC('funcmetas');



$lb=array("\n"); 
//$javacon=loadChild('n_objt','carrito');
//$java=str_replace($lb,'',$javacon);




/*
echo $javacon;
echo "\n----------------\n ";
echo $java;
echo "\n---------------- \n";
*/


//$v['JSpostPROCESS']['%listHTML%']=$java;

//loadJS('n_objt','swip');
loadJS('n_objt','global');
loadJS('n_objt','init');


createCSS();

global $datCur;

if($v['where']['pag']>1){$addpag=" - Página " . $v['where']['pag'];}else{$addpag="";};

$Datos['codTittle']=$v['where']['codTittle'] . $addpag;
$Datos['baseurlFonts']=$v['path']['baseURLskin'][$v['conf']['mode']];

$Datos['codTittleSIN']=$v['where']['pagTittle'];
$Datos['canonical']='http://' . strtolower($v['where']['site']) . strtolower($_SERVER['REQUEST_URI']);
$Datos['Portal']=$v['where']['site'];

if(array_key_exists('imgCat', $v)){
$Datos['imgCatPEQ']=$v['imgCat'];
}else{$Datos['imgCatPEQ']="";}
########## diferentes tipos de descripcion
if(($v['where']['view']=='categorias')||($v['where']['view']=='home')){

$txt=trim(DTXTcat($v['where']['id']));
if(!$txt){$txt=InventaDTXTcat($v['where']['pagTittle'],0);};

$Datos['description']=$txt;
}

if($v['where']['view']=='cursos'){
$Datos['description']=$datCur['cur_descripcion'];
}

if($v['where']['view']=='cms'){
$Datos['description']=$v['where']['pagTittle'];
}


if(array_key_exists('HTTP_X_UA_DEVICE', $_SERVER)){
$Datos['device']=$_SERVER['HTTP_X_UA_DEVICE'];
}else{
$Datos['device']='';	
}
$Datos['timestamp']=time();

$Datos['keywords']=getKeywords();
##########################################

$Datos['imgDedo']=loadIMG("dedo.png");
$Datos['imgIconos']=loadIMG("iconos.png");
$Datos['imgValor']=loadIMG("valoracion.png");
$Datos['imgFspain']=loadIMG("spainF.png");
$Datos['imgIprovis']=loadIMG("spainP.png");


$Datos['links_css']=$v['linksCSS'];
$Datos['links_cssIE']=$v['linksCSSIE'];

createJS();

$Datos['links_js']=$v['linksjS'];

$gaccounts[1]="UA-36119979-1"; $gaccountsN[1]="cursodecursos.com";
$gaccounts[2]="UA-36119979-2"; $gaccountsN[2]="masterenmasters.com";
$gaccounts[3]="UA-36119979-3"; $gaccountsN[3]="fp-formacionprofesional.com";
$gaccounts[4]="UA-36119979-4"; $gaccountsN[4]="oposicionesa.com";

$Datos['analytics']=$gaccounts[$v['where']['idp']];
$Datos['analyticsN']=$gaccountsN[$v['where']['idp']];
##########################################################

?>