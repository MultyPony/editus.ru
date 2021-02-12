<?php
function dbbackup() {
    $folder = '../../mysqldump/';
    if (isset($_POST['deldump'])){
        unlink($folder.$_POST['deldump']);
    }
    if (isset($_FILES['uploadsql'])){
       exec('mysql '.Main_config::$db.' --user='.Main_config::$user.' --password='.Main_config::$password.' < '.$_FILES['uploadsql']['tmp_name']);
    }
    if (isset($_POST['filename'])){
        $filename = $folder.$_POST['filename'];
        if(file_exists($filename))
        {
           $fp = @fopen($filename, "rb");
           if ($fp)
           {
              header("Content-type: text/plain ");
              header("Content-Length: " . filesize($filename));
              header("Content-Disposition: attachment; filename=dump.sql ");
              header('Content-Transfer-Encoding: binary');
              header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
              fpassthru($fp);
              exit;
           }
        }
    }
    if (isset($_POST['savedump'])){
        $name = $folder.'dump_'.date("ymd_H-i").'.sql';
        exec('mysqldump  '.Main_config::$db.' --user='.Main_config::$user.' --password='.Main_config::$password.' --add-drop-table > '.$name );
    }
    $files = array();
    if ($handle = opendir($folder)) {
        while (false !== ($file = readdir($handle))) { 
            if ($file !== '.' && $file !== '..'){ 
                $files[] = $file;
            }
        }
        closedir($handle); 
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data, 'action'=>'index.php?do=dbbackup','files'=>$files));
    $tpl->fetch('dbbackup.tpl');
    return $tpl->get_tpl();
}
function laststat(){
    $db = new Db();
    $db->query("SELECT userFirstName, userLastName, userEmail 
                FROM Users 
                WHERE lastLogin > '".date('Y-m-d H:i:s', mktime(0, 0, 0, date("m"), date("d")-5, date("Y")))."' ");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    return var_export($rows);
}
?>
