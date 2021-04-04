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
                                        $newkey = '';
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
                                                        userTelephone='".$db->mres($userTelephone)."',
                                                        userIsActive = '1',
                                                        userGroupId = '11' ");
                                        // $db->query("INSERT INTO UsersActivation
                                                    // SET userId = LAST_INSERT_ID(),
                                                        // activationKey='".$newkey."' ");


                                        // $ar_search = array('_USERNAME','_USERLASTNAME','_ACTIVATELINK');
                                        // $ar_replace = array($userFirstName,$userLastName,'//'.$_SERVER['HTTP_HOST'].'/'.Main_config::$main_file_name.'?do=activate&key=' . $newkey.$actiono);

                                        // $e->mail($userEmail, str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_subj')), str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_text')));

                                        // $e->mail(Main_config::$debugmail, 'Editus', 'Зарегистрирован новый пользователь '.$userFirstName.' '.$userEmail."\n ( id - ".$_SESSION['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');

                                        $tpl->set_vars(array('send'=>'1'));
                                        // $e->messuser(_R_REGISTEROK,1,true);
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
    function register_partner(&$e) {
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
                                        $db->query("INSERT INTO Users
                                                    SET userFirstName = '".$db->mres($userFirstName)."',
                                                        userEmail = '".$db->mres($userEmail)."',
                                                        userPassword = '" . sha1($userPassword) . "',
                                                        userLastName ='".$db->mres($userLastName)."',
                                                        userAdditionalName='".$db->mres($userAdditionalName)."',
                                                        userTelephone='".$db->mres($userTelephone)."',
                                                        isPartner = 1,
                                                        userIsActive = 1");
                                        $db->query("SELECT LAST_INSERT_ID()");
                                        $insert_id = $db->fetch_array();
                                        $insert_id = $insert_id[0];
                                        $db->query("INSERT INTO PartnersData
                                                    SET userId = '".$insert_id."',
                                                        partnerName='".$db->mres($_POST['userTitle'])."' ");
                                        if (isset($_FILES["userLogo"])){
                                            $image = new Imagick($_FILES['userLogo']['tmp_name']);
                                            $pathdir = './partner_logo/logo_'.intval($insert_id);
                                            if (($image->getImageFormat () == 'JPEG') || ($image->getImageFormat () == 'PNG')){
                                                $image->adaptiveResizeImage(250,0);
                                                $image->writeImage($pathdir.'.jpg');
                                            }
                                        }

//                                        $ar_search = array('_USERNAME','_USERLASTNAME','_ACTIVATELINK');
//                                        $ar_replace = array($userFirstName,$userLastName,'//'.$_SERVER['HTTP_HOST'].'/'.Main_config::$main_file_name.'?do=activate&key=' . $newkey.$actiono);

//                                        $e->mail($userEmail, str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_subj')), str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_text')));

//                                        $e->mail(Main_config::$debugmail, 'Editus', 'Зарегистрирован новый пользователь '.$userFirstName.' '.$userEmail."\n ( id - ".$_SESSION['userId'].' '.$_SERVER['HTTP_USER_AGENT'].')');

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
        $action[2] = Main_config::$main_file_name . '?do=register_partner';
        if (isset($_GET['pj'])){
            $action[0].='&amp;pj='.$_GET['pj'];
            $action[1].='&amp;pj='.$_GET['pj'];
            $action[2].='&amp;pj='.$_GET['pj'];
        }
        $tpl->set_vars(array('action'=>$action));
        $tpl->fetch('register_partner.tpl');
        return $tpl->get_tpl();
    }
    function genpass($len = 6){
        $newpass = '';
        for ($p = 0; $p < $len; $p++){
            $val = rand(1, 16);
            $pass = dechex($val);
            $newpass .= $pass;
        }
        return $newpass;
    }
    function register_from_partner(&$e){
        $token = $_GET['token'];
        $curTime = date('YmdHis', mktime(date("H"), date("i"), 0, date("m"), date("d"), date("Y")));
        $ttl = substr($token,-14);
        if ($ttl - $curTime<=0){
            echo 'Token time expired';
            return;
        }
        $hash = substr($token,-14-32,32);
        $userEmail = base64_decode(substr($token, 0, -14-32));

        $db = new Db();
        $db->query("SELECT userId AS partnerId, partnerName, partnerKey
                    FROM PartnersData");
        $partnerData = '';
        while ($row = $db->fetch_array()){
            if (md5($row['partnerKey'].$ttl)==$hash){
                $partnerData = $row;
                $db->query("SELECT *
                            FROM Users
                            WHERE userEmail = '".$db->mres($userEmail)."' ");
                $data = $db->fetch_array();
                if (($db->num_rows()) == 0){
                    $new_password = $this->genpass();
                    $db->query("INSERT INTO Users
                                SET userEmail = '".$db->mres($userEmail)."',
                                    userPassword = '" . sha1($new_password) ."',
                                    partnerId = '".$partnerData['partnerId']."',
                                    userIsActive='1',
                                    userGroupId = '".Settings::$v['defgroup']."'
                                    ");
                    $db->query("SELECT LAST_INSERT_ID()");
                    $insert_id = $db->fetch_array();
                    $insert_id = $insert_id[0];

                    $_SESSION['userEmail'] = $userEmail;
                    $_SESSION['userId'] = $insert_id;

//                    $ar_search = array('_USERNAME','_USERLASTNAME','_ACTIVATELINK');
//                    $ar_replace = array($userFirstName,$userLastName,'//'.$_SERVER['HTTP_HOST'].'/'.Main_config::$main_file_name.'?do=activate&key=' . $newkey.$actiono);

                    $e->mail($userEmail, 'Ваш пароль для входа на editus.ru : '.$new_password);
                    $action = 'project.php';
                    header("Location: //".$_SERVER['HTTP_HOST'].'/'.$action);

//                    $e->mail($userEmail, str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_subj')), str_replace($ar_search, $ar_replace, Settings::getsetting('mailregister','mailregister_text')));

//                    $tpl->set_vars(array('send'=>'1'));
//                    $e->messuser(_R_REGISTEROK,1,true);
                }else{
                    if ($data['partnerId']==0){
                        $action = Main_config::$main_file_name.'?do=login';
                        header("Location: //".$_SERVER['HTTP_HOST'].'/'.$action);
                    }else{
                        $_SESSION['userEmail'] = $data['userEmail'];
                        $_SESSION['userId'] = $data['userId'];
                        $action = 'project.php';
                        header("Location: //".$_SERVER['HTTP_HOST'].'/'.$action);
                    }
                }
            }
        }
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
                            $newpass = (isset($newpass) ? $newpass : '') . $pass;
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
            $userPassword = sha1($_POST['userPassword']);
            $db = new Db();
            if (!empty($userEmail) && !empty($userPassword)) {
                 if (preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $userEmail)) {
                     $db->query("SELECT userId, isPartner, partnerId
                                 FROM Users
                                 WHERE userEmail = '".$db->mres($userEmail)."' AND
                                       userPassword = '".$db->mres($userPassword)."' AND
                                       userIsActive = '1' ");
                     if ($db->num_rows() == 1) {
                        $res=$db->fetch_object();
                        $_SESSION['userEmail'] = $userEmail;
                        $_SESSION['userId'] = $res->userId;
                        $_SESSION['partnerId'] = $res->partnerId;
                        if ($res->isPartner==1){
                             $_SESSION['myPartnerId'] = $res->userId;
                        }
                        $db->query("UPDATE Users SET lastLogin = '".date('Y-m-d H:i:s')."' WHERE userId = '".$res->userId."' ");
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
            $userPassword = sha1(($_POST['userPassword']));
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
            unset($_SESSION['myPartnerId']);
            unset($_SESSION['partnerId']);
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
