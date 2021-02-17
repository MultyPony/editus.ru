<?php

class User {
//    var $engine;

    function register(&$e) {
        $tpl = new Template();
        $tpl->set_path('templates/');
        $actiono = '';
        if (isset($_GET['o'])){
            $actiono.='&o='.$_GET['o'];       
        }
        if (isset($_POST['userEmail'])) {
            $userFirstName = trim($_POST['userFirstName']);
            $userEmail = trim($_POST['userEmail']);
            $userPassword = trim($_POST['userPassword']);
            $userPasswordConf = trim($_POST['userPasswordConf']);
            $userLastName = trim($_POST['userLastName']);
            $userAdditionalName = trim($_POST['userAdditionalName']);
            $userTelephone = trim($_POST['userTelephone']);
            if (!empty($userFirstName) && !empty($userEmail) && !empty($userPassword) && !empty($userTelephone)) {
                if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $userEmail)){
                    if (strlen($userFirstName) > 3){
                        if (strlen($userTelephone) >= 5){
                            if (strlen($userPassword) >= 5){
                                if ($userPassword == $userPasswordConf){
                                    $db = new Db();
                                    $db->query("SELECT * 
                                                FROM Users 
                                                WHERE userEmail = '".$db->mres($userEmail)."'");
                                    if (($db->num_rows()) < 1){
                                        for ($p = 0; $p < 8; $p++) {
                                            $val = rand(1, 16);
                                            $key = dechex($val);
                                            $newkey = $newkey . $key;
                                        }
                                        $db->query("INSERT INTO Users 
                                                    SET userFirstName = '".$db->mres($userFirstName)."', 
                                                        userEmail = '".$db->mres($userEmail)."', 
                                                        userPassword = '" . sha1($userPassword) . "', 
                                                        userLastName ='".$db->mres($userLastName)."', 
                                                        userAdditionalName='".$db->mres($userAdditionalName)."', 
                                                        userTelephone='".$db->mres($userTelephone)."' ");
                                        $db->query("INSERT INTO UsersActivation 
                                                    SET userId = LAST_INSERT_ID(), 
                                                        activationKey='".$newkey."' ");
                                        
                                        
                                        $ar_search = array('_USERNAME','_USERLASTNAME','_ACTIVATELINK');
                                        $ar_replace = array($userFirstName,$userLastName,'//'.$_SERVER['HTTP_HOST'].'/'.Main_config::$main_file_name.'?do=activate&key=' . $newkey.$actiono);
                                        
                                        $e->mail($userEmail, str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_subj')), str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_text')));

                                        $e->mail(Main_config::$debugmail, 'Editus', 'Зарегистрирован новый пользователь '.$userFirstName.' '.$userEmail."\n ( id - ".$_SESSION['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');

                                        $tpl->set_vars(array('send'=>'1'));
                                        $e->messuser(_R_REGISTEROK,1,true);
                                    }else{
                                        $e->messuser(_R_EXISTEMAIL);
                                    }
                                }else{
                                    $e->messuser(_R_PASSWORDNOTMATCH);
                                }
                            }else{
                                $e->messuser(_R_SHOTPASSWORD);
                            }
                        }else{
                                $e->messuser(_R_SHOTPHONE);
                        }
                    }else{
                        $e->messuser(_R_SHOTUSERNAME);
                    }                    
                }else{
                    $e->messuser(_R_INCORRECTEMAIL);
                }
            }else{
                $e->messuser(_R_FILLFORM);
            } 
        }
        $action[0] = Main_config::$main_file_name . '?do=login';
        $action[1] = Main_config::$main_file_name . '?do=recover_password';
        $action[2] = Main_config::$main_file_name . '?do=register';
        if (isset($_GET['pj'])){
            $action[0].='&amp;pj='.$_GET['pj'];
            $action[1].='&amp;pj='.$_GET['pj'];
            $action[2].='&amp;pj='.$_GET['pj'];
        }
        $tpl->set_vars(array('action'=>$action));
        $tpl->fetch('register.tpl');
        return $tpl->get_tpl();
    }

