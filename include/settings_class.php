<?php

class Settings {
    static $v = array();
    
    function __construct() {

        $db = new Db();
        $db->query("SELECT * 
                    FROM Settings
                    WHERE gew = '1'");
        while ($row = $db->fetch_array()) {
            if ($row['is_ser']==1){
                self::$v[$row['settingName']]=unserialize($row['settingData']);
            }else{
                self::$v[$row['settingName']]=$row['settingData'];
            }
        }
    }
    static function getsetting($name,$nuarray='') {
        $db = new Db();
        $db->query("SELECT * 
                    FROM Settings
                    WHERE settingName = '".$name."'");
        $row = $db->fetch_array();
        if ($row['is_ser']==1){
            if ($nuarray==''){
                return unserialize($row['settingData']);
            }else{
                $t = unserialize($row['settingData']);
                return $t[$nuarray];
            }
        }else{
            return $row['settingData'];
        }
    }
    function add($name,$data){
        $db = new Db();
        if (!is_string($data) && !s_numeric($data) && is_array($data)){
            $data = serialize($data);
        }
        $db->query("INSERT INTO Settings
                    SET settingName = '".$name."',
                        settingData = '".$data."'");
    }
    static function editsettings(&$tpl,&$usr){
            $db = new Db();
            if (isset($_POST['onpage']) && isset($_POST['defgroup'])){
                $db->query("UPDATE Settings
                            SET settingData = '".intval($_POST['onpage'])."'
                            WHERE settingName = 'onpage' ");
                $db->query("UPDATE Settings
                            SET settingData = '".intval($_POST['defgroup'])."'
                            WHERE settingName = 'defgroup' ");
                $db->query("UPDATE Settings
                            SET settingData = '".intval($_POST['managegroup'])."'
                            WHERE settingName = 'managegroup' ");
                $db->query("UPDATE Settings
                            SET settingData = '".intval($_POST['typograthgroup'])."'
                            WHERE settingName = 'typograthgroup' ");
                header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=editsettings");
            }
            if (isset($_POST['mail'])){
                if (!isset($_POST['mail']['smtp_auth'])){
                    $_POST['mail']['smtp_auth'] =0;
                }
                if (!isset($_POST['mail']['smtp'])){
                    $_POST['mail']['smtp'] =0;
                }
                $db->query("UPDATE Settings
                            SET settingData = '".  serialize($_POST['mail'])."'
                            WHERE settingName = 'mail' ");
                header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=editsettings");
            }
            if (isset($_POST['ftp'])){
                $db->query("UPDATE Settings
                            SET settingData = '".  serialize($_POST['ftp'])."'
                            WHERE settingName = 'ftp' ");
                header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=editsettings");
            }
            $db->query("SELECT groupId, groupName 
                        FROM Groups");
            while ($row = $db->fetch_array()){
                $groups[] = $row;
            }
            $ntpl = new Template();
            $ntpl->set_path('../templates/admin/');
            $ntpl->set_vars(array('data' => Settings::$v,'groups'=>$groups));
            $ntpl->fetch('editsettings.tpl');
            return $ntpl->get_tpl();
    }
}

?>
