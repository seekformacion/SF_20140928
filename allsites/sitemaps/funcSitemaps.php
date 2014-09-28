<?php

if( ! ini_get('date.timezone') )
{
   date_default_timezone_set('GMT');
}



function GetURLtoCACHE($idp){global $v;
$cc=0; 
$d=date('d')-1; if(strlen($d)==1){$d="0" . $d;}
$hoy=(date('Y') . date('m') . date('d') . date('H') . date('i') . date('s'))*1;
#################3 compruebo numero de url a realizar por iteracion.. 720 interaciones en 5 dias cada 10 min
$limit=10;
$dcats=DBselect("select count(id) as tot from util_cache where idp IN ($idp);");
if(array_key_exists(1, $dcats)){$tot=$dcats[1]['tot'];$limit=round(($tot/500),0);};
echo "\nlimite $limit\n\n";

//$limit=100;



$dt=date('Y') . date('m') . date('d');
$dcats=DBselect("select id, url, tipo, idp from util_cache where idp IN ($idp) AND ldate < $hoy ORDER BY ldate ASC limit $limit;");

if(count($dcats)>0){foreach($dcats as $key => $val){

$id=$val['id'];	
$tipo=$val['tipo'];
//$t_id=$val['t_id'];
$url=$val['url'];
$idppp=$val['idp'];
$idpp=$v['vars']['purl'][$idppp];
$idpp2=str_replace('http://', '', $idpp);

//echo "URL: $url \n";
$cc++;
$urlsH[$cc][1]=$idpp;
$urlsH[$cc][2]=$idpp2;
$urlsH[$cc][3]=$url;

	

						/*    RECAHEO DE LOS REDIRECCIONAMIENTOS
						$dcats=DBselect("select Redir, url from skf_urls where idp = ($idppp) AND t_id ='$t_id' AND tipo=$tipo;"); 
						if(count($dcats)>0){
						$redir=$dcats[1]['Redir'];
						if($redir){
							
						$url2=$dcats[1]['url']; 
						$redir=str_replace('.html', '', $redir);	
						$url2=str_replace('.html', '', $url2);
							
						$urlR=str_replace($url2, $redir, $url);
						//echo $urlR . "\n";
						
						if($urlR!=$url){
							
						$cc++;
						$urlsH[$cc][1]=$idpp;
						$urlsH[$cc][2]=$idpp2;
						$urlsH[$cc][3]=$urlR;
						
						//refress($idpp,$idpp2,$urlR);
							
						}else{
						
							
						}
						
						
						}}
						*/


	
}}

if(count($urlsH)>0){foreach($urlsH as $kk => $valor){
refressB($valor[1],$valor[2],$valor[3]);
}}

if(count($urlsH)>0){foreach($urlsH as $kk => $valor){
refressG($valor[1],$valor[2],$valor[3]);
}}

	
}


function createSitemap($idp){global $v;

$homes[1]=1;
$homes[1183]=1;
$homes[2365]=1;
$homes[3547]=1;


$ruta= $v['path']['httpd'];
$port=$v['vars']['purl'][$idp]; 
$port=str_replace('http://', '', $port); 
$ruta=str_replace('cursodecursos.com', $port, $ruta);

echo "\n";
echo $ruta;
echo "\n";
echo "\n";


$SiteTXT="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n\n";


$dupli=array();
$res=DBselect("SELECT * FROM util_sitemap WHERE idp=$idp ORDER BY tipo;");
if(array_key_exists(1, $res)){ foreach ($res as $key => $value) {
$id=$value['id']; $idc=$value['t_id']; $url=$value['url']; $pri=$value['prior']; $date=$value['date']; $chksum=$value['chksum'];


if($pri <= 1){$pri=1;};
$pri=($pri/10);	
if($pri==1){$pri="1.0";};	
if(!array_key_exists($url, $dupli)){$SiteTXT .="<url>\n<loc>$url</loc>\n</url>\n\n";$dupli[$url]=1;} //echo "<url>\n<loc>$url</loc>\n<priority>$pri</priority>\n</url>\n\n";
echo "#";

}}

$SiteTXT.="</urlset>\n";

echo "\n";echo "\n";
echo $ruta . "/sitemap.xml";
echo "\n";echo "\n";

$myFile = $ruta . "/sitemap.xml";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = $SiteTXT;
fwrite($fh, $stringData);
fclose($fh);	

$ppp=$v['vars']['purl'][$idp];	
$urlR=$v['vars']['purl'][$idp] . "/sitemap.xml";	
refress($ppp,$port,$urlR);	
}


