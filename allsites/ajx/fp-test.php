<?php




require '/www/repositorios/facebook-php-sdk/src/facebook.php';

$app_id = "622071311181276";
$app_secret = "24c6ad4ef66b34ec0fd74021bfd0fb5a";
$facebook = new Facebook(array(
'appId' => $app_id,
'secret' => $app_secret,
'cookie' => true
));
$signed_request = $facebook->getSignedRequest();
$like_status = $signed_request["page"]["liked"];

if ($like_status) {

echo "<br>
EL USUARIO DIOOO A MEGUSTAAAAAA
<br>";

$url= $facebook->getLoginUrl(array("scope" => "publish_stream,publish_actions"));

echo "<br><br>";


$permissions = $facebook->api("/me/permissions");



if( array_key_exists('publish_actions', $permissions['data'][0]) ) {
    // Permission is granted!
    echo "we have permission";
	echo "<br><br>";
	
} else {
    // We don't have the permission
    echo "no perms";
    echo "<br><br>";
	
    $login_url = $facebook->getLoginUrl( array( 'scope' => 'publish_actions' ) );
      echo 'Please <a href="' . $login_url . '">login.</a>';
}


	
	
}else{

echo "<br>
EL USUARIO NO DIO A MEGUSTA
<br>";	
	
}

?>


<script>
	window.open('<?php echo $url; ?>','popup','width=300,height=400');
</script>



