<?php
/**
 * User: vasia
 * Date: 17/11/14
 * Time: 23:08
 */

class CardPay {

    const URL_REGISTER_ORDER = 'https://www.avangard.ru/iacq/h2h/reg';

    protected $curl = null;
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
    }

    function registerOrder($orderData){
        $data = '<?xml version="1.0" encoding="windows-1251"?>
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
                    <CLIENT_EMAIL>' . $orderData['clietn_email'] . '</CLIENT_EMAIL>
                    <CLIENT_PHONE>' . $orderData['client_phone'] . '</CLIENT_PHONE>
                    <CLIENT_IP>'.$_SERVER["REMOTE_ADDR"].'</CLIENT_IP>
                 </NEW_ORDER>';
        $this
            ->setUrl(self::URL_REGISTER_ORDER)
            ->setData($data)
            ->send();
        return $this;
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
} 