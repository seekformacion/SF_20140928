<?php
header("content-type: application/json"); 

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=$url; 
require_once ('iniAJX.php');

includeFUNC('categorias');
includeFUNC('sacaCursos');
includeFUNC('images');

$dd['admin']=loadChild('objt','adminCAT');
$dd['js']="http://192.168.1.43/admcat.js";

echo json_encode($dd);
?>