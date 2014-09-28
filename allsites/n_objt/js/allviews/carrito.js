

// del carrito


function showSl2(x){
 $("#alSld:not(:animated)").animate({left:x}, 500);

//$('#alSld:not(:animated)').animate({scrollLeft:x},600);
	
	
}


function cuforMove(d){
var nc=document.getElementById('cc').value;
var max=(nc-1)*(-60);
	
var position = $("#cntCurF").position();
  
var top=position.top;
if(d==2){var x=top-60;}else{var x=top+60;}

if(x<max){x=0;}
if(x>0){x=max;}

var counter=((x/60)*-1)+1;
counter2=counter + '/' + nc; 
document.getElementById('counter').innerHTML=counter2;

$("#cntCurF:not(:animated)").animate({top:x}, 400);
 	
}


function showSl(x){
 
if (jQuery.browser.msie == true) { 

	if (jQuery.browser.version < 9.0){
	$("#em-2:not(:animated)").scrollLeft(x);
	}else{ 
	$("#em-2:not(:animated)").animate({scrollLeft:x}, 500);
	}
 
 
}else{
$("#em-2:not(:animated)").animate({scrollLeft:x}, 500);
}	


	
}




function selpC(p){
var cn=document.getElementById('P' + p).className;	
var scn=cn.replace('nact','');
if(scn.length < cn.length){
	
for (i=1 ; i <= 5; i++){if(document.getElementById('P' + i)){
document.getElementById('P' + i + 'c').setAttribute("style", "visibility:hidden;");	
var icn=document.getElementById('P' + i).className;	
var iscn=icn.replace('act','');
if(iscn.length < icn.length){
	document.getElementById('P' + i).className=iscn + " nact";
	document.getElementById('fp' + i).className="fnacti iconos";}
	
}}

document.getElementById('P' + p).className=scn + " act";
document.getElementById('fp' + p).className="facti iconos";
}
document.getElementById('P' + p + 'c').setAttribute("style", "visibility:visible;");			
}


function scrll(p,w){
var hei=$("#" + p).height();
var hei=(Number(hei)* -1) + 100;
	
var pos=document.getElementById(p).style.top;
pos=pos.replace('px','');pos=Number(pos);
if(w==0){pos=pos+103}
if(w==1){pos=pos-103}

if(pos>0){pos=0;}
if(pos<=hei){pos=hei;}


if (jQuery.browser.msie == true) { 

	if (jQuery.browser.version < 9.0){
	document.getElementById(p).setAttribute("style", "top:" + pos + 'px;');	
	}else{ 
	$("#" + p + ":not(:animated)").animate({top:pos}, 500);
	}
 
 
}else{
$("#" + p + ":not(:animated)").animate({top:pos}, 500);
}





}


function changePRO(){
var pais=document.getElementById(10).value;
if(pais!='ES'){
document.getElementById(11).value=99;	
}else{

if(document.getElementById(11).value==99){	
document.getElementById(11).value=0;
}
		
}	
}


function changePAIS(){
var pro=document.getElementById(11).value;
if(pro==99){
if(document.getElementById(10).value=='ES'){	
document.getElementById(10).value=0;
}	
}else{
if(document.getElementById(10).value!='ES'){	
document.getElementById(10).value='ES';
}}}


function showdoit(){
document.getElementById('showdoit').setAttribute("style", "visibility:inherit;");	
setTimeout('showdoit2();', 1000);	
}

function showdoit2(){
document.getElementById('timer').setAttribute("style", "visibility:hidden;");	
document.getElementById('fin').setAttribute("style", "visibility:inherit;");
}


