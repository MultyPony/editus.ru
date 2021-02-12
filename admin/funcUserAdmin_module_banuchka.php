<?php

//function listusers(&$m) {
//    $db = new Db();
//
//    $db->query("SELECT * FROM Users");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('listusers.tpl');
//    return $tpl->get_tpl();
//}
###Заказы на отправку в типографию###
//function orderswaitupload(&$m) {
//    $db = new Db();
//if (isset($_GET['ok'])) {
//
//        $db->query("UPDATE UsersOrders SET stateId=6 WHERE orderId='{$_GET['orderid']}'");
//    }
//    $db->query("SELECT UsersOrders.orderId,UsersOrders.orderName,UsersOrders.orderAutor,
//                UsersOrders.orderCount,UsersOrders.orderPages,UsersOrders.userId
//        FROM UsersOrders WHERE StateId=3");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('orderswaitupload.tpl');
//    return $tpl->get_tpl();
//}
###Все Заказы###
//function listallorders(&$m) {
//    $db = new Db();
//
//    $db->query("SELECT UsersOrders.orderId,Users.userEmail,
//        UsersOrders.orderName,UsersOrders.orderAutor,
//        UsersOrders.orderCount,UsersOrders.orderPages,
//        UsersOrders.orderSymb,UsersOrders.orderPriceBlock,
//        UsersOrders.orderPriceAdditService,UsersOrders.orderPriceCover,
//        OrdersStates.stateName,Users.userId,UsersOrders.orderDate
//        FROM UsersOrders,Users,OrdersStates
//        WHERE
//        (UsersOrders.StateId<>0 AND Users.userId=UsersOrders.userId AND OrdersStates.StateId=UsersOrders.StateId)
//        ORDER BY orderDate");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('listallorders.tpl');
//    return $tpl->get_tpl();
//}
###Службы доставки###
//function deliveryagents(&$m) {
//
//    $db = new Db();
//    if (isset($_POST['addnew'])) {
//    $db->query("INSERT INTO DeliveryProviders SET DeliveryProviderName = '{$_POST['addnew']}'");
//    }
//    if (isset($_POST['deliverycost'])) {
//         $db->query("SELECT COUNT(*) FROM DeliveryProvidersCosts WHERE DeliveryProviderId = '{$_POST['more']}' AND CountryId = '{$_POST['countryid']}' AND RegionId= '{$_POST['regionid']}'");
//         $row = $db->fetch_array();
//
//         if ($row['0']!=0)
//             {
//
//             $db->query("UPDATE DeliveryProvidersCosts SET DeliveryProviderCosts= '{$_POST['deliverycost']}' WHERE DeliveryProviderId = '{$_POST['more']}' AND CountryId = '{$_POST['countryid']}' AND RegionId= '{$_POST['regionid']}'");
//
//             }
//         if ($row['0']==0){
//             $db->query("INSERT INTO DeliveryProvidersCosts SET DeliveryProviderId = '{$_POST['more']}', CountryId = '{$_POST['countryid']}', RegionId= '{$_POST['regionid']}', DeliveryProviderCosts= '{$_POST['deliverycost']}'");
//         }
//
//    }
//
//    if (isset($_GET['more']) || isset($_POST['more'])) {
//        if (isset($_GET['more'])) {$DelPrId = $_GET['more'];}
//        if (isset($_POST['more'])) {$DelPrId = $_POST['more'];}
//        $db->query("SELECT DeliveryCountries.CountryName,DeliveryRegions.RegionName,DeliveryProvidersCosts.DeliveryProviderCosts FROM DeliveryProvidersCosts,DeliveryRegions,DeliveryCountries WHERE (DeliveryProviderId='$DelPrId' AND DeliveryCountries.CountryId=DeliveryProvidersCosts.CountryId AND DeliveryRegions.RegionId=DeliveryProvidersCosts.RegionId)");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    ###Массив стран
//     $db->query("SELECT CountryId,CountryName FROM DeliveryCountries");
//    while ($country = $db->fetch_array()) {
//        $countries[] = $country;
//    }
//   ###Массив Регионов###
//    $db->query("SELECT RegionId,RegionName FROM DeliveryRegions WHERE RegionParentId=0");
//    while ($region = $db->fetch_array()) {
//        $regions[] = $region;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows,'data2' => $countries,'data3'=>$regions,'agentid'=>$DelPrId));
//    $tpl->fetch('deliveryagentsmore.tpl');
//    return $tpl->get_tpl();
//    }
//    if (!(isset($_GET['more']))) {
//    $db->query("SELECT DeliveryProviderId,DeliveryProviderName, DeliveryProviderAvatarUrl FROM DeliveryProviders");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('deliveryagents.tpl');
//    return $tpl->get_tpl();
//    }


}
###Заказы на оплате###
//function ordersforpay(&$m) {
//    $db = new Db();
//    if (isset($_GET['ok'])) {
//
//        $db->query("UPDATE UsersOrders SET stateId=2 WHERE orderId='{$_GET['orderid']}'");
//    }
//    $db->query("SELECT UsersOrders.orderId,UsersOrders.orderPriceTotal,OrdersStates.stateName
//        FROM UsersOrders,OrdersStates
//        WHERE (UsersOrders.StateId=1 AND UsersOrders.stateId=OrdersStates.stateId)");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('ordersforpay.tpl');
//    return $tpl->get_tpl();
//}
//###Заказы на модерации###
//function ordersformod(&$m) {
//    $db = new Db();
//    ###Отклонение заказа###
//    if (isset($_GET['deny'])) {
//    $db->query("UPDATE UsersOrders SET stateId='5' WHERE orderId='{$_GET['orderid']}'");
//    }
//    ###Прошел Модерацию###
//if (isset($_GET['ok'])) {
//
//    $db->query("SELECT AdditionalServiceId FROM AdditionalServiceCosts WHERE label='makeup'");
//     while ($row = $db->fetch_array()) {
//         $rows[] = $row;
//     }
//     foreach ($rows as $cur)
//     {
//        $db->query("SELECT COUNT(*) FROM UsersOrders WHERE (orderId='{$_GET['orderid']}' AND orderAdditService LIKE '%".$cur['0']."%')");
//        $row = $db->fetch_array();
//         if ($row['0']!=0)
//        {
//            $nextState='4';
//
//        }
//     }
//     if (!(isset($nextState))){$nextState='3';}
//     unset($rows);
//     $db->query("UPDATE UsersOrders SET stateId='".$nextState."' WHERE orderId='{$_GET['orderid']}'");
//    }
//    $db->query("SELECT UsersOrders.orderId,UsersOrders.orderName,UsersOrders.orderAutor,
//                UsersOrders.orderCount,UsersOrders.orderPages,UsersOrders.userId
//        FROM UsersOrders WHERE StateId=2");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('ordersformod.tpl');
//    return $tpl->get_tpl();
//}
//###Заказы Для Ручной Верстки###
//function ordersformanualedit(&$m) {
//    $db = new Db();
//if (isset($_GET['ok'])) {
//     $db->query("UPDATE UsersOrders SET stateId='3' WHERE orderId='{$_GET['orderid']}'");
//}
//    $db->query("SELECT UsersOrders.orderId,UsersOrders.orderName,UsersOrders.orderAutor,
//                UsersOrders.orderCount,UsersOrders.orderPages,UsersOrders.userId
//        FROM UsersOrders WHERE StateId=4");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('ordersformanualedit.tpl');
//    return $tpl->get_tpl();
//}
//###Заявки на печать###
//function ordersforprint(&$m) {
//    $db = new Db();
//
//    $db->query("SELECT UsersOrders.orderId,Users.userEmail,UsersOrders.orderName,UsersOrders.orderAutor,UsersOrders.orderPriceTotal FROM UsersOrders,Users WHERE (UsersOrders.StateId=10 AND Users.userId=UsersOrders.userId)");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('ordersforprint.tpl');
//    return $tpl->get_tpl();
//}
###Печать###
function ordersonprint(&$m) {
    $db = new Db();
if (isset($_GET['ok'])) {
     $db->query("UPDATE UsersOrders SET stateId='7' WHERE orderId='{$_GET['orderid']}'");
}
   $db->query("SELECT UsersOrders.orderId,UsersOrders.orderName,UsersOrders.orderAutor,
                UsersOrders.orderCount,UsersOrders.orderPages,UsersOrders.userId
        FROM UsersOrders WHERE StateId=6");
    while ($row = $db->fetch_array()) {
        $rows[] = $row;
    }
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $rows));
    $tpl->fetch('ordersonprint.tpl');
    return $tpl->get_tpl();
}
###Отделка###
//function ordersmakeup(&$m) {
//    $db = new Db();
//if (isset($_GET['ok'])) {
//     $db->query("UPDATE UsersOrders SET stateId='8' WHERE orderId='{$_GET['orderid']}'");
//}
//    $db->query("SELECT UsersOrders.orderId,UsersOrders.orderName,UsersOrders.orderAutor,
//                UsersOrders.orderCount,UsersOrders.orderPages,UsersOrders.userId
//        FROM UsersOrders WHERE StateId=7");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('ordersmakeup.tpl');
//    return $tpl->get_tpl();
//}
//###Доставка###
//function ordersdelivery(&$m) {
//    $db = new Db();
//if (isset($_GET['ok'])) {
//     $db->query("UPDATE UsersOrders SET stateId='10' WHERE orderId='{$_GET['orderid']}'");
//}
//    $db->query("SELECT UsersOrders.orderId,DeliveryCountries.CountryName,
//        DeliveryRegions.RegionName,UsersDeliveryAddreses.addressStr,
//        UsersDeliveryAddreses.addressHouse,UsersDeliveryAddreses.addressBuild,
//        UsersDeliveryAddreses.addressApt,DeliveryProviders.DeliveryProviderName
//                FROM UsersOrders,UsersDeliveryAddreses,DeliveryRegions,DeliveryCountries,DeliveryProviders
//        WHERE (UsersOrders.StateId=8 AND
//        UsersDeliveryAddreses.addressId=UsersOrders.addressId AND
//        DeliveryRegions.RegionId=UsersDeliveryAddreses.addressRegion AND
//        DeliveryCountries.CountryId=UsersDeliveryAddreses.addressCountry AND
//        UsersOrders.DeliveryProviderId=DeliveryProviders.DeliveryProviderId)");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('ordersdelivery.tpl');
//    return $tpl->get_tpl();
//}
//###Форматы бумаги в системе###
//function listformats(&$m) {
//    $db = new Db();
//
//    $db->query("SELECT formatName, formatWidth, formatHeight, formatInA3 FROM PaperFormat");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $rows));
//    $tpl->fetch('listformats.tpl');
//    return $tpl->get_tpl();
//}
//
//function editgroups(&$m) {
//    $db = new Db();
//
//    if (isset($_POST['newgroupsname'])) {
//        $db->query("INSERT INTO Groups SET groupName = '{$_POST['newgroupsname']}'");
//        $db->query("INSERT INTO GroupsAccess SET groupId= LAST_INSERT_ID(), roleId = '{$_POST['newgroupsrole']}' ");
//    }
//    if (isset($_POST['delgroups'])) {
//        $db->query("DELETE FROM Groups WHERE groupId = '{$_POST['idgroup']}'");
//        $db->query("DELETE FROM GroupsAccess WHERE groupId = '{$_POST['idgroup']}'");
//    }
//    if ((isset($_POST['editgroupsname']) || isset($_POST['editgroupsrole'])) && !isset($_POST['delgroups'])) {
//        if (isset($_POST['adminaccess'])) {
//            $adminaccess = ", adminAccess = '1' ";
//        } else {
//            $adminaccess = ", adminAccess = '0' ";
//        }
////        if (isset($_POST['usersdef'])) {
////            $usersdef = ", usersdef = '1' ";
////        } else {
////            $usersdef = ", usersdef = '0' ";
//        //}
//        //$db->query("UPDATE Groups SET groupName = '{$_POST['editgroupsname']}'{$adminaccess} {$usersdef} WHERE groupId = '{$_POST['idgroup']}' ");
//        $db->query("UPDATE GroupsAccess SET roleId = '{$_POST['editgroupsrole']}' WHERE groupId = '{$_POST['idgroup']}' ");
//    }
//    $db->query("SELECT Groups.groupId, Groups.groupName, Groups.adminAccess, GroupsAccess.roleId FROM Groups, GroupsAccess WHERE Groups.groupId = GroupsAccess.groupId");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $db->query("SELECT * FROM Roles");
//    while ($row = $db->fetch_array()) {
//        $rows2[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('groups' => $rows, 'roles' => $rows2));
//    $tpl->fetch('editgroups.tpl');
//    return $tpl->get_tpl();
//}
//
//function edituser(&$m) {
//    $db = new Db();
//
//    if (isset($_POST['edituserid'])) {
//        if (isset($_POST['edituseractivation'])) {
//            $activation = ", userIsActive = '1'";
//        } else {
//            $activation = ", userIsActive = '0'";
//        }
//        if (!empty($_POST['edituserpassword'])) {
//            $npass = " userPassword='" . sha1($_POST['edituserpassword']) . "', ";
//        } else {
//            $npass = '';
//        }
//        $db->query("UPDATE Users SET userFirstName='{$_POST['edituserfirstname']}', userLastName='{$_POST['edituserlastname']}', userAdditionalName='{$_POST['edituseradditionalname']}', {$npass} userGroupId='{$_POST['editusergroup']}', userTelephone='{$_POST['editusertelephone']}', userInformation='{$_POST['edituserinformation']}'{$activation} WHERE userId = '{$_POST['edituserid']}' ");
//    }
//    if (isset ($_POST['deluserid'])){
//        $db->query("DELETE FROM Users WHERE userId = '{$_POST['edituserid']}' ");
//    }
//    $db->query("SELECT * FROM Users WHERE userId = '{$_GET['id']}' LIMIT 1");
//    $data = $db->fetch_array();
//    $db->query("SELECT * FROM Groups");
//    while ($row = $db->fetch_array()) {
//        $groups[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('data' => $data, 'groups' => $groups));
//    $tpl->fetch('edituser.tpl');
//    return $tpl->get_tpl();
//}

