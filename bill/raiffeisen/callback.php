<?php
include_once "../../config.inc.php";
include_once "../../include/db_class.php";
require_once '../../include/lang/errors_lang.php';
require_once '../../include/engine_class.php';
require_once '../cardpay/Log.php';


function returnResult($code) {
    header("HTTP/1.1 202 Accepted");
    echo 'RESP_CODE=' . $code;
    exit();
}

$data = $_GET;
Log::save($data);
if (isset($data['descr']) && isset($data['type']) && $data['type'] == 'conf_pay'){
    if ($data['result'] == 0){

        $type = substr($data['descr'], 0, 3);
        $order_id = intval(substr($data['descr'], 3));
        $amt = intval($data['amt']);

        if ($type == 'pub'){
            $db = new Db();
            $db->query("SELECT
                            CEILING((UsersOrders.orderPriceBind + UsersOrders.orderPriceCover + UsersOrders.orderPriceAdditService + UsersOrders.orderPriceBlock + UsersOrders.orderPriceDeliver)) AS orderPriceTotal,
                            orderstep
                        FROM UsersOrders
                        WHERE UsersOrders.orderId = '".$order_id."' LIMIT 1");

            $dataOrder = $db->fetch_array();
            
            if ($dataOrder['orderstep'] >= 4 ) {
                returnResult(1);
            }

            if ($dataOrder['orderPriceTotal'] != $amt) {
                returnResult(-2);
            }

            $db->query("UPDATE UsersOrders
                        SET orderstep = 4,
                            stateId = 2
                        WHERE orderId = '" . $order_id . "' ");
            try {
                $z = new Engine();
                $z->set_path_to_root('../../');
                $z->load_class('settings');
                new Settings();
                $z->mail(array('pay@editus.ru'), 'Оплата - raiffeisen', 'Заказ №'.$order_id.' оплачен');
            } catch (Exception $e) {}
            returnResult(0);
        }
    }
}
returnResult(-2);
