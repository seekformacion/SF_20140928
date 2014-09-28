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







require_once $v['path']['fw'] . '/core/templates/paths.php';

includeINIT('vars');
includeINIT('provins');
includeINIT('config');
includeCORE('db/dbfuncs');
includeCORE('templates/templates');
includeCORE('funcs/general');

//$hoy=date('Y') . date('m') . date('d');
$defP=array();

$lcents="";
$cents=DBselectSDB("select id, CPLA from skP_centros where CPLA > 0 limit 50;",'seekpanel');
if(count($cents)>0){
	foreach ($cents as $kk => $val){
	$idc=$val['id']; $cpla=$val['CPLA'];	
	$defP[$idc]=$cpla;
	$lcents .=$idc . ",";	
	$centros[$idc]=1;
	}

	$lcents=substr($lcents, 0,-1);
	
//echo "\n";
//print_r($centros);


/*
	cursos
	1,9,21,22,23,24,25,26,27,28,29,15,16,17,18,19,11
	
	masters	
	2,3,8,10,12,13,14,20,5,6,7

	opo
	4
*/


$CPLAreg=array();
if(count($centros)>0){
foreach ($centros as $idcent => $kkk) {
	
	$reglas=DBselectSDB("select atributo, valor, CPL from skP_precios_rule where id_centro=$idcent AND proceso=1 ORDER BY orden ASC",'seekpanel');
   	if(count($reglas)>0){ foreach ($reglas as $key => $values) {
   	   $atributo=$values['atributo'];
	   $valor=$values['valor'];
	   $CPLn=$values['CPL'];
	
	$cplreg=array(); 
    $cplreg=DBselectSDB("select id FROM skP_cursos where $atributo $valor AND id_centro=$idcent;",'seekpanel');
	//echo "\nselect id FROM skP_cursos where $atributo $valor AND id_centro=$idcent;";
	if(count($cplreg)>0){foreach($cplreg as $kk => $idsREG){
			$CPLAreg[$idsREG['id']]=$CPLn;
		}}
	   
	}}
		
	
	
	
	
}}


//print_r($CPLAreg);




$curs=DBselectSDB("select id, id_centro, cur_id_tipocurso, cur_id_metodo, CPLA from skP_cursos where id_centro IN ($lcents);",'seekpanel');
if(count($curs)>0){foreach ($curs as $ky => $valc){

$idcu=$valc['id'];		
$idce=$valc['id_centro'];
$tip=$valc['cur_id_tipocurso'];
$met=$valc['cur_id_metodo'];
$CPLA=$valc['CPLA'];	

$cpA=0; $cpB=0;

if($CPLA!=''){
	$cpl=$CPLA;
}elseif(array_key_exists($idcu, $CPLAreg)){
	$cpl=$CPLAreg[$idcu];
}else{   
    $cpl=$defP[$idce]; 
	}	
	

$precios[$idcu]=$cpl;	
	
}}



if(count($precios)>0){
$q="UPDATE skv_cursos 
   SET OrdDESC = CASE 
 ";	
$lcu="";
 		
	foreach ($precios as $idcurso => $cplF) {
	$q.="WHEN id = $idcurso THEN '$cplF' ";	 $lcu.=$idcurso . ",";
	}

$lcu=substr($lcu,0,-1);
$q.="ELSE OrdDESC END WHERE id IN ($lcu);";



$err=DBUpInsSDB($q,'seekformacion');		
//echo $err;
$q2=str_replace('OrdDESC', 'pccur', $q);

$err=DBUpInsSDB($q2,'seekformacion');		
//echo $err;

$err=DBUpInsSDB("UPDATE skP_centros SET lstPRE = 1 WHERE id IN ($lcents);",'seekpanel');	



print_r($precios);

}




	
}


















/*
foreach ($dcats as $key => $vals) {
$idc=$vals['cent']; $idcur=$vals['cur']; $idcup=$vals['id_dat_cupon']; $idins=$vals['id'];	

$datos[$idc][$idcup][$idcur]=$idins;
	
}

$date=date('Y') . date('m') . date('d');

//print_r($datos);

if(count($datos)>0){
foreach ($datos as $idcent => $cups){foreach ($cups as $idcupon => $curs){foreach($curs as $idcurso => $idins){
$err="";
$err=DBUpInsSDB("INSERT INTO skP_cupones (id_cent,id_cupon,fecha,id_curso) VALUES ($idcent,$idcupon,$date,$idcurso);",'seekpanel');		
if(!$err){
DBUpIns("UPDATE skf_datCupon_cur SET done=1 WHERE id=$idins;");
sendCupon($idcent,$idcupon,$idcurso);
}



		
}}}}

*/


?>