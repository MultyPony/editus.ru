<h2><?php echo _LSAO_TITLE; ?></h2>
<form method="get" action="index.php"> 
    <fieldset>
        <legend> <?php echo _LSAO_FILTER; ?></legend>
        <input type="hidden" name="do" value="listshopallorders" />
        <label><?php echo _LSAO_USERORDER; ?><input style="width: 70px" type="text" name="userorder" /></label>
        <label><?php echo _LSAO_ORDERID; ?><input style="width: 70px" type="text" name="orderid" /></label>
        <label><?php echo _LSAO_ORDERSTATE; ?>
            <select name="filtstate">
            <option value="all"><?php echo _LSAO_ALLORDER; ?></option>
        <?php foreach ($states as $key => $val) {?>
            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
            <?php } ?>
        </select></label>
        <?php echo _LSAO_ORDERPRICE; ?><input type="text" name="pf" style="width: 70px" /><input style="width: 70px" type="text" name="pt" />
        <br><input type="submit" value="<?php echo _LSAO_APPLYY; ?>" />
    </fieldset>
</form>
<table class="dataview" id="listshopallorders">
    <thead>
        <tr>
            <th><?php echo _LSAO_ORDERIDADMIN; ?></th>
            <th><?php echo _LSAO_USERMAIL; ?></th>
            <th><?php echo _LSAO_ORDERPRICE;?></th>
            <th><?php echo _LSAO_ORDERSTATE; ?></th>
            <th><?php echo _LSAO_ORDERDATE; ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
        foreach ($data as $cur){
            if ($cur['orderstep']>0){
                $state = $states[$cur['stateId']];
            } 
//            if ($cur['orderstep']==1){
//                $state = _LSAO_NOTCOMPCOVER;
//            }
//            if ($cur['orderstep']==2){
//                $state = _LSAO_NOTCOMPDELIV;
//            }
            echo '
                <tr>
                <td><a href="?do=viewshoporderadmin&amp;o='.$cur['orderId'].'" >K' . $cur['orderId'].'</a></td>
                <td><a href="?do=edituser&amp;id='.$cur['userId'].'">' . $cur['userEmail'] . '</a></td>
                <td style="background-color: #FE2E2E; color: black;"> ' . $cur['orderPriceTotal'] . '</td>
                <td> ' . $state . '<br><a href="?do=editshopstatus&amp;id=' . $cur['orderId'] . '">' . _LSAO_CHANGESTATUS . '</a></td>
                <td>' . date("H:i d-m-Y", strtotime($cur['orderDate'])). '</td>
                </tr>';
        }
    }
    ?>

</table>
 <?php echo $pages;?>
<!--<input type="button" value="Add"></input>-->
