<?php 
$ref = $_SERVER['QUERY_STRING']; 
if ( !empty($ref) ) $ref = '?'.$ref; 
header('HTTP/1.1 301 Moved Permanently'); 
header('Location: //<?php echo $_SERVER['SERVER_NAME'];?>/new/equip.html'.$ref); 
exit(); 
?>
