<?php 

$subs=$v['subs'];

$idpro=$v['where']['id_provi'];
$online=$v['where']['online'];
$distancia=$v['where']['distancia'];



$Datos['presen']="";
$Datos['css']="topMs";
$Datos['cabe']="Modalidad";
$Datos['backUrl']='';

$chk=0;
if(($subs['dis']>0)&&(!$distancia)){$chk++;
$rDatos['opcMET'][1]['pagTittle']=$v['where']['pagTittleSimp'] . " a distancia";
$rDatos['opcMET'][1]['pagTittleC']="A distancia";

$urlS=$v['where']['urlSimple'];
$urlS=str_replace('.html', '', $urlS);
$url="/a_distancia$urlS" . "_a_distancia.html";

$rDatos['opcMET'][1]['url']=$url;		
}
		
if(($subs['onl']>0)&&(!$online)){$chk++;
$rDatos['opcMET'][2]['pagTittle']=$v['where']['pagTittleSimp'] . " online";
$rDatos['opcMET'][2]['pagTittleC']="Online";

$urlS=$v['where']['urlSimple'];
$urlS=str_replace('.html', '', $urlS);
$url="/online$urlS" . "_online.html";

$rDatos['opcMET'][2]['url']=$url;		
}

if(!$chk){
$rDatos['opcMET'][0]['pagTittle']=1;	
}

if($subs['pre']>0){
$Datos['presen'].="<li onclick='dMp();' id='prov' class='liPreC'>Presenciales</li></ul>

<ul id='lisP'>
";

foreach ($subs['spr'] as $idprov => $c) {
$titP=$v['vars']['provN'][$idprov];
$titPA=$v['where']['pagTittleSimp'] . " presenciales en " . $v['vars']['provN'][$idprov];		

$urlS=$v['where']['urlSimple'];
$urlS=str_replace('.html', '', $urlS);
$provn2=normaliza($titP);
$urlP="/presencial/$provn2$urlS" . "_presenciales_en_$provn2.html";



$Datos['presen'].="<li onclick=\"lK('$urlP')\"><a href='$urlP' title='$titPA'>$titP</a></li>";
}


$Datos['presen'].="</ul>";	
	
}




	


?>