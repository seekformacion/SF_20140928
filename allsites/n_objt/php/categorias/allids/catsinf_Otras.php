<?php

$catsinf=$v['where']['cats_inf_otras'];
//print_r($catsinf);
//$Datos['ctsin']=$v['where']['Catsin'];

if(count($catsinf)>0){

$listCats="";
foreach ($catsinf as $key => $value) {

$newc[$key]['idc']=$value['t_id']; $listCats.=$value['t_id'] . ",";
$newc[$key]['url']=$value['url'];
$newc[$key]['pagTittleC']=$value['pagTittleC'];
$newc[$key]['pagTittle']=$value['pagTittle'];
$newc[$key]['done']="";

$noadmin=1;
if(array_key_exists('modeA', $_COOKIE)){if($_COOKIE['modeA']=='admin'){$noadmin=0;}}

if($noadmin){
		
	$newc[$key]['done']='<div class="iconos ticScatF color2_BG"></div>';

	}else{
	
	$idcc=$value['t_id']; $a=""; $b="";
	$res=DBselect("SELECT mini_Text, text_desc FROM skf_txtDesc WHERE t_id=$idcc;");	
	if(array_key_exists(1, $res)){$a=trim($res[1]['mini_Text']);$b=trim($res[1]['text_desc']);};	
	
	if(($a)&&($b)){$newc[$key]['done']='<div class="iconos ticScatF color2_BG"></div>';}
	}


	
}	
	
$rDatos['cadCinf']=$newc;

global $lccu; global $lccuT;
$listCats=substr($listCats, 0,-1); $lcusos=""; $lccu['html']="";


/*
$curinf=DBselect("SELECT DISTINCT(id_cur) as idCUR FROM skv_relCurCats WHERE id_cat IN ($listCats) AND showC=1;");
if(count($curinf)>0){foreach ($curinf as $k => $vals){$lcusos.=$vals['idCUR'] . ",";};};$lcusos=substr($lcusos, 0,-1);
$lcusos=ordenaCURs($lcusos,0,2);

$first=1;
if(count($lcusos)>0){foreach ($lcusos as $key => $idcc) {

$lccu['key']=$key; $lccu['$idcc']=$idcc;
$lccu['html'] .=loadChild('objt','subCURcatsinf');

	
}}
*/



}else{
//$rDatos['cadCinf'][0]['idc']=1;	
$Datos['codNULL']=1;		
}



	

	
	

?>