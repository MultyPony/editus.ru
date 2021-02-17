<?php

function editclientdata(&$e) {
    if (!isset($_GET['a'])) {
        $db = new Db();
        if (isset($_POST['ecd_firsname'])) {
            $f = true;
            if (!empty($_POST['ecd_password'])) {
                if ($_POST['ecd_password'] == $_POST['ecd_passwordconf']) {
                    $npass = " userPassword='" . sha1($_POST['ecd_passwordconf']) . "', ";
                } else {
                    $e->messuser(_ECD_PASSWORDNOTCONFIR, 0);
                    $f = false;
                }
            } else {
                $npass = '';
            }
            if ($f != false) {
                if (isset($_POST['ecd_subscmailer'])){
                    $sql = " subscMailer='1' , ";
                }else{
                    $sql = " subscMailer='0' , ";
                }
                $db->query("UPDATE Users 
                            SET userFirstName='" . $db->mres($_POST['ecd_firsname']) . "',
                                userLastName='" . $db->mres($_POST['ecd_lastname']) . "', 
                                userAdditionalName='" . $db->mres($_POST['ecd_additionalname']) . "', 
                                " . $npass . " 
                                userTelephone='" . $db->mres($_POST['ecd_telephone']) . "', 
                                userInformation='" . $db->mres($_POST['ecd_information']) . "' ,
                                isOrg = '".intval($_POST['ecd_type'])."',
                                orgName='" . $db->mres($_POST['ecd_orgname']) . "' ,
                                orgINN='" . $db->mres($_POST['ecd_orginn']) . "' , ".$sql."
                                orgKPP='" . $db->mres($_POST['ecd_orgkpp']) . "' 
                             WHERE userId = '" . $_SESSION['userId'] . "' ");
                $e->messuser(_ECD_DATASAVE, 1);
            }
        }
        if (empty($_POST['ecd_editaddress']) && isset($_POST['ecd_addresscontact'])) {
            $db->query("INSERT INTO UsersDeliveryAddreses 
                        SET userId = '" . $_SESSION['userId'] . "',
                            addressContact = '" . $db->mres($_POST['ecd_addresscontact']) . "', 
                            addressTelephone = '" . $db->mres($_POST['ecd_addresstelephone']) . "',
                            addressCountry = '" . $db->mres($_POST['ecd_addresscountry']) . "',
                            addressRegion = '" . $db->mres($_POST['ecd_addressregion']) . "',
                            addressIndex = '" . intval($_POST['ecd_addressindex']) . "',
                            addressCity = '" . $db->mres($_POST['ecd_addresscity']) . "',
                            addressStr = '" . $db->mres($_POST['ecd_addressstr']) . "',
                            addressHouse = '" . $db->mres($_POST['ecd_addresshouse']) . "',
                            addressBuild = '" . $db->mres($_POST['ecd_addressbuild']) . "',
                            addressApt = '" . $db->mres($_POST['ecd_addressapt']) . "',
                            addressComment = '" . $db->mres($_POST['ecd_addresscomment']) . "' ");
            $e->messuser(_ECD_DATASAVE, 1);
        }
        if (!empty($_POST['ecd_editaddress']) && !isset($_POST['ecd_deladdress'])) {
            $db->query("UPDATE UsersDeliveryAddreses 
                        SET userId = '" . $_SESSION['userId'] . "',
                            addressContact = '" . $db->mres($_POST['ecd_addresscontact']) . "', 
                            addressTelephone = '" . $db->mres($_POST['ecd_addresstelephone']) . "',
                            addressCountry = '" . $db->mres($_POST['ecd_addresscountry']) . "',
                            addressRegion = '" . $db->mres($_POST['ecd_addressregion']) . "',
                            addressIndex = '" . intval($_POST['ecd_addressindex']) . "',
                            addressCity = '" . $db->mres($_POST['ecd_addresscity']) . "',
                            addressStr = '" . $db->mres($_POST['ecd_addressstr']) . "',
                            addressHouse = '" . $db->mres($_POST['ecd_addresshouse']) . "',
                            addressBuild = '" . $db->mres($_POST['ecd_addressbuild']) . "',
                            addressApt = '" . $db->mres($_POST['ecd_addressapt']) . "',
                            addressComment = '" . $db->mres($_POST['ecd_addresscomment']) . "'
                         WHERE userId = '" . $_SESSION['userId'] . "' AND
                               addressId = '" . intval($_POST['ecd_editaddress']) . "'");
            $e->messuser(_ECD_DATASAVE, 1);
        }
        if (isset($_POST['ecd_deladdress'])) {
            $db->query("UPDATE UsersDeliveryAddreses
                        SET isdel = '1'
                        WHERE userId = '" . $_SESSION['userId'] . "' AND
                              addressId = '" . intval($_POST['ecd_editaddress']) . "'");
            $e->messuser(_ECD_ADDRESSDELETED, 2);
        }
        $db->query("SELECT userLastName, userFirstName, userAdditionalName, userEmail, userTelephone, userInformation, isOrg, orgName, orgINN, orgKPP, subscMailer 
                    FROM Users 
                    WHERE userId = '" . $_SESSION['userId'] . "' LIMIT 1");
        $data = $db->fetch_array();

        $db->query("SELECT addressId, addressIndex, addressCity, addressStr, addressHouse, addressApt
                    FROM UsersDeliveryAddreses 
                    WHERE userId = '" . $_SESSION['userId'] . "' AND 
                          isdel = '0' ");
        while ($row = $db->fetch_array()) {
            $addreses[] = $row;
        }
        if (is_numeric($_POST['ecd_addreses'])) {
            $db->query("SELECT addressContact, addressTelephone, addressCountry, addressRegion, addressIndex, 
                               addressCity, addressStr, addressHouse, addressBuild, addressApt, addressComment
                        FROM UsersDeliveryAddreses 
                        WHERE userId = '" . $_SESSION['userId'] . "' AND
                              addressId = '" . intval($_POST['ecd_addreses']) . "' LIMIT 1");
            $data2 = $db->fetch_array();
            $data2['11'] = intval($_POST['ecd_addreses']);
        }
        $db->query("SELECT CountryId, CountryName
                    FROM DeliveryCountries");
        while ($row = $db->fetch_array()) {
            $countrys[] = $row;
        }
        $tpl = new Template();
        $tpl->set_vars(array('countrys'=>$countrys,'mode'=>1,'data' => $data, 'action' => Main_config::$main_file_name . '?do=editclientdata', 'addreses' => $addreses, 'data2' => $data2));
        $tpl->fetch('editclientdata.tpl');
        return $tpl->get_tpl();
        
    }else{
        if ($_POST['do']=='getregion'){
            $db = new Db();
            $db->query("SELECT RegionId, RegionName, iscity
                        FROM DeliveryRegions
                        WHERE CountryId = '".  intval($_POST['countryid'])."' AND
                              RegionParentId ='0' ORDER BY RegionName ");
            while ($row = $db->fetch_array()) {
                $regions[] = $row;
            }
            $sel = 0;
            if ($_POST['edit']!=0){
                $db->query("SELECT addressRegion
                            FROM UsersDeliveryAddreses
                            WHERE addressId = '".  intval($_POST['edit'])."' ");
                $row = $db->fetch_array();
            }
            
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('mode'=>2,'regions'=>$regions,'sel'=>$row[0]));
            $tpl->fetch('editclientdata.tpl');
            $tpl->display();
        }
    }
}

function supportclient(&$e) {
    $db = new Db();
    $data['sc_subject']=$_POST['sc_subject'];
    $data['sc_message']=$_POST['sc_message'];
    $data['sc_cat']=$_POST['sc_cat'];
    if (isset($_POST['sc_message'])){
        if (!empty($_POST['sc_message'])){
            if (!empty($_POST['sc_subject'])){
               $db->query("INSERT INTO SupportMess
                           SET subj = '".$db->mres($_POST['sc_subject'])."',
                               mess = '".$db->mres($_POST['sc_message'])."',
                               catId = '".intval($_POST['sc_cat'])."',
                               userId = '".$_SESSION['userId']."'");
               $data['sc_message']='';
               $data['sc_subject']='';
               $data['sc_cat']='';
               $mails[]="support@editus.ru";
               $db->query("SELECT Users.userEmail 
                           FROM Users, SupportCat
                           WHERE SupportCat.catId = '".intval($_POST['sc_cat'])."' AND SupportCat.userGroupId = Users.userGroupId ");
               while ($row = $db->fetch_array()) {
                        $mails[] = $row[0];
               }
               $e->mail($mails, 'Editus. Новое сообщение в ТП', 'Пришло новое сообщение в техподдержку.'."\nТема сообщения:".$_POST['sc_subject']."\nТело сообщения:\n".$_POST['sc_message']);
               $e->messuser(_SC_SENDMESSOK,1);
            }else{
                $e->messuser(_SC_EMPTYSUBJ,0);
            }
        }else{
            $e->messuser(_SC_EMPTYMESS,0);
        }
    }
    $datamess = array();
    $db->query("SELECT messId, replyId, subj, is_read, is_read_ans
                FROM SupportMess
                WHERE userId = '".$_SESSION['userId']."'");
    while ($row = $db->fetch_array()) {
            $datamess[] = $row;
    }
    $db->query("SELECT messId, subj
                FROM SupportMess
                WHERE userId = '".$_SESSION['userId']."' AND
                      is_read_ans = '1' AND
                      replyId <> '0' ".Engine::pagesql()." ");
    while ($row = $db->fetch_array()) {
            $archiv[] = $row;
    }
    $db->query("SELECT count(*) 
                FROM SupportMess
                WHERE userId = '".$_SESSION['userId']."' AND
                      is_read_ans = '1' AND
                      replyId <> '0'");
    $count = $db->fetch_array();
    $db->query("SELECT catName, catId
                FROM SupportCat");
    while ($row = $db->fetch_array()) {
        $cats[] = $row;
    }
    $tpl = new Template();
    $tpl->set_vars(array('action' => Main_config::$main_file_name . '?do=supportclient', 'cats' => $cats,'userdata'=>$userdata, 'datamess'=>$datamess,'archiv'=>$archiv, 'href' => Main_config::$main_file_name . '?do=viewsupportmess&amp;id=', 'pages'=> Engine::pagetpl($count['0'], Main_config::$main_file_name . '?do=supportclient')));
    $tpl->fetch('supportclient.tpl');
    return $tpl->get_tpl();
}
function viewsupportmess($e){
    $db = new Db();
    if (isset($_GET['id'])){
        $db->query("UPDATE SupportMess
                    SET is_read_ans = '1' 
                    WHERE messId = '".intval($_GET['id'])."'");
    }
    $db->query("SELECT subj, mess, replyId
                FROM SupportMess
                WHERE messId = '".intval($_GET['id'])."' AND 
                      userId = '".$_SESSION['userId']."' ");
    $mess = $db->fetch_array();
    $db->query("SELECT  mess
                FROM SupportMess
                WHERE messId = '".$mess['replyId']."'");
    $ans = $db->fetch_array();
    $e->do='supportclient';
    $tpl = new Template();
    $tpl->set_vars(array('action' => Main_config::$main_file_name . '?do=viewsupportmess', 'mess'=>$mess,'ans'=>$ans, 'back'=>Main_config::$main_file_name . '?do=supportclient' ));
    $tpl->fetch('viewsupportmess.tpl');
    return $tpl->get_tpl();
}

?>
