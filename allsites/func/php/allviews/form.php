<?php
function getForm(){global $v;
		
		
		

$proD=array();
$paises=$v['vars']['paises'];asort($paises);
$provins=$v['vars']['provS'];asort($provins);

$idc=$v['where']['id'];
$idp=$v['where']['idp'];
$uid="dd";

$result['idp']=$idp;

#$provins['010']="Álaba";
#$provins['050']="Ávila";

$provins['999']="Fuera de España";

$datSes=array();
#########3 datos de la session

$datSes[7]='ES';$datSes[6]='';

/*
$res4=DBselect("SELECT cp, ct FROM skv_user_sessions WHERE seekforID='$uid';");		
if(count($res4)>0){foreach ($res4 as $pp => $vals){
	
	
$datSes[7]=$vals['ct'];

if($datSes[7]=='ES'){
$cp=$vals['cp'];
		
$cp3=substr($cp,0,3);
	
if(($cp3=='077') || ($cp3=='078')){
$cp="$cp3";	
}else{
$cp=substr($cp,0,2); 
$cp="$cp" . '0';	
}

$datSes[6]="$cp";
}elseif($datSes[7]!=''){
$datSes[6]="999";	
}else{$datSes[7]='ES';}	
}}
*/



/*
$res3=DBselect("SELECT id_campo, valor FROM skv_user_data WHERE seekforID='$uid';");		
if(count($res3)>0){foreach ($res3 as $pp => $vals){
$datSes[$vals['id_campo']]=$vals['valor'];
}}
*/

/*
$id="";		
$res3=DBselect("SELECT id FROM skv_user_data WHERE seekforID='$uid' AND id_campo=7;");		
if(count($res3)>0){$id=$res3[1]['id'];}		
if(!$id){$valor=$datSes[7];
DBUpIns("INSERT INTO skv_user_data (seekforID,id_campo,valor) VALUES ('$uid',7,'$valor');");	
}		
*/

/*
$id="";		
$res3=DBselect("SELECT id FROM skv_user_data WHERE seekforID='$uid' AND id_campo=6;");		
if(count($res3)>0){$id=$res3[1]['id'];}		
if(!$id){$valor=$datSes[6];
DBUpIns("INSERT INTO skv_user_data (seekforID,id_campo,valor) VALUES ('$uid',6,'$valor');");	
}
*/




####3 datos del curso
$res=DBselect("SELECT t_id, pagTittleC FROM skf_urls WHERE t_id IN ($idc) AND tipo=2;");
if(count($res)>0){foreach ($res as $point => $vals){
$idcu=$vals['t_id']; $titu=$vals['pagTittleC'];
$Dcurso[$idcu]['titu']=$titu;
}}

$centros="";$esmin=1000;$online=0;$cpdonde="";$valorCup=0;
$res2=DBselect("SELECT id, OrdDESC, cur_minestudi, cur_id_tipocurso, cur_id_metodo, id_centro, (SELECT file_logo FROM skv_centros WHERE id=id_centro) as logo FROM skv_cursos WHERE id IN ($idc);");
if(count($res2)>0){foreach ($res2 as $point => $valc){
		
$OrdDESC=$valc['OrdDESC'];	if($OrdDESC==""){$OrdDESC=0;};  $OrdDESC=number_format($OrdDESC,2);

$valorCup=$valorCup+$OrdDESC;

$centros.=$valc['id_centro'] . ",";

$idcu=$valc['id']; $idtip=$valc['cur_id_tipocurso']; $idmet=$valc['cur_id_metodo']; $logo=$valc['logo'];
if($valc['cur_minestudi']<$esmin){$esmin=$valc['cur_minestudi'];};

$Dcurso[$idcu]['tip']=$v['vars']['eqtip'][$idtip]['s'];
$Dcurso[$idcu]['met']=$v['vars']['eqmet'][$idmet]['s'];
$Dcurso[$idcu]['logo']=$logo;

if($idmet <= 3){$cpdonde.=$idcu . ",";}else{$online++;}

}}
$valorCup=number_format($valorCup,2);
$centros=substr($centros, 0,-1);
$cpdonde=substr($cpdonde, 0,-1);

### saco provis donde si no hay online
$lpdonde="";
if(!$online){
	
$res2=DBselect("select distinct idpro as idp from skv_relCurPro where idcur in ($cpdonde);");
if(count($res2)>0){foreach ($res2 as $point => $valP){
$cp=$valP['idp'];
$cp3=substr($cp,0,3);
if(($cp3=='077') || ($cp3=='078')){
$cp="$cp3";	
}else{
$cp=substr($cp,0,2); 
$cp="$cp" . '0';	
}
$proD["$cp"]=1;
}}

if(count($proD)>0){foreach ($proD as $idpp => $uno){$lpdonde .=$idpp . ",";}}
$lpdonde=substr($lpdonde, 0,-1);		

}

//echo $centros;
//print_r($Dcurso);

$htmlCur=""; $cc=0;

/*
foreach ($Dcurso as $idcur => $datos){$cc++;

$tit=$datos['titu'];		
$desc=$datos['tip'] . " / " . $datos['met'];
$logo=$datos['logo'];

$htmlCur.='

<div class="cdcurF">
<img class="logoCent" src="/img/global/logos/p/' . $logo . '" style="width:80px; position:absolute; top:9px; margin:0px; left:28px;">
<div style="top: 12px;" class="titCurF">' . $tit . '</div>
<div style="top: 32px;" class="titCurF">' . $desc . '</div>
</div>
';
	
}
*/


########## obtengo campos de los centros
$res=DBselect("SELECT idcampo, muestro FROM skv_relCampos WHERE id_centro IN ($centros) AND obligado=1;");
if(count($res)>0){foreach ($res as $point => $vals){
$campos[$vals['idcampo']]=1;
}}



$campos[1]=1;
$campos[2]=1;
$campos[3]=1;
$campos[6]=1;



/*
$campos[8]=1;
$campos[9]=1;
$campos[15]=1;
$campos[16]=1;
$campos[18]=1;
$campos[23]=1;
*/
$result2['html']='';
######## cabecera cursos
$result['html']='
<form autocomplete="on" method="POST">
<div class="claim general">Solicita más información gratuita y sin compromiso</div>
';


/*
$result['html']='
<input type="hidden" id="cc" value="' . $cc . '">

<div class="gris3_BG detCU" >
<div style="top:0px; position: absolute;" id="cntCurF">

' . $htmlCur . '

</div></div>
';
*/


if($cc>1){
$result['html'] .='

<div class="fupForm iconos" onclick="cuforMove(1);"></div>
<div style=" color: #888888;font-family: arial;font-size: 11px;height: 30px;left: 446px;position: absolute;text-align: center;top: 24px;width: 24px;" id="counter">
1/' . $cc . '
</div>
<div class="fdwForm iconos" onclick="cuforMove(2);"></div>

</div>

';
}




######## inicion form
if($cc>1){
$errEs="Le recordamos que para realizar alguno de los cursos de los que solicita información, el nivel mínimo de estudios es de: ". $v['vars']['esmin'][$esmin] ;
$lpdondeE="Le recordamos que ninguno de los cursos de los que solicita información se imparten en la provincia seleccionada";
}else{
$errEs="Le recordamos que para realizar este curso, el nivel mínimo de estudios es de: ". $v['vars']['esmin'][$esmin];	
$lpdondeE="Le recordamos que el curso del que solicita información no se imparte en la provincia seleccionada";
};


if($lpdonde){
$result2['html'].="

<input type='hidden' id='lpdonde' value='$lpdonde'>
<input type='hidden' id='lpdondeE' value='$lpdondeE'>
";	
}



$result2['html'].="
<input type='hidden' id='cursosCup' value='$idc'>
<input type='hidden' id='Cents' value='$centros'>
";	


$result2['html'].='



<input type="hidden" id="esmin" value="' . $v['vars']['equiEst'][$esmin] . '">
<input type="hidden" id="esminE" value="' . $errEs . '">


';



$result2['html'].='
<div class="cntF" id="">
';


$tab=0;
#################################################################### Nombre ID: 1
if(array_key_exists(1, $campos)){
if(array_key_exists(1, $datSes)){$value=$datSes[1];}else{$value="";} 	
$tab++; $cmpT="df_1|n,";
$result2['html'].='
<div class="nomCamp"><span class="obli">*</span>Nombre:</div>

<div class="contFields">
<label style="display:none">nombre</label>
<input name="first_name" autocomplete="on" x-autocompletetype="first_name" value="' . $value . '" 
class="formI ftext1" id="df_1" onchange="sendDat(this.id,this.value);" tabindex="' . $tab . '"/>
</div>
<div class="clean"></div>
';
}




#################################################################### Apellidos ID: 2
if(array_key_exists(2, $campos)){
if(array_key_exists(2, $datSes)){$value=$datSes[2];}else{$value="";}	
$tab++; $cmpT.="df_2|n,";
$result2['html'].='

<div class="nomCamp"><span class="obli">*</span>Apellidos:</div>

<div class="contFields">
<input name="apellidos"
 x-autocompletetype="apellidos" value="' . $value . '" class="formI ftext1" id="df_2" 
 onchange="sendDat(this.id,this.value);" tabindex="' . $tab . '"/>
</div>


<div class="clean"></div>

';
}



#################################################################### Sexo ID: 11
if(array_key_exists(11, $campos)){$value1="";$value2="";$colSel="";$tab++; $cmpT.="df_11|s,";
if(array_key_exists(11, $datSes)){$colSel="color:#444444;";if($datSes[11]==1){$value1="selected";}else{$value2="selected";};};	
$result2['html'].='

<div class="nomCamp nc_11"><span class="obli">*</span>Sexo:</div>
<div class="nomCamp nc_12"><span class="obli">*</span>Fecha de nacimiento:</div>


<div class="contFields">

<select class="formS" name="sex" 
autocomplete="on" x-autocompletetype="sex" id="df_11" 
onchange="sendDatS(this.id,this.value);" tabindex="' . $tab . '">
<option value="" class="fst" >Seleccione</option>	
<option value="1" class="nfst" ' . $value1 . '>Hombre</option>
<option value="2" class="nfst" ' . $value2 . '>Mujer</option>	
</select>
';

$sanio="";$smes="";$sdia="";$colSel="";$tab++;
if(array_key_exists(12, $datSes)){$value=$datSes[12]; $colSel="color:#444444;"; $sanio=substr($value,0,4); $smes=substr($value,4,2); $sdia=substr($value,6,2);  }


$cmpT.="df_dn|s,";
$result2['html'].='
<select class="formS" maxlength="2" name="bday-day" autocomplete="on" x-autocompletetype="bday-day" id="df_dn" onchange="sendDatS(this.id,this.value);"  tabindex="' . $tab . '">
<option value="" class="fst">Día</option>	
';



$dia=0;$tab++;
while ($dia <= 30){$dia++;
if($dia <= 9){$dia='0' . $dia;};
if($dia==$sdia){$sele="selected";}else{$sele="";}
$result2['html'].="<option value='$dia' class='fst' $sele>$dia</option>";	
}


$result2['html'].='
</select>


<select class="formS " name="bday-month" autocomplete="on" x-autocompletetype="bday-month" id="df_mn" onchange="sendDatS(this.id,this.value);" tabindex="' . $tab . '">
<option value="" class="fst">Mes</option>	
';

$mes=0;$tab++;
while ($mes <= 11){$mes++;
if($mes <= 9){$mes='0' . $mes;};
if($mes==$smes){$sele="selected";}else{$sele="";}
$result2['html'].="<option value='$mes' class='fst' $sele>$mes</option>";	
}


$result2['html'].='
</select>

<select class="formS "  name="bday-year" autocomplete="on" x-autocompletetype="bday-year" id="df_an" onchange="sendDatS(this.id,this.value);"  tabindex="' . $tab . '">
<option value="" class="fst">Año</option>	
';

$anio=2000;
while ($anio >= 1900){$anio--;
if($anio==$sanio){$sele="selected";}else{$sele="";}
$result2['html'].="<option value='$anio' class='fst' $sele>$anio</option>";	
}


$result2['html'].='
</select>
</div>


<div class="clean"></div>


';
}



#################################################################### Nacionalidad ID: 18
if(array_key_exists(18, $campos)){

$colSel="";$value="";
if(array_key_exists(18, $datSes)){$value=$datSes[18]; $colSel="color:#444444;";}
$tab++;	$cmpT.="df_18|s,";
$result2['html'].='

<div class="nomCamp"><span class="obli">*</span>Nacionalidad:</div>

<div class="contFields">
<select class="formS "  id="df_18" onchange="sendDatS(this.id,this.value);" tabindex="' . $tab . '"/>
<option value="" class="fst">Seleccione</option>	
';


foreach ($paises as $cod => $valor){
if($cod==$value){$sel="selected";}else{$sel="";};
$result2['html'].="<option value='$cod' $sel>$valor</option>";
}

$result2['html'].='
</select>
</div>


<div class="clean"></div>


';
}



#################################################################### Telefono Email ID: 4 y 3
if(array_key_exists(3, $campos)){

$dmail="";$dtel="";	$cmpT.="df_4|n,";$cmpT.="df_3|n,";
if(array_key_exists(3, $datSes)){$dmail=$datSes[3];}
if(array_key_exists(4, $datSes)){$dtel=$datSes[4];}	
$tab++;	
$result2['html'].='




<div style="position:relative; float: left; height:21px;">
<div class="nomCamp nc_4"><span class="obli">*</span>Teléfono:</div>
<div class="nomCamp nc_3"><span class="obli">*</span>E-Mail:</div>
</div>
<div class="clean"></div>

<div class="contFields">


<label style="display:none">telefono</label>
<input tabindex="' . $tab . '" name="telefono" autocomplete="on" x-autocompletetype="tel-national" value="' . $dtel . '" 
class="formI ftext1" id="df_4" onchange="sendDat(this.id,this.value);"/>
<label style="display:none">email</label>
<input tabindex="' . $tab++ . '" name="email" autocomplete="on" x-autocompletetype="email" value="' . $dmail . '" 
class="formI ftext1" id="df_3" onchange="sendDat(this.id,this.value);"/>


</div>



<div class="clean"></div>
<br>
';

}



#################################################################### Direccion ID 8
if(array_key_exists(8, $campos)){
$val="";if(array_key_exists(8, $datSes)){$val=$datSes[8];}


if(array_key_exists(26, $campos)){
$val2="";if(array_key_exists(26, $datSes)){$val2=$datSes[26];}

$result2['html'].='

<div class="nomCamp nc_8" ><span class="obli">*</span>Calle:</div>
<div class="nomCamp nc_26"><span class="obli">*</span>Num:</div>

<div class="clean"></div>



<div class="contFields calle">


<label style="display:none">Direccion</label>
<input name="address1" autocomplete="on" x-autocompletetype="address1" value="' . $val . '" class="formI ftext1" id="df_8" onchange="sendDat(this.id,this.value);"  tabindex="' . $tab . '"/>
<label style="display:none">numero</label>
<input name="numero" autocomplete="on" x-autocompletetype="numero" 
 value="' . $val2 . '" class="formI ftext1" id="df_26" onchange="sendDat(this.id,this.value);"  tabindex="' . $tab . '"/>


</div>



<div class="clean"></div>

';

}else{
	
$tab++;	$cmpT.="df_8|n,";							
$result2['html'].='

<div class="nomCamp"><span class="obli">*</span>Dirección:</div>

<div class="contFields">
<input name="address1" autocomplete="on" x-autocompletetype="address1" value="' . $val . '" 
class="formI ftext1" id="df_8" onchange="sendDat(this.id,this.value);"  tabindex="' . $tab . '"/>
</div>


<div class="clean"></div>
';						
					
				
			
		
	
}
}



#################################################################### Localidad ID 9
if(array_key_exists(9, $campos)){
$val="";if(array_key_exists(9, $datSes)){$val=$datSes[9];}
$tab++;	$cmpT.="df_9|n,";
$result2['html'].='

<div class="nomCamp"><span class="obli">*</span>Localidad:</div>

<div class="contFields">
<input name="city" autocomplete="on" x-autocompletetype="city" value="' . $val . '" class="formI ftext1" id="df_9" 
onchange="sendDat(this.id,this.value);"  tabindex="' . $tab . '"/>
</div>


<div class="clean"></div>
';
}



#################################################################### Pais Provincia CP ID 6 7 10
if(array_key_exists(6, $campos)){

$colSel1="";$value1="";$colSel2="";$value2="";
if(array_key_exists(7, $datSes)){$value1=$datSes[7]; $colSel1="color:#444444;";}
if(array_key_exists(6, $datSes)){$value2=$datSes[6]; $colSel2="color:#444444;";}	
$val="";if(array_key_exists(10, $datSes)){$val=$datSes[10];}		

$tab++;	$cmpT.="df_6|n,";$cmpT.="df_7|n,";$cmpT.="df_10|n,";
$result2['html'].='


<div class="nomCamp nc_7"><span class="obli">*</span>País:</div>
<div class="nomCamp nc_6"><span class="obli">*</span>Provincia:</div>
<div class="nomCamp nc_10"><span class="obli">*</span>C.P:</div>
<div class="clean"></div>

<div class="contFields">

	
<label style="display:none">pais</label>	
<select name="pais" autocomplete="on" x-autocompletetype="pais" 
tabindex="' . $tab . '" class="formS " id="df_7" onchange="sendDatS(this.id,this.value);">
<option value="" class="fst">Seleccione</option>	

';


foreach ($paises as $cod => $valor){
if($cod==$value1){$sel="selected";}else{$sel="";};
$result2['html'].="<option value='$cod' $sel>$valor</option>";
}




$tab++;
$result2['html'].='
</select>	

<label style="display:none">pais</label>
<select name="provincia" autocomplete="on" x-autocompletetype="provincia"  tabindex="' . $tab . '" 
class="formS " id="df_6" onchange="sendDatS(this.id,this.value);">
<option value="" class="fst">Seleccione</option>	
';


foreach ($provins as $cod => $valor){
if($cod==$value2){$sel="selected";}else{$sel="";};
$result2['html'].="<option value='$cod' $sel>$valor</option>";
}

$tab++;
$result2['html'].='
</select>	

<input tabindex="' . $tab . '" name="zip" autocomplete="on" x-autocompletetype="zip" value="' . $val . '" class="formI ftext1" 
 id="df_10" onchange="sendDat(this.id,this.value);"/>



</div>



<div class="clean"></div>


';
}



#################################################################### Nivel de estudios ID 15
if(array_key_exists(15, $campos)){
	
$colSel="";$value="";
if(array_key_exists(15, $datSes)){$value=$datSes[15]; $colSel="color:#444444;";}
$tab++;	$cmpT.="df_15|s,";
$result2['html'].='


<div class="nomCamp"><span class="obli">*</span>Nivel de estudios:</div>

<div class="contFields">
<select tabindex="' . $tab . '" class="formS " id="df_15" onchange="sendDatS(this.id,this.value);">
<option value="" class="fst">Seleccione</option>	
';


foreach ($v['vars']['estudi'] as $id => $values) {$valo=$values['s'];
if($id==$value){$sel="selected";}else{$sel="";};
$result2['html'].="<option value='$id' class='fst' $sel>$valo</option>";	
}


$result2['html'].='
</select>
</div>


<div class="clean"></div>

';
}



#################################################################### Profesion ID 16
if(array_key_exists(16, $campos)){
$val="";if(array_key_exists(16, $datSes)){$val=$datSes[16];}
$tab++;	$cmpT.="df_16|s,";
$result2['html'].='

<div class="nomCamp"><span class="obli">*</span>Profesión:</div>

<div class="contFields">
<input tabindex="' . $tab . '" name="nombre" value="' . $val . '" class="formI ftext1" id="df_16" onchange="sendDat(this.id,this.value);"/>
</div>


<div class="clean"></div>

';
}



#################################################################### Situacion actual ID 23
if(array_key_exists(23, $campos)){
$colSel="";$value="";
if(array_key_exists(23, $datSes)){$value=$datSes[23]; $colSel="color:#444444;";}
$tab++;	$cmpT.="df_23|s,";
$result2['html'].='

<div class="nomCamp"><span class="obli">*</span>Situación actual:</div>

<div class="contFields">
<select tabindex="' . $tab . '" class="formS " id="df_23" onchange="sendDatS(this.id,this.value);">
<option value="" class="fst">Seleccione</option>	
';


foreach ($v['vars']['situLab'] as $id => $values) {$valo=$values['s'];
if($id==$value){$sel="selected";}else{$sel="";};
$result2['html'].="<option value='$id' class='fst' $sel>$valo</option>";	
}


$result2['html'].='
</select>
</div>


<div class="clean"></div>

';
}








$cmpT=substr($cmpT, 0,-1);

#################################################################### Pie form

$result2['html'].='</div>';

$result['html'].=$result2['html'];




$boton='
<div class="minfoF" onclick="sndForm();"></div>
';


$result3['html']='
<div class="pieNue">


<div class="pieTx" style="">
Los campos marcados con asterisco (*), son campos obligatorios.
</div>
<div class="clean"></div>

<div class="pieTx" style="">
Al solicitar más información pulsando el botón "solicitar información" estas aceptando y dando tu conformidad a la 
<span onclick="javascript:document.getElementById(\'bases\').style.display=\'block\';"  style="font-weight:bold; cursor:pointer;">política de privacidad y condiciones de uso</span>
</div>
<div class="clean"></div>

<input type="hidden" id="cmpT" value="' . $cmpT .'">
<input type="hidden" id="valorCup" value="' . $valorCup .'">

</form>

<div id="bases" style="display: none;">
<div class="basesSeek">
<iframe scrolling="auto" height="120" frameborder="0" marginwidth="5" marginheight="5" border="0" id="poli" src="/ajx/bases/basesForm.php" class="poli" style="display: block; ">
</iframe>
</div>
';

$res=DBselect("SELECT id FROM skv_centros_legales WHERE id_centro IN ($centros);");


if(count($res)>0){
	
$result3['html'].='

<div class="basesSeek" style="display: inherit; margin-top:10px;">
<iframe class="poli" style="display: inherit; visibility:inherit;" scrolling="auto" height="80" frameborder="0" marginwidth="5" marginheight="5" border="0" id="legalCent" src="/ajx/legales.php?cents=' . $centros . '&uid=' . $uid . '">
</iframe>
</div>

';
}

$result3['html'].='
</div>
</div>
';

$result['html'].=$boton . $result3['html'];



return $result['html'];		
		
		
	
}


?>