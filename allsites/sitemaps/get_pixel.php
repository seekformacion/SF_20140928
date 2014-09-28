<?php

###########
## use get_pixel.php idcentro [d]=force do changes
## ej: get_pixel.php 314 d 
#########3

set_time_limit(0);
ini_set("memory_limit", "-1");

$idc=$argv[1];
if(array_key_exists(2, $argv)){$act=$argv[2];}else{$act="";}

include('/www/dbA.php');

$v['conf']['host']="54.194.56.56";
$v['conf']['db']="seekformacion";
$v['conf']['usr']="root";
$v['conf']['pass']="amazSeek2010";




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



########## busca cod campo o crea
function equicampo($value,$table,$campo){global $conf;
$id=0;
$datC= DBselectSDB("SELECT id from $table where $campo='$value';",'seekformacion');$idold=0; 
if(array_key_exists(1, $datC)){$id=$datC[1]['id'];};
if(!$id){
$id=DBUpInsLSDB("INSERT into $table ($campo) values ('$value');",'seekformacion');	
}
return $id;
}

#######################  inserta campos
function inserta_campos($datos,$idseek){
DBUpInsSDB("DELETE FROM skv_relCampos WHERE id_centro=$idseek;",'seekformacion');
	
foreach ($datos as $idsed => $valores) {
		 	$camp=$valores[0];
           	$idcampo=equicampo($camp,'skv_campos','nom_campo');	
			$datos[$idsed]['idcampo']=$idcampo;
}

		
foreach ($datos as $idsed => $valores) {
$ob=$valores['obligado']; $camp=$valores[0]; $most=$valores[1]; $equi=$valores[2];$idcampo=$valores['idcampo'];
$idn=DBUpInsLSDB("INSERT INTO skv_relCampos	(id_centro,idcampo,muestro,bd,obligado)	VALUES ($idseek,'$idcampo','$most','$equi','$ob');",'seekformacion');	
}

	
}









$datC= DBselectSDB("SELECT id_old FROM skv_centros WHERE id='$idc';",'seekformacion');$idold=0; 
if(array_key_exists(1, $datC)){$idold=$datC[1]['id_old'];};

echo "\n\n";
echo "id_centro: $idc --> $idold";

#campos
$lineas=array();
$c = curl_init('http://procenet:nuevaof21@82.223.155.233:81/listadocampos.php?idcentro=' . $idold);
curl_setopt($c, CURLOPT_VERBOSE, false);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
$page = curl_exec($c);
curl_close($c);
$data=str_replace('><',">\n<",$page);
$lineas=explode("\n",$data); 


foreach ($lineas as $pointer => $codigo){
$lineanew=array();
$codigo=trim($codigo);

#nombre idcontacto
if(strlen($codigo)>strlen(str_replace('<tr align="center" class="listadopar" id="','',$codigo))){
$quitosdecurso=array('<tr align="center" class="listadopar" id="');
$lineanew=explode('"', str_replace($quitosdecurso,'',$codigo) ); $idcont=$lineanew[0];
$datos['campos'][$idcont]['id']=$idcont;$datos['campos'][$idcont]['obligado']=0;	
}


if(strlen($codigo)>strlen(str_replace('*','',$codigo))){
$datos['campos'][$idcont]['obligado']=1;		
}

if(strlen($codigo)>strlen(str_replace('<td width="110" align="left"','',$codigo))){
$quitosdecurso=array('<td width="110" align="left" onClick="javaescript:recargafichacampo(' . $idcont . ',\'' . $idold . '\');">','</td>');
$datos['campos'][$idcont][]=trim(str_replace($quitosdecurso,'',$codigo));		
}

}


//print_r($datos);

echo "\n\n";

utf8_encode_deep($datos);
foreach ($datos['campos'] as $idcol => $valores) {

$ob=$valores['obligado']; $camp=$valores[0]; $most=$valores[1]; $equi=$valores[2];
$idcampo=equicampo($camp,'skv_campos','nom_campo');	

echo "$ob : $idcampo : $camp --> $most : $equi \n";	
}

if($act=='d'){
inserta_campos($datos['campos'], $idc);
}


echo "\n\n";


