<?php
set_time_limit(0);
ini_set("memory_limit", "-1");
include('/www/dbA.php');

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


$idcu=7600; $idp=1;

$bus=phraseC('cursos baremables para auxiliares de enfermeria',1,2,1,3);
$keys= $bus['w'];





$dcur=DBselect("select nombre, cur_descripcion, 
cur_dirigidoa, cur_paraqueteprepara, temario, 
cur_cat, cur_palclave from skv_cursos where id=$idcu;");
if(array_key_exists(1, $dcur)){
$idcat=$dcur[1]['cur_cat'];



$dcat=DBselect("select idp, pagTittle from skf_urls where t_id=$idcat AND tipo=1;");
if(array_key_exists(1, $dcat)){
$categoria=	$dcat[1]['pagTittle'];
$idp=	$dcat[1]['idp'];		
}
echo "$categoria \n *************** \n";

$nombre = " " . borraSP(noHTML($dcur[1]['nombre']));

$categoria = " " . borraSP(noHTML($categoria));
$categoria.= " " . borraSP(noHTML($dcur[1]['cur_palclave']));	

$resto  = " " . borraSP(noHTML($dcur[1]['cur_descripcion']));	
$resto .= " " . borraSP(noHTML($dcur[1]['cur_dirigidoa']));
$resto .= " " . borraSP(noHTML($dcur[1]['cur_paraqueteprepara']));
$resto .= " " . borraSP(noHTML($dcur[1]['temario']));
	
}

$result=array();

echo "\n *************** \n";
if($categoria){
$dnom=phraseC($categoria,1,2,1,3); $ratio=1;			
foreach ($dnom['w'] as $nkw => $vals) { foreach ($vals as $pal => $porc) {//$pal=utf8_encode($pal);
if(array_key_exists($pal, $result)){ $result[$pal]=$result[$pal] + ($porc*$ratio); }else{$result[$pal]=$porc*$ratio;};		
}}
}
echo "$categoria \n *************** \n";

if($nombre){
$dnom=phraseC($nombre,1,2,1,3); $ratio=1;			
foreach ($dnom['w'] as $nkw => $vals) { foreach ($vals as $pal => $porc) {//$pal=utf8_encode($pal);
if(array_key_exists($pal, $result)){ $result[$pal]=$result[$pal] + ($porc*$ratio); }else{$result[$pal]=$porc*$ratio;};		
}}
}

if($resto){
$dnom=phraseC($resto,1,2,1,3); $ratio=1;			
foreach ($dnom['w'] as $nkw => $vals) { foreach ($vals as $pal => $porc) {//$pal=utf8_encode($pal);
if(array_key_exists($pal, $result)){ $result[$pal]=$result[$pal] + ($porc*$ratio); }else{$result[$pal]=$porc*$ratio;};		
}}
}

asort($result);

//print_r($result);

echo "\n\n______________________***********************__________________________________________\n\n";
echo "\n$categoria \n";
echo "\n$nombre \n";
echo "\n$resto \n";
$v['debugIN']=0;

print_r($keys);



$res=array();$res[$idcu]=0; $palMatch=array();
foreach ($keys as $numpals => $pals) {foreach ($pals as $keywd => $pes){

	$keywd=utf8_encode($keywd);
	$keyw=base_convert(md5($keywd),16,11); $subKeyw=substr("$keyw",0,3);		
	
	$dcu=DBselectSDB("SELECT t_id, peso from md5_$subKeyw WHERE md5='$keyw' AND idp=$idp AND tipo=2 GROUP BY t_id;",'seek_engine_' . $numpals); 
	if(count($dcu)>0){foreach($dcu as $kk => $datos ){$id=$datos['t_id']; $peso=$datos['peso']*($numpals/2); 
		if(array_key_exists($id, $res)){$res[$id]=$res[$id]+$peso;}else{$res[$id]=$peso;}
		if(array_key_exists($keywd, $palMatch)){$palMatch[$keywd]=$palMatch[$keywd]+$peso;}else{$palMatch[$keywd]=$peso;}
	}
	$peso2=$res[$idcu];
	echo "$id \t\t $keywd \t$numpals\t\t $keyw \t $peso2\n";
	}




######### disminuyo antonimos
$dcuNO=DBselectSDB("SELECT ant from antonimos WHERE pal='$keywd';",'seek_keys');
if(array_key_exists(1, $dcuNO)){
																			if($v['debugIN']>0){
								                                            echo "\n\nPALS RESTO en SC2:\n";}

	foreach ($dcuNO as $kk => $vkno){
		
		$kwr=utf8_decode($vkno['ant']);
		
		$numpalsA=count(explode(' ',$kwr));
		$keyw=base_convert(md5($kwr),16,11);$subKeyw=substr("$keyw",0,3);
		$dcu=DBselectSDB("SELECT t_id, peso  from md5_$subKeyw WHERE md5='$keyw' AND idp=$idp AND tipo=2 GROUP BY t_id;",'seek_engine_' . $numpalsA); 
		if(count($dcu)>0){														
		foreach($dcu as $kk => $datos ){$id=$datos['t_id']; $peso=$datos['peso']*($numpalsA/2); 
		if(array_key_exists($id, $res)){$res[$id]=$res[$id]-($peso*20);}else{$res[$id]=-($peso*20);};
		}
		
		echo "_______________\nresto \t$numpalsA $kwr \t\t\t\t $keyw \t   <---- (-)\n";$peso2=$res[$idcu];	
		echo "$id \t\t $kwr \t$numpalsA\t\t $keyw \t $peso2  <---- (-) \n";	
		
		}	
	}
	//echo "SELECT t_id, peso  from md5_$subKeyw WHERE md5='$keyw' AND idp=$idp AND tipo=2 GROUP BY t_id; ".'seek_engine_' . $numpals;
	//print_r($dcu);



		$keyw=base_convert(md5($keywd),16,11); $subKeyw=substr("$keyw",0,3); 								
		$dcu=DBselectSDB("SELECT t_id, peso  from md5_$subKeyw WHERE md5='$keyw' AND idp=$idp AND tipo=2 GROUP BY t_id;",'seek_engine_' . $numpals); 
		if(count($dcu)>0){foreach($dcu as $kk => $datos ){$id=$datos['t_id']; $peso=$datos['peso']*($numpals/2); 
		if(array_key_exists($id, $res)){$res[$id]=$res[$id]+($peso*1);}else{$res[$id]=($peso*1);}
		}
		
		
		echo "\npongo \t$numpals $keywd \t\t\t\t $keyw \t   <---- (-)\n";$peso2=$res[$idcu];	
		echo "$id \t\t $keywd \t$numpals\t\t $keyw \t $peso2  <---- (-) \n_______________\n";	
		}

																		
	
}

#################################


	
}}






?>