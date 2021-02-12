<h2 id="ordersmakeup"><?php echo _SOMU_TITLE; ?></h2>
<p style="margin: 0;">
    <span style="border-bottom: 1px solid #000;">
    <input type="hidden" id="activetab" value="getfromprint"/>
    <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="getfromprint" class="but" value="<?php echo _SOMU_ORDERINFO;?>" />
    <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="orders" class="but" value="<?php echo _SOMU_LISTORDERS;?>"/>
    </span>
</p>
<div id="getfromprint-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
    <form method="post">
        <label style="font-size: 36px;">K<input style="font-size: 36px;" type="text" name="orderid" id="orderid" value="<?php echo $orderid; ?>" /></label>
        <input style="font-size: 36px;"  type="submit" value="<?php echo _SOMU_GETDATAORDER; ?>"/>
    </form>
    <?php if ($chang){
        echo '<p>'._SOMU_CHANGESTATUS.'</p>';
    }
    if (!empty($data['itemsId'])){ 
        echo '<p>';
        foreach ($data['itemsId'] as $cur){
            echo '<a href="./index.php?do=shopviewitem&itemid='.$cur.'">'.$items[$cur].'</a><br />';
        }
        echo '</p>';
    }?>
</div>
<div id="orders-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
    <table class="dataview">
        <thead>
            <tr>
                <th><?php echo _SOMU_ORDERIDADMIN ?></th>
                <th><?php echo _SOMU_ORDERTODO ?></th>
            </tr>
        </thead>
        <?php
        if (count($orders)>0){
        foreach ($orders as $cur)
            echo '
              <tr>
                <td>K'.$cur['orderId'].'</td>
                <td>
                    <a href="./index.php?do=shopordersmakeup&amp;orderid='.$cur['orderId'].'">'._SOMU_VIEW.'</a><br>
                    <a href="ftp://www.pcentre.net/'.date("d.m.Y", strtotime($dataorder['orderUploadDate'])).'/'.$cur['orderId'].'/">Открыть папку с Заказом на FTP</a><br>
                </td>
            </tr>';
        }
        ?>
    </table>
</div>