<h2><?php echo _SOFME_TITLE; ?></h2>
<table class="dataview">
    <thead>
        <tr>
            <td><?php echo _SOFME_NUM; ?></td>
            <td><?php echo _SOFME_ITEMS; ?></td>
            <td><?php echo _SOFME_ACTION; ?></td>
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
                if (!file_exists('./../items/'.$cur.'/'.$cur.'_block.pdf') || !file_exists('./../items/'.$cur.'/'.$cur.'_cover.pdf')){
                    echo '<a href="./index.php?do=shopedititem&iditem='.$cur.'">'.$items[$cur].'</a><br />';
                }
            }
            echo '</td><td><a href="./index.php?do=shopordersformanualedit&orderid='.$cur2['orderId'].'&ok">'._SOFME_NEXT.'</a></td>
                </tr>';
        }
    }
    ?>
</table>