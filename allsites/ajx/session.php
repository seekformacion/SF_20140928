<?php
header('P3P: CP="NOI ADM DEV COM NAV OUR STP"');
header("content-type: application/json"); 

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');


includeCORE('funcs/funcSESSION');


$new=0;
if (isset($_COOKIE["seekforID"])){
$seekforID= $_COOKIE["seekforID"];
}else{$new=1;
$seekforID=create_new_user();
$expire=time()+60*60*24*30;
setcookie("seekforID", $seekforID, $expire, '/');
}




if (isset($_GET['id'])) $rtnjsonobj->id = $_GET['id'];

if($new){$seekforID.="||new";};
 
$rtnjsonobj->message = $seekforID;
echo $_GET['callback']. '('. json_encode($rtnjsonobj) . ')';  


?>