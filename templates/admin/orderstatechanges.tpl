<h2><?php echo _OSC_TITLE; ?></h2>
<form method="post" action="index.php?do=orderstatechanges"> 
    <fieldset>
        <legend> <?php echo _OSC_FILTER; ?></legend>
        <label><?php echo _OSC_ORDERID; ?><input type="text" name="searchorder" /></label>
        <br><input type="submit" value="<?php echo _OSC_APPLYY; ?>" />
    </fieldset>
</form>
<table class="dataview" id="orderstatechanges">
    <thead>
        <tr>
            <th><?php echo _OSC_NUM; ?></th>
            <th><?php echo _OSC_STATE; ?></th>
            <th><?php echo _OSC_USER; ?></th>
            <th><?php echo _OSC_DATE; ?></th>          
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur)
        echo '
            <tr>
            <td style="padding: 3px;">' . $cur['orderId'] .'</td>
            <td style="padding: 3px;">' . $states[$cur['curState']] .'</td>
            <td style="padding: 3px;"><a href="./index.php?do=edituser&id='.$cur['userId'].'" >' . $cur['userEmail'].'</a></td>
            <td style="padding: 3px;">' . date("H:i d.m.Y", strtotime($cur['dateChange'])) . '</td>
            </tr>';
    }
    ?>

</table>
