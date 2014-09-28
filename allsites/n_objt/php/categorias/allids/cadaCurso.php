<?php

global $v;global $data; global $pals; global $pesos;
$eqtip=$v['vars']['eqtip'];
$eqmet=$v['vars']['eqmet'];
$eqp=$v['vars']['provN'];

$nom=$data['nombre'];

############ añado nombre de provin en titulo
$idpro=$v['where']['id_provi'];
if($idpro){
$np=$eqp[$idpro];
$nom="$nom en $np";		
}
#############################################

############ añado online en titulo
//if($v['where']['online']){$nom="$nom online";};
#############################################

############ añado distancia en titulo
//if($v['where']['distancia']){$nom="$nom a distancia";};
#############################################


 
$Datos['nombre']=$nom;# . "-" . $data['cur_id_metodo'] . "-" . $data['id'];
$Datos['url']=$data['url'];
$Datos['id']=$data['id'];
$Datos['pinp']=$data['pinp'];

if($v['debugIN']>0){
$Datos['precio']=$pesos[$data['id']];
}else{
$Datos['precio']=$data['price'];	
}


####### franja titulacion precio

if(($data['cur_id_certificado']==1)||($data['cur_id_certificado']==2)||($data['cur_id_certificado']==7)||($data['cur_id_certificado']==10)){
$tit=$v['vars']['certi'][$data['cur_id_certificado']];

$Datos['tit']="<div class='titu'>$tit</div>";
$Datos['prf']='prF';
}else{
$Datos['tit']="";
$Datos['prf']='';	
}
###############################



$Datos['tip']=$eqtip[$data['cur_id_tipocurso']]['s'];

if($v['where']['id_provi']){$pp= ' en ' . normaliza($v['vars']['provN'][$v['where']['id_provi']]);}else{$pp="";};
$Datos['met']=$eqmet[$data['cur_id_metodo']]['s'] . $pp;
$Datos['v']=valoracion($data['id']);
//$Datos['bc']=$v['where']['bc'];

$descripcion=$data['cur_paraqueteprepara'] . "</p><p>" . $data['cur_descripcion'];


if(strlen($descripcion)>400){$descripcion=substr($descripcion, 0,400) . "...";};

//$descripcion=strongTXT($descripcion,$pals);

$Datos['cur_descripcion']= $descripcion;
$Datos['ncent']=$data['ncent'];
$Datos['imgLogoCent']=loadLogoCent('p/' . $data['file_logo']);


?>