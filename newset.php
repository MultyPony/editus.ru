<?php
$v['mail']['smtp'] = 1;
$v['mail']['smtp_host']='mx.fgcs.ru'; 
$v['mail']['smtp_auth']=true;        
$v['mail']['smtp_port']='25';           
$v['mail']['smtp_user']='noreplyeditus@banuchka.ru';
$v['mail']['smtp_pass']='editus';
$v['mail']['smtp_secure']='tls';
$v['mail']['def_from'] ='noreply@editus.ru';

echo '|'.serialize($v['mail']).'|';
?>
