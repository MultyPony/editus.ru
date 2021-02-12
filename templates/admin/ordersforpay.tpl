<h2><?php echo _OFP_PAY ?></h2>
<table class="dataview" id="ordersforpay">
    <thead>
        <tr>
            <th><?php echo _OFP_NUM ?></th>
            <th><?php echo _OFP_EMAIL ?></th>
            <th><?php echo _OFP_PRICE ?></th>
            <th><?php echo _OFP_DATE ?></th>          
            <th><?php echo _OFP_ACTION ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur)
        echo '
            <tr>
            <td style="padding: 3px;">' . $cur['orderId'] .'</td>
            <td style="padding: 3px;">' . $cur['userEmail'] .'</td>
            <td style="padding: 3px;">' . $cur['orderPriceTotal'] . ' '._OFP_RUB.'</td>
            <td style="padding: 3px;">' . date("H:i d.m.Y", strtotime($cur['orderDate'])) . '</td>
            <td style="padding: 3px;"><a href="./index.php?do=ordersforpay&orderid='.$cur['orderId'].'&ok">'._OFP_CONF.'</a></td>
            </tr>';
    }
    ?>

</table>