function revi2(){

var doit=1;
for (a=8 ; a<=12 ; a++){
var cnt="";
var cnt = document.getElementById(a).value; if(cnt==0){cnt="";};

if(!cnt){doit=0;

document.getElementById('e'+ a).innerHTML="Campo obligatorio.";
document.getElementById('e'+ a).setAttribute("style", "visibility:inherit;");

var clas=document.getElementById(a).className; 
clas=clas.replace('bdc1','bdcE');
clas=clas.replace('color2_BG','color2_B_GE');
document.getElementById(a).className=clas; 		
}else{

document.getElementById('e'+ a).innerHTML="";
document.getElementById('e'+ a).setAttribute("style", "visibility:hidden;");
var clas=document.getElementById(a).className; 
clas=clas.replace('bdcE','bdc1');
clas=clas.replace('color2_B_GE','color2_BG');
document.getElementById(a).className=clas; 
	
}

var pro=document.getElementById(11).value;
var cp=document.getElementById(12).value;
var cp2=document.getElementById(12).value;
cp=cp.substring(0,2);

if(pro && cp){
if(pro!=cp){doit=0;
	
document.getElementById('e12').innerHTML="No coincide con la provincia";
document.getElementById('e12').setAttribute("style", "visibility:inherit;");

var clas=document.getElementById(12).className; 
clas=clas.replace('bdc1','bdcE');
clas=clas.replace('color2_BG','color2_B_GE');
document.getElementById(12).className=clas; 



}else{

setCookie("geoCP",cp2,365);
window.top.geoCP=cp2;

document.getElementById('e12').innerHTML="";
document.getElementById('e12').setAttribute("style", "visibility:hidden;");
var clas=document.getElementById(12).className; 
clas=clas.replace('bdcE','bdc1');
clas=clas.replace('color2_B_GE','color2_BG');
document.getElementById(12).className=clas; 

	
}}


}	


if(doit){showdoit();setcupon();};	
}	


function setcupon(){

uid=window.top.ckk;

var url='/ajx/setcupon.php?uid=' + uid;
$.getJSON(url, function(data) {
$.each(data, function(key, val) {
	
});
});
	
}


function revi1(){

var doit=1;
for (a=1 ; a<=7 ; a++){
var cnt="";

var cnt = document.getElementById(a).value; if(cnt==0){cnt="";}; cnt=cnt.replace('dd/mm/aaaa','');
if(!cnt){doit=0;

document.getElementById('e'+ a).innerHTML="Campo obligatorio.";
document.getElementById('e'+ a).setAttribute("style", "visibility:inherit;");

var clas=document.getElementById(a).className; 
clas=clas.replace('bdc1','bdcE');
clas=clas.replace('color2_BG','color2_B_GE');
document.getElementById(a).className=clas; 		
}else{

document.getElementById('e'+ a).innerHTML="";
document.getElementById('e'+ a).setAttribute("style", "visibility:hidden;");
var clas=document.getElementById(a).className; 
clas=clas.replace('bdcE','bdc1');
clas=clas.replace('color2_B_GE','color2_BG');
document.getElementById(a).className=clas; 
	
}
	
}


if(document.getElementById(4).value!='dd/mm/aaaa'){
	
}

if(document.getElementById(6).value!=''){if(!chkMail()){doit=0;}}

if(document.getElementById(5).value!=''){if(!chkPhone()){doit=0;}}

var naci=document.getElementById(4).value; naci=naci.replace('dd/mm/aaaa','');
if(naci!=''){if(!chkNacimiento()){doit=0;}}

	
if(doit){showSl(2400);};	
}

/*
function insVals(){if(!window.top.fields){window.top.fields=new Array;window.top.fields[0]="";}

for (a=1; a<=12 ; a++){
var val = document.getElementById(a).value; val=val.replace('|','/');
window.top.fields[a]=val;	
}
var datos= window.top.fields.join('|');

if(datos!=getCookie("datos")){
setCookie('datos',datos,365);	
insDatos(datos);
}

}
*/

function insDatos(datos){
uid=window.top.ckk;		
var url='/ajx/insDatos.php?uid=' + uid + '&datos=' + datos;
$.getJSON(url, function(data) {


});	

	
}


function chkPhone(){
var phone=document.getElementById('df_4').value; 
phone=phone.replace(/ /g,'');
phone=phone.replace(/\+/g,'');
phone=phone.replace(/\-/g,'');
phone=phone.replace(/\(/g,'');
phone=phone.replace(/\)/g,'');

var pattern=/^[0-9]+$/;	
if((pattern.test(phone))&&(phone.length>=9)){ 
return true;   
    }else{   
return false;
    }
	
	
}



