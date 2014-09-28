<?php

function getKeywords(){global $v;

$idp=$v['where']['idp'];
$view=$v['where']['view'];
$idv=$v['where']['id'];

$kewords=array();$pals="";$pals2="";

if($view=='cursos'){

$inf=DBselect("select * from skf_urls where tipo=2 AND t_id=$idv;");	
if(array_key_exists(1, $inf)){foreach ($inf as $cc => $vals){

$pals.=$vals['pagTittleC'] . ", ";
$pals.=$v['vars']['raizS'][$idp] . limpia($vals['pagTittleC']) . ", ";
$pals.=str_replace(' ', ', ',limpia($vals['pagTittleC']));
	
}}



	
}

if($view=='categorias'){
$inf=DBselect("select * from skf_urls where tipo=1 AND t_id=$idv;");	
if(array_key_exists(1, $inf)){foreach ($inf as $cc => $vals){

$pals.=$vals['pagTittleC'] . ", ";
$pals.=$v['vars']['raizS'][$idp] . limpia($vals['pagTittleC']) . ", ";
$pals.=limpia($vals['pagTittleC']) . ", ";
$pals.=str_replace(' ', ', ',limpia($vals['pagTittleC']));
	
}}



	
}

if($view=='home'){
	
}


$pp=explode(', ',$pals); 
if(count($pp)>0){ foreach ($pp as $cc => $pi) {$ppp[$pi]=1;}
foreach ($ppp as $pal => $value) {$pals2 .=$pal .", ";}
}

	
$pals2=substr($pals2, 0,-2);	
return $pals2;	
}


function limpia($pal){
$borros=array('Cursos: ', 'Cursos de ', 'Masters: ', 'Masters en ','Fp: ', 'Grado medio en ', 'Grado superior en ', 'Oposiciones: ', 'Oposiciones a ' );
$pal=str_replace($borros,'',$pal);
return $pal;	
}

?>