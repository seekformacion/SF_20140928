<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=$idc; 
require_once ('iniAJX.php');

$id="";
$res=DBselect("SELECT id FROM skf_txtDesc WHERE t_id=$idc;");
if(array_key_exists(1, $res)){$id=$res[1]['id'];};

if($id){
$res=DBUpIns("UPDATE skf_txtDesc SET $campo='$cont' WHERE id=$id;");	
}else{
$res=DBUpIns("INSERT INTO skf_txtDesc (t_id,$campo) VALUES ($idc,'$cont');");		
}

$vals[$campo]=$cont;

echo json_encode($vals);
?>
