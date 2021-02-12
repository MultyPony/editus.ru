<h2>Заказы</h2>
<form method="get" action="index.php">
    <fieldset>
        <legend> <?php echo _LAO_FILTER; ?></legend>
    <input type="hidden" name="do" value="listallorders" />
    <label><?php echo _LAO_USERORDER; ?><input style="width: 100px" type="text" name="userorder" /></label>
    <label><?php echo _LAO_ORDERID; ?><input style="width: 70px" type="text" name="orderid" /></label>
    <label><?php echo _LAO_ORDERSTATE; ?><select name="filtstate">
        <option value="all"><?php echo _LAO_ALLORDER; ?></option>
        <option value="ncom"><?php echo _LAO_NOTCOMPL; ?></option>
    <?php foreach ($states as $key => $val) {?>
        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
        <?php } ?>
    </select></label><br />
    <?php echo _LAO_ORDERCOUNT; ?><input type="text" name="cf" style="width: 20px" /><input style="width: 20px" type="text" name="ct" />
    <?php echo _LAO_ORDERPRICE; ?><input type="text" name="pf" style="width: 70px" /><input style="width: 70px" type="text" name="pt" />
    <br><input type="submit" value="<?php echo _LAO_APPLYY; ?>" />
    </fieldset>
</form>
<table class="dataview" id="orderlistsadmin" style="width: 900px;">
    <thead>
        <tr>
            <th><?php echo _LAO_ORDERIDADMIN ?></th>
            <th><?php echo _LAO_USERMAIL ?></th>
            <th><?php echo _ORDERNAMEADMIN ?></th>
            <th><?php echo _ORDERAUTHORADMIN ?></th>
            <th><?php echo _ORDERCOUNTADMIN ?></th>
            <th><?php echo _ORDERLISTSADMIN ?></th>
            <th><?php echo _ORDERCHARSADMIN ?></th>
<!--            <th><?php echo _ORDERPRICEADMIN ?></th>
            <th><?php echo _ORDERPRICEADDADMIN ?></th>
            <th><?php echo _ORDERPRICECOVERADMIN ?></th>-->
            <th><?php echo _ORDERPRICETOTALADMIN ?></th>
            <th><?php echo _LAO_ORDERSTATE ?></th>
            <th><?php echo _LAO_ORDERDATE; ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
        foreach ($data as $cur){
            if ($cur['orderstep']>=3){
                $state = $states[$cur['stateId']];
            } if ($cur['orderstep']==1){
                $state = _LAO_NOTCOMPCOVER;
            }
            if ($cur['orderstep']==2){
                $state = _LAO_NOTCOMPDELIV;
            }
            echo '
                <tr>
                <td><a href="?do=vieworderadmin&amp;o='.$cur['orderId'].'" >' . $cur['orderId'].'</a></td>
                <td><a href="?do=edituser&amp;id='.$cur['userId'].'">' . $cur['userEmail'] . '</a></td>
                <td>' . $cur['orderName'] . '</td>
                <td>' . $cur['orderAutor'] . '</td>
                <td>' . $cur['orderCount'] .'</td>
                <td>' . $cur['orderPages'] . '</td>
                <td>' . $cur['orderSymb'] . '</td>';
//                <td>' . $cur['orderPriceBlock'] . '</td>
//                <td> ' . $cur['orderPriceAdditService'] . '</td>
//                <td> ' . $cur['orderPriceCover'] . '</td>
                echo '<td style="background-color: #FE2E2E; color: black;"> ' . $cur['orderPriceTotal'] . '</td>
                <td> ' . $state . '<br><a href="?do=editstatus&amp;id=' . $cur['orderId'] . '">' . _LAO_CHANGESTATUS . '</a></td>
                <td>' . date("H:i d-m-Y", strtotime($cur['orderDate'])). '</td>
                </tr>';
    //    echo '                <a href="../../uploads/'.$cur['userId'].'/'.$cur['orderId'].'/'.$cur['orderId'].'_block_converted.pdf">PDF</a>
//                <a href="../../uploads/'.$cur['userId'].'/'.$cur['orderId'].'/'.$cur['orderId'].'_block.doc">Word</a>
    //        <tr>
    //        <td><input type="text"></input></td>
    //        <td><input type="text"></input></td>
    //        <td><input type="text"></input></td>
    //        <td><input type="text"></input></td>
    //        </tr>';
        }
    }
    ?>

</table>
 <?php echo $pages;?>
<!--<input type="button" value="Add"></input>-->
