<?php
$_SERVER['HTTP_X_UA_DEVICE']='M';
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='cursos';
$v['where']['id']=$idcur; 

$v['where']['pag']=1;
$v['where']['pagTittle']='Solicita información gratuitamente';
$v['where']['codTittle']='Solicita información gratuitamente';

require_once ('iniAJX.php');



includeFUNC('form');

$form=getForm();
loadJS('n_objt','form');
loadCSS('n_objt','form');
loadCSS('n_objt','formM');



$metas=loadChild('n_objt','metasFM');


?>

<!DOCTYPE html>
<html lang="es">

<head>
<?php echo $metas;?>
</head>



<body class="gris1_BG" onload="init();">

<div class="pgM" id="page">	

<div class="cL color2_BG" id="menu">
<div id="cmenu">	
<?php echo $form;?>
<div style="clear:both"></div>	
</div></div>

</div>

</body>
</html>