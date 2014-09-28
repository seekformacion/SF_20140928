<?php
set_time_limit(0);
ini_set("memory_limit", "-1");


include('/www/dbA.php');

$v['debug']=0;
$v['admin']=0;

$v['conf']['state']=1; # 1=test 2=produccion
$v['conf']['mode']=1; # 1=local 2=cloud
$v['where']['idp']=						1; #### ID DEL PORTAL PARA TABLA urls
$v['where']['view']=					'sitemaps'; #### ID DEL PORTAL PARA TABLA urls
$v['where']['id']=					    '1'; 
$v['where']['site']=					"cursodecursos.com";



$v['path']['bin']=$v['path']['repo'] .	"/SF_20121104";
$v['path']['fw']=$v['path']['repo'] .	"/FrameW_1";
$v['path']['img']=$v['path']['repo'] .	"/SeekFormacion_images";

$v['path']['baseURLskin'][1]=""; ## baseURL del SKIN local
$v['path']['baseURLskin'][2]="http://s3-eu-west-1.amazonaws.com/seekf"; ## baseURL del SKIN en CLOUD







include('funcSitemaps.php');  
require_once $v['path']['fw'] . '/core/templates/paths.php';

includeINIT('vars');
includeINIT('provins');
includeINIT('config');
includeCORE('db/dbfuncs');
includeCORE('templates/templates');
includeCORE('funcs/general');
includeCORE('mail/mail');
includeCORE('funcs/convertData');


$datos=array();

$dcats=DBselect("select * from skf_datCupon_cur where done=0 GROUP BY cent, id_dat_cupon, cur;");

foreach ($dcats as $key => $vals) {
$idc=$vals['cent']; $idcur=$vals['cur']; $idcup=$vals['id_dat_cupon']; $idins=$vals['id'];	

$datos[$idc][$idcup][$idcur]=$idins;
	
}

$date=date('Y') . date('m') . date('d');

//print_r($datos);

if(count($datos)>0){
foreach ($datos as $idcent => $cups){foreach ($cups as $idcupon => $curs){foreach($curs as $idcurso => $idins){
$err="";

$CPL=getCPLcup($idcupon,$idcent,$idcurso);#### obtengo el CPL al q se factura este cupon
	
$err=DBUpInsSDB("INSERT INTO skP_cupones (id_cent,id_cupon,fecha,id_curso,CPL) VALUES ($idcent,$idcupon,$date,$idcurso,'$CPL');",'seekpanel');		
if(!$err){
	
######## miro si se envia pixel	
$DOp=DBselectSDB("SELECT activo, method FROM skv_relCentPixel WHERE id_centro=$idcent;",'seekformacion'); 	
if(array_key_exists(1, $DOp)){if($DOp[1]['activo']==1){$method=$DOp[1]['method'];
sendPIXEL($idcent,$idcupon,$idcurso,$method);	
}}
####################

sendCupon($idcent,$idcupon,$idcurso);
	
DBUpIns("UPDATE skf_datCupon_cur SET done=1 WHERE id=$idins;");

}



		
}}}}








function sendCupon($idcent,$idcupon,$idcurso){
	

$from="cupones@seekformacion.com";
$fromN="Cupones Seek Formación";

//$to="felinares@hotmail.com";
//$toN="Fernando linares";

$to="e.b.moya@gmail.com";
$toN="Eduardo Buenadicha";

$subject="Cupon enviado a $idcent;";
$message="Cupon enviado a $idcent";
$plain=$message;
$message=loadChild('mails','cupon');

$vconf=array();
sendM($from,$fromN,$to,$toN,$subject,$message,$plain,'mail.php',$vconf);



	
	
}








?>