function chkNacimiento(){
var naci=document.getElementById(4).value;
var pattern=/^(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[0-2])\/(19|20)\d{2}$/;	
if(pattern.test(naci)){ 
document.getElementById('e4').innerHTML="";
document.getElementById('e4').setAttribute("style", "visibility:hidden;");
var clas=document.getElementById(4).className; 
clas=clas.replace('bdcE','bdc1');
clas=clas.replace('color2_B_GE','color2_BG');
document.getElementById(4).className=clas; 
	
	        
return true;   
    }else{   

document.getElementById('e4').innerHTML="Fecha incorrecta";
document.getElementById('e4').setAttribute("style", "visibility:inherit;");

var clas=document.getElementById(4).className; 
clas=clas.replace('bdc1','bdcE');
clas=clas.replace('color2_BG','color2_B_GE');
document.getElementById(4).className=clas;
return false;
    }


	
}


function chkMail(){
var mail=document.getElementById('df_3').value;
var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
if(pattern.test(mail)){ 
return true;   
    }else{   
return false;
    }	
}


function getURLSOC(red){
uid=window.top.ckk;	
var url='/ajx/getURLSOC.php?uid=' + uid + '&red=' + red;
$.getJSON(url,function(data) {
$.each(data, function(key, val) {
doSOC(val,red);
});
});		
	
}

function doSOC(url,red){
var dats=url.split('|');
var url=dats[0]; var url2=dats[1];

if(red=='face'){
var pagina="https://www.facebook.com/dialog/feed?app_id=673960869311429&display=popup&caption=Me gustaría que me dierais vuestra opinión sobre los siguientes cursos&link=" + url +  "&redirect_uri=" + url2;	
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
}

if(red=='tweet'){
var pagina="http://twitter.com/share?text=Me gustaría que me dierais vuestra opinión sobre los siguientes cursos&url=" + url;
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";

}


if(red=='gplus'){
var pagina="https://plus.google.com/share?url=" + url;	
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=390, top=85, left=140";

}



window.open(pagina,"soc",opciones);
	
}


function facebook(){
	var urlsoc=getURLSOC('face');	
}

function tweet(){
	var urlsoc=getURLSOC('tweet');	
}


function gplus(){
	var urlsoc=getURLSOC('gplus');	
}


// new form


