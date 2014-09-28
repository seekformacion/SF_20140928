<?php

function valoracion($idc){
$rest= ($idc % 5);
$rest++;
return $rest;	
}

function rcount($idc){
$rest= ($idc % 21);
$rest=$rest +3;
return $rest;	
}



function minidatCUR($idcur){global $v;
	
$res=DBselect("SELECT t_id, url, pagTittle, pagTittleC FROM skf_urls WHERE tipo=2 AND t_id=$idcur;");	
return $res[1];	
}


function limpiaPrice($precio){


$precio=str_replace(',', '.', $precio);
$precio = preg_replace('/[^0-9,\.]/','',$precio);
$dec=explode('.', $precio); 
if(count($dec)>1){if(strlen($dec[1])==3){$precio=str_replace('.', '', $precio);}};


return $precio;	
}

############### obtengo url de un curso dado
function urlCur($idc){global $v;
$res=DBselect("SELECT url, idp FROM skf_urls WHERE tipo=2 AND t_id=$idc;");		
$data['url']=$res[1]['url'];	
if($res[1]['idp']!=$v['where']['idp']){$data['url']=$v['vars']['purl'][$res[1]['idp']] . $data['url'];};

return $data['url'];
} 
#####################################3

################## compone el bloque de cursos de una pagina
function getBloqueCursos($idc){global $data; global $v; global $pesos;


$bloqueCursos="";
$listcur=getCURcat($idc);
#### eliminacion de huecos y comoas
$listcur=str_replace(',,', ',', $listcur);
if(substr($listcur, 0,1)==','){$listcur=substr($listcur, 1);}
if(substr($listcur, strlen($listcur)-1,1)==','){$listcur=substr($listcur, 0,-1);}
#################


if($listcur){
$res=DBselect("SELECT	id, nombre,	cur_id_tipocurso, cur_id_metodo, cur_descripcion, 
						cur_dirigidoa, cur_paraqueteprepara, cur_id_certificado, cur_mostarprecio, cur_precio,  
						id_centro, (SELECT nombre FROM skv_centros WHERE id=id_centro) as ncent, 
						id_centro, (SELECT file_logo FROM skv_centros WHERE id=id_centro) as file_logo 
						FROM skv_cursos where id IN ($listcur) ORDER BY FIELD(id, $listcur);");	

$ccc=0;	
foreach ($res as $key => $data) {$ccc ++; if(($ccc % 2)){$data['pinp']='p';}else{$data['pinp']='i';}
$data['url']=urlCur($data['id']);

$data['cur_precio']=limpiaPrice($data['cur_precio']);

if(($data['cur_mostarprecio']==1)&&($data['cur_precio']<500)&&($data['cur_precio'])){
	
$precio=$data['cur_precio'];	
$precio=number_format($precio*1,2);
$precio=str_replace('.', ',', $precio);
$precio=str_replace(',00', '', $precio);
		
$data['price']=$precio . " €";

}else{$data['price']="";}
		
$bloqueCursos .=loadChild('n_objt','cadaCurso');	
}	

}else{
//$v['return']=$v['where']['id'];	
}

return $bloqueCursos;
}

############################3



############# obtiene ids de cursos a mostrar segun URL y Pag ORDENADOS

##################################


function getCURProv(){global $v;
global $datCur;

if($datCur){
	
if(array_key_exists('idcat', $datCur)){
$idc=$datCur['idcat'];}	

}else{
$idc=$v['where']['id'];
}


$idt=$v['where']['idt'];
$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cat=$idc AND id_tipo IN ($idt) AND id_metodo != 4 AND id_metodo !=5;");		
$cin="";foreach ($res as $key => $data) {$idc=$data['id_cur']; $cin .=$idc . ",";};$cin=substr($cin, 0,-1);

$provins=array();

$iprov=$v['where']['id_provi'];
if($iprov){$iprov="AND idpro NOT LIKE '$iprov%'";}else{$iprov="";}

if($cin){
$res=DBselect("SELECT SUBSTRING(idpro,1,3) as idp, count(distinct idcur) as C FROM skv_relCurPro WHERE idcur IN ($cin) $iprov GROUP BY idp ORDER BY C DESC; ");
$provins=array();
if(count($res)>0){ foreach ($res as $key => $dat) {$idp=$dat['idp']; if(strlen($idp)==2){$idp='0' . $idp;};
if(($idp=='070')||($idp=='077')||($idp=='078')){}else{$idp=substr($idp, 0,2) . "0";}
if(array_key_exists($idp, $provins)){$provins[$idp]=$provins[$idp]+$dat['C'];}else{$provins[$idp]=$dat['C'];}
}}}

arsort($provins);

return $provins;	
}


function getCURMet($met){global $v;
$idc=$v['where']['id'];
$idt=$v['where']['idt'];
$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cat=$idc AND id_tipo IN ($idt) AND id_metodo=$met;");		
if(count($res)>0){return TRUE;}else{return FALSE;};
}


############# resalta palabras en un texto con <strong>
function strongTXT($txt,$pals){$marcos=array();
$txt2=stripAccents($txt);
$txt=utf8_decode($txt);

echo "\n _________ \n $txt \n ____-- \n";

$borros=array('\\');

if(count($pals)>0){foreach ($pals as $point => $pal){$palsi[stripAccents($pal)]=strlen(stripAccents($pal));}}
arsort($palsi);

//$palsi=array();
//$palsi[' auxiliar de enfermeria.'] = 22;

//print_r($palsi);	
	
if(count($palsi)>0){foreach ($palsi as $pal => $ll){
	
$pal=str_replace('/', '\/', $pal);	
$pal2="/ $pal/i";

echo "\n$pal2 \n";
//echo "$txt2 \n"; 

$out=array();					
preg_match_all($pal2, $txt2, $out, PREG_OFFSET_CAPTURE); $c=0;

//echo "\n _________ \n $pal \n ____-- \n";
//echo "\n _________ \n $pal2 \n ____-- \n";

if(count($out[0])>0){
print_r($out[0]);	
foreach ($out[0] as $key => $value) {#if(!array_key_exists($value[1], $marcos)){ $marcos[$value[1]]=1;
$p=$value[1] + 1 + $c;
$l=$p + strlen( str_replace($borros,'' , $pal) );
$txt=substr($txt,0,$l) . "</strong>" . substr($txt,$l);	
$txt=substr($txt,0,$p) . "<strong>" . substr($txt,$p);
$c=$c+17;
}}

$txt2=stripAccents($txt);
}}

//echo "$txt \n";
//$txt=utf8_encode($txt);

echo "\n _________ \n $txt \n ____-- \n";
return $txt;
}
##################################


function ordenaCURsNEW($curs,$ini,$fin){global $pesos; global $v;
$np=round($v['where']['npags']/2);$pesos2=array();$npos=array();$nlist=array();
if($np==0){$np=1;}
$cpp=$v['conf']['cpp'];


$pcursos=explode(',',$curs);
foreach ($pcursos as $kk => $iddcc){if(array_key_exists($iddcc, $pesos)){
$pesos2[$iddcc]=$pesos[$iddcc];	
}}

arsort($pesos2);
																					if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\n<br>\nOrdNEW Pesos:<br>\n";
																					$v['dbi'].=json_encode($pesos);}


$max=reset($pesos2);
$min=end($pesos2);
//echo "max: $max  min: $min  np:$np \n";
$dife=round($max/$np);

$a=0; $pos=$max;
foreach ($pesos2 as $idcu => $peso) {$np=$v['where']['npags'];
	while ($np > 0){
	$pos=$max-($dife*$np);
	if($peso>=$pos){$pf=$pos;}	
	$np--;}	
$npos[$pf][]=$idcu;
}

//print_r($npos);
																			      if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\n<br>\nOrdNEW Npos:<br>\n";
																					$v['dbi'].=json_encode($npos);}

																			      

