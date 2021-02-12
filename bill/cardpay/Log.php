<?php
/**
 * User: vasia
 * Date: 01/12/14
 * Time: 16:33
 */
include_once "../../config.inc.php";
include_once "../../include/db_class.php";

class Log {

    static function save($data){
        $db = new Db();
        $data = serialize($data);
        $sql = "INSERT INTO `CardPayAvangardLog` (`data`) VALUES ( '" . $data . "' ) ";
        $db->query($sql);
    }
} 