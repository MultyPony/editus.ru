<?php

function listusers(&$e,&$t) {
    $db = new Db();
    $db->query("SELECT Users.userId, Users.userFirstName, Users.userLastName,
                       Users.userAdditionalName, Users.userEmail, Users.userRegistrationDate, Groups.groupName
                FROM Users, Groups
                WHERE Groups.groupId = Users.userGroupId");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('listusers.tpl');
    return $tpl->get_tpl();
}
function usersmailer(){
    $db = new Db();
    if (isset($_POST['subj']) && isset($_POST['umails']) && isset($_POST['mess'])){
        $sm = serialize($_POST['umails']);
        $db->query("INSERT INTO UsersMailer
                    SET usersEmail = '".$sm."',
                        remainUsersEmail = '".$sm."',
                        subj = '".$_POST['subj']."',
                        mess = '".$_POST['mess']."' ");
    }
    $db->query("SELECT mailerId, usersEmail, subj, mess, mailerDate, isSend, isStart
                FROM UsersMailer
                WHERE isSend = '1' ".Engine::pagesql()." ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $db->query("SELECT count(*)
                FROM UsersMailer
                WHERE isSend = '1' ");
    $count = $db->fetch_array();
    $db->query("SELECT Users.userId, Users.userEmail, Users.userFirstName, Groups.groupName, Users.userGroupId
                FROM Users, Groups
                WHERE Groups.groupId = Users.userGroupId AND
                      Users.userGroupId <> 0 AND
                      subscMailer = '1' ORDER BY Users.userGroupId");
    while ($row = $db->fetch_array()) {
        $users[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'users'=>$users,'pages'=> Engine::pagetpl($count['0'], 'index.php?do=usersmailer',true)));
    $tpl->fetch('usersmailer.tpl');
    return $tpl->get_tpl();
}

function listformats(&$m) {
    $db = new Db();

    $db->query("SELECT formatName, formatWidth, formatHeight, formatInA3 FROM PaperFormat");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('listformats.tpl');
    return $tpl->get_tpl();
}

function editgroups(&$m) {
    $db = new Db();
    
    if (isset($_POST['newgroupsname'])) {
        $db->query("INSERT INTO Groups SET groupName = '{$_POST['newgroupsname']}'");
        $db->query("INSERT INTO GroupsAccess SET groupId= LAST_INSERT_ID(), roleId = '{$_POST['newgroupsrole']}' ");
    }
    if (isset($_POST['delgroups'])) {
        $db->query("DELETE FROM Groups WHERE groupId = '{$_POST['idgroup']}'");
        $db->query("DELETE FROM GroupsAccess WHERE groupId = '{$_POST['idgroup']}'");
    }
    if ((isset($_POST['editgroupsname']) || isset($_POST['editgroupsrole'])) && !isset($_POST['delgroups'])) {
        if (isset($_POST['adminaccess'])) {
            $adminaccess = ", adminAccess = '1' ";
        } else {
            $adminaccess = ", adminAccess = '0' ";
        }

        $db->query("UPDATE Groups SET groupName = '{$_POST['editgroupsname']}'{$adminaccess} WHERE groupId = '{$_POST['idgroup']}' ");
        $db->query("UPDATE GroupsAccess SET roleId = '{$_POST['editgroupsrole']}' WHERE groupId = '{$_POST['idgroup']}' ");
    }
    $db->query("SELECT Groups.groupId, Groups.groupName, Groups.adminAccess, GroupsAccess.roleId FROM Groups, GroupsAccess WHERE Groups.groupId = GroupsAccess.groupId");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $db->query("SELECT * FROM Roles");
    while ($row = $db->fetch_array()) {
        $rows2[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('groups' => $rows, 'roles' => $rows2));
    $tpl->fetch('editgroups.tpl');
    return $tpl->get_tpl();
}

function edituser(&$m) {
    $db = new Db();
    
    if (isset($_POST['edituserid'])) {
        if (isset($_POST['edituseractivation'])) {
            $activation = ", userIsActive = '1'";
        } else {
            $activation = ", userIsActive = '0'";
        }
        if (!empty($_POST['edituserpassword'])) {
            $npass = " userPassword='" . sha1($_POST['edituserpassword']) . "', ";
        } else {
            $npass = '';
        }
        $db->query("UPDATE Users SET userFirstName='{$_POST['edituserfirstname']}', userLastName='{$_POST['edituserlastname']}', userAdditionalName='{$_POST['edituseradditionalname']}', {$npass} userGroupId='{$_POST['editusergroup']}', userTelephone='{$_POST['editusertelephone']}', userInformation='{$_POST['edituserinformation']}'{$activation} WHERE userId = '{$_POST['edituserid']}' ");
    }
    if (isset ($_POST['deluserid'])){
        $db->query("DELETE FROM Users WHERE userId = '{$_POST['edituserid']}' ");
    }
    $db->query("SELECT * FROM Users WHERE userId = '{$_GET['id']}' LIMIT 1");
    $data = $db->fetch_array();
    $db->query("SELECT * FROM Groups");
    while ($row = $db->fetch_array()) {
        $groups[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data, 'groups' => $groups));
    $tpl->fetch('edituser.tpl');
    return $tpl->get_tpl();
}

function listroles(&$m) {
    $db = new Db();
    
    if (isset($_POST['newrolename'])) {
        $db->query("INSERT INTO Roles SET roleName = '{$_POST['newrolename']}'");
    }
    if (isset($_POST['delrole'])) {
        $id = intval($_POST['idrole']);
        $db->query("DELETE FROM Roles WHERE roleId = '{$id}' ");
        $db->query("DELETE FROM RolesAccess WHERE roleId = '{$id}' ");
    }
    if (isset($_POST['editrolename']) && !isset($_POST['delmenuitem'])) {
        $db->query("UPDATE Roles SET roleName = '{$_POST['editrolename']}' WHERE roleId = '{$_POST['idrole']}'");
    }
    $db->query("SELECT GroupsAccess.roleId
                FROM Users, GroupsAccess
                WHERE Users.userId = '".$_SESSION['userId']."' AND 
                      GroupsAccess.groupId = Users.userGroupId  LIMIT 1 ");
    $exep = $db->fetch_array();
    if ($exep[0]=='1'){
        $exep = true;
    }else{
        $exep = false;
    }
    $db->query("SELECT * FROM Roles");
    while ($row = $db->fetch_array()) {
        if (!$exep){
            if ($row['roleId'] != 1){
                $roles[] = $row;
            }
        }else{
            $roles[] = $row;
        }
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('roles' => $roles));
    $tpl->fetch('listroles.tpl');
    return $tpl->get_tpl();
}

function editadminmenu(&$m) {
    $db = new Db();
    
    
    if (isset($_POST['newmenuitemname'])) {
        $db->query("INSERT INTO MenuAdmin 
                    SET menuName = '".$db->mres($_POST['newmenuitemname'])."', 
                        functionId = '".$_POST['newmenufunction']."', 
                        href ='".$_POST['newmenuhref']."', 
                        groupName = '".$db->mres($_POST['newmenugroup'])."',
                        itemOrder = '".$_POST['newmenuitemorder']."'");
    }
    if (isset($_POST['delmenuitem'])) {
        $db->query("DELETE
                    FROM MenuAdmin 
                    WHERE menuId = '".$_POST['idmenuitem']."'");
    }
    if ((isset($_POST['editmenuname']) || isset($_POST['editmenufunction'])) && !isset($_POST['delmenuitem'])) {
        $db->query("UPDATE MenuAdmin 
                    SET menuName = '".$_POST['editmenuname']."', 
                        functionId = '".$_POST['editmenufunction']."', 
                        href = '".$_POST['editmenuhref']."', 
                        itemOrder= '".$_POST['editmenuorder']."' ,
                        groupName = '".$db->mres($_POST['editmenugroup'])."'
                    WHERE menuId = '".$_POST['idmenuitem']."'");
    }
    $db->query("SELECT * 
                FROM Functions ORDER BY functionId ASC");
    while ($row = $db->fetch_array()) {
        $rows2[] = $row;
    }
    $db->query("SELECT * 
                FROM MenuAdmin ORDER BY itemOrder ASC");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('menuitems' => $rows, 'functions' => $rows2));
    $tpl->fetch('editadminmenu.tpl');
    return $tpl->get_tpl();
}

function editusermenu(&$m) {
    $db = new Db();
    
    
    if (isset($_POST['newmenuitemname'])) {
        $db->query("INSERT INTO MenuUsers 
                    SET menuName = '".$db->mres($_POST['newmenuitemname'])."',
                        functionId = '".$_POST['newmenufunction']."', 
                        href ='".$_POST['newmenuhref']."', 
                        groupName = '".$db->mres($_POST['newmenugroup'])."',
                        itemOrder = '".intval($_POST['newmenuitemorder'])."'");
    }
    if (isset($_POST['delmenuitem'])) {
        $db->query("DELETE 
                    FROM MenuUsers 
                    WHERE menuId = '".$_POST['idmenuitem']."'");
    }
    if ((isset($_POST['editmenuname']) || isset($_POST['editmenufunction'])) && !isset($_POST['delmenuitem'])) {
        $db->query("UPDATE MenuUsers 
                    SET menuName = '".$_POST['editmenuname']."', 
                        functionId = '".$_POST['editmenufunction']."', 
                        href = '".$_POST['editmenuhref']."', 
                        itemOrder= '".$_POST['editmenuorder']."' ,
                        groupName = '".$_POST['editmenugroup']."'
                    WHERE menuId = '".$_POST['idmenuitem']."'");
    }
    $db->query("SELECT * FROM Functions");
    while ($row = $db->fetch_array()) {
        $rows2[] = $row;
    }
    $db->query("SELECT * 
                FROM MenuUsers ORDER BY itemOrder ASC");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('menuitems' => $rows, 'functions' => $rows2));
    $tpl->fetch('editusermenu.tpl');
    return $tpl->get_tpl();
}

function editrole(&$m) {
    $db = new Db();
    
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        if (isset($_POST['idrole'])) {
            $k = 0;
            $db->query("DELETE FROM RolesAccess WHERE roleId = '{$id}'");
            $sql = "INSERT INTO RolesAccess (roleId, functionId) VALUES";
            $c = count($_POST) - 1;
            foreach ($_POST as $key => $cur) {
                if ($key != 'idrole') {
                    if (isset($cur)) {
                        $sql.= " ('{$id}', '{$key}' )";
                        $k++;
                        if ($k != $c) {
                            $sql.=",";
                        }
                    }
                }
            }
            if ($k > 0) {
                $db->query($sql);
            }
        }
        $db->query("SELECT Functions.functionId, Functions.functionName, FunctionsDescript.functionHumanName, 
                           FunctionsDescript.functionDescript 
                    FROM Functions, FunctionsDescript 
                    WHERE  Functions.functionId = FunctionsDescript.functionId ");
        while ($row = $db->fetch_array()) {
            $rows[] = $row;
        }
        $db->query("SELECT RolesAccess.functionId, Roles.roleName FROM RolesAccess, Roles WHERE RolesAccess.roleId = {$id} and RolesAccess.roleId = Roles.roleId");
        $rows2 = array();
        while ($row = $db->fetch_array()) {
            $rows2[] = $row[0];
            $namerole = $row[1];
        }
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('listfunction' => $rows, 'roles' => $rows2, 'idrole' => $id, 'namerole' => $namerole));
        $tpl->fetch('editrole.tpl');
        return $tpl->get_tpl();
    }
}
function supportadmin(&$e) {
    $db = new Db();
    $data['sc_subject']=$_POST['sc_subject'];
    $data['sc_message']=$_POST['sc_message'];
    $data['sc_cat']=$_POST['sc_cat'];
     if (isset($_POST['sc_message'])){
       $db->query("INSERT INTO SupportMess
                   SET subj = 'Re',
                       mess = '".$db->mres($_POST['sc_message'])."',
                       catId = '".intval($_POST['sc_cat'])."',
                       userId = '".$_SESSION['userId']."'");
       $db->query("UPDATE SupportMess
                      SET replyId = LAST_INSERT_ID() 
                      WHERE messId = '".intval($_POST['replyId'])."'");
       $db->query("SELECT userEmail
                      FROM Users
                      WHERE userId = '".intval($_POST['userid'])."'");
       $t = $db->fetch_array();
       $e->mail($t[0], 'Новое сообщение', 'Вы получили ответ на Ваше сообщение в службу техподдержки. Для прочтения перейдите по ссылке - //editus-dev.herokuapp.com/editus.php?do=viewsupportmess&id='.intval($_POST['replyId']));
    }
    $datamess = array();
    $db->query("SELECT messId, replyId, subj, is_read, is_read_ans, userId, catId, date
                FROM SupportMess");
    while ($row = $db->fetch_array()) {
            $datamess[] = $row;
    }
    $db->query("SELECT messId, subj
                FROM SupportMess
                WHERE replyId <> '0' ".Engine::pagesql()." ");
    while ($row = $db->fetch_array()) {
            $archiv[] = $row;
    }
    $db->query("SELECT count(*) 
                FROM SupportMess
                WHERE replyId <> '0'");
    $count = $db->fetch_array();
    $db->query("SELECT catId, catName, userGroupId
                FROM SupportCat");
    while ($row = $db->fetch_array()) {
        $cats[$row['catId']] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('action' => 'index.php?do=supportadmin', 'cats' => $cats,'userdata'=>$userdata, 'datamess'=>$datamess,'archiv'=>$archiv, 'href' => 'index.php?do=viewsupportmessadmin&amp;id=', 'pages'=> Engine::pagetpl($count['0'], 'index.php?do=supportadmin', true)));
    $tpl->fetch('supportadmin.tpl');
    return $tpl->get_tpl();
}
function viewsupportmessadmin(&$e){
    $db = new Db();
//    if (isset($_GET['id'])){
//        $db->query("UPDATE SupportMess
//                    SET is_read_ans = '1' 
//                    WHERE messId = '".intval($_GET['id'])."'");
//    }

    $db->query("SELECT SupportMess.subj, SupportMess.mess, SupportMess.replyId, SupportMess.catId, SupportMess.userId,
                       Users.userFirstName, Users.userLastName, Users.userAdditionalName, Users.userEmail
                FROM SupportMess, Users
                WHERE messId = '".intval($_GET['id'])."' AND
                      SupportMess.userId = Users.userId");
    $mess = $db->fetch_array();
    $db->query("SELECT  mess
                FROM SupportMess
                WHERE messId = '".$mess['replyId']."'");
    $ans = $db->fetch_array();
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('action' => 'index.php?do=supportadmin', 'mess'=>$mess,'ans'=>$ans, 'back'=>'index.php?do=supportadmin' ));
    $tpl->fetch('viewsupportmessadmin.tpl');
    return $tpl->get_tpl();
}
function listsupport() {
    $data[_LS_EDITCAT]='index.php?do=editsuppcat';
    $data[_LS_SUPPORT]='index.php?do=supportadmin';

    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data));
    $tpl->fetch('listsupport.tpl');
    return $tpl->get_tpl();
}
function editsuppcat() {
    $db = new Db();
    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM SupportCat 
                    WHERE catId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newname'])) {
        $db->query("INSERT INTO SupportCat 
                     SET catName = '".$db->mres($_POST['newname'])."',
                         userGroupId = '".intval($_POST['newgroup'])."' ");
    }
    if (isset($_POST['name']) ) {
        $db->query("UPDATE SupportCat 
                    SET catName = '".$db->mres($_POST['name'])."',
                        userGroupId = '".intval($_POST['group'])."'
                    WHERE catId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT *
                FROM SupportCat ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $db->query("SELECT Groups.groupId , Groups.groupName
                FROM Groups ");
    while ($row = $db->fetch_array()) {
        $groups[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'groups'=>$groups,'action'=> 'index.php?do=editsuppcat'));
    $tpl->fetch('editsuppcat.tpl');
    return $tpl->get_tpl();
}
function edittext() {
    $db = new Db();
    if (isset($_POST['publrules'])){
        $db->query("UPDATE Settings
                    SET settingData = '".$db->mres($_POST['publrules'])."'
                    WHERE settingName = 'publrules' ");
    }
    if (isset($_POST['offerizd'])){
        $db->query("UPDATE Settings
                    SET settingData = '".$db->mres($_POST['offerizd'])."'
                    WHERE settingName = 'offerizd' ");
    }
    if (isset($_POST['offershop'])){
        $db->query("UPDATE Settings
                    SET settingData = '".$db->mres($_POST['offershop'])."'
                    WHERE settingName = 'offershop' ");
    }
    if (isset($_POST['mailgetorder_text'])){
        $mailgetorder = array('mailgetorder_subj'=>$_POST['mailgetorder_subj'],'mailgetorder_text'=>$_POST['mailgetorder_text']);
        $db->query("UPDATE Settings
                    SET settingData = '".  serialize($mailgetorder)."'
                    WHERE settingName = 'mailgetorder' ");
    }
    if (isset($_POST['mailgetshoporder_text'])){
        $mailgetorder = array('mailgetshoporder_subj'=>$_POST['mailgetshoporder_subj'],'mailgetshoporder_text'=>$_POST['mailgetshoporder_text']);
        $db->query("UPDATE Settings
                    SET settingData = '".  serialize($mailgetorder)."'
                    WHERE settingName = 'mailgetshoporder' ");
    }
    if (isset($_POST['mailrecoverpass_text'])){
        $mailgetorder = array('mailrecoverpass_subj'=>$_POST['mailrecoverpass_subj'],'mailrecoverpass_text'=>$_POST['mailrecoverpass_text']);
        $db->query("UPDATE Settings
                    SET settingData = '".  serialize($mailgetorder)."'
                    WHERE settingName = 'mailrecoverpass' ");
    }
    if (isset($_POST['mailregister_text'])){
        $mailgetorder = array('mailregister_subj'=>$_POST['mailregister_subj'],'mailregister_text'=>$_POST['mailregister_text']);
        $db->query("UPDATE Settings
                    SET settingData = '".  serialize($mailgetorder)."'
                    WHERE settingName = 'mailregister' ");
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data));
    $tpl->fetch('edittext.tpl');
    return $tpl->get_tpl();
}
?>
