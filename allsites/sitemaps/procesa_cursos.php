<?php
set_time_limit(0);
ini_set("memory_limit", "-1");
include('/www/dbA.php');

$dorest=$argv[1];

$v['debug']=1;
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
includeCORE('funcs/general');
includeCORE('funcs/phrassCount');

$dr=DBselectSDB("select valor from operadores where operador='d_$dorest';",'seek_keys');
if(!$dr[1]['valor']){
DBUpInsSDB("update operadores set valor=1 where operador='d_$dorest'",'seek_keys');

$cur=DBselectSDB("select id_cur from skv_relCurCats where showC=1 AND done=0 limit 200;",'seekformacion');
if(count($cur)>0){foreach ($cur as $kk => $vals){
	
$idcur=$vals['id_cur'];

$div=($idcur % 8);


if($div==$dorest){
	
$didcu="";$stopP=0;

$done=DBselectSDB("select done from skv_relCurCats where id_cur=$idcur;",'seekformacion');
$stop=DBselectSDB("select valor from operadores where operador='stopP';",'seek_keys');
$stopP=$stop[1]['valor']; 
    
if(!$stopP){
	if($done[1]['done']!=1){
	echo "\nInicio: $idcur \n";
	
	$didcu=processCUR($idcur);
	if($didcu){
	DBUpInsSDB("update skv_relCurCats set done=1 where id_cur=$didcu;",'seekformacion');		
	
	echo "Done: $didcu \n";
	}else{
	echo "Algo fallo con: $idcur \n";
	DBUpInsSDB("update skv_relCurCats set done=2 where id_cur=$idcur;",'seekformacion');	
	}
	
	


}else{
	DBUpInsSDB("update operadores set valor=0 where operador='d_$dorest'",'seek_keys');
	break;
	
	}

}else{
	DBUpInsSDB("update operadores set valor=0 where operador='d_$dorest'",'seek_keys');
	echo "Proceso parado \n";
	break;
}


}

}}

DBUpInsSDB("update operadores set valor=0 where operador='d_$dorest'",'seek_keys');

}else{
echo "Proceso en ejecucion \n";		
}

?>