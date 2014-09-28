<?php
$done=""; $post_id="";
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');

if(($done)&&($post_id)){

$res=DBUpIns("UPDATE skv_user_social SET estado='1' WHERE id='$done';");
	
	
}
?>

<script>

window.close();	
	
</script>