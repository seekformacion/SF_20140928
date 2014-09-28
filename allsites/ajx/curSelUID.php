<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');



$res=array();$vals=array();

if($do==1){
$res=DBselect("SELECT idc FROM skv_user_sels WHERE UID='$uid';");
if(count($res)>0){foreach ($res as $key => $value) {$vals[]=$value['idc'];}};
}

if($do==2){
$res=DBUpIns("INSERT INTO skv_user_sels (UID,idc) VALUES ('$uid','$idc');");	
$res=DBselect("SELECT count(distinct idc) as N FROM skv_user_sels WHERE UID='$uid';");
if(count($res)>0){foreach ($res as $key => $value) {$vals['N']=$value['N'];}};
}

if($do==3){
$res=DBUpIns("DELETE FROM skv_user_sels WHERE UID='$uid' AND idc=$idc;");	
$res=DBselect("SELECT count(distinct idc) as N FROM skv_user_sels WHERE UID='$uid';");
if(count($res)>0){foreach ($res as $key => $value) {$vals['N']=$value['N'];}};
}


if($do==4){
$res=DBUpIns("INSERT INTO skv_user_vist (UID,idc) VALUES ('$uid','$idc');");	
}

if($do==5){
$res=DBselect("SELECT count(distinct idc) as N FROM skv_user_sels WHERE UID='$uid';");
if(count($res)>0){foreach ($res as $key => $value) {$vals['N']=$value['N'];}};	
}


echo json_encode($vals);
?>