    function recover_password(&$e) {
        $tpl = new Template();
        $tpl->set_path('templates/');
        if (isset($_POST['userEmail'])) {
            $userEmail = trim($_POST['userEmail']);
            $db = new Db();
            if (!empty($userEmail)) {
                if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $userEmail)) {
                    $db->query("SELECT * 
                                FROM Users 
                                WHERE userEmail = '".$db->mres($userEmail)."'");
                    if (($db->num_rows()) == 1){
                        for ($p = 0; $p < 6; $p++) {
                            $val = rand(1, 16);
                            $pass = dechex($val);
                            $newpass = $newpass . $pass;
                        }
                        $row = $db->fetch_array();
                        $userFirstName = $row['userFirstName'];
                        $userLastName = $row['userLastName'];
                        $db->query("UPDATE Users 
                                    SET userPassword='".sha1($newpass)."' 
                                    WHERE userEmail = '".$db->mres($userEmail)."'");
                        
                        $ar_search = array('_USERNAME','_USERLASTNAME','_NEWPASS');
                        $ar_replace = array($userFirstName,$userLastName,$newpass);
                        $e->mail($userEmail, str_replace($ar_search, $ar_replace, Settings::getsetting('mailrecoverpass','mailrecoverpass_subj')), str_replace($ar_search, $ar_replace, Settings::getsetting('mailrecoverpass','mailrecoverpass_text')));
                        $e->messuser(_RP_NEWPASSSENDOK,1,true);
                        $tpl->set_vars(array('send'=>'1'));
                     }else{
                        $e->messuser(_RP_NOEXISTEMAIL);
                    }
                }else{
                    $e->messuser(_RP_INCORRECTEMAIL);
                }
            }else{
                $e->messuser(_RP_FILLEMAIL);
            }
        }
        $action[0] = Main_config::$main_file_name . '?do=login';
        $action[1] = Main_config::$main_file_name . '?do=recover_password';
        $action[2] = Main_config::$main_file_name . '?do=register';
        if (isset($_GET['pj'])){
            $action[0].='&amp;pj='.$_GET['pj'];
            $action[1].='&amp;pj='.$_GET['pj'];
            $action[2].='&amp;pj='.$_GET['pj'];
        }
        $tpl->set_vars(array('action'=>$action));
        $tpl->fetch('recoverpassword.tpl');
        return $tpl->get_tpl();
    }

