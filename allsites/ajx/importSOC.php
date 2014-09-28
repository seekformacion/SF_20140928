<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');
$cc=0;
$idselss=array();
$res=DBselect("SELECT sel FROM skv_user_social WHERE id='$lc';");
if(count($res)>0){
$idsels=$res[1]['sel'];
$idselss=explode(',',$idsels);
if($uid){
$res=DBUpIns("DELETE FROM skv_user_sels WHERE UID='$uid';");
foreach ($idselss as $key => $idcu) {$cc++;
$res=DBUpIns("INSERT INTO skv_user_sels (UID,idc) VALUES ('$uid','$idcu');");	
}		
}

}


$dd=array();
if($cc){	

if($cc>1){$que="$cc cursos que le interesan. Puedes ver la lista de esos cursos ";}
else{$que="un curso en el que esta interesado. Puedes ver ese curso ";};

$dd['newlc']='
<div id="em-3" class="bloque shadow lcSOC">

<div class="amiSOC color1">
Un amigo tuyo ha solicitado tu opinión sobre ' . $que . 'en cualquier momento haciendo click en el botón del selector de cursos en la barra de navegación inferior. 
</div>

<div class="iconos iFAV" style="position:absolute; top: 118px; left:180px;"; onclick="outemer();formup();"></div>
</div>
';

}
echo json_encode($dd)
?>

