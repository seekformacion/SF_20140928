<?php
header("content-type: application/json"); 

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};

$v['where']['view']='categorias';
$v['where']['id']=1; 
require_once ('iniAJX.php');


function getResult($lcurs,$p,$lsel){global $v;$pt=$p; $p=$p . 'p';
$res=DBselect("SELECT id, cur_id_metodo, cur_id_tipocurso, cur_precio, cur_duracion, cur_mostarprecio, 
(SELECT file_logo from skv_centros WHERE id_centro=id) as file_logo, 
(SELECT nombre from skv_centros WHERE id_centro=id) as ncent 
FROM skv_cursos WHERE id IN ($lcurs) ORDER BY FIELD(id, $lcurs);");
foreach ($res as $key => $value) {
$curs[$value['id']]['met']=$v['vars']['eqmet'][$value['cur_id_metodo']]['s'];	
$curs[$value['id']]['tip']=$v['vars']['eqtip'][$value['cur_id_tipocurso']]['c'];
$curs[$value['id']]['pre']=$value['cur_precio'];
$curs[$value['id']]['mpre']=$value['cur_mostarprecio'];
$curs[$value['id']]['dur']=$value['cur_duracion'];
$curs[$value['id']]['file_logo']=$value['file_logo'];
$curs[$value['id']]['ncent']=$value['ncent'];
}

$res=DBselect("SELECT t_id, idp, url, pagTittle FROM skf_urls WHERE t_id IN ($lcurs) AND tipo=2;");
foreach ($res as $key => $value) {
$curs[$value['t_id']]['tit']=$value['pagTittle'];
$curs[$value['t_id']]['url']=$v['vars']['purl'][$value['idp']] . $value['url'];
}

$html="

<div class='cdCrL color1'>
<div class='tit'>&nbsp;</div>
<div class='cent'>Centro</div>
<div class='tip'>Tipo</div> 
<div class='met'>Modalidad</div> 
<div class='dur'>Duración</div>
<div class='pre'>Precio</div>
<div class='clean'></div>
</div>
<div class='clean'></div>

<div class='intCo'><div id='$p' style='position:absolute; top:0px;'>
";
$c=0;
foreach ($curs as $idc => $vals) {$c++;
$met=$vals['met']; $tip=$vals['tip']; $pre=$vals['pre']; $dur=$vals['dur']; $tit=$vals['tit']; $url=$vals['url']; $ncent=$vals['ncent'];	
$imgLogoCent='/img/global/logos/p/' . $vals['file_logo'];

if((!$pre)||($vals['mpre']==0)){$pre="&nbsp;";};
if(!$dur){$dur="&nbsp;";};
if($pt=="P2c"){ if(array_key_exists($idc, $lsel)){$clss="clon"; }else{$clss="cloff"; }; }else{$clss="clon";};

$html.="
<a class='acdCr' href='$url'>
<div class='cdCr'>
<div class='tit'>$tit</div>
<img class='imgCc' src='$imgLogoCent' alt='$ncent' title='$ncent'>
<div class='tip'>$tip</div> 
<div class='met'>$met</div> 
<div class='dur'>$dur</div>
<div class='pre'>$pre</div>
</div>
</a>
<div class='iconos $clss' onclick='adCScarr($idc,\"$p\");'></div>
<div class='clean'></div>


<div class='clean'></div>
";	
}

$html.='</div></div>';

if($c>=4){
$html.="<div class='iconos farr' onclick='scrll(\"$p\",0);'></div>";
$html.="<div class='iconos faba' onclick='scrll(\"$p\",1);'></div>";
}

if(($c<=2)&&($pt=="P1c")){
$html.='
<div class="color1 paso1">
<div class="num1 iconos"></div>
Selecciona en cualquier listado o en las fichas de curso aquellos que más te interesan. Aquí podrás compararlos fácilmente.
<div class="imgPs1 iconos color1"></div>
</div>


<div class="color1 paso2">
<div class="num2 iconos"></div>
Con los cursos seleccionados puedes...
</div>



';
}


return $html;	
}


$lcurs="";$lsel=array();$ncur=0;
$res=DBselect("SELECT distinct idc FROM skv_user_sels WHERE UID='$uid' ORDER BY id DESC;");
if(count($res)>0){foreach ($res as $key => $value) {$lcurs.=$value['idc'] . ","; $vals[]=$value['idc']; $lsel[$value['idc']]=1; $ncur++;};
$lcurs=substr($lcurs, 0,-1);$noa=array();
$vals['P1c']=getResult($lcurs,'P1c',$noa);
}else{
$vals['P1c']="";	
}


$lcurs="";
$res=DBselect("SELECT distinct idc FROM skv_user_vist WHERE UID='$uid' ORDER BY id DESC;");
if(count($res)>0){foreach ($res as $key => $value) {$lcurs.=$value['idc'] . ",";};
$lcurs=substr($lcurs, 0,-1);
$vals['P2c']=getResult($lcurs,'P2c',$lsel);
}else{
$vals['P2c']="";	
}

if($ncur>1){
$vals['social']="Solicitar opinión sobre los $ncur cursos seleccionados en las siguientes redes sociales.";
}elseif ($ncur==1) {
$vals['social']="Solicitar opinión sobre el curso seleccionado en las siguientes redes sociales.";
}elseif ($ncur==0){
$vals['social']="No tienes ningún curso seleccionado.";	
}
$vals['nnc']=$ncur;	

if($ncur>1){$vals['ncur']="de los $ncur cursos seleccionados";} else {$vals['ncur']="del curso seleccionado";}


echo json_encode($vals);

?>