//function listroles(&$m) {
//    $db = new Db();
//
//    if (isset($_POST['newrolename'])) {
//        $db->query("INSERT INTO Roles SET roleName = '{$_POST['newrolename']}'");
//    }
//    if (isset($_POST['delrole'])) {
//        $id = intval($_POST['idrole']);
//        $db->query("DELETE FROM Roles WHERE roleId = '{$id}' ");
//        $db->query("DELETE FROM RolesAccess WHERE roleId = '{$id}' ");
//    }
//    if (isset($_POST['editrolename']) && !isset($_POST['delmenuitem'])) {
//        $db->query("UPDATE Roles SET roleName = '{$_POST['editrolename']}' WHERE roleId = '{$_POST['idrole']}'");
//    }
//    $db->query("SELECT * FROM Roles");
//    while ($row = $db->fetch_array()) {
//        $roles[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('roles' => $roles));
//    $tpl->fetch('listroles.tpl');
//    return $tpl->get_tpl();
//}
//
//function editadminmenu(&$m) {
//    $db = new Db();
//
//
//    if (isset($_POST['newmenuitemname'])) {
//        $db->query("INSERT INTO MenuAdmin SET menuName = '".$db->mres($_POST['newmenuitemname'])."', functionId = '{$_POST['newmenufunction']}', href ='{$_POST['newmenuhref']}', itemOrder = '{$_POST['newmenuitemorder']}'");
//    }
//    if (isset($_POST['delmenuitem'])) {
//        $db->query("DELETE FROM MenuAdmin WHERE menuId = '{$_POST['idmenuitem']}'");
//    }
//    if ((isset($_POST['editmenuname']) || isset($_POST['editmenufunction'])) && !isset($_POST['delmenuitem'])) {
//        $db->query("UPDATE MenuAdmin SET menuName = '{$_POST['editmenuname']}', functionId = '{$_POST['editmenufunction']}', href = '{$_POST['editmenuhref']}', itemOrder= '{$_POST['editmenuorder']}' WHERE menuId = '{$_POST['idmenuitem']}'");
//    }
//    $db->query("SELECT * FROM Functions");
//    while ($row = $db->fetch_array()) {
//        $rows2[] = $row;
//    }
//    $db->query("SELECT * FROM MenuAdmin ORDER BY itemOrder ASC");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('menuitems' => $rows, 'functions' => $rows2));
//    $tpl->fetch('editadminmenu.tpl');
//    return $tpl->get_tpl();
//}
//
//function editusermenu(&$m) {
//    $db = new Db();
//
//
//    if (isset($_POST['newmenuitemname'])) {
//        $db->query("INSERT INTO MenuUsers SET menuName = '".$db->mres($_POST['newmenuitemname'])."', functionId = '{$_POST['newmenufunction']}', href ='{$_POST['newmenuhref']}', itemOrder = '{$_POST['newmenuitemorder']}'");
//    }
//    if (isset($_POST['delmenuitem'])) {
//        $db->query("DELETE FROM MenuUsers WHERE menuId = '{$_POST['idmenuitem']}'");
//    }
//    if ((isset($_POST['editmenuname']) || isset($_POST['editmenufunction'])) && !isset($_POST['delmenuitem'])) {
//        $db->query("UPDATE MenuUsers SET menuName = '{$_POST['editmenuname']}', functionId = '{$_POST['editmenufunction']}', href = '{$_POST['editmenuhref']}', itemOrder= '{$_POST[editmenuorder]}' WHERE menuId = '{$_POST['idmenuitem']}'");
//    }
//    $db->query("SELECT * FROM Functions");
//    while ($row = $db->fetch_array()) {
//        $rows2[] = $row;
//    }
//    $db->query("SELECT * FROM MenuUsers ORDER BY itemOrder ASC");
//    while ($row = $db->fetch_array()) {
//        $rows[] = $row;
//    }
//    $tpl = new Template();
//    $tpl->set_path('../templates/admin/');
//    $tpl->set_vars(array('menuitems' => $rows, 'functions' => $rows2));
//    $tpl->fetch('editusermenu.tpl');
//    return $tpl->get_tpl();
//}
//
//function editrole(&$m) {
//    $db = new Db();
//
//    if (isset($_GET['id'])) {
//        $id = intval($_GET['id']);
//        if (isset($_POST['idrole'])) {
//            $k = 0;
//            $db->query("DELETE FROM RolesAccess WHERE roleId = '{$id}'");
//            $sql = "INSERT INTO RolesAccess (roleId, functionId) VALUES";
//            $c = count($_POST) - 1;
//            foreach ($_POST as $key => $cur) {
//                if ($key != 'idrole') {
//                    if (isset($cur)) {
//                        $sql.= " ('{$id}', '{$key}' )";
//                        $k++;
//                        if ($k != $c) {
//                            $sql.=",";
//                        }
//                    }
//                }
//            }
//            if ($k > 0) {
//                $db->query($sql);
//            }
//        }
//        $db->query("SELECT Functions.functionId, Functions.functionName, FunctionsDescript.functionHumanName, FunctionsDescript.functionDescript FROM Functions, FunctionsDescript WHERE  Functions.functionId = FunctionsDescript.functionId");
//        while ($row = $db->fetch_array()) {
//            $rows[] = $row;
//        }
//        $db->query("SELECT RolesAccess.functionId, Roles.roleName FROM RolesAccess, Roles WHERE RolesAccess.roleId = {$id} and RolesAccess.roleId = Roles.roleId");
//        $rows2 = array();
//        while ($row = $db->fetch_array()) {
//            $rows2[] = $row[0];
//            $namerole = $row[1];
//        }
//        $tpl = new Template();
//        $tpl->set_path('../templates/admin/');
//        $tpl->set_vars(array('listfunction' => $rows, 'roles' => $rows2, 'idrole' => $id, 'namerole' => $namerole));
//        $tpl->fetch('editrole.tpl');
//        return $tpl->get_tpl();
//    }
//}

?>