function sndForm(){
$.ajaxSetup({'async': true});
//console.log('sndForm');
var no0="";
var no3=""; var no6=""; var no8=""; var no11="";
for (i=1 ; i <= 50; i++){
	
	if(document.getElementById('df_' + i)){
	var cln=document.getElementById('df_' + i).className; 	
	val=document.getElementById('df_' + i).value;
	
	if(!val){no0++;
	cln=cln.replace('formI ','formI_e '); cln=cln.replace('formS ','formS_e ');	document.getElementById('df_' + i).className=cln;	
	}else{
	cln=cln.replace('formI_e ','formI '); cln=cln.replace('formS_e ','formS ');	document.getElementById('df_' + i).className=cln;	
	}
		}else{val="";}
	
	
	if(i==3){
	if (!val){var no3=no3+ 'E-mail obligatorio';}else{chkMail();}
	
	}else if(i==4){if (!val){if(!no3){var no3='Teléfono obligatorio';}else{var no3='Teléfono y Mail obligatorios';}}
	}else if(i==6){if (!val){var no6='Campos obligatorios';}
	}else if(i==7){if (!val){var no6='Campos obligatorios';}
	}else if(i==10){if(!val){var no6='Campos obligatorios';}
	
	}else if(i==8){if (!val) {var no8='Campos obligatorios';}
	}else if((i==26)&&(document.getElementById('df_26'))){if (!val){var no8='Campos obligatorios';}
	
	}else if(i==11){if( (!val)&&(document.getElementById('df_11')) ){var no11='Campos obligatorios';}	
		
	}else{	
		
		if(document.getElementById('df_' + i)){	
		if (!val){
				document.getElementById('et_' + i).innerHTML='Campo obligatorio';	
				document.getElementById('e_' + i).style.visibility='inherit';
		}else{
				document.getElementById('e_' + i).style.visibility='hidden';
		}
				
	}
}	
}

	if(document.getElementById('df_dn')){
	if(!document.getElementById('df_dn').value){var no11='Campos obligatorios';document.getElementById('df_dn').className='formS_e ';}else{document.getElementById('df_dn').className='formS ';}
	if(!document.getElementById('df_mn').value){var no11='Campos obligatorios';document.getElementById('df_mn').className='formS_e ';}else{document.getElementById('df_mn').className='formS ';}
	if(!document.getElementById('df_an').value){var no11='Campos obligatorios';document.getElementById('df_an').className='formS_e ';}else{document.getElementById('df_an').className='formS ';}
	}
	
	
	
	if(document.getElementById('et_8')){
	if(no8){
    document.getElementById('et_8').innerHTML=no8;	
	document.getElementById('e_8').style.visibility='inherit';	
    }else{
	document.getElementById('e_8').style.visibility='hidden';
	}
	}
	
	
    if(no3){
    document.getElementById('et_3').innerHTML=no3;	
	document.getElementById('e_3').style.visibility='inherit';	
    }else{
    	
    var chkM=chkMail();	
    var chkT=chkPhone();	
    
    var clnT=document.getElementById('df_4').className;
    var clnM=document.getElementById('df_3').className; 
    
    if(!chkT)				{no0++;no3="Teléfono incorrecto"	;clnT=clnT.replace('formI ','formI_e ');}else{clnT=clnT.replace('formI_e ','formI ');};
    if(!chkM)				{no0++;no3="Mail incorrecto"		;clnM=clnM.replace('formI ','formI_e ');}else{clnM=clnM.replace('formI_e ','formI ');};
    if((!chkM)&&(!chkT))	{no0++;no3="Teléfono y Mail incorrectos";}
    
    document.getElementById('df_4').className=clnT;
    document.getElementById('df_3').className=clnM;
    
    if(no3){
    document.getElementById('et_3').innerHTML=no3;	
	document.getElementById('e_3').style.visibility='inherit';
    }else{
    document.getElementById('e_3').style.visibility='hidden';		
    }
    }	

	if(no6){
    document.getElementById('et_6').innerHTML=no6;	
	document.getElementById('e_6').style.visibility='inherit';	
    }else{
    
    
    // checkeo CP
    var pro=document.getElementById('df_6').value; 
	var cpo=document.getElementById('df_10').value; 	
	var cp=cpo;
			
			cp3=cp.substring(0,3);
			if((cp3=='077') || (cp3=='078')){
			cp=cp3;	
			}else{
			cp=cp.substring(0,2); 
			cp=cp + '0';	
			}
		
	var cln=document.getElementById('df_10').className; 		
	if((pro!=cp)&&(pro!=999)){
		cln=cln.replace('formI ','formI_e '); 
		document.getElementById('et_6').innerHTML='El C.P. no coincide con la provincia';no0++;	
		document.getElementById('e_6').style.visibility='inherit';	
		}else{
		cln=cln.replace('formI_e ','formI ');	
		document.getElementById('e_6').style.visibility='hidden';	
		}
    document.getElementById('df_10').className=cln;
    
    
    		
    }
    
    if(no11){
    document.getElementById('et_11').innerHTML=no11;	
	document.getElementById('e_11').style.visibility='inherit';	
    }else{
    if(document.getElementById('e_11')){
    document.getElementById('e_11').style.visibility='hidden';		
    }}



if(!no0){chkLegales();sendCupon();}
	
}

function chkLegales(){if(document.getElementById('legalCent')){
var cents=document.getElementById('Cents').value;
cnts=cents.split(',');
//console.info(cnts);

		var iframe = document.getElementById('legalCent');
		var innerDoc = iframe.contentDocument || iframe.contentWindow.document;

for (a=0; a<=cnts.length ; a++){var centro=cnts[a];

		for (i=1 ; i <= 50; i++){
		if(innerDoc.getElementById('df_' + centro + "_" + i)){cmp='df_' + centro + "_"+ i;
		
		
		if((i==29)||(i==30)||(i==31)||(i==38)){
			if(innerDoc.getElementById(cmp).checked){var val=1;}else{var val=0;}
		}else{
			var val=innerDoc.getElementById(cmp).value;	
		}
		
		sendDatC(i,centro,val);
		}}	
}
	
}}


function saveallCamp(){
val=document.getElementById('cmpT').value;	
camps=val.split(',');	
//console.info(camps);
for (var a=0 ; a < camps.length ; a++){
var camp=camps[a];
datos=camp.split('|'); var id=datos[0]; var tip=datos[1];
//console.log('id:' + id + ' tip:' + tip);
if(document.getElementById(id)){
if(tip=='n'){sendDat(id,document.getElementById(id).value)}
if(tip=='s'){sendDatS(id,document.getElementById(id).value)}	
}}

if(!document.getElementById('todo')){
document.getElementById('formdinamico').innerHTML=document.getElementById('cupOK').innerHTML;
}else{
document.getElementById('todo').innerHTML=document.getElementById('cupOK').innerHTML;	
document.getElementById('todo').style.width='540px';
if(window.top.isM){document.getElementById("viewport").setAttribute("content", "width=540, user-scalable=no");}
}


}


