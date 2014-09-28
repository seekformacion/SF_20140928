<?php 

includeFUNC('categorias');
includeFUNC('sacaCursos');
includeFUNC('images');

$idcat=$v['where']['id'];
catsINF($idcat);


$appid[1]="676600425716555";
$appid[2]="586283288126818";
$appid[3]="726238200741616";
$appid[4]="1468920489988724";

$idp=$v['where']['idp'];
$Datos['idp']=$idp;
$Datos['fbAPP']=$appid[$v['where']['idp']];


$Datos['imgLogo']=loadIMG("logo.png");
$Datos['home']="http://" . $v['where']['site'];
$Datos['homet']=$v['vars']['purlT'][$idp];

if(!array_key_exists('search', $v)){
$img=imgCATg($v['where']['id']); 

$Datos['imgC1']="<img class='imgCat' alt='". $v['where']['pagTittle'] . "' src='$img'>";
$Datos['imgC2']="<div class='imgCont'></div>";

}else{
$strI=str_replace('-',' ',$v['search']);
$res2=DBselectSDB("SELECT img from cache_str WHERE str='$strI' AND idp=$idp;",'seek_engSTR');
if(array_key_exists(1, $res2)){$idcfM=$res2[1]['img'];
$img=imgCATg($idcfM);
$Datos['imgC2']="<div class='imgCont'></div>";
$Datos['imgC1']="<img class='imgCat' alt='". $v['where']['pagTittle'] . "' src='$img'>";
}else{
	$img="";
	$Datos['imgC2']="";	
}}






$Datos['pagTittle']=$v['where']['pagTittle'];# . " | " . $v['where']['id'];


$Datos['idcfA']=$v['where']['id'];


if(!array_key_exists('search', $v)){
$Datos['breadcrumbs']=breadCRUMBS($idcat);
$bc=$v['where']['bc2'];
$bc=str_replace('<a href', '<a class="color1" href', $bc);
$v['where']['bc']=$bc . " ". $v['where']['pagTittle'];
	
}else{
$Datos['breadcrumbs']="";
$bc="";
$v['where']['bc']="";	
}

###### descripcion y SOCIAL
if(!array_key_exists('search', $v)){
$txt=trim(TXTcat($v['where']['id']));
if(!$txt){$txt=InventaTXTcat($v['where']['pagTittleSimp'],0);};
$Datos['txtDesc']=$txt;
}else{
$Datos['txtDesc']="<br><br>";	
}

$Datos['fburl']="http://" . $v['where']['site']  . $v['where']['urlSimple'];






//$Datos['sliders']=loadChild('objt','sliders');




$Datos['listCursos']=loadChild('n_objt','listCursos');

if(count($v['where']['cats_inf'])>0){
$Datos['catsinf']=loadChild('n_objt','catsinf');
}else{
$Datos['catsinf']="";	
}

$Datos['catsinf_Otras']=loadChild('n_objt','catsinf_Otras');



$Datos['quitos']=loadChild('n_objt','quitos');
$Datos['filtros']=loadChild('n_objt','filtros');
$Datos['footer']=loadChild('n_objt','footer');

global $lccu;
$Datos['topCURinf']=$lccu['html'];


//$Datos['adW_LD']=loadChild('objt','adW_LD');


//$Datos['tod_CUR']=loadChild('objt','tod_CUR');




//$Datos['bloqueGEO']=loadChild('objt','bloqueGEO');
//$Datos['bloqueONLINE']=loadChild('objt','bloqueONLINE');
//$Datos['bloqueDISTANCIA']=loadChild('objt','bloqueDISTANCIA');


//$Datos['masCATS']=loadChild('objt','masCATS');

if($v['where']['npags']>1){
$Datos['navBAR']=loadChild('n_objt','navBAR');
}else{
$Datos['navBAR']="";	
}
//$Datos['header']=loadChild('objt','header');
//$Datos['footer']=loadChild('objt','footer');


//$Datos['descTXTcat']=loadChild('objt','descTXTcat');

global $lccuT;
//$Datos['curDEST']=$lccuT['html'];


$Datos['metas']=loadChild('n_objt','metas');

 														 if($v['debugIN']>0){$Datos['dbi']="<div>" . $v['dbi'] . "</div>";}else{$Datos['dbi']="";}




?>