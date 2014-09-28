<?php

function getSliders(){global $v;$slidesA=array();

$idc=$v['where']['id'];
$idt=$v['where']['idt'];
	

$catrel=array();



$listPorts=array();	
$res=DBselect("SELECT distinct rel_idc FROM skf_relCatsPort WHERE idc=$idc;");	
foreach ($res as $key => $data) {$catrel[]=$data['rel_idc'];};



global $dsliders; $dsliders=array();
$slides="";
if(count($catrel)>0){
foreach ($catrel as $kk => $idcc){

$cinf=CATS_inf_T($idcc); 
$lcinfe= $cinf['list'];
$bb=0;	
$res=DBselect("SELECT idp, crsTittle, url, pagTittle, pagTittleC, t_id FROM skf_urls WHERE tipo=1 AND t_id=$idcc;");		
if(count($res)>0){
		
$bb++;
$dsliders['nom']=$res[1]['crsTittle'];
$dsliders['url']=$v['vars']['purl'][$res[1]['idp']] . $res[1]['url'];
$dsliders['pagTittle']=$res[1]['pagTittleC'];

$txt=trim(DTXTcat($res[1]['t_id']));
if(!$txt){$txt=InventaDTXTcat($res[1]['pagTittleC'],$res[1]['idp']);};
$dsliders['description']=$txt;


	
$listcur="";$res=array();
$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE id_cat IN ($idcc);");	
if(count($res)>0){foreach ($res as $key => $data) {$listcur.=$data['id_cur'] . ",";};};

if($lcinfe){	
$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE id_cat IN ($lcinfe);");	
if(count($res)>0){foreach ($res as $key => $data) {$listcur.=$data['id_cur'] . ",";};};
}


$listcur=substr($listcur, 0,-1);
$curs=ordenaCURs($listcur,0,2);

$cc=0;$dsliders['cross-cursos']=array();

if(count($curs)>0){foreach ($curs as $key => $cur) {
if($cur){
	
$res=DBselect("
SELECT nombre, 
(SELECT url FROM skf_urls WHERE tipo=2 AND skf_urls.t_id=skv_cursos.id) as url, 
(SELECT idp FROM skf_urls WHERE tipo=2 AND skf_urls.t_id=skv_cursos.id) as idp  
FROM skv_cursos WHERE id=$cur;
");

$cc++;	
foreach ($res as $cc2 => $datos){
	//$url=urlCur($cur);
	$dsliders['cross-cursos'][$cc]['nomC']=$datos['nombre'];
	$dsliders['cross-cursos'][$cc]['urlc']=$v['vars']['purl'][$datos['idp']] . $datos['url'];
	};


}}}





if(($cc>0)&&($bb)){
$slidesA[]=loadChild('objt','cadaSlide');
}



}

}}

$nadd=0;
foreach ($slidesA as $key => $sd) {
//if($key==1){$slides.=loadChild('objt','adW_slide');$nadd++;};
$slides.=$sd;
}

//if(!$nadd){$slides.=loadChild('objt','adW_slide');}


return $slides;
	
}


?>