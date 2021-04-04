<?php
include_once "../../config.inc.php";
include_once "../../include/db_class.php";
include_once './CardPayAvangard.php';
require_once '../../include/lang/errors_lang.php';
require_once '../../include/engine_class.php';
require_once './Log.php';


if (isset($_GET['result_code']) && preg_match('~^[A-Za-z]{10}$~', $_GET['result_code']) ) {
    $CardPay = new CardPayAvangard('9281', 'kiLyCsJLyS', 'xdXeJAZpZSzyOkwWZvjv', 'dIqdYGqSqaUcdbymVVVE');
    $orderRegInfo = $CardPay->getOrderRegInfoByResCode($_GET['result_code']);
    $orderId = $orderRegInfo['order_id'];
    $originOrderId = $orderId;
$data['order_amount'] = ($data['order_amount'] * 100);
    $type = substr($orderId,0,3);

    if ($type=='pub'){
        $res = $CardPay->getOrderInfo($orderId);
        $orderId = substr($orderId,3);
        if ($res['response_code'] == 0){
            Log::save($res);
            switch ($res['status_code']) {
                case 1:
                    $db = new Db();
                    $CardPay->updateStatus($originOrderId, 5);
                    $CardPay->setStatusCode($originOrderId, 1);
                    header("Location: https:editus.php?do=orderstep4&o=" . $orderId . '&paycard_status=1');
                    exit;
                case 3:
                    $db = new Db();
                    $db->query("UPDATE UsersOrders
                                SET orderstep = 4,
                                    stateId = 2
                                WHERE orderId = '" . intval($orderId) . "' ");
                    $CardPay->setStatusCode($originOrderId, 3);
                    $z = new Engine();
                    $z->set_path_to_root('../../');
                    $z->load_class('settings');
                    new Settings();
                    $z->mail(array('support@editus.ru'), 'Оплата - Avangard', 'Заказ №'.$orderId.' на сумму '.$amount.' оплачен');
                    header("Location: https:editus.php?do=listorders&o=" . $orderId);
                    exit;
                    break;
                case 2:
                    $CardPay->setStatusCode($originOrderId, 2);
                    header("Location: https:editus.php?do=orderstep4&o=" . $orderId . '&paycard_status=99');
                    exit;
                    break;
                default:
                    header("Location: https:editus.php?do=orderstep4&o=" . $orderId . '&paycard_status=99');
                    exit;
            }
        } else {
            header("Location: https:editus.php?do=orderstep4&o=" . $orderId . '&paycard_status=99');
            exit;
        }
    }

    if ($type=='sho'){
        $res = $CardPay->getOrderInfo($orderId);
        $orderId = substr($orderId,3);

        if ($res['response_code'] == 0){
            Log::save($res);
            switch ($res['status_code']) {
                case 1:
                    $CardPay->updateStatus($originOrderId, 5);
                    header("Location: https:editus.php?do=shoporderstep2&o=" . $orderId . '&paycard_status=1');
                    exit;
                case 3:
                    $db = new Db();
                    $db->query("UPDATE ShopOrders
                                SET stateId = 3,
                                    orderstep = 2
                                WHERE orderId = '" . intval($orderId) . "' ");
                    $z = new Engine();
                    $z->set_path_to_root('../../');
                    $z->load_class('settings');
                    new Settings();
                    $z->mail(array('support@editus.ru'), 'Оплата - Avangard', 'Заказ №K'.$orderId.' на сумму '.$amount.' оплачен');
                    header("Location: https:editus.php?do=shoporderstep2&o=" . $orderId . '&paycard_status=0');
                    exit;
                    break;
                case 2:
                    $CardPay->removeRegInfo($originOrderId);
                    header("Location: https:editus.php?do=shoporderstep2&o=" . $orderId . '&paycard_status=99');
                    exit;
                    break;
                default:
                    header("Location: https:editus.php?do=shoporderstep2&o=" . $orderId . '&paycard_status=99');
                    exit;
            }
        } else {
            header("Location: https:editus.php?do=shoporderstep2&o=" . $orderId . '&paycard_status=99');
            exit;
        }
    }


    header("Location: https:");
}