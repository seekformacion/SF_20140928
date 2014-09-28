<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='sitemaps';
$v['where']['id']=1; 
require_once ('iniAJX.php');

$v['where']['idp']=$portal;

echo loadChild('objt','pagina2');
?>