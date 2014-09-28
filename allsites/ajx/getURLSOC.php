<?php

header("content-type: application/json"); 

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');

$res=DBselect("SELECT idc FROM skv_user_sels WHERE UID='$uid';");$idsels="";
if(count($res)>0){foreach($res as $c => $vals){$idsels.=$vals['idc'] . ",";}};
$idsels=substr($idsels, 0,-1);


$res=DBselect("SELECT id_cat, (SELECT id_sup FROM skf_cats WHERE id=id_cat) as top FROM skv_relCurCats WHERE id_cur IN ($idsels);");$catsels=array();
if(count($res)>0){foreach($res as $c => $vals){
	
	foreach ($vals as $key => $value) {
	if(array_key_exists($value, $catsels)){$catsels[$value]++;}else{$catsels[$value]=1;};	
	}	

}}

arsort($catsels);
$first_key = key($catsels);

$res=DBselect("SELECT idp, url, pagTittleC FROM skf_urls WHERE t_id=$first_key AND tipo=1;");
if(count($res)>0){foreach($res as $c => $vals){$url=$v['vars']['purl'][$vals['idp']] . $vals['url']; $nom=$vals['pagTittleC'];}};

$res2=array();$id="";
$res2=DBselect("SELECT id FROM skv_user_social WHERE uid='$uid' AND red='$red' AND estado=0;");
if(count($res2)>0){	if(array_key_exists('id', $res2[1])){$id=$res2[1]['id']; }}

if($id){
$res=DBUpIns("UPDATE skv_user_social SET sel='$idsels' WHERE id='$id';");
}else{
$res=DBUpIns("INSERT INTO skv_user_social (uid,sel,red) VALUES ('$uid','$idsels','$red');");
$res2=DBselect("SELECT id FROM skv_user_social WHERE uid='$uid' AND red='$red' AND estado=0;");
$id=$res2[1]['id'];
}


$dat1=urlencode($url . "#lc$id");
$dat2=urlencode("http://cursodecursos.com/ajx/socialdone.php?done=" . $id);

$datospass=$dat1 ."|" . $dat2 . "|" . $nom;

$d[]=$datospass;




echo json_encode($d);
?>