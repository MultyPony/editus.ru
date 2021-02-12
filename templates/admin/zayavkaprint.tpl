<h2><?php echo _ZP_TITLE; ?></h2>
<table class="dataview" id="zayavkaprint">
    <thead>
        <tr>
            <th><?php echo _ZP_NUMl ?></th>
            <th><?php echo _ZP_LINK; ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur){
        echo '
            <tr>
            <td style="padding: 3px;">' . $cur['orderId'] .'</td><td style="padding: 3px;">';
            if (file_exists('./../uploads/'.$cur['userId'].'/'.$cur['orderId'].'/'.$cur['orderId'].'_zayavka.xls')){
                echo '<a href="./../include/get.php?oid='.$cur['orderId'].'&uid='.$cur['userId'].'&o=zayavka">'._ZP_DOWNLOAD.'</a>';
            }
            echo '</td></tr>';
    }
    }
    ?>

</table>
