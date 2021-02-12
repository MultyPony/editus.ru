<h2><?php echo _OSFP_PAY ?></h2>
<table class="dataview" id="ordersshopforpay">
    <thead>
        <tr>
            <th><?php echo _OSFP_NUM ?></th>
            <th><?php echo _OSFP_EMAIL ?></th>
            <th><?php echo _OSFP_PRICE ?></th>
            <th><?php echo _OSFP_DATE ?></th>          
            <th><?php echo _OSFP_ACTION ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur)
        echo '
            <tr>
            <td style="padding: 3px;">K' . $cur['orderId'] .'</td>
            <td style="padding: 3px;">' . $cur['userEmail'] .'</td>
            <td style="padding: 3px;">' . $cur['orderPriceTotal'] . ' '._OSFP_RUB.'</td>
            <td style="padding: 3px;">' . date("H:i d.m.Y", strtotime($cur['orderDate'])) . '</td>
            <td style="padding: 3px;"><a href="./index.php?do=ordersshopforpay&orderid='.$cur['orderId'].'&ok">'._OSFP_CONF.'</a></td>
            </tr>';
    }
    ?>

</table>