function getPageDevices($url){
$devices[]="Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.9 Safari/536.5";
$devices[]="User agent: Mozilla/5.0 (Linux; Android 4.3; SPH-L710 Build/JSS15J) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.99 Mobile Safari/537.36";

foreach ($devices as $key => $dev) {
$c = curl_init($url);
curl_setopt($c, CURLOPT_VERBOSE, true);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_USERAGENT, $dev);
$page = curl_exec($c);
curl_close($c);	
}	

$hoy=(date('Y') . date('m') . date('d') . date('H') . date('i') . date('s'))*1;
DBUpIns("UPDATE util_cache SET ldate=$hoy WHERE url='$url';");
}


function refress($idpp,$idpp2,$url){

$url2=str_replace($idpp, '', $url);

if($url2==""){$url2="/";};

exec("varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $idpp2 && req.url == $url2\"") . "\n";

//echo "varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $idpp2 && req.url == $url2\"" . "\n";

sleep(2);
//echo "GET: \n";	
getPageDevices($url);	

}



function refressB($idpp,$idpp2,$url){

$url2=str_replace($idpp, '', $url);

if($url2==""){$url2="/";};

exec("varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $idpp2 && req.url == $url2\"") . "\n";

echo "varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $idpp2 && req.url == $url2\"" . "\n";

sleep(1);
//echo "GET: \n";	
//getPageDevices($url);	

}




function refressG($idpp,$idpp2,$url){

$url2=str_replace($idpp, '', $url);

if($url2==""){$url2="/";};

//exec("varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $idpp2 && req.url == $url2\"") . "\n";
//echo "varnishadm -T 127.0.0.1:6082 -S /etc/varnish/secret ban \"req.http.host == $idpp2 && req.url == $url2\"" . "\n";

sleep(3);
//echo "GET: \n";	
getPageDevices($url);	

}













function doitC($idp,$idc,$url){global $sqlI;global $v;
$dt=date('Y') . date('m') . date('d');
$url=$v['vars']['purl'][$idp] . $url;$dt="";
$sqlI[]="(2,$idp,$idc,'$url',5,'$dt'),";

}

function doit($idp,$idc,$url,$c,$mets){global $sqlI;global $v;
$cpp=$v['conf']['cpp'];		$dt=date('Y') . date('m') . date('d');
//echo "$idc - $url - $c \n";
//print_r($mets);	
$p=10;
if( substr($url, 0,4) != "http"){ $url=$v['vars']['purl'][$idp] . $url;};$dt="0"; //$url=str_replace('http://', '', $url);
$sqlI[]="(1,$idp,$idc,'$url',$p,'$dt'),";

	if(count($mets)>0){
	$pags=ceil($c/$cpp);
		if($pags > 1){$a=2;
			while ($a <= $pags) {$p--;
			$url2=str_replace('.html', '-pag' . $a . '.html', $url);$a++;$dt="0";
			$sqlI[]="(1,$idp,$idc,'$url2',$p,'$dt'),";	
			}
		}
	
	$p=9;
	if($mets['D']>0){$cd=$mets['D']; 
	$url2=str_replace('.com/', '.com/a_distancia/', $url);
	$url2=str_replace('.html', '_a_distancia.html', $url2);
	$pags=ceil($cd/$cpp);	
	if($pags > 0){$a=1;
		while ($a <= $pags) {
	    	if($a==1){$dt="0";
			$sqlI[]="(1,$idp,$idc,'$url2',$p,'$dt'),";					
			}else{$p--;	
			$url3=str_replace('.html', '-pag' . $a . '.html', $url2);$dt="0";
			$sqlI[]="(1,$idp,$idc,'$url3',$p,'$dt'),";	
			}$a++;
	}}}
	
	
	$p=9;
	if($mets['O']>0){$cd=$mets['O']; 
	
	$url2=str_replace('.com/', '.com/online/', $url);
	$url2=str_replace('.html', '_online.html', $url2);
	$pags=ceil($cd/$cpp);	
	if($pags > 0){$a=1;
		while ($a <= $pags) {
	    	if($a==1){$dt="0";
			$sqlI[]="(1,$idp,$idc,'$url2',$p,'$dt'),";					
			}else{$p--;	
			$url3=str_replace('.html', '-pag' . $a . '.html', $url2);$dt="0";
			$sqlI[]="(1,$idp,$idc,'$url3',$p,'$dt'),";	
			}$a++;
	}}}
	
	
	if(array_key_exists('idP', $mets)){
	if($mets['idP']>0){foreach($mets['idP'] as $idpro => $cd){$p=9;
	
	$url2=str_replace('.com/', '.com/presencial/' . normaliza($v['vars']['provN'][$idpro]) . '/', $url);	
	$url2=str_replace('.html', '_presenciales_en_' . normaliza($v['vars']['provN'][$idpro]) . '.html', $url2);
	$pags=ceil($cd/$cpp);	
	if($pags > 0){$a=1;
		while ($a <= $pags) {
	    	if($a==1){$dt="0";
			$sqlI[]="(1,$idp,$idc,'$url2',$p,'$dt'),";					
			}else{$p--;	$dt="0";
			$url3=str_replace('.html', '-pag' . $a . '.html', $url2);
			$sqlI[]="(1,$idp,$idc,'$url3',$p,'$dt'),";	
			}$a++;
	
	
	}}}}}
	
	
	
	
	
	}	

	
}

