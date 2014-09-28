<?php
global $datCur;
$Datos['anchor']=$v['vars']['eqmet'][$datCur['cur_id_metodo']]['s'];


$idcur=$v['where']['id'];
//$Datos['curnom']=$v['where']['pagTittle'];

$met=$v['vars']['eqmet'][$datCur['cur_id_metodo']]['s'];
$met=strtolower($met);

$Datos['metodo']=$met;
$eqp=$v['vars']['provN'];

$idcentroS=$datCur['id_centro'];
$cps=DBselect("SELECT idpro FROM skv_relCurPro WHERE idcur=$idcur;");
//$cps=DBselect("SELECT distinct provincia FROM skv_sedes WHERE idcentro=$idcentroS ORDER BY nombre;");
$cc=0;

//echo "SELECT idpro FROM skv_relCurPro WHERE idcur=$idcur;";
//print_r($cps);
$provincias="";
if(count($cps)>0){
foreach ($cps as $key => $prov) {$cc++;
$idp=substr($prov['idpro'],0,3);
if(($idp=='070')||($idp=='077')||($idp=='078')){}else{$idp=substr($idp, 0,2) . "0";}	
$rDatos['cadasede'][$cc]['cp']=	$idp;
$provincias.=$eqp[$idp] . ", ";
}	
}

$Datos['tipo']=$v['vars']['eqtip'][$datCur['cur_id_tipocurso']]['s'];
$provincias=substr($provincias, 0,-2) . ".";
$Datos['provincias']=$provincias;
?>