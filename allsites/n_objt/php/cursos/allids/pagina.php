<?php 

function ldsecc($sec,$cnte,$tit){
global $dsecc; 
$dsecc['cnt']=$cnte; 
$dsecc['sec']=$sec; 	
$dsecc['tit']=$tit; 

return loadChild('n_objt','seccion');
}

includeFUNC('categorias');
includeFUNC('sacaCursos');
includeFUNC('images');
includeFUNC('form');

$appid[1]="676600425716555";
$appid[2]="586283288126818";
$appid[3]="726238200741616";
$appid[4]="1468920489988724";



$idcur=$v['where']['id'];

$shc=DBselect("SELECT showC FROM skv_relCurCats WHERE id_cur=$idcur;");
if(count($shc)>0){$showc=$shc[1]['showC'];}

//echo "SELECT showC FROM skv_relCurCats WHERE id_cur=$idcur; --- $showc";




$datCur=array();
global $datCur;
$datos=DBselect("SELECT * FROM skv_cursos WHERE id=$idcur;");
if(array_key_exists(1, $datos)){$datCur=$datos[1];};


$Datos['cur_descripcion']=$datCur['cur_descripcion'];


$Datos['v']=valoracion($idcur);
$Datos['rv']=$Datos['v'] + 5;
$Datos['rc']=rcount($idcur);

$Datos['idp']=$v['where']['idp'];
$Datos['fbAPP']=$appid[$v['where']['idp']];
$Datos['pagTittle']=$v['where']['pagTittle'];
$Datos['imgLogo']=loadIMG("logo.png");
$Datos['home']="http://" . $v['where']['site'];
$Datos['homet']=$v['vars']['purlT'][$v['where']['idp']];


$idcentro=$datCur['id_centro'];$logo="";
$datos=DBselect("SELECT file_logo, nombre FROM skv_centros WHERE id=$idcentro;");
if(array_key_exists(1, $datos)){$logo=$datos[1]['file_logo']; $Datos['nLogoCent']=$datos[1]['nombre'];};      
$Datos['imgLogoCent']=loadLogoCent('g/' . $logo);



$idcat="";
$dato=DBselect("select id_cat from skv_relCurCats where id_cur=$idcur;");
if(array_key_exists(1, $dato)){$idcat=$dato[1]['id_cat'];};

if($idcat){

$v['imgCat']=imgCATg($idcat); 
$Datos['imgCat']=$v['imgCat'];	
	
$Datos['breadcrumbs']=breadCRUMBSCUR($idcat);

$datCur['idcat']=$idcat;
$datCur['idCurso']=$idcur;

$catnoms=DBselect("SELECT pagTittleC, url FROM skf_urls WHERE t_id=$idcat AND tipo=1;");
$datCur['catDCurNOM']=$catnoms[1]['pagTittleC'];
$datCur['catDCurURL']=$catnoms[1]['url'];


################# cursos de la cat
global $rOtroscur;

$listcur="";	
$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE showC=1 AND id_cat=$idcat AND id_cur != $idcur;");
foreach ($res as $key => $data) {$listcur.=$data['id_cur'] . ",";};
$listcur=trim(substr($listcur, 0,-1));

$curs=array();$cc=0;
if($listcur){$curs=ordenaCURs($listcur,0,5);}
if(count($curs)>0){foreach ($curs as $p => $idcur){$cc++;$rOtroscur[$cc]=minidatCUR($idcur);};}

}else{$Datos['breadcrumbs']="";};



