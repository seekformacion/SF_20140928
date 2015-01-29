<?php
header('Access-Control-Allow-Origin: *');
echo $_SERVER['HTTP_X_FORWARDED_FOR'];
?>
