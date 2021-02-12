<h2 id="ordersmakeup"><?php echo _OMU_TITLE; ?></h2>
<p style="margin: 0;">
    <span style="border-bottom: 1px solid #000;">
    <input type="hidden" id="activetab" value="getfromprint"/>
    <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="getfromprint" class="but" value="<?php echo _OMU_ORDERINFO;?>" />
    <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="orders" class="but" value="<?php echo _OMU_LISTORDERS;?>"/>
    </span>
</p>
<div id="getfromprint-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
    <form method="post">
        <label><input style="font-size: 36px;" type="text" name="orderid" id="orderid" value="<?php echo $orderid; ?>" /></label>
        <input style="font-size: 36px;"  type="submit" value="<?php echo _OMU_GETDATAORDER; ?>"/>
    </form>
    <?php if ($chang){
        echo '<p>'._OMU_CHANGESTATUS.'</p>';
    }
    if (!empty($data)){ ?>
        <table>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_OREDERNAME;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderName']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_COUNT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderCount']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_PAGES;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPages']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_SYMB;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderSymb']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_COVER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $covers[$data['orderCover']]; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_FORMAT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['formatName']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_PAPERTYPE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['PaperTypeName'].' '.$data['PaperTypeWeight']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_BIND;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['BindingName']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_COLOR;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['PrintTypeName']; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OMU_ADDSERVICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $addedads; ?></td></tr>
        </table>
    <?php }?>
</div>
<div id="orders-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
    <table class="dataview">
        <thead>
            <tr>
                <th><?php echo _ORDERIDADMIN ?></th>
                <th><?php echo _ORDERNAMEADMIN ?></th>
                <th><?php echo _ORDERAUTHORADMIN ?></th>
                <th><?php echo _ORDERCOUNTADMIN ?></th>
                <th><?php echo _ORDERLISTSADMIN ?></th>
                <th><?php echo _ORDERTODO ?></th>
            </tr>
        </thead>
        <?php
        if (count($orders)>0){
        foreach ($orders as $cur)
            echo '
                  <tr>
                <td>'.$cur['orderId'].'</td>
                <td>' . $cur['orderName'] . '</td>
                <td>' . $cur['orderAutor'] . '</td>
                <td>' . $cur['orderCount'] . '</td>
                <td> ' . $cur['orderPages'] . '</td>
                <td>
                <a href="./index.php?do=ordersmakeup&amp;orderid='.$cur['orderId'].'">'._OMU_VIEW.'</a><br>
                <a href="ftp://www.pcentre.net/'.date("d.m.Y", strtotime($dataorder['orderUploadDate'])).'/'.$cur['orderId'].'/">Открыть папку с Заказом на FTP</a><br>
                </td>
                </tr>';
        }
        ?>
    </table>
</div>