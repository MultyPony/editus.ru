<h2><?php echo _OOP_TITLE; ?></h2>
<table class="dataview">
    <thead>
        <tr>
            <td><?php echo _OOP_NUM; ?></td>
            <td><?php echo _OOP_NAME; ?></td>
            <td><?php echo _OOP_AUTHOR; ?></td>
            <td><?php echo _OOP_COUNT; ?></td>
            <td><?php echo _OOP_ACTION; ?></td>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
        foreach ($data as $cur){
            echo '
                <tr>
                <td><a href="./index.php?do=vieworderadmin&o=' . $cur['orderId'] .'">' . $cur['orderId'] .'</a></td>
                <td>' . $cur['orderName'] . '</td>
                <td>' . $cur['orderAutor'] . '</td>
                <td>' . $cur['orderCount'] . '</td>
                <td>
                    <a href="./../include/get.php?uid=' . $cur['userId'] .'&oid=' . $cur['orderId'] .'&o=blocklayot">'._OOP_GETBLOCK.'</a><br />
                    <a href="./../include/get.php?uid=' . $cur['userId'] .'&oid=' . $cur['orderId'] .'&o=coverlayot">'._OOP_GETOVER.'</a>
                </td>
                </tr>';
        }
    }
    ?>

</table>