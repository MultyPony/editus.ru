<?php

class Engine {
 
    private $path_to_root = './';
    private $path_to_lang = 'include/lang/';
    private $path_to_classes = 'include/';
    private $path_to_module = 'include/';
//    var $user='';
    var $tpl='';
    var $settings = '';
    var $do='';
   
    function set_path_to_root($path) {
        $this->path_to_root = $path;
    }

    function set_path_to_module($path) {
        $this->path_to_module = $path;
    }

    function set_path_to_lang($path) {
        $this->path_to_lang = $path;
    }
    function load_main_settings() {
        if (file_exists($this->path_to_root . 'config.inc.php')) {
            include_once $this->path_to_root . 'config.inc.php';
        } else {
            throw new Exception(_NOTEXISTFILECONFIG, 4);
        }
    }

    function load_lang_error() {
        if (file_exists($this->path_to_root . $this->path_to_lang . 'errors_lang.php')) {
            include_once $this->path_to_root . $this->path_to_lang . 'errors_lang.php';
        } else{
            throw new Exception(_NOTEXISTFILELANGERRORS . ' errors_lang.php', 5);
        }
    }

    function load_class($name) {
        if (file_exists($this->path_to_root . $this->path_to_classes . $name . '_class.php')) {
            include_once $this->path_to_root . $this->path_to_classes . $name . '_class.php';
        } else {
            throw new Exception(_NOTEXISTFILECLASS . ' ' . $name . '_class.php', 6);
        }
    }
    function load_ext_class($name) {
        if (file_exists($this->path_to_root . $this->path_to_classes .'ext_libs/'. $name . '.php')) {
            include_once $this->path_to_root . $this->path_to_classes .'ext_libs/'. $name . '.php';
        } else {
            throw new Exception(_NOTEXISTFILECLASS . ' ' . $name . '.php', 6);
        }
    }

    function load_lang($name,$s=0) {
        if (file_exists($this->path_to_root . $this->path_to_lang . $name . '_lang.php')) {
            include_once $this->path_to_root . $this->path_to_lang . $name . '_lang.php';
        } elseif ($s!=1) {
            throw new Exception(_NOTEXISTFILELANG . ' ' . $name . '_lang.php', 7);
        }
    }

