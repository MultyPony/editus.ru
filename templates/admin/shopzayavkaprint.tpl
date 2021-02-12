<h2><?php echo _SZP_TITLE; ?></h2>
<table class="dataview">
    <thead>
        <tr>
            <td><?php echo _SZP_NUM; ?></td>
            <td><?php echo _SZP_ITEMS; ?></td>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
        foreach ($data as $cur2){
            echo '
                <tr>
                <td>K' . $cur2['orderId'] .'</a></td>
                <td>';
            foreach ($cur2['itemsId'] as $cur){
                if (file_exists('./../include/bookstore/K'.$cur2['orderId'].'/'.$cur.'_zayavka.xls')){
                    echo '<a href="./../include/shopget.php?oid='.$cur2['orderId'].'&itemid='.$cur.'&o=zayavka">'._SZP_ZAYAV.$items[$cur].'</a><br />';
                }
            }
            echo '</tr>';
        }
    }
    ?>
</table>