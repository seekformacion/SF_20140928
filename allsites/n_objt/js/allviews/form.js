
function sndForm(){
$.ajaxSetup({'async': true});
//console.log('sndForm');
var no0="";
var no3=""; var no6=""; var no8=""; var no11=""; var nodn="";
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
				
				
		}else{
				
		}
				
	}
}	
}

	if(document.getElementById('df_dn')){
	if(!document.getElementById('df_dn').value){no0++;var nodn='Campos obligatorios';document.getElementById('df_dn').className='formS_e ';}else{document.getElementById('df_dn').className='formS ';}
	if(!document.getElementById('df_mn').value){no0++;var nodn='Campos obligatorios';document.getElementById('df_mn').className='formS_e ';}else{document.getElementById('df_mn').className='formS ';}
	if(!document.getElementById('df_an').value){no0++;var nodn='Campos obligatorios';document.getElementById('df_an').className='formS_e ';}else{document.getElementById('df_an').className='formS ';}
	}
	
	
	
	
	
	
    if(no3){
	
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
    
 
    }	

	if(no6){
    
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
		no0++;	
		
		}else{
		cln=cln.replace('formI_e ','formI ');	
		
		}
    document.getElementById('df_10').className=cln;
    
    
    		
    }
    
    if(document.getElementById('df_11')){
    if(no11){
    document.getElementById('df_11').className='formS_e';
 	    }else{
    document.getElementById('df_11').className='formS';	
   }}



if(!no0){chkLegales();sendCupon();}
	
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



function sendCupon(){

vcup=document.getElementById('valorCup').value;
vcup=Math.round(Number(vcup));
//ga('send', 'event', 'MasInfo','enviado','enviado',vcup);

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




function sendDatC(cmp,centro,val){$.ajaxSetup({ cache: false });
$.ajaxSetup({'async': true});

uid=window.top.ckk;	
if(!uid){uid=getCookie('seekforID');}

val=encodeURIComponent(val);
var url='/ajx/updtUserDataC.php?uid=' + uid + '&cmp=' + cmp + '&val=' + val + '&centro=' + centro;
$.getJSON(url,function(data) {$.each(data, function(key, val) {});});	

	
}

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

/*
if(!document.getElementById('todo')){
document.getElementById('formdinamico').innerHTML=document.getElementById('cupOK').innerHTML;
}else{
document.getElementById('todo').innerHTML=document.getElementById('cupOK').innerHTML;	
document.getElementById('todo').style.width='540px';
if(window.top.isM){document.getElementById("viewport").setAttribute("content", "width=540, user-scalable=no");}
}
*/
alert('Tus datos han sido enviados correctamente.')
}
