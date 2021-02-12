<?php
include_once "../../config.inc.php";
include_once "../../include/db_class.php";
include_once './CardPayAvangard.php';
include_once './Log.php';

$CardPay = new CardPayAvangard('9281', 'kiLyCsJLyS', 'xdXeJAZpZSzyOkwWZvjv', 'dIqdYGqSqaUcdbymVVVE');

$res = $CardPay->getOrderInfo('pub121191');
var_dump($CardPay->getOrderRegInfo($order_id), $res);