<?php
include_once "../../config.inc.php";
include_once "../../include/db_class.php";
include_once './CardPayAvangard.php';
include_once './Log.php';

session_start();
if (empty($_SESSION['userId'])) exit;
//$CardPay = new CardPayAvangard('1113', 'pKJENjLcB13', 'xdXeJAZpZSzyOkwWZvjv', 'dIqdYGqSqaUcdbymVVVE');
$CardPay = new CardPayAvangard('9281', 'kiLyCsJLyS', 'xdXeJAZpZSzyOkwWZvjv', 'dIqdYGqSqaUcdbymVVVE');

if ($_GET['type'] == 'pub'){

    $db = new Db();
    $db->query("SELECT
      uo.userId,
      CONCAT('order #',uo.orderId) AS order_desc,
      CONCAT(u.userLastName,' ', u.userFirstName) AS client_name,
      uo.orderId AS order_id,
      CONCAT(uda.addressIndex , ', ',dc.CountryName, ', ', dr.RegionName, ', ', uda.addressCity, ', ', uda.addressStr, ', ', uda.addressHouse) as client_address,
      u.userEmail AS client_email,
      u.userTelephone AS client_phone,
      CEILING((uo.orderPriceBind + uo.orderPriceCover + uo.orderPriceAdditService + uo.orderPriceBlock + uo.orderPriceDeliver)) AS order_amount
    FROM UsersOrders uo
    INNER JOIN Users u ON u.userId = uo.userId
    LEFT JOIN UsersDeliveryAddreses AS uda ON uda.`addressId` = uo.`addressId`
    LEFT JOIN DeliveryCountries dc ON dc.`CountryId` = uda.`addressCountry`
    LEFT JOIN DeliveryRegions dr ON dr.`RegionId` = uda.`addressRegion`
    WHERE uo.orderId = '" . intval($_GET['o']) . "'
      AND uo.userId = '" . $_SESSION['userId'] . "' LIMIT 1");
    $data = $db->fetch_array();
    $data['order_amount'] = ($data['order_amount'] * 100);
    $data['order_id'] = 'pub' . $data['order_id'];
    $data['back_url'] = "https://editus-dev.ru/bill/cardpay/revert_result.php";
    Log::save($data);
    $cardres = $CardPay->getOrderRegInfo($data['order_id']);
    if ($cardres['status'] == 0){
        $CardPay->removeRegInfo($data['order_id']);
    }
    $CardPay->registerOrder($data);
    $res = $CardPay->getLastResult();
    if ($res['ticket']) {
        $CardPay->updateStatus($data['order_id'], 5);
        header("Location: https://www.avangard.ru/iacq/pay?ticket=" . $res['ticket']);
        exit(0);
    }

    header("Location: https://editus-dev.ru/editus.php?do=orderstep4&o=" . intval($_GET['o']) . '&paycard_status=99');
    exit(0);
}

if ($_GET['type'] == 'sho'){

    $db = new Db();
    $db->query("SELECT
      so.userId,
      CONCAT('order #',so.orderId) AS order_desc,
      CONCAT(u.userLastName,' ', u.userFirstName) AS client_name,
      so.orderId AS order_id,
      CONCAT(uda.addressIndex , ', ',dc.CountryName, ', ', dr.RegionName, ', ', uda.addressCity, ', ', uda.addressStr, ', ', uda.addressHouse) as client_address,
      u.userEmail AS client_email,
      u.userTelephone AS client_phone,
      CEILING((so.orderPriceDeliver + so.orderCost)) AS order_amount
    FROM ShopOrders so
    INNER JOIN Users u ON u.userId = so.userId
    LEFT JOIN UsersDeliveryAddreses AS uda ON uda.`addressId` = so.`addressId`
    LEFT JOIN DeliveryCountries dc ON dc.`CountryId` = uda.`addressCountry`
    LEFT JOIN DeliveryRegions dr ON dr.`RegionId` = uda.`addressRegion`
    WHERE so.orderId = '" . intval($_GET['o']) . "'
      AND so.userId = '" . $_SESSION['userId'] . "' LIMIT 1");
    $data = $db->fetch_array();
    $data['order_amount'] = ($data['order_amount'] * 100);
    $data['order_id'] = 'sho' . $data['order_id'];
    $data['back_url'] = "https://editus-dev.ru/bill/cardpay/revert_result.php";
    Log::save($data);
    $CardPay->removeRegInfo($data['order_id']);
    $CardPay->registerOrder($data);
    $res = $CardPay->getLastResult();
    if ($res['ticket']) {
        $CardPay->updateStatus($data['order_id'], 5);
        header("Location: https://www.avangard.ru/iacq/pay?ticket=" . $res['ticket']);
        exit(0);
    }

    header("Location: https://editus-dev.ru/editus.php?do=shoporderstep2&o=" . intval($_GET['o']) . '&paycard_status=99');
    exit(0);
}



