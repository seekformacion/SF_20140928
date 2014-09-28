<?php




foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');
$valor=addslashes($valor);

$query="UPDATE $table SET $campo='$value' WHERE t_id=$idc AND tipo IN (0,1);"; echo $query;

DBUpIns($query);


$vals=array();
echo json_encode($vals)
?>