if ($showc){

$Datos['secc']="";
//print_r($datCur);

 
$metodo=$v['vars']['eqmet'][$datCur['cur_id_metodo']]['s'];



if($datCur['cur_id_metodo']<=3)
{
	$Datos['secc'].="<a href='#$metodo'><h2>$metodo</h2></a>";
	$cnt['geo']=loadChild('n_objt','geo');
}else{
	$Datos['secc'].="<h2>$metodo</h2>";
	$cnt['geo']="";
	}


$cnt['dur']="";	
if($datCur['cur_duracion'])
{
	$duracion=$datCur['cur_duracion'];
	if(strlen($duracion)<15){
		$Datos['secc'].="<h2>$duracion</h2>";
		
	}else{
		$Datos['secc'].="<a href='#duracion'><h2>Duración</h2></a>";
		$cnte="<p>" . $duracion . "</p>"; 
		$cnt['dur']=ldsecc('duracion',$cnte,"Duración.");
	}
	
}		



$certi=$v['vars']['certi'][$datCur['cur_id_certificado']];

if($datCur['cur_titoficial']){
$Datos['secc'].="<a href='#certificado'><h2>$certi</h2></a>";	
$cnte="<p>" . $datCur['cur_titoficial'] . "</p>"; 
$cnt['cert']=ldsecc('certificado',$cnte,"$certi.");

}else{
$Datos['secc'].="<h2>$certi</h2>";$cnt['cert']="";
}
	


$edad="";      
if( ($datCur['cur_edadmin']) && ($datCur['cur_edadmax']) ){$edad="Entre " . $datCur['cur_edadmin'] . " y " . $datCur['cur_edadmax'] . " años.";};	
if( ($datCur['cur_edadmin']) && (!$datCur['cur_edadmax']) ){$edad="Mas de  " . $datCur['cur_edadmin'] .  " años.";};	
if( (!$datCur['cur_edadmin']) && ($datCur['cur_edadmax']) ){$edad="Menos de  " . $datCur['cur_edadmax'] .  " años.";};		  
if($edad){$edad="<strong>Edad:</strong> $edad";};

$esmin="";
$esmin=$v['vars']['esmin'][$datCur['cur_minestudi']];
if($esmin){$esmin="<strong>Nivel de estudios mínimo:</strong> $esmin</p>";};
	  
if(($edad)||($esmin)){$Datos['requi']="<p>$edad $esmin</p>";}else{$Datos['requi']="";}

if($datCur['cur_otrosdatos']){
$Datos['cur_otrosdatos']="<p>" . $datCur['cur_otrosdatos'] . "</p>";
}else{
$Datos['cur_otrosdatos']="";	
}





$precio=$datCur['cur_precio'];
$precio=str_replace(',', '.', $precio);
$precio = preg_replace('/[^0-9,\.]/','',$precio);
$dec=explode('.', $precio); 
if(count($dec)>1){if(strlen($dec[1])==3){$precio=str_replace('.', '', $precio);}};



if( ($datCur['cur_precio']) && ($datCur['cur_mostarprecio']==1) ){
	if($precio<=300){
		$precio=number_format($precio*1,2);
		$precio=str_replace('.', ',', $precio);
		$precio=str_replace(',00', '', $precio);
	$Datos['cabP']="
	<div class='zprec'>
	<div class='price'>$precio €</div>	
	</div>
	";	
	}else{
	$Datos['cabP']="";	
	}		
	
$precio="<br><br><p><strong>Precio: </strong>" . $datCur['cur_precio'] . "</p>";
}else{
$precio="";
$Datos['cabP']="";	
};
$Datos['cur_precio']=$precio;








$prepara=$datCur['cur_paraqueteprepara'];
$dirigido=$datCur['cur_dirigidoa'];
$temario=$datCur['temario'];

$q=array('h1>','h2>','<strong>DURACIÓN</br>');
$p=array('h4>','h4>','');
$temario=str_replace($q,$p,$temario);


$cnte="<p>" . $prepara . "</p>"; 
$cnt['prepara']=ldsecc('prepara',$cnte,"Para qué te prepara.");

$cnte="<p>" . $dirigido . "</p>"; 
$cnt['dirigido']=ldsecc('dirigido',$cnte,"A quien va dirigido.");

$cnte="<div class='temario'>" . $temario . "</div>"; 
$cnt['temario']=ldsecc('temario',$cnte,"Temario.");


$Datos['secciones']=$cnt['cert'] . $cnt['dur'] . $cnt['geo'] . $cnt['prepara'] . $cnt['dirigido'] . $cnt['temario'];
$Datos['footer']=loadChild('n_objt','footer');

//print_r($Datos);
//$Datos['footer']=loadChild('objt','footer');


$Datos['form']=getForm();
loadJS('n_objt','form');
loadCSS('n_objt','form');

$Datos['metas']=loadChild('n_objt','metas');
if($v['debugIN']>0){$Datos['dbi']="<div>" . $v['dbi'] . "</div>";}else{$Datos['dbi']="";}

}else{
$Datos['H_redirect']=$datCur['catDCurURL'];
}


?>