function sendCupon(){

vcup=document.getElementById('valorCup').value;
vcup=Math.round(Number(vcup));
ga('send', 'event', 'MasInfo','enviado','enviado',vcup);

$.ajaxSetup({ cache: false });
$.ajaxSetup({'async': true});


uid=window.top.ckk;
if(!uid){uid=getCookie('seekforID');}

val=document.getElementById('cursosCup').value;	
var url='/ajx/sendCupon.php?uid=' + uid + '&cursos=' + val;
$.getJSON(url,function(data) {$.each(data, function(key, val) {
if(key=='ok'){
window.top.idcupon=val;	
saveallCamp();		
}	
});});
	
}

function sendDatS(cmp,val){
$.ajaxSetup({'async': true});
if(val){
document.getElementById(cmp).style.color='#444444';

if((cmp=='df_dn')||(cmp=='df_mn')||(cmp=='df_an')){
val=document.getElementById('df_an').value + document.getElementById('df_mn').value + document.getElementById('df_dn').value;
cmp='df_12';
//console.log('Naci:' + val);
if(val.length < 8){val='';};
}


if((cmp=='df_7')&&(val!='ES')){document.getElementById('df_6').value='999';sendDat('df_6','999');}
if((cmp=='df_7')&&(val=='ES')){document.getElementById('df_6').value='';sendDat('df_6','');}
if((cmp=='df_6')&&(val!='999')){document.getElementById('df_7').value='ES';sendDat('df_7','ES');}
if((cmp=='df_6')&&(val=='999')){document.getElementById('df_7').value='';sendDat('df_7','');}

if(cmp=='df_6'){
if(document.getElementById('lpdonde')){

var lpd=document.getElementById('lpdonde').value;
var lpd2=lpd.replace(val,'');
if(lpd == lpd2){alert(document.getElementById('lpdondeE').value);};

}
}


if((cmp=='df_15')&&(val < Number(document.getElementById('esmin').value))){alert(document.getElementById('esminE').value);}

if(val){sendDat(cmp,val);};
}else{document.getElementById(cmp).style.color='#888888';}
}





function sendDatC(cmp,centro,val){$.ajaxSetup({ cache: false });
$.ajaxSetup({'async': true});

uid=window.top.ckk;	
if(!uid){uid=getCookie('seekforID');}

val=encodeURIComponent(val);
var url='/ajx/updtUserDataC.php?uid=' + uid + '&cmp=' + cmp + '&val=' + val + '&centro=' + centro;
$.getJSON(url,function(data) {$.each(data, function(key, val) {});});	

	
}



function sendDat(cmp,val){$.ajaxSetup({ cache: false });
$.ajaxSetup({'async': true});
cmp=cmp.replace('df_','');


uid=window.top.ckk;	
if(!uid){uid=getCookie('seekforID');}

		if((cmp==10)||(cmp==6)){
		var pro=document.getElementById('df_6').value; 
		var cpo=document.getElementById('df_10').value; 	
		var cp=cpo;
			
			cp3=cp.substring(0,3);
			if((cp3=='077') || (cp3=='078')){
			cp=cp3;	
			}else{
			cp=cp.substring(0,2); 
			cp=cp + '0';	
			}
		
		
		if(pro==cp){
		setCookie("geoCP",cp,365);
		window.top.geoCP=cp;	
		var url='/ajx/chkCP.php?uid=' + uid + '&cp=' + cpo;
		$.getJSON(url,function(data) {$.each(data, function(key, val) {});});	
		
		}
			
		}


uid=window.top.ckk;
if(!uid){uid=getCookie('seekforID');}	
val=encodeURIComponent(val);
var url='/ajx/updtUserData.php?uid=' + uid + '&cmp=' + cmp + '&val=' + val;
$.getJSON(url,function(data) {$.each(data, function(key, val) {});});	

	
}


function closeW(){
window.close();	
}

function goContest(){
var idcup=window.top.idcupon;
var idp=window.top.idport;
var url="https://www.seekformacion.com/ajx/fb/cApple.php?ref=CUP_" + idcup + '&idp=' + idp;
//alert(url);
window.location.href=url;	
}	

