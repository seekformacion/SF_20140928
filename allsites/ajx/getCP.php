<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');


$vals=array();$vals['cp']="";
$res=DBselect("SELECT cp FROM skv_user_sessions WHERE seekforID='$uid';");
if(count($res)>0){foreach ($res as $key => $value) {$vals['cp']=$value['cp'];}};


echo json_encode($vals);