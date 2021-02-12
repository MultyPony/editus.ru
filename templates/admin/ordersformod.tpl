<?php if ($mode==1){ ?>
<h2><?php echo _OFM_TITLE; ?></h2>
<table class="dataview" id="oredersformod"> 
    <thead>
        <tr>
            <th><?php echo _OFM_NUM; ?></th>
            <th><?php echo _OFM_EMAIL; ?></th>
            <th><?php echo _OFM_NAME; ?></th>
            <th><?php echo _OFM_AUTHOR ?></th>
            <th><?php echo _OFM_COUNT; ?></th>
            <th><?php echo _OFM_PAGES; ?></th>
            <th><?php echo _OFM_ACTION; ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur){
        echo '
            <tr>
            <td><a href="?do=vieworderadmin&amp;o='.$cur['orderId'].'" >' . $cur['orderId'].'</a></td>
            <td>' . $cur['userEmail'] . '</td>
            <td>' . $cur['orderName'] . '</td>
            <td>' . $cur['orderAutor'] . '</td>
            <td>' . $cur['orderCount'] . '</td>
            <td> ' . $cur['orderPages'] . '</td>
            <td>
            <a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=block'.$cur['formatUplBlock'].'">'._OFM_GETDOC.'</a>
            <a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=blocklayot">'._OFM_GETPDF.'</a><br />';
            if (strpos($cur['orderAdditService'],'8')!=false){
                echo '<a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=cover">'._OFM_GETCOVER.'</a>
                <a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=coverlayot">'._OFM_GETPDFC.'</a><br />';
            }
            echo '<a href="./index.php?do=ordersformod&orderid='.$cur['orderId'].'&ok">'._OFM_NEXT.'</a>
                <a href="./index.php?do=ordersformod&orderid='.$cur['orderId'].'&ok&edit">'._OFM_NEXTEDIT.'</a>
                <a href="./index.php?do=ordersformod&orderid='.$cur['orderId'].'&deny">'._OFM_DENY.'</a>
                </td>
            </tr>';
    } 
    }?>

</table>
<?php } if ($mode==2){?>
<form action="index.php?do=ordersformod" method="post">
<table>
    <tr><td style="vertical-align: middle;"><?php echo _OFM_REASON; ?></td><td><textarea name="causedeny" style="width: 300px; height: 150px;"></textarea></td></tr>
</table>
    <input type="hidden" name="orderid" value="<?php echo intval($_GET['orderid']);?>">
    <input type="submit" style="margin-left: 150px;" value="<?php echo _OFM_SEND; ?>">
</form>
<?php    
} ?>