function getINF($idc){$c=0;
$res=DBselect("select id from skf_cats where superiores like '%|$idc|%' ORDER BY id;");$lC=""; //echo 	"select id from skf_cats where superiores like '%|$idc|%' ORDER BY id; \n" ;
if(array_key_exists('1', $res)){foreach ($res as $key => $value) {$lC.=$value['id'] . ",";};$lC=substr($lC, 0,-1);};

if($lC){
$res=DBselect("select count(id) as c FROM skv_relCurCats WHERE id_cat IN ($lC) AND showC=1"); 	//echo "select count(id) as c FROM skv_relCurCats WHERE id_cat IN ($lC) AND showC=1 \n";
if(array_key_exists('1', $res)){$c=$res[1]['c'];};
}
return $c;	
}

function getMET($idc,$idp){global $curs;

$res=DBselect("SELECT id_cur FROM skv_relCurCats WHERE id_cat=$idc AND showC=1;");
if(array_key_exists('1', $res)){foreach ($res as $kk => $val){$curs[$val['id_cur']]=$idp;}};
	
$res=DBselect("SELECT count(id) as c FROM skv_relCurCats WHERE id_cat=$idc AND id_metodo IN (4) AND showC=1;");
if(array_key_exists('1', $res)){$c['D']=$res[1]['c'];};
$res1=DBselect("SELECT count(id) as c FROM skv_relCurCats WHERE id_cat=$idc AND id_metodo IN (5) AND showC=1;");	
if(array_key_exists('1', $res1)){$c['O']=$res1[1]['c'];};
$res2=DBselect("SELECT count(id) as c FROM skv_relCurCats WHERE id_cat=$idc AND id_metodo NOT IN (4,5) AND showC=1;");
if(array_key_exists('1', $res2)){$c['P']=$res2[1]['c'];
	
	if($c['P']>0){
	$res3=DBselect("SELECT id_cur FROM skv_relCurCats WHERE id_cat=$idc AND id_metodo NOT IN (4,5) AND showC=1;");$lC="";
	foreach ($res3 as $key => $value) {$lC.=$value['id_cur'] . ",";};$lC=substr($lC, 0,-1);
	$res=DBselect("SELECT idpro, count(id) as c FROM skv_relCurPro WHERE idcur IN ($lC) GROUP BY idpro;"); 
	if(array_key_exists('1', $res)){$idps=array();
	foreach ($res as $key => $value) {
		$pro=$value['idpro']; $pro=substr($pro, 0,3);
		if(($pro=='077')||($pro=='078')){}else{$pro=substr($pro, 0,2) . "0";};
		if(array_key_exists($pro, $idps)){$idps[$pro]=$idps[$pro]+$value['c'];}else{$idps[$pro]=$value['c'];}	
		}
	$c['idP']=$idps;	
	}}
}	


return $c;	
}

function refressUCACHE(){$bor=array();$add=array();
$a=1;
while($a<=3){
	$res=DBselect("select url, idp FROM util_sitemap WHERE tipo=$a AND url NOT IN (select url FROM util_cache WHERE tipo=$a) limit 500;");
	if(count($res)>0){foreach($res as $kk => $val){$t_id=$val['url']; $idp=$val['idp']; $add[$a][$t_id]=$idp;}};			
	
	$res=DBselect("select id FROM util_cache WHERE tipo=$a AND url NOT IN (select url FROM util_sitemap WHERE tipo=$a) limit 500;");
	if(count($res)>0){foreach($res as $kk => $val){$id=$val['id']; $bor[]=$id;}};
			
	$a++;	
}	

$ladds="";
if(count($add)>0){foreach ($add as $tipo => $dats) {foreach($dats as $t_id => $idp){
$ladds .="($tipo,$idp,'$t_id'),";	
}}
$ladds=substr($ladds, 0,-1);
DBUpIns("INSERT INTO util_cache (tipo,idp,url) VALUES $ladds;");	
}

$lbor="";
if(count($bor)>0){foreach ($bor as $kk => $id) {
$lbor .="$id,";	
}
$lbor=substr($lbor, 0,-1);
DBUpIns("DELETE FROM util_cache WHERE id IN ($lbor);");
}

	
}

?>