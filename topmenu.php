<?php 
    require_once './config.inc.php';
    require_once './include/db_class.php';
?>

<div class="entry-meta" id="logintop">
<?php
    if (Main_config::$serviceoff !=1 || isset($_SESSION['admin'])){
    if (!isset($_SESSION['userEmail'])) {
?>    
    <a href="editus.php"> войти</a>, 
    <a href="editus.php?do=register"> зарегистрироваться</a> или 
    <a href="editus.php?do=recover_password"> напомнить пароль</a>

<?php } else { ?>
    <a href="editus.php?do=listorders">издать книгу</a>,   
<?php 
    $db = new Db();
    $db->query("SELECT SUM(amount) AS amount
                FROM ShopCart
                WHERE userId = '".$_SESSION['userId']."' ");
    $row = $db->fetch_array();
    $s = 'style="display:none;"';
    if ($row['amount']!=NULL){
        $s = 'style="display:inline;"';
    }
?>
    <a href="editus.php?do=showcart">
        купить книгу<span <?php  echo $s;?> id="cart"> (<span id="carts"><?php  echo $row['amount'];?></span>)</span>
    </a>, 
    <a href="editus.php?do=editclientdata"> мои данные</a>,
    <a href="editus.php?do=logout">выход</a>
<?php 
    }
} else { echo 'Ведутся технические работы'; } 
?>
</div>
