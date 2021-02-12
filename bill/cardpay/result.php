<?php
include_once "../../config.inc.php";
include_once "../../include/db_class.php";
include_once './CardPayAvangard.php';
require_once '../../include/lang/errors_lang.php';
require_once '../../include/engine_class.php';
require_once './Log.php';


Log::save($_POST);
if (isset($_POST['ticket']) && isset($_POST['signature'])){
    $data = $_POST;
    Log::save($data);
    $CardPay = new CardPayAvangard('9281', 'kiLyCsJLyS', 'psrRTxAmxTgLKDejsZSU', 'WnSCcRAQCGVTpqjbuYfu');
    $order_id = $data['order_number'];
    if ($data['status_code'] == 3){
        if ($data['signature'] == $CardPay->getSignature($data['order_number'])){
            $type = substr($order_id, 0, 3);
            if ($type == 'pub'){
                $db = new Db();
                $db->query("UPDATE UsersOrders
                            SET orderstep = 4,
                                stateId = 2
                            WHERE orderId = '" . substr($order_id, 3) . "' ");
                $CardPay->updateStatus($order_id, 10);
                $CardPay->setStatusCode($order_id, 3);
                $z = new Engine();
                $z->set_path_to_root('../../');
                $z->load_class('settings');
                new Settings();
                $z->mail(array('pay@editus.ru'), 'Оплата - Avangard', 'Заказ №'.$order_id.' оплачен');
                header("HTTP/1.1 202 Accepted");
            }
            if ($type=='sho') {
                $db = new Db();
                $db->query( "UPDATE ShopOrders
                             SET stateId = 3,
                                 orderstep = 2
                             WHERE orderId = '" . substr($order_id, 3) . "' " );
                $CardPay->updateStatus($order_id, 10);
                $CardPay->setStatusCode($order_id, 3);
                $z = new Engine();
                $z->set_path_to_root( '../../' );
                $z->load_class( 'settings' );
                new Settings();
                $z->mail( array( 'support@editus.ru' ), 'Оплата - Avangard', 'Заказ №K' . $orderId . ' оплачен' );
                header("HTTP/1.1 202 Accepted");
            }
        }
    } else {
        $CardPay->setStatusCode($order_id, $data['status_code']);
    }
}
exit;