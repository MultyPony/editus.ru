<?php 
$ref = $_SERVER['QUERY_STRING']; 
if ( !empty($ref) ) $ref = '?'.$ref; 
header('HTTP/1.1 301 Moved Permanently'); 
header('Location: //editus.ru/new/equip.html'.$ref); 
exit(); 
?>
