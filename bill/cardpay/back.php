<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Эдитус. Издательство и печать</title>
    </head>
    <body>
        <form action="back.php" method="post" enctype="application/x-www-form-urlencoded">
            <input type="text" name="order_id" placeholder="order id"/>
            <input type="text" name="amount" placeholder="amount"/>
            <input type="submit" value="abort"/>
        </form>
    </body>
<head>
<?php

if (isset($_POST['order_id'])){
    include_once "../../config.inc.php";
    include_once "../../include/db_class.php";
    include_once './CardPayAvangard.php';
    include_once './Log.php';

    session_start();
    if (empty($_SESSION['userId'])) exit;
    $order_id = '-pub' . trim($_POST['order_id']);
    $db = new Db();
    $db->query("SELECT * FROM `CardPayAvangard` WHERE order_id = '" . $order_id . "'");
    $data = $db->fetch_array();
    $ticket = $data['ticket'];
    $CardPay = new CardPayAvangard('9281', 'kiLyCsJLyS', 'xdXeJAZpZSzyOkwWZvjv', 'dIqdYGqSqaUcdbymVVVE');
	if (isset($_POST['amount']) && !empty($_POST['amount'])){
		$r = $CardPay->abortOrder($ticket, $_POST['amount']);
	} else {
		$r = $CardPay->abortOrder($ticket);
	}
    var_dump($ticket, $r);
}


