
window.addEventListener("orientationchange", function() {
if(parseInt(getAndroidVersion()) >=3){
viewport_set();	
}else{
viewport_set_old();	
} 
}, false);



		



function viewport_set(){

if (window.matchMedia("(orientation: portrait)").matches) {
var ancho=720; 
}else{
var ancho=480;
}

//document.getElementById("tan").innerHTML=ancho;
document.getElementById("viewport").setAttribute("content", "user-scalable=0, width=" + ancho);  	
}



function viewport_set_old(){

if(screen.height > screen.width){var ancho=720;}else{var ancho=480;};

//document.getElementById("tan").innerHTML=ancho;
document.getElementById("viewport").setAttribute("content", "width=" + ancho + ", initial-scale=1.0, maximum-scale=1.0, user-scalable=0");  	
}






function viewport_setF(){

if (window.matchMedia("(orientation: portrait)").matches) {
var ancho=480; 
}else{
var ancho=720;
}

//document.getElementById("tan").innerHTML=ancho;
document.getElementById("viewport").setAttribute("content", "user-scalable=0, width=" + ancho);  	
}



function viewport_set_oldF(){

if(screen.height > screen.width){var ancho=480;}else{var ancho=720;};

//document.getElementById("tan").innerHTML=ancho;
document.getElementById("viewport").setAttribute("content", "width=" + ancho + ", initial-scale=1.0, maximum-scale=1.0, user-scalable=0");  	
}







function init(){
first();
checkCookie();	
	
}



function first(){

if(parseInt(getAndroidVersion())>=3){
viewport_setF();
}else{
viewport_set_oldF();
if(document.getElementById('cmenu')){document.getElementById('cmenu').className='oldclosed';}		
}

}




function NOexpandM(){
var cnn=document.getElementById('page').className;
var cnn=cnn.replace(' exP','');	
document.getElementById('page').className=cnn;	
}

function expandM(){
var cnn=document.getElementById('page').className + ' exP';	
document.getElementById('page').className=cnn;	
}




function getAndroidVersion(ua) {
    var ua = ua || navigator.userAgent; 
    var match = ua.match(/Android\s([0-9\.]*)/);
    return match ? match[1] : false;
}




function omenu(){
var hW =window.innerHeight;	

	document.getElementById('page').className='pageD';
	document.getElementById('page').style.height=hW + 'px';
	document.getElementById('page').style.overflow='hidden';
	document.getElementById('shadow').style.display='block';	
	document.getElementById('MmenuL').style.display='block';
	
if(parseInt(getAndroidVersion())>=3){	
document.getElementById('cmenu').className='opened';
}else{
document.getElementById('cmenu').className='oldopened';
}		

}



function cmenu(){
var hW =window.innerHeight;	

	document.getElementById('MmenuL').style.display='none';	
	document.getElementById('shadow').style.display='none';	
	document.getElementById('page').className='page';
	document.getElementById('page').style.height='inherit';
	document.getElementById('page').style.overflow='visible';
	
if(parseInt(getAndroidVersion())>=3){	
	document.getElementById('cmenu').className='closed';
}else{
document.getElementById('cmenu').className='oldclosed';	
}


}









    
