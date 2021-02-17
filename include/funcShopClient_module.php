<?php

function addtocart(){
    if (isset($_SESSION['userId'])){
        $db = new Db();
        $db->query("SELECT id
                    FROM ShopCart
                    WHERE userId = '".$_SESSION['userId']."' AND
                          itemsId = '".  intval($_POST['itemid'])."' ");
        if ( $db->num_rows() > 0){
            $db->query("UPDATE ShopCart
                        SET amount = amount + 1 
                        WHERE itemsId = '".  intval($_POST['itemid'])."' ");
        }else{
            $db->query("INSERT INTO ShopCart 
                        SET itemsId = '".  intval($_POST['itemid'])."',
                            userId = '".$_SESSION['userId']."',
                            amount = '1' ");
        }
        $db->query("SELECT SUM(amount) AS amount
                    FROM ShopCart
                    WHERE userId = '".$_SESSION['userId']."' ");
        $row = $db->fetch_array();
        echo $row['amount'];
    }
}

function showcart(&$e, &$t){
    if (!isset($_GET['a'])){
        $db = new Db();
        if (isset($_POST['itemdel'])){
            $db->query("DELETE 
                        FROM ShopCart
                        WHERE ShopCart.id = '".intval($_POST['itemdel'])."' AND 
                              ShopCart.userId = '".$_SESSION['userId']."'");
            $e->messuser(_SC_DELETED, 2);
        }
        $db->query("SELECT ShopCart.id, ShopItems.itemName, ShopCart.amount, (ShopItems.itemPrice*ShopCart.amount) AS sum, ShopCart.itemsId
                    FROM ShopCart, ShopItems
                    WHERE ShopCart.itemsId = ShopItems.itemId AND
                          ShopCart.userId = '".$_SESSION['userId']."'");
        while ($row = $db->fetch_array()) {
            $data[] = $row;
        }
        $t->addjs('jquery.tablesorter.min');
        $tpl = new Template();
        $tpl->set_vars(array('data'=>$data,'action'=>Main_config::$main_file_name . '?do=shoporderstep1'));
        $tpl->fetch('showcart.tpl');
        return $tpl->get_tpl();
    }else{
        if ($_POST['do']=='calc'){
            $count = intval($_POST['count']);
            $itemid = intval($_POST['itemid']);
            if ($count > 0 ){
                $db = new Db();
                $db->query("UPDATE ShopCart
                            SET amount = '".$count."'
                            WHERE ShopCart.id = '".$itemid."' AND 
                                  ShopCart.userId = '".$_SESSION['userId']."'");
                $db->query("SELECT (ShopItems.itemPrice*ShopCart.amount) AS sum
                            FROM ShopCart, ShopItems
                            WHERE ShopCart.itemsId = ShopItems.itemId AND 
                                  userId = '".$_SESSION['userId']."' AND
                                  ShopCart.id = '".$itemid."' ");
                $row1 = $db->fetch_array();
                echo $row1['sum']._SC_RUB;
            }else{
                echo '0'._SC_RUB;
            }
        }
    }
}
function shoporderstep1(&$e, &$t, &$u) {
    if (!isset($_GET['a'])) {
        if (isset($_POST['so_new'])) {
            $db = new Db();
            $db->query("SELECT ShopCart.itemsId, ShopItems.itemName, ShopCart.amount, (ShopItems.itemPrice*ShopCart.amount) AS sum
                        FROM ShopCart, ShopItems
                        WHERE ShopCart.itemsId = ShopItems.itemId AND
                              ShopCart.userId = '".$_SESSION['userId']."'");
            while ($row = $db->fetch_array()) {
                $dataorder[] = $row;
            }
            $db->query("SELECT addressId, addressIndex, addressCity, addressStr, addressHouse, addressApt
                        FROM UsersDeliveryAddreses 
                        WHERE userId = '" . $_SESSION['userId'] . "'  AND 
                              isdel = '0' ");
            while ($row = $db->fetch_array()) {
                $addreses[] = $row;
            }
            $db->query("SELECT CountryId, CountryName
                        FROM DeliveryCountries");
            while ($row = $db->fetch_array()) {
                $countrys[] = $row;
            }
            $db->query("SELECT isOrg
                        FROM Users 
                        WHERE userId = '". $_SESSION['userId'] ."' LIMIT 1");

            $row = $db->fetch_array();
            $isOrg = $row['isOrg'];
            $t->addjs('jquery.simplemodal.1.4.1.min');
            $e->do = 'showcart';
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('isorg'=>$isOrg,'mode'=>1,'countrys'=>$countrys,'dataorder'=>$dataorder,'addreses'=>$addreses, 'action' => Main_config::$main_file_name . '?do=shoporderstep2'));
            $tpl->fetch('shoporderstep1.tpl');
            return $tpl->get_tpl();
        }
    }else{
        if ($_POST['do']=='getregion'){
            $db = new Db();
            $db->query("SELECT RegionId, RegionName, iscity
                        FROM DeliveryRegions
                        WHERE CountryId = '".  intval($_POST['countryid'])."' AND
                              RegionParentId ='0' ");
            while ($row = $db->fetch_array()) {
                $regions[] = $row;
            }
            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('mode'=>2,'regions'=>$regions));
            $tpl->fetch('shoporderstep1.tpl');
            $tpl->display();
        }
        if ($_POST['do']=='savenewaddress'){
            $db = new Db();
            $db->query("INSERT INTO UsersDeliveryAddreses 
                        SET userId = '" . $_SESSION['userId'] . "',
                            addressContact = '" . $db->mres($_POST['so1_addresscontact']) . "', 
                            addressTelephone = '" . $db->mres($_POST['so1_addresstelephone']) . "',
                            addressCountry = '" . intval($_POST['so1_addresscountry']) . "',
                            addressRegion = '" . intval($_POST['so1_addressregion']) . "',
                            addressIndex = '" . intval($_POST['so1_addressindex']) . "',
                            addressCity = '" . $db->mres($_POST['so1_addresscity']) . "',
                            addressStr = '" . $db->mres($_POST['so1_addressstr']) . "',
                            addressHouse = '" . intval($_POST['so1_addresshouse']) . "',
                            addressBuild = '" . intval($_POST['so1_addressbuild']) . "',
                            addressApt = '" . intval($_POST['so1_addressapt']) . "',
                            addressComment = '" . $db->mres($_POST['so1_addresscomment']) . "' ");
            $db->query("SELECT LAST_INSERT_ID()");
            $sel = $db->fetch_array();
            $db->query("SELECT addressId, addressIndex, addressCity, addressStr, addressHouse, addressApt
                        FROM UsersDeliveryAddreses 
                        WHERE userId = '" . $_SESSION['userId'] . "' AND 
                              isdel = '0' ");
            while ($row = $db->fetch_array()) {
                $addreses[] = $row;
            }

            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('mode'=>3,'addreses'=>$addreses,'sel'=>$sel[0]));
            $tpl->fetch('shoporderstep1.tpl');
            $tpl->display();
        }
        if ($_POST['do']=='getproviders'){
            $db = new Db();

            $db->query("SELECT PaperTypeCostsBlock.PaperTypeWeight,
                               PaperFormat.formatWidth,
                               PaperFormat.formatHeight,
                               ShopCart.amount,
                               ShopItems.itemPages
                        FROM PaperTypeCostsBlock, PaperFormat, ShopCart, ShopItems
                        WHERE ShopItems.papertTypeId = PaperTypeCostsBlock.PaperTypeId AND
                              ShopItems.formatId = PaperFormat.formatId AND
                              ShopItems.itemId = ShopCart.itemsId AND
                              ShopCart.userId = '".intval($_SESSION['userId'])."'");

            while ($row = $db->fetch_array()) {
                $massa += ($row['PaperTypeWeight']*(($row['formatWidth']*$row['formatHeight'])/1000000000)*$row['amount']*($row['itemPages']/2+50))*1000;
            }
            if ($massa<1000){
                $db->query("SELECT DeliveryProviders.DeliveryProviderName AS DeliveryProviderName, 
                               DeliveryProvidersCosts.DeliveryProvidersCostsId AS DeliveryProvidersCostsId,
                               DeliveryProvidersCosts.DeliveryProviderCosts AS DeliveryProvidersCosts,
                               DeliveryProvidersCosts.OverQuote AS OverQuote
                        FROM DeliveryProviders, DeliveryProvidersCosts, UsersDeliveryAddreses
                        WHERE UsersDeliveryAddreses.addressId = '".intval($_POST['addressid'])."' AND
                              UsersDeliveryAddreses.addressCountry = DeliveryProvidersCosts.CountryId AND
                              UsersDeliveryAddreses.addressRegion = DeliveryProvidersCosts.RegionId AND
                              DeliveryProvidersCosts.DeliveryProviderId = DeliveryProviders.DeliveryProviderId AND
                              DeliveryProvidersCosts.minWeight < '".$massa."' AND
                              DeliveryProvidersCosts.maxWeight > '".$massa."' ");
                while ($row = $db->fetch_array()) {
                    $providers[] = $row;
                }
            }else{
                $db->query("SELECT DeliveryProviders.DeliveryProviderName AS DeliveryProviderName, 
                               DeliveryProvidersCosts.DeliveryProvidersCostsId AS DeliveryProvidersCostsId,
                               DeliveryProvidersCosts.DeliveryProviderCosts AS DeliveryProvidersCosts,
                               DeliveryProvidersCosts.OverQuote AS OverQuote
                        FROM DeliveryProviders, DeliveryProvidersCosts, UsersDeliveryAddreses
                        WHERE UsersDeliveryAddreses.addressId = '".intval($_POST['addressid'])."' AND
                              UsersDeliveryAddreses.addressCountry = DeliveryProvidersCosts.CountryId AND
                              UsersDeliveryAddreses.addressRegion = DeliveryProvidersCosts.RegionId AND
                              DeliveryProvidersCosts.DeliveryProviderId = DeliveryProviders.DeliveryProviderId AND
                              DeliveryProvidersCosts.minWeight < '".$massa."' AND
                              DeliveryProvidersCosts.maxWeight > '".$massa."' ");
                while ($row = $db->fetch_array()) {
                    $row['DeliveryProvidersCosts']= $row['DeliveryProvidersCosts']+$row['OverQuote']*ceil(($massa/1000)-1);
                    $providers[] = $row;
                }
            }

            $tpl = new Template();
            $tpl->set_path('templates/');
            $tpl->set_vars(array('massa'=>$massa,'mode'=>4,'providers'=>$providers));
            $tpl->fetch('shoporderstep1.tpl');
            $tpl->display();
        }
        if ($_POST['do']=='calc'){
            if ($_POST['idprovid']!=-1){
                echo $_POST['totalcosts']+$_POST['delivcosts'];
            }else{
                echo $_POST['totalcosts'];
            }
        }
    }
}

function shoporderstep2(&$e, &$t, &$u) {
    if (!isset($_GET['a'])) {
       if (isset($_POST['so1_newo'])){
            $db = new Db();
            $db->query("SELECT ShopCart.itemsId, ShopCart.amount, ShopItems.itemPrice
                        FROM ShopCart, ShopItems
                        WHERE userId = '" . $_SESSION['userId'] . "' AND
                              ShopCart.itemsId = ShopItems.itemId ");
            if ($db->num_rows() > 0) {
                while ($row = $db->fetch_array()) {
                    $d[$row['itemsId']]=$row['amount'];
                    $orderCosts += ($row['amount']*$row['itemPrice']);
                }
                if ($_POST['typedeliv']!='pickup'){
                       $db->query("SELECT PaperTypeCostsBlock.PaperTypeWeight,
                           PaperFormat.formatWidth,
                           PaperFormat.formatHeight,
                           ShopCart.amount,
                           ShopItems.itemPages
                    FROM PaperTypeCostsBlock, PaperFormat, ShopCart, ShopItems
                    WHERE ShopItems.papertTypeId = PaperTypeCostsBlock.PaperTypeId AND
                          ShopItems.formatId = PaperFormat.formatId AND
                          ShopItems.itemId = ShopCart.itemsId AND
                          ShopCart.userId = '".intval($_SESSION['userId'])."'");
                    while ($row = $db->fetch_array()) {
                        $massa += ($row['PaperTypeWeight']*(($row['formatWidth']*$row['formatHeight'])/1000000000)*$row['amount']*($row['itemPages']/2+50))*1000;
                    }
                    unset ($row);
                    $db->query("SELECT DeliveryProviderCosts, DeliveryProviderId, OverQuote
                                FROM DeliveryProvidersCosts
                                WHERE DeliveryProvidersCostsId = '".intval($_POST['so1_providers'])."'");
                    $row = $db->fetch_array();
                    if ($massa<1000){
                        $delivcost = $row['DeliveryProviderCosts'];
                    }else{
                        $delivcost = $row['DeliveryProviderCosts']+$row['OverQuote']*ceil(($massa/1000)-1);
                    }
                    $delivprovid = $row['DeliveryProviderId'];
                }else{
                    $delivcost = 0;
                    $delivprovid = 0;
                }
                $db->query("INSERT INTO ShopOrders
                            SET itemsId = '".serialize($d)."',
                                orderCost = '".$orderCosts."',
                                orderPriceDeliver = '".$delivcost."',
                                addressId = '".intval($_POST['so1_addreses'])."',
                                DeliveryProviderId = '".$delivprovid."',
                                stateId = '1',                                    
                                orderstep = '1',
                                userId = '".intval($_SESSION['userId'])."',
                                isOrg = '".intval($_POST['isorg'])."'");
                $db->query("SELECT LAST_INSERT_ID()");
                $sel = $db->fetch_array();
                $sel = $sel[0];
                $db->query("INSERT INTO ShopOrderStateChanges 
                            SET orderId = '" . $sel . "',
                                curState = '2',
                                userId = '" . $_SESSION['userId'] . "' ");
                $db->query("DELETE 
                            FROM ShopCart
                            WHERE userId = '".intval($_SESSION['userId'])."'");
                $db->query("SELECT userFirstName, userLastName
                            FROM Users
                            WHERE Users.userId = '" . $_SESSION['userId'] . "' ");
                $userdata = $db->fetch_array();
                $ar_search = array('_USERNAME','_NUMORDER','_USERLASTNAME');
                $ar_replace = array($userdata['userFirstName'],'K'.$sel,$userdata['userLastName']);
                $db->query("SELECT userEmail
                            FROM Users
                            WHERE Users.userGroupId = '" .Settings::$v['managegroup'] . "' ");
                while ($row = $db->fetch_array()) {
                    $mails[] = $row['userEmail'];
                }
                $mails[] = $_SESSION['userEmail'];
                $e->mail($mails,str_replace($ar_search, $ar_replace, Settings::getsetting('mailgetshoporder','mailgetshoporder_subj')), str_replace($ar_search,$ar_replace, Settings::getsetting('mailgetshoporder','mailgetshoporder_text')));
                $e->messuser(_SO2_STEPCOMPLETE, 1);
                $_GET['o']=$sel;
            }
        }else{

//                $db = new Db();
//                $db->query("SELECT orderstep
//                            FROM UsersOrders
//                            WHERE orderId = '" . intval($_GET['o']) . "' AND
//                                  userId = '" . $_SESSION['userId'] . "' LIMIT 1");
//                if ($db->num_rows()==1){
//                    $step = 3;
//                    $maxstep = 4;
//                    $row = $db->fetch_array();
//                    if (($row['orderstep'])!=$step){
//                        if (($row['orderstep']+1)<=$maxstep) {
//                            header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=orderstep".(intval($row['orderstep'])+1)."&o=".intval($_GET['o']));
//                            exit();
//                        }else{
//                            header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?do=listorders");
//                            exit();
//                        }
//                    }
//                }
        }

        $db = new Db();
        if (isset($_GET['paycard_status'])) {
            $status_num = intval($_GET['paycard_status']);
            if ($status_num == 99){
                $e->messuser("Произошла неизвестная ошибка, попробуйте позже", 0);
            }
            if ($status_num == 0){
                $e->messuser("Оплата успешно произведена", 1);
            }
        }


        $db->query("SELECT CEILING(orderCost + orderPriceDeliver) AS orderPriceTotal
                    FROM ShopOrders
                    WHERE orderId = '".intval($_GET['o'])."' ");
        $row = $db->fetch_array();
        $tprice =$row['orderPriceTotal'];
        if ($tprice>=15000){
            $qiwi = 1;
        }
        $hrefkvit = '/include/bs_excelorder.php?o='.intval($_GET['o']);
        $hrefkvit2 = '/include/bs_excelorder.php?o='.intval($_GET['o']).'&clean';
        //qiwi
        if ($qiwi != 1){
            $db->query("SELECT paysysId 
                        FROM OrderBills
                        WHERE ispay <> 1 AND
                              orderId = 'bs".intval($_GET['o'])."' AND
                              paysys = 'qiwi'");
            if (($db->num_rows()) < 1 ){
                $qiwi = 2;
            }elseif (($db->num_rows()) == 1){
                require_once "bill/IShopServerWSService.php";
                $row = $db->fetch_array();
                $service = new IShopServerWSService('bill/IShopServerWS.wsdl', array('location'      => 'https://ishop.qiwi.ru/services/ishop', 'trace' => 1));
                $params = new checkBill();
                $params->login = 12456;
                $params->password = 'gpvqmlu';
                $params->txn = $row['paysysId'];
                $res = $service->checkBill($params);
                if ($res->status== 50){
                    $qiwi = 3;
                }elseif ($res->status >= 100 || $res->status <0) {
                    $qiwi = 4;
                }
            }
        }
        //robokassa
        $mrh_login = "ysuccuba";
        $mrh_pass1 = "gpvqmlu12456";
        $inv_id = intval($_GET['o']);
        $inv_desc = 'Счет на оплату № K'.intval($_GET['o']).' от '.date("d.m.y");
        $out_summ = $tprice;
        $shpt = 'bs';
        $culture = "ru";
        $receipt = json_encode(array(
            sno => "usn_income_outcome",
            items => array(
                array(
                    name => "Название товара 1",
                    quantity => 1,
                    sum => $out_summ,
                    payment_method => "full_payment",
                    payment_object => "payment",
                    tax => "none"
                )
            )
        ));
        $receiptEncoded = urlencode($receipt);
        echo $receipt;
        $crc = md5($mrh_login.':'.$out_summ.':'.$inv_id.':'. $receiptEncoded . ':' .$mrh_pass1.':shpt='.$shpt);
        $robokassa = "<form action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
                     "<input type=hidden name=MrchLogin value=$mrh_login>".
                     "<input type=hidden name=OutSum value=$out_summ>".
                     "<input type=hidden name=InvId value=$inv_id>".
                     "<input type=hidden name=Desc value='$inv_desc'>".
                     "<input type=hidden name=shpt value='$shpt'>".
                     "<input type=hidden name=SignatureValue value='$crc''>".
                     "<input type=hidden name=Culture value='$culture'>".
                     "<input type=hidden name=Receipt value='$receiptEncoded'>".
                     "<label>Стоимость:  ".$out_summ." руб. <input class='button red' type=submit value='Оплатить'></label>". "</form>";
        //

        $e->do = 'listshoporders';
        $tpl = new Template();
        $tpl->set_path('templates/');
        $tpl->set_vars(array('hrefkvit2'=>$hrefkvit2,'qiwi'=>$qiwi,'robokassa'=>$robokassa,'hrefkvit'=>$hrefkvit,'action' => Main_config::$main_file_name . '?do=shoporderstep2&o='.intval($_GET['o'])));
        $tpl->fetch('shoporderstep2.tpl');

        if ($_GET['d']){
            $tpl->fetch('d_shoporderstep2.tpl');
        } else {
            $tpl->fetch('shoporderstep2.tpl');
        }
        return $tpl->get_tpl();
    }else{
        if ($_POST['do']=='createbill'){
            $db = new Db();
            $db->query("SELECT CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) AS orderPriceTotal
                        FROM ShopOrders
                        WHERE ShopOrders.orderId = '".intval($_POST['o'])."' ");
            $row = $db->fetch_array();
            $price = $row['orderPriceTotal'];
            require_once "bill/IShopServerWSService.php";
            $service = new IShopServerWSService('bill/IShopServerWS.wsdl', array('location'      => 'https://ishop.qiwi.ru/services/ishop', 'trace' => 1));
            $txn = 'bs'.intval($_POST['o']).'-'.date("ymdhi");
            $params_newpay = new createBill();
            $params_newpay->login = 12456;
            $params_newpay->password = 'gpvqmlu';
            $params_newpay->user = intval($_POST['phone']);
            $params_newpay->amount = $price;
            $params_newpay->comment = 'Счет на оплату № K'.intval($_POST['o']).' от '.date("d.m.y");
            $params_newpay->txn = $txn;
            $params_newpay->lifetime = date("d.m.y H:i:s", mktime(0, 0, 0, date("m"), date("d")+7, date("y")));
            $params_newpay->alarm = 0;
            $params_newpay->create = true;
            $res = $service->createBill($params_newpay);
            if ($res->createBillResult==0){
                $db = new Db();
                $db->query("SELECT paysysId 
                FROM OrderBills
                WHERE ispay <> 1 AND
                      orderId = 'bs".intval($_POST['o'])."' AND
                      paysys = 'qiwi' ");
                if (($db->num_rows()) < 1){
                    $db->query("INSERT INTO OrderBills
                                SET orderId = 'bs".intval($_POST['o'])."',
                                    userId = '".$_SESSION['userId']."',
                                    paysys = 'qiwi',
                                    paysysId = '".$txn."' ");
                    echo _SO2_TEXTQIWI2;
                }else{
                    $db->query("UPDATE OrderBills
                                SET paysysId = 'bs".$txn."' 
                                WHERE orderId = 'bs".intval($_POST['o'])."' AND
                                      paysys = 'qiwi' ");
                    echo _SO2_TEXTQIWI2;
                }
            }
        }
        if ($_POST['do']=='resetbillqiwi'){
            $db = new Db();
            $db->query("SELECT paysysId 
                        FROM OrderBills
                        WHERE ispay <> 1 AND
                              orderId = 'bs".intval($_POST['o'])."' ");
            $row = $db->fetch_array();
            require_once "bill/IShopServerWSService.php";
            $service = new IShopServerWSService('bill/IShopServerWS.wsdl', array('location'      => 'https://ishop.qiwi.ru/services/ishop', 'trace' => 1));
            $params2 = new cancelBill();
            $params2->login = 12456;
            $params2->password = 'gpvqmlu';
            $params2->txn = $row['paysysId'];
            $res = $service->cancelBill($params2);
            if ($res->cancelBillResult==0){
                echo '<input type="hidden" name="orderid" id="so2_orderid" value="'.$_POST['o'].'" />
                <label>'._SO2_TYPEPHONE.'<input name="qiwiphone" id="so2_qiwiphone" type="text" maxlength="10" style="width: 100px;" /></label>
                <br><input class="button" type="button" id="so2_send" value="'._SO2_CHECKOUT.'"/>';
            }
        }
    }
}

function listshoporders(&$e, &$t, &$u) {
    $db = new Db();

    if (isset($_POST['orderdel'])) {
//        $db->query("DELETE
//                    FROM ShopOrders
//                    WHERE orderId = '" . intval($_POST['orderdel']) . "' AND
//                          userId = '".$_SESSION['userId']."' ");
        $db->query("UPDATE ShopOrders
                    SET stateId = '11'
                    WHERE orderId = '" . intval($_POST['orderdel']) . "' AND
                          userId = '".$_SESSION['userId']."' ");
        $e->messuser(_LSO_ORDERDELETED, 2);
    }
    $db->query("SELECT orderId,	CEILING(orderCost + orderPriceDeliver) AS orderPriceTotal, orderDate, stateId, orderstep
                FROM ShopOrders 
                WHERE userId = '".$_SESSION['userId']."' AND
                      stateId <> '11' AND stateId <> '9' ORDER BY orderId DESC ". Engine::pagesql());
    $orders = array();
    while ($row = $db->fetch_array()) {
        $orders[] = $row;
    }
    $db->query("SELECT count(*)
                FROM ShopOrders 
                WHERE userId = '".$_SESSION['userId']."' AND
                      stateId <> '11'");
    $count = $db->fetch_array();
    $db->query("SELECT stateId, stateName
                FROM OrdersStates");
    while ($row = $db->fetch_array()) {
        $status[$row['stateId']] = $row['stateName'];
    }
    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('templates/');
    $tpl->set_vars(array('actionview'=>Main_config::$main_file_name . '?do=viewshoporder&amp;o=','pages' => Engine::pagetpl($count['0'], Main_config::$main_file_name . '?do=listshoporders'),'actiondel' => Main_config::$main_file_name . '?do=listshoporders&amp;p=' . intval($_GET['p']),'status'=>$status,'orders' => $orders,'hrefcont'=> Main_config::$main_file_name . '?do=shoporderstep2&amp;o='));
    $tpl->fetch('listshoporders.tpl');
    return $tpl->get_tpl();
}
function viewshoporder(&$e){
    if (is_numeric($_GET['o'])){
        $db = new Db();
        $db->query("SELECT ShopOrders.orderId AS orderId, 
                           ShopOrders.itemsId AS itemsId, 
                           ShopOrders.orderCost AS orderCost, 
                           ShopOrders.orderDate AS orderDate, 
                           ShopOrders.orderstep AS orderstep, 
                           ShopOrders.stateId AS stateId,
                           ShopOrders.orderPriceDeliver AS orderPriceDeliver,
                           CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) AS orderPriceTotal,
                           ShopOrders.DeliveryProviderId AS DeliveryProviderId,
                           ShopOrders.addressId AS addressId
                    FROM ShopOrders
                    WHERE userId = '".$_SESSION['userId']."' AND
                          orderId = '".intval($_GET['o'])."' LIMIT 1");
        $data = $db->fetch_array();

        $t = unserialize($data['itemsId']);
        $sqlcomporder = 'SELECT itemId, itemName 
                         FROM ShopItems
                         WHERE ';
        foreach ($t as $key=>$val){
            if (!isset($f)){
                $sqlcomporder .=" itemId = '".$key."' ";
                $f = 1;
            }else if ($f == 1){
                $sqlcomporder .=" OR itemId = '".$key."' ";
            }
        }
        $db->query($sqlcomporder);
        while ($row = $db->fetch_array()) {
            $comp .= ', '.$row['itemName'].' x'.$t[$row['itemId']];
        }
        $comp[0]='';
        if ($data['DeliveryProviderId']!=0){
            $db->query("SELECT DeliveryProviderName
                        FROM DeliveryProviders 
                        WHERE DeliveryProviderId = '". $data['DeliveryProviderId'] ."' ");
            $row = $db->fetch_array();
            $namedeliv = $row[0];
            $db->query("SELECT DeliveryCountries.CountryName AS CountryName,
                               DeliveryRegions.RegionName AS RegionName,
                               UsersDeliveryAddreses.addressIndex AS addressIndex,
                               UsersDeliveryAddreses.addressCity AS addressCity,
                               UsersDeliveryAddreses.addressStr AS addressStr,
                               UsersDeliveryAddreses.addressHouse AS addressHouse,
                               UsersDeliveryAddreses.addressBuild AS addressBuild,
                               UsersDeliveryAddreses.addressApt AS addressApt,
                               UsersDeliveryAddreses.addressContact AS addressContact,
                               UsersDeliveryAddreses.addressTelephone AS addressTelephone
                        FROM UsersDeliveryAddreses, DeliveryCountries, DeliveryRegions
                        WHERE UsersDeliveryAddreses.addressId = '". $data['addressId'] ."' AND
                              DeliveryCountries.CountryId = UsersDeliveryAddreses.addressCountry AND 
                              DeliveryRegions.RegionId = UsersDeliveryAddreses.addressRegion ");
            $dataadres = $db->fetch_array();
        }
//        if ($data['stateId']==5){
//            $db->query("SELECT OrdersDeny.cause
//                        FROM OrdersDeny
//                        WHERE OrdersDeny.orderId = '".intval($_GET['o'])."' ");
//            $denycause = $db->fetch_array();
//        }
        $e->do = 'listshoporders';
        $tpl = new Template();
        $tpl->set_path('templates/');
        $tpl->set_vars(array('denycause'=>$denycause[0], 'hrefcont'=> Main_config::$main_file_name . '?do=orderstep1&amp;o=','data'=>$data,'comp'=>$comp, 'namedeliv'=>$namedeliv, 'dataadres'=>$dataadres));
        $tpl->fetch('viewshoporder.tpl');
        return $tpl->get_tpl();
    }
}
function listshoparchive(&$e, &$t, &$u) {
    $db = new Db();
    $db->query("SELECT ShopOrders.orderId, ShopOrders.orderDate,  
                CEILING(ShopOrders.orderCost + ShopOrders.orderPriceDeliver) AS orderPriceTotal
                FROM ShopOrders 
                WHERE ShopOrders.userId = '".$_SESSION['userId']."' AND 
                      ShopOrders.stateId = '9' ORDER BY orderId DESC ". Engine::pagesql());
    $orders = array();
    while ($row = $db->fetch_array()) {
        $orders[] = $row;
    }
    $db->query("SELECT count(*)
                FROM ShopOrders 
                WHERE userId = '".$_SESSION['userId']."' AND
                      stateId = '9'");
    $count = $db->fetch_array();

    $t->addjs('jquery.tablesorter.min');
    $tpl = new Template();
    $tpl->set_path('templates/');
    $tpl->set_vars(array('orders'=>$orders,'actionview'=>Main_config::$main_file_name . '?do=viewshoporder&amp;o=','pages' => Engine::pagetpl($count['0'], Main_config::$main_file_name . '?do=listshoparchive')));
    $tpl->fetch('listshoparchive.tpl');
    return $tpl->get_tpl();
}
?>
