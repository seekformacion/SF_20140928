<?php

function breadCRUMBS($idcat){global $v;
$idt=$v['where']['idt'];
$idp=$v['where']['idp'];
$id_sup="";


$inf=DBselect("select id_sup, superiores from skf_cats where id=$idcat;");
$sup=$inf[1]['superiores']; $id_sup=$inf[1]['id_sup']; $sup=substr($sup, 1); $sup=substr($sup, 0,-1); $sup=str_replace('|', ',', $sup); 

$v['where']['csup']['nom']="home";
$v['where']['csup']['url']="/";
if($id_sup){
$dcats=DBselect("select pagTittleC, url from skf_urls where t_id=$id_sup AND tipo IN (1);");
if(count($dcats)>0){foreach ($dcats as $key => $dat) {$url=$dat['url']; $n=$dat['pagTittleC'];
$v['where']['csup']['nom']=$n;
$v['where']['csup']['url']=$url;
}}}


curDesc($id_sup,$idcat);


$bc=""; $bc2="";
if($sup){
$dcats=DBselect("select * from skf_urls where t_id IN ($sup) AND tipo IN (0,1) ORDER BY FIELD(t_id,$sup);");
foreach ($dcats as $key => $dat) {
$url=$dat['url']; $n=$dat['pagTittleC'];	
	if($url=="/"){
	$url=$v['vars']['purl'][$idp];
	$n=$v['vars']['purlT'][$idp];
	$bc.="<a itemtype='http://data-vocabulary.org/Breadcrumb' href='$url' title='$n' itemprop='url'><span itemprop='title'>$n</span></a>";
	}else{$bc.=" > <a itemtype='http://data-vocabulary.org/Breadcrumb' href='$url' itemprop='url'><span itemprop='title'>$n</span></a> "; $bc2.="<a itemtype='http://data-vocabulary.org/Breadcrumb' href='$url' itemprop='url'><span itemprop='title'>$n</span></a> >> ";};
}}


$v['where']['bc2']=substr($bc2, 0,-1);
return ($bc);
}



function breadCRUMBSCUR($idcat){global $v;
$idt=$v['where']['idt'];
$idp=$v['where']['idp'];


$inf=DBselect("select superiores from skf_cats where id=$idcat;");
$sup=$inf[1]['superiores']; $sup = $sup . $idcat . "|"; 
$sup=substr($sup, 1); $sup=substr($sup, 0,-1); $sup=str_replace('|', ',', $sup); 

$bc="";
if($sup){
$dcats=DBselect("select * from skf_urls where t_id IN ($sup) AND tipo IN (0,1) ORDER BY FIELD(t_id,$sup);");
foreach ($dcats as $key => $dat) {
$url=$dat['url']; $n=$dat['pagTittleC'];	
	if($url=="/"){
	$url=$v['vars']['purl'][$idp];
	$n=$v['vars']['purlT'][$idp];
	$bc.="<a itemtype='http://data-vocabulary.org/Breadcrumb' href='$url' itemprop='url'><span itemprop='title'>$n</span></a>";
	}else{$bc.="> <a itemtype='http://data-vocabulary.org/Breadcrumb' href='$url' itemprop='url'><span itemprop='title'>$n</span></a> ";};
}}


return ($bc);
}



