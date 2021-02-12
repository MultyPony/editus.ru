<h2><?php echo _SOOP_TITLE; ?></h2>
<table class="dataview">
    <thead>
        <tr>
            <td><?php echo _SOOP_NUM; ?></td>
            <td><?php echo _SOOP_ITEMS; ?></td>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
        foreach ($data as $cur){
            echo '
                <tr>
                <td>K' . $cur['orderId'] .'</a></td>
                <td>';
            foreach ($cur['itemsId'] as $cur){
                echo '<a href="./index.php?do=shopviewitem&itemid='.$cur.'">'.$items[$cur].'</a><br />';
            }
            echo '</td>
                </tr>';
        }
    }
    ?>
</table>