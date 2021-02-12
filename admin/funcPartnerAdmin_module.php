<?php

function listpartners(&$e,&$t) {
    $db = new Db();
    $db->query("SELECT Users.userId, Users.userFirstName, Users.userLastName,
                       Users.userAdditionalName, Users.userEmail, Users.userRegistrationDate, Groups.groupName
                FROM Users, Groups
                WHERE Groups.groupId = Users.userGroupId AND isPartner = '1'");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('listpartners.tpl');
    return $tpl->get_tpl();
}

function editpartner(&$e) {
    $db = new Db();
    $partnerid = intval($_GET['id']);
    if (isset($_POST['ep_key'])) {
        $key = $db->mres($_POST['ep_key']);
        $page = $db->mres($_POST['ep_returnpage']);
        $title = $db->mres($_POST['ep_title']);
        $mainpage = $db->mres($_POST['ep_mainpage']);
        $percent = floatval($_POST['ep_percent']);
        $status = intval($_POST['ep_status']);
        $format = end(explode(".", $_FILES['epd_logo']['name']));
        if (!isset($_FILES["epd_logo"])){
            if ((isset($_FILES["epd_logo"]) && ($format == 'jpg' || $format=='png'))){
                $image = new Imagick($_FILES['epd_logo']['tmp_name']);
                $pathdir = './partner_logo/logo_'.intval($_SESSION['userId']);
                if (($image->getImageFormat () == 'JPEG') || ($image->getImageFormat () == 'PNG')){
                    $image->adaptiveResizeImage(250,0);
                    $image->writeImage($pathdir.'.jpg');
                }
            }
        }
        $sql = "UPDATE PartnersData
                    SET partnerPage = '".$page."',
                        partnerName = '".$title."',
                        partnerKey = '".$key."',
                        partnerMainPage = '".$mainpage."',
                        percent = '".$percent."',
                        status 	= '".$status."'
                    WHERE userId = '".intval($_GET['id'])."';";
        $db->query($sql);
    }
    $statuses = array(0=>_EP_STATUSOFF,1=>_EP_STATUSON);
    $sql = "SELECT partnerName, partnerKey, status, partnerPage, percent, partnerMainPage
                FROM PartnersData
                WHERE userId = '".$partnerid."' LIMIT 1";
    $db->query($sql);
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $db->fetch_array(),'statuses'=>$statuses));
    $tpl->fetch('editpartner.tpl');
    return $tpl->get_tpl();
}
?>
