<?php
require_once '/local/http/editus.ru/www/config.inc.php';
require_once '/local/http/editus.ru/www/include/db_class.php';
require_once '/local/http/editus.ru/www/include/engine_class.php';


exec("ps aux | grep send.ph[p] | grep -v grep",$process);
if  (count($process)>1){
//    exit;
}
$z = new Engine();
$z->set_path_to_root('/local/http/editus.ru/www/');

$z->load_class('settings');
new Settings();

$Db = new Db();
$sql = "SELECT * FROM `DeferredMailer` WHERE `isSend` = '0' AND `sendDate` < UNIX_TIMESTAMP(CURDATE()+INTERVAL 23 HOUR +INTERVAL 59 MINUTE)";
$Db->query($sql);

if ($Db->num_rows() == 0){
    exit;
}
$ids_complete = array();

while($row = $Db->fetch_array()){
    try {
        $z->mail($row['recipients'], $row['subj'], $row['name'] . "\n\n" . $row['body'], array('noreply@angelson.ru','AngelSon'));
    } catch (Exception $e) {
var_dump($e);
        continue;
    }
    $ids_complete[] = "'".$row['id']."'";
}
if (count($ids_complete) > 0) {
    $Db = new Db();
    $sql = "UPDATE `DeferredMailer` SET `isSend` = '1' WHERE `id` IN ( " . implode(',', $ids_complete) . " )";
    $Db->query($sql);
}


