<?php
$idprovi="";
$url=$v['where']['url']; 
$idp=$v['where']['idp'];
$eqtempl=$v['vars']['eqtempl'];
$eqp=$v['vars']['provN'];
							

															
###################### comprobamos modalidad.
if(strpos($url,'presencial/')){
	$valsurl=explode('/presencial/',$url); 
	$url=$valsurl[1]; 										 						
	$valsurl=explode('/',$url); 
	$prov=$valsurl[0]; 											 				
	$url="/" . $valsurl[1]; $quito="_presenciales_en_" . trim($prov);								
    $url=str_replace($quito, "", $url);
	

foreach ($eqp as $va => $ke){$ke=normaliza($ke);$equiPlow[$ke]=$va;};
$idprovi=$equiPlow[$prov];
$v['where']['id_provi']= $idprovi;
}else{
$v['where']['id_provi']="";	
}


if(strpos($url,'online/')){
	
	$url=str_replace('/online/', "/", $url);
	$url=str_replace('_online.html', ".html", $url);
	$url=str_replace('_online-', "-", $url);									 				
$v['where']['online']=1;
}else{
$v['where']['online']=0;	
}


if(strpos($url,'a_distancia/')){
	
	$url=str_replace('/a_distancia/', "/", $url);
	$url=str_replace('_a_distancia.html', ".html", $url);
	$url=str_replace('_a_distancia-', "-", $url);								 				
$v['where']['distancia']=1;
}else{
$v['where']['distancia']=0;	
}




############################################


##### obtenemos numero de pagina
if(strpos($url,'-pag')){
		
		
$valsurl=explode('-pag',str_replace('.html','',$url));

if(is_numeric($valsurl[1])){
$v['where']['pag']=$valsurl[1];
$url=str_replace('-pag' . $valsurl[1], '', $url); 
}elseif(array_key_exists(2, $valsurl)){
	
if(is_numeric($valsurl[2])){

$v['where']['pag']=$valsurl[2];
$url=str_replace('-pag' . $valsurl[2], '', $url); 
	
}else{	
$v['where']['pag']=1;	
}	
		
}else{	
$v['where']['pag']=1;	
}	
	
	
}else{ $v['where']['pag']=1;}
################




$idts="";
foreach ($v['vars']['tipPort'] as $idt => $idpp) {
if($idp==$idpp){$idts .=$idt . ",";};	
}
$idts=substr($idts,0,-1);
$v['where']['idt']=$idts; #### pueden crearse listas de tipos   ej: 1,2  EQUILAVE A: CURSOS Y MASTERS



if(array_key_exists('search',$v)){
$res=array();

$v['where']['urlSimple']="/search" . $url;

$url=str_replace('.html','',$url);
$url=str_replace('_',' ',$url);
$url=str_replace('/','',$url);

$v['search']=$url;

$url2=str_replace('-',' ',$url); 
$v['where']['pagTittleSimp']=ucfirst($url2);
$v['where']['codTittle']=ucfirst($url2);
$v['where']['pagTittle']=ucfirst($url2);

$v['where']['view']='categorias';
$v['where']['id']=0;

}else{

$res=DBselect("SELECT id, tipo, t_id, codTittle, pagTittleC, Redir FROM skf_urls where idp=$idp AND url='$url';");
	
}




if(count($res)>0){
	
$v['where']['view']=$eqtempl[$res[1]['tipo']];
$v['where']['id']=	$res[1]['t_id'];


$v['where']['codTittle']=$res[1]['codTittle'];
$v['where']['pagTittle']=$res[1]['pagTittleC'];
$v['where']['urlSimple']=$url;

$quits=array('Cursos de ', 'Cursos para la ', 'Cursos para ', 'Cursos ', 'Masters en ', 'Masters de ', 'Masters ', 'Fp: Grado medio en ', 'Fp: Grado superior en ', 'Oposiciones a ', 'Oposiciones al ', 'Oposiciones para ');
$Catsin=$res[1]['pagTittleC'];  $Catsin=str_replace($quits, '', $Catsin);
$v['where']['Catsin']=$Catsin;

############# añado prov a los titulos
$v['where']['pagTittleSimp']=$v['where']['pagTittle'];

if($idprovi){
$v['where']['codTittle']=$v['where']['codTittle'] . " en " . $eqp[$idprovi];
$v['where']['pagTittle']=$v['where']['pagTittle'] . " en " . $eqp[$idprovi];
}

############# añado online a los titulos
if($v['where']['online']){
$v['where']['codTittle']=$v['where']['codTittle'] . " online";
$v['where']['pagTittle']=$v['where']['pagTittle'] . " online";	
}

############# añado a distancia a los titulos
if($v['where']['distancia']){
$v['where']['codTittle']=$v['where']['codTittle'] . " a distancia";
$v['where']['pagTittle']=$v['where']['pagTittle'] . " a distancia";	
}

if($v['debug']>0){
echo $v['where']['url']. " <br>\n";
echo "Tipo:" . $v['where']['view'] . " id: " . $v['where']['id']  . " Pag: " . $v['where']['pag'] . " idts: " . $v['where']['idt'] . " <br>\n";
}

}else{

$res=DBselect("SELECT id, tipo, t_id, codTittle, pagTittleC, url FROM skf_urls where idp=$idp AND Redir='$url';");
if(count($res)>0){
$newURL=$res[1]['url'];	
$newURL=str_replace('.html', '', $newURL);	

if($v['where']['online']==1){$newURL='/online' . $newURL ."_online";};
if($v['where']['distancia']==1){$newURL='/a_distancia' . $newURL ."_a_distancia";};
if($v['where']['id_provi']){$newURL='/presencial/' . normaliza($v['vars']['provN'][$v['where']['id_provi']]) . $newURL ."_presenciales_en_" . normaliza($v['vars']['provN'][$v['where']['id_provi']]);};



if($v['where']['pag']>1){$newURL=$newURL ."-pag" . $v['where']['pag'];};


$newURL=$newURL . ".html";
header("HTTP/1.1 301 Moved Permanently"); 
header("Location: $newURL");
		
exit();	

}else{

if(!array_key_exists('search',$v)){	
header("HTTP/1.0 404 Not Found"); 	
}

}	
}









?>