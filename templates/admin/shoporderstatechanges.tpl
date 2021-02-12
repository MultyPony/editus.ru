<h2><?php echo _SOSC_TITLE; ?></h2>
<form method="post" action="index.php?do=orderstatechanges"> 
    <fieldset>
        <legend> <?php echo _SOSC_FILTER; ?></legend>
        <label><?php echo _SOSC_ORDERID; ?><input type="text" name="searchorder" /></label>
        <br><input type="submit" value="<?php echo _SOSC_APPLYY; ?>" />
    </fieldset>
</form>
<table class="dataview" id="orderstatechanges">
    <thead>
        <tr>
            <th><?php echo _SOSC_NUM; ?></th>
            <th><?php echo _SOSC_STATE; ?></th>
            <th><?php echo _SOSC_USER; ?></th>
            <th><?php echo _SOSC_DATE; ?></th>          
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur)
        echo '
            <tr>
            <td style="padding: 3px;">K' . $cur['orderId'] .'</td>
            <td style="padding: 3px;">' . $states[$cur['curState']] .'</td>
            <td style="padding: 3px;"><a href="./index.php?do=edituser&id='.$cur['userId'].'" >' . $cur['userEmail'].'</a></td>
            <td style="padding: 3px;">' . date("H:i d.m.Y", strtotime($cur['dateChange'])) . '</td>
            </tr>';
    }
    ?>

</table>