    function load_module($name) {
        if (file_exists($this->path_to_root . $this->path_to_module . $name . '_module.php')) {
            include_once $this->path_to_root . $this->path_to_module . $name . '_module.php';
        } else {
            throw new Exception(_NOTEXISTFILEMODULE . ' ' . $name . '_module.php', 8);
        }
    }
    function call_function(&$tpl, &$usr, $g=0) {
        $funcname = $this->do;
        if ($funcname != 'editsettings' && $funcname != 'logout' && $funcname != 'login' && $funcname != 'register' && $funcname != 'recover_password' && $funcname != 'activate') {
            $db = new Db();
            $db->query("SELECT functionId,modulName 
                        FROM Functions 
                        WHERE functionName = '".$funcname."' LIMIT 1 ");
            if ($db->num_rows() == 1 ) {
                $row = $db->fetch_object();
                if (($g==1) || (in_array($row->functionId,$usr->access()))){
                    $this->load_module($row->modulName);
                    $this->load_lang($row->modulName,1);
                    if (function_exists($funcname)){
                        $tpl->set_vars(array('content'=>$funcname($this,$tpl,$usr)),0);
                    }else{
                       throw new Exception(_NOTFINDFUNCTIONINMODULE . ' ' . $funcname, 9);
                    }
                }else{
                    throw new Exception(_NOTACCESSFUNCTION . ' ' . $funcname, 9);
                }
            } else {
                throw new Exception(_NOTFINDFUNCTION . ' ' . $funcname, 9);
            }
        }elseif ($funcname == 'editsettings'){
            if ((in_array(-1,$usr->access()))){
                $tpl->set_vars(array('content'=>Settings::editsettings()));
            }
        }
    }
    function showadminmenu(&$u){
        $db = new Db();
        $db->query("SELECT MenuAdmin.menuName, Functions.functionName, MenuAdmin.href, 
                    MenuAdmin.itemOrder, Functions.functionId, MenuAdmin.groupName
                    FROM MenuAdmin, Functions 
                    WHERE MenuAdmin.functionId = Functions.functionId  ORDER BY MenuAdmin.itemOrder ASC");
        $acs = $u->access();
        while ($row = $db->fetch_array()) {
            if ((in_array($row[4],$acs)) || strlen($row[2])>3){ 
                if ($this->do==$row['functionName']){
                    $row['active']=1;
                }else{
                    $row['active']=0;
                }
                $rows[] = $row;
            }
        }
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('menuitems' => $rows));
        $tpl->fetch('adminmenu.tpl');
        return $tpl->get_tpl();
    }
    function showusermenu(&$u){
        $db = new Db();
        $db->query("SELECT MenuUsers.menuName, Functions.functionName, MenuUsers.href, 
                           MenuUsers.itemOrder, Functions.functionId, MenuUsers.groupName
                    FROM MenuUsers, Functions 
                    WHERE MenuUsers.functionId = Functions.functionId ORDER BY MenuUsers.itemOrder ASC");
        $acs = $u->access();
        while ($row = $db->fetch_array()) {
            if ((in_array($row[4],$acs)) || strlen($row[2])>3){ 
                if ($this->do==$row['functionName']){
                    $row['active']=1;
                }else{
                    $row['active']=0;
                }
                $rows[] = $row;
            }
        }
        if ($u->is_admin()){
            $rows[]=array('menuName'=>'Admin panel',
                          'functionName'=>'',
                          'href'=>'./admin/index.php',
                          'itemOrder'=>'98',
                          'functionId'=>'',
                          'groupName'=>'Admin');
        }
        $tpl = new Template();
        $tpl->set_path('templates/');
        $tpl->set_vars(array('menuitems' => $rows));
        $tpl->fetch('usermenu.tpl');
        return $tpl->get_tpl();
    }
    function messuser($mess,$type=0,$nh=false){
        $tpl = new Template();
        $tpl->set_path('templates/');
        if($type==1){
            $tp='ok';
        }
        if($type==0){
            $tp='error';
        }
        if($type==2){
            $tp='inf';
        }
        if ($nh){
            $nh='-nh';
        }else{
            $nh='';
        }
        $tpl->set_vars(array('mess' => $mess, 'type' => $tp,'nh'=>$nh));
        $tpl->fetch('message.tpl');
        $this->tpl->set_vars(array('mess'=> $tpl->get_tpl()),0);
    }
    
    function mail($to,$sub,$mess,$from='', $html = 'auto'){
        $this->load_ext_class('phpmailer/class.phpmailer');
        $mail = new PHPMailer(true);
        try {
            if (Settings::$v['mail']['smtp'] == 1){
                $mail->IsSMTP();
                $mail->Host       = Settings::$v['mail']['smtp_host']; // SMTP server
                $mail->SMTPAuth   = Settings::$v['mail']['smtp_auth'];  
                $mail->SMTPSecure = Settings::$v['mail']['smtp_secure'];
                $mail->Port       = Settings::$v['mail']['smtp_port'];                    // set the SMTP port for the GMAIL server
                $mail->Username   = Settings::$v['mail']['smtp_user']; // SMTP account username
                $mail->Password   = Settings::$v['mail']['smtp_pass'];        // SMTP account password
            }else{
                $mail->IsMail();
            }
            if (is_array($to)){
                for($i=0;$i<count($to);$i++) {
                    if ($i==0){
                        $mail->AddAddress($to[$i]);
                    }else{
                        $mail->AddBCC($to[$i]);                
                    }
                }
            }else{
                $mail->AddAddress($to);
            }
            if (empty($from)){
                $from = Settings::$v['mail']['def_from'];
            }
            $mail->SetFrom($from,'Editus');
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $sub;
            $mail->Body = $mess;
            if ($html == 'auto'){
                if (is_numeric(strpos($mess, '<html'))){
                    $mail->IsHTML(true);    
                }else{
                    $mail->IsHTML(false);   
                }
            }else{
                $mail->IsHTML($html);  
            }
            //$mail->Send();
        } catch (phpmailerException $e) {
            if (Main_config::$debug==1){
                echo $e->errorMessage();
            }
        }
            
    }
    static function pagesql(){
        if (!isset($_GET['p'])){
            $_GET['p']=1;
        }
        $l1 = (intval($_GET['p'])-1) * (intval(Settings::$v['onpage']));
        $l2 = Settings::$v['onpage'];
        $pagesql = "LIMIT ".$l1.", ".$l2;
        return $pagesql;
    }
    static function pagetpl( $count, $action,$ad=false){
        if ($count > Settings::$v['onpage']){
            $pages = intval($count/Settings::$v['onpage']);
            if ($count%Settings::$v['onpage'] > 0){
                $pages+=1;
            }
            if (!isset($_GET['p'])){
                $_GET['p']=1;
            }
            $tpl = new Template();
            if ($ad){
                $tpl->set_path('../templates/admin/');
            }
            $tpl->set_vars(array('pages' => $pages,'action'=>$action, 'curpage'=>intval($_GET['p'])));
            $tpl->fetch('listpage.tpl');
            return $tpl->get_tpl();  
        }
    }
}

?>