$almacen=array();

foreach ($npos as $grupo => $lista){
$almacen=suborder($lista,$almacen);	
}




$output = array_slice($almacen, $ini, $fin - $ini +1);
foreach ($output as $ll => $id){$nlist[]=$id;};
																				
																			      if($v['debugIN']>0){
																					$v['dbi'].=  "<br>\n<br>\nOrdNEW nlist:<br>\n";
																					$v['dbi'].=json_encode($nlist);}
																				
//print_r($nlist);
return $nlist;	
}




function suborder($lista,$almacen){global $pesos;
$curs="";	
foreach($lista as $kk => $idcur){if($idcur){$curs.="$idcur,";}}$curs=substr($curs,0,-1);

$lastC="";
if($curs){
$res=DBselect("SELECT id, pccur, id_centro, OrdDESC FROM skv_cursos WHERE id IN ($curs) ORDER BY pccur DESC, OrdDESC DESC;");		
foreach ($res as $key => $value) {
	if(!$value['pccur']){$value['pccur']=0;};if($value['pccur']==0){$value['pccur']=1;};
	$idcent=$value['id_centro']; if($idcent==$lastC){$pcc=($value['pccur']-0.5)*$pesos[$value['id']];}else{$pcc=$value['pccur']*$pesos[$value['id']];}$lastC=$idcent;
	$preORD[$value['id']]=$pcc; $pesos[$value['id']]=$value['pccur']. " - " . $pesos[$value['id']];
	}

arsort($preORD);	
foreach ($preORD as $id => $kk) {$almacen[]=$id;}
}	

return $almacen;
}	
	









function ordenaCURs($curs,$ini,$fin){
$nlist=array();


$lastC="";
if($curs){
$res=DBselect("SELECT id, pccur, id_centro, OrdDESC FROM skv_cursos WHERE id IN ($curs) ORDER BY pccur DESC, OrdDESC DESC ;");		
foreach ($res as $key => $value) {
	
	if(!$value['pccur']){$value['pccur']=0;};
	
	$idcent=$value['id_centro']; if($idcent==$lastC){$pcc=$value['pccur']-0.5;}else{$pcc=$value['pccur'];}$lastC=$idcent;
		
	$preORD[$value['id']]=$pcc;
	
	}

//print_r($preORD);

arsort($preORD);	

//print_r($preORD);

foreach ($preORD as $id => $kk) {$preout[]=$id;}

//print_r($preout);


//echo "________________- $ini ___  $fin __ \n";

$output = array_slice($preout, $ini, $fin - $ini +1);

//print_r($output);

foreach ($output as $ll => $id){$nlist[]=$id;};
}

	
return $nlist;
}




?>