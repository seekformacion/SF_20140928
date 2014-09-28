<?php
header("content-type: application/json"); 

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');

$res=DBselect("SELECT datos FROM skv_user_sessions WHERE seekforID='$uid';");
if(count($res)>0){
$datos=$res[1]['datos']; $dat=explode('|',$datos);

$res=DBselect("SELECT idc, (select id_centro from skv_cursos WHERE id=idc) as cent FROM skv_user_sels WHERE UID='$uid';");
if(count($res)>0){
foreach ($res as $key => $val) {$cursos[$val['cent']][]=$val['idc'];}	
}

print_r($dat);	

$nombre=$dat[1];    
$apellidos=$dat[2]; 
$sexo=$dat[3];      
$naci=$dat[4];      
$tel=$dat[5];       
$mail=$dat[6];      
$estudi=$dat[7];    
$direccion=$dat[8]; 
$localidad=$dat[9]; 
$pais=$dat[10];      
$provi=$dat[11];     
$cp=$dat[12];        

$res=DBselect("SELECT id FROM skf_datCupon WHERE 
nombre='$nombre' AND 
apellidos='$apellidos' AND 
sexo='$sexo' AND 
naci='$naci' AND 
tel='$tel' AND 
mail='$mail' AND 
estudi='$estudi' AND 
direccion='$direccion' AND 
localidad='$localidad' AND 
pais='$pais' AND 
cp='$cp' AND 
provi='$provi';");
if(count($res)>0){$id=$res[1]['id'];}else{

$id=DBUpInsL("INSERT INTO skf_datCupon (nombre,apellidos,sexo,naci,tel,mail,estudi,direccion,localidad,pais,provi,cp) VALUES ('$nombre','$apellidos','$sexo','$naci','$tel','$mail','$estudi','$direccion','$localidad','$pais','$provi','$cp');");	
}

foreach ($cursos as $cent => $curs) {foreach ($curs as $c => $idc){
$res=DBselect("SELECT id FROM skf_datCupon_cur WHERE id_dat_cupon='$id' AND cur=$idc");
if(count($res)>0){}else{
DBUpIns("INSERT INTO skf_datCupon_cur (id_dat_cupon,cent,cur) VALUES ($id,$cent,$idc);");	
}			
	
}}

}

?>
