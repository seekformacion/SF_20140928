<?php

global $v;

$v['where']['cacheQ']=0;

$_SERVER['HTTP_X_UA_DEVICE']='';

if(array_key_exists('q', $_GET)){
$v['where']['url']=$_GET['q'];
}else{
$v['where']['url']='/';	
}



if(strpos($v['where']['url'],'search/')){$v['where']['url']=str_replace('/search/','/',$v['where']['url']);$v['search']=1;};

if(strpos($v['where']['url'],'|sql')){$v['where']['url']=str_replace('|sql','',$v['where']['url']);$v['debug']=-1;};
if(strpos($v['where']['url'],'|dbi')){$v['where']['url']=str_replace('|dbi','',$v['where']['url']);$v['debugIN']=1;};
if(strpos($v['where']['url'],'|deb')){$v['where']['url']=str_replace('|deb','',$v['where']['url']);$v['debug']=1;};
if(strpos($v['where']['url'],'|admin')){$v['where']['url']=str_replace('|admin','',$v['where']['url']);};
if(strpos($v['where']['url'],'|noadmin')){$v['where']['url']=str_replace('|noadmin','',$v['where']['url']);};

#if($_SESSION['admin']){$v['admin']=1;};

//if(strlen(str_replace('/cat=', '', $v['where']['url'])) < strlen($v['where']['url'])) {$v['where']['view']="categorias"; 	$sacos=explode('=', $v['where']['url']); 	$v['where']['id']=$sacos[1];};
//if(strlen(str_replace('/cur=', '', $v['where']['url'])) < strlen($v['where']['url'])) {$v['where']['view']="cursos"; 		$sacos=explode('=', $v['where']['url']); 	$v['where']['id']=$sacos[1];};

######### se inicializan previo a obtener datos de url para q funcione paths
$v['where']['view']='none';
$v['where']['id']=0; #################
require_once $v['path']['fw'] . '/core/templates/paths.php';



includeINIT('vars');
includeINIT('provins');
includeINIT('config');
includeCORE('db/dbfuncs');
includeCORE('templates/templates');
includeCORE('funcs/general');
includeFUNC('URLdata');  ##### obtengo datos de la url tipo de pagina e id asociado
includeCORE('funcs/phrassCount');


#echo loadChild('objt','arbol');

loadCSS('n_objt','colores');
$pagina=loadChild('n_objt','pagina');

if( (array_key_exists('return', $v) && ( ($v['where']['id_provi']) ||($v['where']['distancia']) ||($v['where']['online']) ) )){
$idcatM=$v['return'];

$idp=$v['where']['idp'];
$res=DBselect("SELECT url FROM skf_urls where idp=$idp AND tipo=1 AND t_id=$idcatM;");

if(array_key_exists(1, $res)){
$newURL=$res[1]['url'];
//header("HTTP/1.1 301 Moved Permanently"); 
//header("Location: $newURL");
}else{
header("HTTP/1.0 404 Not Found");	
}
}else{
	
echo $pagina;	
}

	


?>