function curDesc($idsup,$idcat){
$homes[1]=1;	



/* 
#########3 para curso destacado
if(array_key_exists($idsup,$homes)){$idsup=$idcat;};

$cats=DBselect("select id from skf_cats where id_sup=$idsup;"); 
$lcats="";
foreach ($cats as $key => $vals) {if($vals['id']!=$idcat){$lcats .=$vals['id'] . ",";}};$lcats=substr($lcats, 0,-1);
	
if($lcats){	
$catsPort=DBselect("select id_cat, count(distinct id_cur) as S from skv_relCurCats 
where id_cat IN ($lcats) AND showC=1 GROUP BY id_cat ORDER BY S DESC;");
$qty=0;$lcatsT="";
foreach ($catsPort as $kk => $val) {if($val['S']>0){$lcatsT .=$val['id_cat'] . ",";};}; 
$lcatsT=substr($lcatsT, 0,-1);
}

$inf=DBselect("select pagTittleC from skf_urls where t_id=$idsup AND tipo=1;");
if(count($inf)>0){$pagTC=$inf[1]['pagTittleC'];}else{$pagTC="";};

$lcusos=""; 
if($lcatsT){
$curinf=DBselect("SELECT DISTINCT(id_cur) as idCUR FROM skv_relCurCats WHERE showC=1 AND id_cat IN ($lcatsT);");
if(count($curinf)>0){foreach ($curinf as $k => $vals){$lcusos.=$vals['idCUR'] . ",";};};$lcusos=substr($lcusos, 0,-1);
$lcusos=ordenaCURs($lcusos,0,0);
}

global $lccuT;
if(count($lcusos)>0){foreach ($lcusos as $key => $idcc) {
$lccuT['key']=$key; $lccuT['$idcc']=$idcc; $lccuT['pagTC']=$pagTC;
$lccuT['html']=loadChild('objt','subCURcatsinfT');
}}
#########################	
*/


}