    function login(&$e) {
        $actionloc = $_SERVER['PHP_SELF'].'?do=listprojects';
        if (isset($_GET['pj'])){
            $actionloc.='&pj='.$_GET['pj'];       
        }else{
            if (!empty ($_POST['lastdo'])){
                $actionloc=$_POST['lastdo'];
            }
        }
        if (isset($_POST['userEmail'])) {
            $userEmail = trim($_POST['userEmail']);
            $userPassword = sha1(trim($_POST['userPassword']));
            $db = new Db();
            if (!empty($userEmail) && !empty($userPassword)) {
                 if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $userEmail)) {
                     $db->query("SELECT userId 
                                 FROM Users 
                                 WHERE userEmail = '".$db->mres($userEmail)."' AND 
                                       userPassword = '".$db->mres($userPassword)."' AND 
                                       userIsActive = '1'");
                     if ($db->num_rows() == 1) {
                        $res=$db->fetch_object();
                        $_SESSION['userEmail'] = $userEmail;
                        $_SESSION['userId'] = $res->userId;
                        $e->mail(Main_config::$debugmail, 'Editus', 'Вошел пользователь '.$_SESSION['userEmail']."\n ( id - ".$_SESSION['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');
                        header("Location: //".$_SERVER['HTTP_HOST'].$actionloc);
                        exit();
                     }else{
                         $e->messuser(_L_INCOORECT);
                     }
                   
                 }else{
                     $e->messuser(_L_INCORRECTEMAIL);
                 }
            }else{
                $e->messuser(_L_FILLFORM);
            }
        }
        $tpl = new Template();
        $tpl->set_path('templates/');
        $lastdo = $_SERVER['REQUEST_URI'];
        $action[0] = Main_config::$main_file_name . '?do=login';
        $action[1] = Main_config::$main_file_name . '?do=recover_password';
        $action[2] = Main_config::$main_file_name . '?do=register';
        if (isset($_GET['pj'])){
            $action[0].='&amp;pj='.$_GET['pj'];
            $action[1].='&amp;pj='.$_GET['pj'];
            $action[2].='&amp;pj='.$_GET['pj'];
        }
        $tpl->set_vars(array('action'=>$action,'lastdo'=>$lastdo));
        $tpl->fetch('login.tpl');
        return $tpl->get_tpl();
    }
        function adminlogin() {
        if (isset($_POST['userEmail'])) {
            $userEmail = trim($_POST['userEmail']);
            $userPassword = sha1(trim($_POST['userPassword']));
            $db = new Db();
            if (empty($userEmail) || empty($userPassword)) {
                return _FILLFORM;
            } elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $userEmail)) {
                return _INCORRECTEMAIL;
            }
            $db->query("SELECT Users.userId FROM Users, Groups WHERE Users.userEmail = '$userEmail' AND Users.userPassword = '$userPassword' AND Users.userIsActive = '1' AND Users.userGroupId = Groups.groupId AND Groups.adminAccess = '1'");
            if ($db->num_rows() != 1) {
                return _INCOORECT;
            } else { 
                $res=$db->fetch_object();
                $_SESSION['userEmail'] = $userEmail;
                $_SESSION['userId'] = $res->userId;
                $_SESSION['admin'] = '1';
                
                header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
                exit();

            }
        }
    }
    function logout(){
        if ($this->is_user()){
            unset ($_SESSION['userEmail']);
            unset ($_SESSION['userId']);
            unset($_SESSION['admin']);
            header("Location: //".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
            exit();
        }
    }
    function activate(&$e) {
        $tpl = new Template();
        $tpl->set_path('templates/');
        if (isset($_GET['key'])) {
            $db = new Db();
            $db->query("SELECT userId 
                        FROM UsersActivation 
                        WHERE activationKey = '".$db->mres($_GET['key'])."' ");
             if (($db->num_rows()) == 1) {
                $row=$db->fetch_array();
                $db->query("UPDATE Users 
                            SET userIsActive='1',
                                userGroupId = '".Settings::$v['defgroup']."'
                            WHERE userId = '".$row['userId']."' ");
                $db->query("DELETE 
                            FROM UsersActivation 
                            WHERE activationKey = '".$db->mres($_GET['key'])."' ");
                $e->messuser(_A_USERACTIVATE,1,true);
                $e->mail(Main_config::$debugmail, 'Editus', 'Пользователь выполнил активацию '.$_SESSION['userEmail'].'/n ('.$row['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');
             }else {
                $e->messuser(_A_KEYNOTEXIST,0,true);
            }
        }
        $action[0] = Main_config::$main_file_name . '?do=login';
        $action[1] = Main_config::$main_file_name . '?do=recover_password';
        $action[2] = Main_config::$main_file_name . '?do=register';
        if (isset($_GET['pj'])){
            $action[0].='&amp;pj='.$_GET['pj'];
            $action[1].='&amp;pj='.$_GET['pj'];
            $action[2].='&amp;pj='.$_GET['pj'];
        }
        $tpl->set_vars(array('action'=>$action));
        $tpl->fetch('activate.tpl');
        return $tpl->get_tpl();
    }
    function is_user(){
       if(isset($_SESSION['userEmail'])){
           return TRUE;
       }
    }
    function is_admin(){
       if($_SESSION['admin']=='1'){
           return TRUE;
       }
    }    
    function access(){
        $db = new Db();
        $db->query("SELECT Functions.functionId 
                    FROM Functions, Users, GroupsAccess, RolesAccess 
                    WHERE Users.userId = '".$_SESSION['userId']."' AND 
                          Users.userGroupId = GroupsAccess.groupId AND
                          GroupsAccess.roleId = RolesAccess.roleId AND
                          RolesAccess.functionId = Functions.functionId");
        $rows = array();
        while ($row=$db->fetch_array()){
            $rows[]=$row[0];               
        }
        return $rows;

    }
}

?>
