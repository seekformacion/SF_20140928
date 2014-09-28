<?php

$catsinf=$v['where']['cats_inf'];


if(count($catsinf)>0){

foreach ($catsinf as $key => $value) {

$newc[$key]['idc']=$value['t_id'];
$newc[$key]['url']=$value['url'];
$newc[$key]['pagTittleC']=$value['pagTittleC'];


/*
if(!$v['admin']){
		
	$newc[$key]['done']='<div class="iconos ticScatF color2_BG"></div>';

	}else{
	
	$idcc=$value['t_id']; $a=""; $b="";
	$res=DBselect("SELECT mini_Text, text_desc FROM skf_txtDesc WHERE t_id=$idcc;");	
	if(array_key_exists(1, $res)){$a=trim($res[1]['mini_Text']);$b=trim($res[1]['text_desc']);};	
	
	if(($a)&&($b)){$newc[$key]['done']='<div class="iconos ticScatF color2_BG"></div>';}
	}
*/

	
}	
	
$rDatos['cadCinf']=$newc;
}else{
$Datos['codNULL']=1;		
}



	

	
	

?>