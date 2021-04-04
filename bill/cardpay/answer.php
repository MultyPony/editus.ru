<?php
include_once "../../config.inc.php";
include_once "../../include/db_class.php";
include_once './CardPayAvangard.php';

session_start();

header("Location: https:editus.php?do=orderstep4&o=" . intval($_GET['o']) . '&paycard_status=99');
exit(0);