function catsSAME($idcat){global $v; 
$idt=$v['where']['idt'];
$idp=$v['where']['idp'];



$inf=DBselect("select id_sup from skf_cats where id=$idcat;");
$idsup=$inf[1]['id_sup']; 
$cats=DBselect("select id from skf_cats where id_sup=$idsup;");

$lcats="";
foreach ($cats as $key => $vals) {if($vals['id']!=$idcat){$lcats .=$vals['id'] . ",";}};$lcats=substr($lcats, 0,-1);
	

if($lcats){
	
$catsPort=DBselect("select id_cat, count(distinct id_cur) as S from skv_relCurCats 
where id_cat IN ($lcats) GROUP BY id_cat ORDER BY S DESC;");
$qty=0;$lcatsT="";
foreach ($catsPort as $kk => $val) {if($val['S']>5){$lcatsT .=$val['id_cat'] . ",";};}; 
$lcatsT=substr($lcatsT, 0,-1);






$dcats=array();
if($lcatsT){
$dcats=DBselect("select * from skf_urls where t_id IN ($lcatsT) AND tipo=1 ORDER BY pagTittleC;");
}






if(count($dcats)==0){$dcats=array();};
}else{
	
$dcats=array();	
}

$limit=6;
foreach ($dcats as $key => $value) {$limit--;
if($limit>=0){$dcats2[$key]=$value;}	
}

//$v['where']['cats_same']=$dcats2;









}





function catsINF($idcat){global $v; global $ctinf;

$idt=$v['where']['idt'];
$idp=$v['where']['idp'];

$lcats=array();
$ctinf=array();

$listC=CATS_inf_T($idcat);


$linfT=trim($listC['list']);
$infA=$listC['infA'];



if($linfT){
	
$catsPort=DBselect("select id_cat, count(distinct id_cur) as S from skv_relCurCats 
where id_cat IN ($linfT) AND showC=1 GROUP BY id_cat ORDER BY S DESC;");

foreach ($catsPort as $key => $val) {

if (array_key_exists($val['id_cat'], $infA)){	
$idc=$infA[$val['id_cat']]; $qty=$val['S'];
if (array_key_exists($idc, $lcats)){$lcats[$idc]=$lcats[$idc]+$qty;}else{$lcats[$idc]=$qty;};
}
}




$qty=0;$lcatsT="";
foreach ($lcats as $idc => $qty) {if($qty>0){$lcatsT .=$idc . ","; $ctinf[$idc]=1;};}; 
$lcatsT=substr($lcatsT, 0,-1);

$dcats=array();

if($lcatsT){
$dcats=$catsPort=DBselect("select * from skf_urls where t_id IN ($lcatsT) AND idp=$idp AND tipo=1 ORDER BY pagTittleC;");
}

if(count($dcats)==0){$dcats=array();};

}else{
$dcats=array();	
}

$v['where']['cats_inf']=$dcats;


if((count($dcats)<10)&&(!array_key_exists('search', $v))){
catsSAME($idcat);
}else{
$v['where']['cats_same']=array();	
}
}




function filtraCATS($catsinf){
$res=array();
foreach ($catsinf as $point => $values) {
$id=$values['id'];	
$nom=$values['nom'];
$id_old=$values['id_old'];

$res[$point]['id']=$id;
$res[$point]['nom']=$nom;
$res[$point]['id_old']=$id_old;

$res[$point]['cats_inf']=CATS_inf($id);

}	

return $res;
}


function CATS_inf_T($cat){
$listinf="";$infA=array();

$inf=DBselect("select id from skf_cats where superiores like '%|$cat|';");
foreach ($inf as $key => $val) {$infA[$val['id']]=$val['id']; $infB[$val['id']]=$val['id'];};




$inferiores=DBselect("select id, superiores from skf_cats where superiores like '%|$cat|%';"); 



foreach ($inferiores as $key => $values) {
$idci=$values['id'];	
$listinf .=$idci . ",";

if(!array_key_exists($idci, $infA)){
	$sup=$values['superiores']; $sup=substr($sup, 1);$sup=substr($sup, 0,-1); $sups=explode('|', $sup);
	$cc=count($sups) -1;
	if($cc-1 < 0){$_1=0;}else{$_1=$cc-1;}
	if($cc-2 < 0){$_2=0;}else{$_2=$cc-2;}
	if($cc-3 < 0){$_3=0;}else{$_3=$cc-3;}
	
				 
		if(array_key_exists($sups[$cc], $infB)){			$infA[$idci]=$infB[$sups[$cc]];
		}elseif(array_key_exists($sups[$_1], $infB)){		$infA[$idci]=$infB[$sups[$_1]];
		}elseif(array_key_exists($sups[$_2], $infB)){		$infA[$idci]=$infB[$sups[$_2]];
		}elseif(array_key_exists($sups[$_3], $infB)){		$infA[$idci]=$infB[$sups[$_3]];			
		}	
		
		
}

}



$listC['list']=substr($listinf, 0,-1);
$listC['infA']=$infA;

return $listC;
}



function miniTXTcat($cat){
$txt=DBselect("select mini_Text from skf_txtDesc where t_id=$cat;");
if(array_key_exists(1, $txt)){return $txt[1]['mini_Text'];}else{return '';};
}

function TXTcat($cat){
$txt=DBselect("select text_desc from skf_txtDesc where t_id=$cat;");
if(array_key_exists(1, $txt)){return $txt[1]['text_desc'];}else{return '';};
}

function DTXTcat($cat){
$txt=DBselect("select mini_Text from skf_txtDesc where t_id=$cat;");
if(array_key_exists(1, $txt)){return $txt[1]['mini_Text'];}else{return '';};
}



function InventaTXTcat($nc,$idp){global $v;
$idc=$v['where']['id'];
if(!$idp){$idp=$v['where']['idp'];};


############ cursos
$p=strtolower($nc); $s=str_replace('cursos ', 'curso ', $p);

$cur[0]="Tenemos para ti una gran variedad de $p, estos cursos tienen el objetivo de formar a profesionales altamente cualificados. ";
$cur[1]="Encontraras una amplia variedad de $p para desarrollar tus habilidades y ampliar tu formación en este sector y mejorar tus posibilidades de encontrar trabajo.";
$cur[2]="Diversos $p que te facilitarán encontrar trabajo a corto plazo. Tenemos la oferta más variada del mercado. ¡Hay uno a tu medida!";
$cur[3]="Te ofrecemos varios $p para que te puedas convertir en un profesional y recibir la formación necesaria para desempeñar un oficio en este sector.";
$cur[4]="Estos $p te aportarán el aprendizaje necesario para dominar todos los aspectos necesarios para desempeñar funciones en este sector.";
$cur[5]="Estos $p están diseñados para que se dominen todas las técnicas relacionadas, Conviertete en un profesional. ";
$cur[6]="Con estos $p podrás obtener la mejor formación en este sector y acceso a puestos de trabajo altamente cualificados.";
$cur[7]="Con estos $p podrás desarrollar los aspectos que te permitirán ampliar tu formación dentro de este mundo.";
$cur[8]="Te ofrecemos los $p más variados, unidades didácticas, programas formativos, investigación en el aula, formación abierta y a distancia, y muchos más.";
$cur[9]="Ante la gran demanda de este tipo de formación te ofrecemos un abanico de $p con los que podrás obtener todos los conocimientos necesarios.";
$cur[10]="Con estos $p podrás desarrollar tus conocimientos y habilidades en este campo y desenvolverte sin dificultades en este sector laboral. ";
$cur[11]="¿Buscas un $s? Tenemos una gran oferta con la que podrás ampliar tus perspectivas laborales. ";
$cur[12]="Tenemos los mejores $p que te permitirán convertirte en un profesional y así encontrar empleo es este sector.";
$cur[13]="Te ofrecemos varios $p para que te puedas convertir en un experto y recibir la formación necesaria para desempeñar un oficio en este sector.";
$cur[14]="Con estos $p podrás obtener la mejor formación en este sector y acceso a puestos de trabajo altamente cualificados.";
$cur[15]="Te ofrecemos los mejores $p. Conviértete en un profesional en este sector con grandes posibilidades y consigue unos conocimientos que te ayudarán a prosperar en este sector.";
$cur[16]="Tenemos para ti una gran oferta de $p con los que obtendrás las habilidades y conocimientos necesarios para conseguir un empleo de calidad.";
$cur[17]="¿Quiéres encontrar empleo? Nuestros $p te proporcionarán la formación que necesitas y podrás trabajar este sector en auge.";
$cur[18]="Aquí podrás encontrar una gran variedad de $p con los que abrirte paso en el mercado laboral y trabajar en el puesto que siempre has deseado.";
$cur[19]="Decídete y comienza uno de nuestros $p conseguirás un excelente currículum a la vez que los conocimientos necesarios para desempeñar un empleo en este sector.";
$cur[20]="Si estás buscando un $s te ofrecemos distintas opciones con las que llegarás a ser un experto en este sector que actualmente ofrece grandes oportunidades laborales.";
$cur[21]="Tenemos una oferta de $p con los que aprenderás a dominar los aspectos más importantes  y estarás capacitado para cualquier tipo de situación laboral.";
$cur[22]="Visítanos y encontrarás la mejor oferta de $p, si decides estudiar unos de estos cursos no te arrepentirás ya que podrás lograr alcanzar tus objetivos laborales.";


if($idp==1){
$rest= ($idc % 23);	
return $cur[$rest];
}



############ masters
$p=strtolower($nc); $s=str_replace('masters ', 'master ', $p);
$mas[0]="Tenemos los mejores $p que te permitirán convertirte en un profesional y así encontrar empleo es este sector.";
$mas[1]="Tenemos para ti una gran variedad de $p, estos cursos tienen el objetivo de formar a profesionales altamente cualificados. ";
$mas[2]="¿Estás pensando en hacer un master? Puedes elegir entre nuestra selección de $p, encontrarás el que mejor se adapta a tus necesidades.";
$mas[3]="Tenemos la mayor oferta de masters, decídete a estudiar uno de estos $p y completarás tu currículum con una óptima formación de calidad.";
$mas[4]="¿Quiéres hacer un $s? No dudes en visitarnos, tenemos la más amplia oferta con la que abrirás las puertas del mercado laboral o prosperarás en tu empleo.";
$mas[5]="¿Quiéres una formación avanzada y altamente especializada? Te ofrecemos gran cantidad de $p que te aportarán las habilidades y conocimientos que necesitas.";
$mas[6]="Comienza un $s, conseguirás la capacitación que necesitas  y se te abrirán las puertas de este sector con grandes oportunidades laborales.";
$mas[7]="Si quieres introducirte en un mundo con múltiples salidas laborales te ofrecemos la oportunidad de estudiar uno de nuestros $p.";
$mas[8]="Aquí encontrarás la más variada oferta en $p, especialízate en este sector en crecimiento y dominarás todas las funciones que tengas que superar a nivel laboral.";
$mas[9]="El mercado de trabajo es cada vez más exigente, te ofrecemos una gran oferta de $p que te facilitarán tanto la consecución de empleo como la promoción en caso de que ya lo tuvieses.";
$mas[10]="¿Quiéres diferenciarte del resto de profesionales de tu sector? Aquí encontrarás multitud de $p con los que conseguirás un valor añadido y te aportarán un factor diferenciador.";
$mas[11]="¿Necesitas complementar tus estudios actuales? Estos $p te ofrecen esa oportunidad. Con ellos ampliarás las posibilidades de encontrar empleo o de mejorar el que ya tienes.";
$mas[12]="¿Pensando en hacer un $s? No lo pienses más. Elije entre la selección de $p que te ofrecemos.";
$mas[13]="La mejor selección de $p. Para que puedas elegir el $s que más se adapta a ti.";
$mas[14]="¿Estás buscando un master? Aquí te ofrecemos una amplia selección de $p";
$mas[15]="En un mercado laboral cada vez más exigente es necesario ampliar las oportunidades profesionales. Informate aquí de los $p.";
$mas[16]="Completa tu formación orientándote a resultados inmediatos. Elije el $s que más se adapta a ti.";



if($idp==2){
$rest= ($idc % 17);	
return $mas[$rest];
}






############ fp
$ncmin=strtolower($nc); 
$p=str_replace('fp: grado medio ','grados medios ',$ncmin);          $s=str_replace('fp: grado medio ','grado medio ',$ncmin); 
$p=str_replace('fp: grado superior ','grados superiores ',$p);       $s=str_replace('fp: grado superior ','grado superior ',$s); 

$fp[0]="Tenemos para ti distintos $p, con ellos podras convertirte en un profesional de este campo y te abrirán las puertas del mercado laboral.";	
$fp[1]="Si quieres estudiar un $s este es tu sitio, tenemos la mejor oferta de grados de formación profesional relacionados con este sector para que puedas conseguir los conocimientos que necesitas. ";
$fp[2]="¿Quiéres estudiar y encontrar empleo en un sector con gran demanda de profesionales? Tenemos los mejores $p para que te conviertas en un experto.";
$fp[3]="¿Te gustaría estudiar formación profesional? Aquí encontrarás $p con los que te resultará más sencillo encontrar empleo en este sector con múltiples salidas laborales. ";
$fp[4]="Si estas pensando en estudiar un $s. No te pierdas la oferta de $p que te ofrecemos.";
$fp[5]="Conviertete en un profesional con los $p que te te proponemos. Realiza un $s y certifica tu valía";
$fp[6]="Decídete a estudiar un $s de formación profesional, con ellos podrás obtener empleo y promocionar tanto en el ámbito privado como en el público.";
$fp[7]="Tenemos la mejor oferta de $p con los que obtendrás el título de formación profesional que te abrirá las puertas del mercado laboral.";
$fp[8]="¿Quiéres estudiar y encontrar empleo como un profesional cualificado? Tenemos los mejores $p para que puedas acreditar tus conocimientos. ";
$fp[9]="¿Estás pensando en comenzar un grado medio o superior de formación profesional? Te ofrecemos la oportunidad de elegir entre nuestros $p.";
$fp[10]="Hoy en día la mejor opción para encontrar empleo es estudiar formación profesional, te presentamos nuestra extensa oferta en $p.";
$fp[11]="Con nuestros $p conseguirás la mejor formación y te abrirás las puertas del mercado laboral estudiando lo que más te gusta.";
$fp[12]="¿Quiéres conocer a fondo una profesión? Decídete a comenzar un $s de formación profesional y podrás conseguir el trabajo que más encaja contigo.";
$fp[13]="¿Sabías que 4 de cada 10 ofertas de empleo son para titulados en formación profesional? Tenemos distintos $p que te permitirán desarrollar la profesión que más te guste.";





if($idp==3){
$rest= ($idc % 14);	
return $fp[$rest];
}




############ oposiciones
$p=strtolower($nc); $s=str_replace('oposiciones ', 'oposición ', $p);
$op[0]="¿Estás pensando en opositar? Aquí encontrarás lo necesario para formarte y obtener los mejores resultados en las pruebas de acceso para $p.";
$op[1]="¿Quieres preparar una $s? Con estos cursos preparativos conseguirás la preparación necesaria para superar el examen con una gran calificación.";
$op[2]="Ser funcionario es tener la certeza de un empleo estable y para toda la vida, da el paso, lánzate y comienza uno de nuestros cursos de preparación a $p.";
$op[3]="¿Te gustaría ser empleado público? Pierde el respeto a las pruebas de acceso con esta oferta de cursos de preparación a $p y encuentra un empleo con la mayor estabilidad.";
$op[4]="¿Llevas tiempo pensando en prepararte unas oposiciones? Esta es tu oportunidad, aquí encontrarás una amplia oferta de cursos de preparación para $p.";
$op[5]="¿Quiéres encontrar plaza fija como empleado público? Tenemos para ti los cursos preparativos para $p con los que tu éxito está asegurado.";
$op[6]="Prepara tus $p con el curso de preparación que más encaje contigo, tenemos cursos para que puedas presentarte a multitud de oposiciones y puedas conseguir una plaza.";
$op[7]="¿Estás interesado en ser funcionario del estado? Si no sabes cómo hacerlo te ayudamos con estos cursos de preparación para $p.";
$op[8]="Si buscas encontrar plaza fija como funcionario te ofrecemos diversos cursos de preparación a $p con los que podrás superar la convocatoria.";
$op[9]="Aquí podrás encontrar los cursos de preparación para $p que te permitan conseguir exitosamente el puesto tan deseado que siempre has querido.";
$op[10]="¿Has decidido presentarte a una convocatoria para $p? Visítanos y consigue encontrar el curso de preparación que mejor encaja con tu perfil.";
$op[11]="Si tu objetivo es conseguir un empleo estable tenemos para ti una serie de cursos preparativos para $p con los mejores temarios para que superes fácilmente las pruebas de acceso.";


if($idp==4){
$rest= ($idc % 12);	
return $op[$rest];
}




}


function InventaDTXTcat($nc,$idp){global $v;
if(!$idp){$idp=$v['where']['idp'];};
$idc=$v['where']['id'];
$nidc=(($idc+17)*($idc+50/($idc+3)));


############ cursos
$p=strtolower($nc); $s=str_replace('cursos ', 'curso ', $p);
$cur[0]="Los mejores $p con los que podrás convertirte en un profesional de este sector y mejora tus conocimientos para encontrar empleo fácilmente.";
$cur[1]="¿Estas interesado en un $s? Te ofrecemos los mejores y más completos $p";
$cur[2]="Te ofrecemos varios $p para que te puedas convertir en un experto y recibir la formación necesaria para desempeñar un oficio en este sector.";
$cur[3]="Con estos $p podrás obtener la mejor formación en este sector y acceso a puestos de trabajo altamente cualificados.";
$cur[4]="Te ofrecemos los mejores $p. Conviértete en un profesional en este sector con grandes posibilidades y consigue unos conocimientos que te ayudarán a prosperar en este sector.";
$cur[5]="Tenemos para ti una gran oferta de $p con los que obtendrás las habilidades y conocimientos necesarios para conseguir un empleo de calidad.";
$cur[6]="¿Quiéres encontrar empleo? Nuestros $p te proporcionarán la formación que necesitas y podrás trabajar este sector en auge.";
$cur[7]="Aquí podrás encontrar una gran variedad de $p con los que abrirte paso en el mercado laboral y trabajar en el puesto que siempre has deseado.";
$cur[8]="Decídete y comienza uno de nuestros $p conseguirás un excelente currículum a la vez que los conocimientos necesarios para desempeñar un empleo en este sector.";
$cur[9]="Si estás buscando un $s te ofrecemos distintas opciones con las que llegarás a ser un experto en este sector que actualmente ofrece grandes oportunidades laborales.";
$cur[10]="Tenemos una oferta de $p con los que aprenderás a dominar los aspectos más importantes  y estarás capacitado para cualquier tipo de situación laboral.";
$cur[11]="Visítanos y encontrarás la mejor oferta de $p, si decides estudiar unos de estos cursos no te arrepentirás ya que podrás lograr alcanzar tus objetivos laborales.";
$cur[12]="Estos $p te aportarán el aprendizaje necesario para dominar todos los aspectos necesarios para desempeñar funciones en este sector.";
$cur[13]="Estos $p están diseñados para que se dominen todas las técnicas relacionadas, Conviertete en un profesional. ";
$cur[14]="Con estos $p podrás obtener la mejor formación en este sector y acceso a puestos de trabajo altamente cualificados.";
$cur[15]="Con estos $p podrás desarrollar los aspectos que te permitirán ampliar tu formación dentro de este mundo.";
$cur[16]="Te ofrecemos los $p más variados, unidades didácticas, programas formativos, investigación en el aula, formación abierta y a distancia, y muchos más.";
$cur[17]="Ante la gran demanda de este tipo de formación te ofrecemos un abanico de $p con los que podrás obtener todos los conocimientos necesarios.";
$cur[18]="Con estos $p podrás desarrollar tus conocimientos y habilidades en este campo y desenvolverte sin dificultades en este sector laboral. ";


if($idp==1){
$rest= ($nidc % 19);	
return $cur[$rest];
}





############ masters
$p=strtolower($nc); $s=str_replace('masters ', 'master ', $p);
$mas[0]="Tenemos los mejores $p que te permitirán convertirte en un profesional y así encontrar empleo es este sector.";
$mas[1]="Tenemos para ti una gran variedad de $p, estos cursos tienen el objetivo de formar a profesionales altamente cualificados. ";
$mas[2]="¿Estás pensando en hacer un master? Puedes elegir entre nuestra selección de $p, encontrarás el que mejor se adapta a tus necesidades.";
$mas[3]="Tenemos la mayor oferta de masters, decídete a estudiar uno de estos $p y completarás tu currículum con una óptima formación de calidad.";
$mas[4]="¿Quiéres hacer un $s? No dudes en visitarnos, tenemos la más amplia oferta con la que abrirás las puertas del mercado laboral o prosperarás en tu empleo.";
$mas[5]="¿Quiéres una formación avanzada y altamente especializada? Te ofrecemos gran cantidad de $p que te aportarán las habilidades y conocimientos que necesitas.";
$mas[6]="Comienza un $s, conseguirás la capacitación que necesitas  y se te abrirán las puertas de este sector con grandes oportunidades laborales.";
$mas[7]="Si quieres introducirte en un mundo con múltiples salidas laborales te ofrecemos la oportunidad de estudiar uno de nuestros $p.";
$mas[8]="Aquí encontrarás la más variada oferta en $p, especialízate en este sector en crecimiento y dominarás todas las funciones que tengas que superar a nivel laboral.";
$mas[9]="El mercado de trabajo es cada vez más exigente, te ofrecemos una gran oferta de $p que te facilitarán tanto la consecución de empleo como la promoción en caso de que ya lo tuvieses.";
$mas[10]="¿Quiéres diferenciarte del resto de profesionales de tu sector? Aquí encontrarás multitud de $p con los que conseguirás un valor añadido y te aportarán un factor diferenciador.";
$mas[11]="¿Necesitas complementar tus estudios actuales? Estos $p te ofrecen esa oportunidad. Con ellos ampliarás las posibilidades de encontrar empleo o de mejorar el que ya tienes.";
$mas[12]="¿Pensando en hacer un $s? No lo pienses más. Elije entre la selección de $p que te ofrecemos.";
$mas[13]="La mejor selección de $p. Para que puedas elegir el $s que más se adapta a ti.";
$mas[14]="¿Estás buscando un master? Aquí te ofrecemos una amplia selección de $p";
$mas[15]="En un mercado laboral cada vez más exigente es necesario ampliar las oportunidades profesionales. Informate aquí de los $p.";
$mas[16]="Completa tu formación orientándote a resultados inmediatos. Elije el $s que más se adapta a ti.";

if($idp==2){
$rest= ($nidc % 17);	
return $mas[$rest];
}



############ fp
$ncmin=strtolower($nc); 
$p=str_replace('fp: grado medio ','grados medios ',$ncmin);          $s=str_replace('fp: grado medio ','grado medio ',$ncmin); 
$p=str_replace('fp: grado superior ','grados superiores ',$p);       $s=str_replace('fp: grado superior ','grado superior ',$s); 

$fp[0]="Tenemos los mejores $p que te permitirán convertirte en un profesional y así encontrar empleo es este sector.";
$fp[1]="Tenemos para ti una gran variedad de $p, estos cursos tienen el objetivo de formar a profesionales altamente cualificados. ";
$fp[2]="¿Quiéres estudiar y encontrar empleo en un sector con gran demanda de profesionales? Tenemos los mejores $p para que te conviertas en un experto.";
$fp[3]="¿Te gustaría estudiar formación profesional? Aquí encontrarás $p con los que te resultará más sencillo encontrar empleo en este sector con múltiples salidas laborales. ";
$fp[4]="Si estas pensando en estudiar un $s. No te pierdas la oferta de $p que te ofrecemos.";
$fp[5]="Conviertete en un profesional con los $p que te te proponemos. Realiza un $s y certifica tu valía";
$fp[6]="Decídete a estudiar un $s de formación profesional, con ellos podrás obtener empleo y promocionar tanto en el ámbito privado como en el público.";
$fp[7]="Tenemos la mejor oferta de $p con los que obtendrás el título de formación profesional que te abrirá las puertas del mercado laboral.";
$fp[8]="¿Quiéres estudiar y encontrar empleo como un profesional cualificado? Tenemos los mejores $p para que puedas acreditar tus conocimientos. ";
$fp[9]="¿Estás pensando en comenzar un grado medio o superior de formación profesional? Te ofrecemos la oportunidad de elegir entre nuestros $p.";
$fp[10]="Hoy en día la mejor opción para encontrar empleo es estudiar formación profesional, te presentamos nuestra extensa oferta en $p.";
$fp[11]="Con nuestros $p conseguirás la mejor formación y te abrirás las puertas del mercado laboral estudiando lo que más te gusta.";
$fp[12]="¿Quiéres conocer a fondo una profesión? Decídete a comenzar un $s de formación profesional y podrás conseguir el trabajo que más encaja contigo.";
$fp[13]="¿Sabías que 4 de cada 10 ofertas de empleo son para titulados en formación profesional? Tenemos distintos $p que te permitirán desarrollar la profesión que más te guste.";

if($idp==3){
$rest= ($nidc % 14);	
return $fp[$rest];
}



############ oposiciones
$p=strtolower($nc); $s=str_replace('oposiciones ', 'oposición ', $p);
$op[0]="Tenemos los mejores $p que te permitirán convertirte en un profesional y así encontrar empleo es este sector.";
$op[1]="Tenemos para ti una gran variedad de $p, estos cursos tienen el objetivo de formar a profesionales altamente cualificados. ";
$op[2]="Ser funcionario es tener la certeza de un empleo estable y para toda la vida, da el paso, lánzate y comienza uno de nuestros cursos de preparación a $p.";
$op[3]="¿Te gustaría ser empleado público? Pierde el respeto a las pruebas de acceso con esta oferta de cursos de preparación a $p y encuentra un empleo con la mayor estabilidad.";
$op[4]="¿Llevas tiempo pensando en prepararte unas oposiciones? Esta es tu oportunidad, aquí encontrarás una amplia oferta de cursos de preparación para $p.";
$op[5]="¿Quiéres encontrar plaza fija como empleado público? Tenemos para ti los cursos preparativos para $p con los que tu éxito está asegurado.";
$op[6]="Prepara tus $p con el curso de preparación que más encaje contigo, tenemos cursos para que puedas presentarte a multitud de oposiciones y puedas conseguir una plaza.";
$op[7]="¿Estás interesado en ser funcionario del estado? Si no sabes cómo hacerlo te ayudamos con estos cursos de preparación para $p.";
$op[8]="Si buscas encontrar plaza fija como funcionario te ofrecemos diversos cursos de preparación a $p con los que podrás superar la convocatoria.";
$op[9]="Aquí podrás encontrar los cursos de preparación para $p que te permitan conseguir exitosamente el puesto tan deseado que siempre has querido.";
$op[10]="¿Has decidido presentarte a una convocatoria para $p? Visítanos y consigue encontrar el curso de preparación que mejor encaja con tu perfil.";
$op[11]="Si tu objetivo es conseguir un empleo estable tenemos para ti una serie de cursos preparativos para $p con los mejores temarios para que superes fácilmente las pruebas de acceso.";



if($idp==4){
$rest= ($nidc % 12);	
return $op[$rest];
}





}




?>