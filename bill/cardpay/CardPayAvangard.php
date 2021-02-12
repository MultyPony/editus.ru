<?php
/**
 * User: vasia
 * Date: 17/11/14
 * Time: 23:08
 */

include_once "../../config.inc.php";
include_once "../../include/db_class.php";

class CardPayAvangard {

    const URL_REGISTER_ORDER = 'https://www.avangard.ru/iacq/h2h/reg';
    const URL_ABORT_ORDER = 'https://www.avangard.ru/iacq/h2h/reverse_order';
    const URL_INFO_ORDER = 'https://www.avangard.ru/iacq/h2h/get_order_info';

    protected $curl = null;
    protected $db = null;
    protected $lastResultRaw = null;

    protected $shop_id = null;
    protected $shop_password = null;
    protected $shop_sign = null;
    protected $shop_av_sign = null;

    protected $headers = array
    (
        'Content-type: application/x-www-form-urlencoded;charset=windows-1251',
        'Expect:'
    );

    function __construct($shop_id, $shop_password, $shop_sign, $shop_av_sign){
        $this->shop_id = $shop_id;
        $this->shop_password = $shop_password;
        $this->shop_sign = $shop_sign;
        $this->shop_av_sign = $shop_av_sign;

        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);

        $this->db = new Db();
    }

    function registerOrder($orderData){
        $data = '<?xml version="1.0" encoding="UTF-8"?>
                     <NEW_ORDER>
                        <SHOP_ID>' . $this->shop_id . '</SHOP_ID>
                        <SHOP_PASSWD>' . $this->shop_password . '</SHOP_PASSWD>
                        <AMOUNT>' . $orderData['order_amount'] . '</AMOUNT>
                        <ORDER_NUMBER>' . $orderData['order_id'] . '</ORDER_NUMBER>
                        <ORDER_DESCRIPTION>' . $orderData['order_desc'] . '</ORDER_DESCRIPTION>
                        <LANGUAGE>RU</LANGUAGE>
                        <BACK_URL>' . $orderData['back_url'] . '</BACK_URL>
                        <CLIENT_NAME>' . $orderData['client_name'] . '</CLIENT_NAME>
                        <CLIENT_ADDRESS>' . $orderData['client_address'] . '</CLIENT_ADDRESS>
                        <CLIENT_EMAIL>' . $orderData['client_email'] . '</CLIENT_EMAIL>
                        <CLIENT_PHONE>' . $orderData['client_phone'] . '</CLIENT_PHONE>
                        <CLIENT_IP>'.$_SERVER["REMOTE_ADDR"].'</CLIENT_IP>
                     </NEW_ORDER>';
        $res = $this
            ->setUrl(self::URL_REGISTER_ORDER)
            ->setData($data)
            ->send()
            ->getLastResult();
        if ($res['ticket']) {
            $this->db->query("INSERT INTO `CardPayAvangard` (`id`, `ticket`, `ok_code`, `failure_code`, `response_code`, `order_id`, `dataOrder`)
                              VALUES ('" . $res['id'] . "', '" . $res['ticket'] . "', '" . $res['ok_code'] . "', '" . $res['failure_code'] . "', '" . $res['response_code'] . "', '" . $orderData['order_id'] . "', '" . json_encode($orderData) . "' ) ");
        }
        return $this;
    }

    function updateStatus($order_id, $status){
        if (empty($order_id)) return false;
        $this->db->query("UPDATE `CardPayAvangard`
                            SET status = '" . intval($status) . "'
                            WHERE order_id = '" . $this->db->mres($order_id) . "'  ");
    }

    function getOrderInfo($order_id){
        $order_id = $order_id;
        $res = $this->getOrderRegInfo($order_id);
        if (count($res) > 0 && isset($res['ticket'])) {
            $ticket = $res['ticket'];
        } else {
            return null;
        }
        $data = '<?xml version="1.0" encoding="UTF-8"?>
                    <get_order_info>
                       <ticket>' . $ticket . '</ticket>
                       <shop_id>' . $this->shop_id . '</shop_id>
                       <shop_passwd>' . $this->shop_password . '</shop_passwd>
                    </get_order_info>';
        $res = $this
            ->setUrl(self::URL_INFO_ORDER)
            ->setData($data)
            ->send()
            ->getLastResult();
        return $res;
    }

    function markAsCompletedOrder($order_id){
        return $this->db->query("UPDATE `CardPayAvangard`
                          SET `status` = 1
                          WHERE `order_id` = '" . $order_id . "' ");
    }

    function abortOrder($ticket, $amount = false)
    {
        $data = '<?xml version="1.0" encoding="UTF-8"?>
                    <reverse_order>
                       <ticket>' . $ticket . '</ticket>
                       <shop_id>' . $this->shop_id . '</shop_id>
                       <shop_passwd>' . $this->shop_password . '</shop_passwd>';
        if ($amount !== false){
          $data .='<amount>' . $amount . '</amount>';    
        }
        $data .='</reverse_order >';
        $res = $this
            ->setUrl( self::URL_ABORT_ORDER )
            ->setData( $data )
            ->send()
            ->getLastResult();
        return $res;
    }


    function getOrderRegInfo($order_id, $status = false){
        $sql = "SELECT *
                FROM `CardPayAvangard`
                WHERE `order_id` = '" . $this->db->mres($order_id) . "' " . ($status===false ? "" : " AND status = '" . $status . "'") . " LIMIT 1";
        $this->db->query($sql);
        $res = $this->db->fetch_array();
        if (isset($res['dataOrder'])) {
            $res['dataOrder'] = (array)json_decode($res['dataOrder'], true);
        }
        return $res;
    }

    function getOrderRegInfoByResCode($rescode){
        $this->db->query("SELECT *
                          FROM `CardPayAvangard`
                          WHERE `ok_code` = '" . $this->db->mres($rescode) . "'
                             OR `failure_code` = '" . $this->db->mres($rescode) . "' LIMIT 1");
        $res = $this->db->fetch_array();

        return $res;
    }

    protected function setUrl($url){
        curl_setopt($this->curl, CURLOPT_URL, $url);
        return $this;
    }

    protected function setData($data){
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, "xml=".$data);
        return $this;
    }

    function getLastResultRaw(){
        return $this->lastResultRaw;
    }

    function send(){
        $this->lastResultRaw = curl_exec($this->curl);
        return $this;
    }

    function getLastResult(){
        return (array)simplexml_load_string($this->getLastResultRaw());
    }

    function close(){
        curl_close($this->curl);
        return $this;
    }

    function removeRegInfo($order_id){
        $this->db->query("DELETE FROM `CardPayAvangard`
                          WHERE order_id = '" . $this->db->mres($order_id) . "'  ");
    }

    function getSignature($order_id){
        $data = $this->getOrderRegInfo($order_id);
        $amount = $data['dataOrder']['order_amount'];
        return mb_strtoupper(md5(mb_strtoupper(md5($this->shop_av_sign) . md5($this->shop_id . $order_id . $amount))));
    }

    function setStatusCode($order_id, $code){
        if (empty($order_id)) return false;
        $this->db->query("UPDATE `CardPayAvangard`
                            SET status_code = '" . intval($code) . "'
                            WHERE order_id = '" . $this->db->mres($order_id) . "'  ");
    }
} 
