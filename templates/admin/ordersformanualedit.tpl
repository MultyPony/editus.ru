<h2><?php echo _OFME_TITLE ?></h2>
<table class="dataview" id="ordersformanualedit">
    <thead>
        <tr>
            <th><?php echo _OFME_NUM; ?></th>
            <th><?php echo _OFME_EMAIL; ?></th>
            <th><?php echo _OFME_NAME; ?></th>
            <th><?php echo _OFME_AUTHOR ?></th>
            <th><?php echo _OFME_COUNT; ?></th>
            <th><?php echo _OFME_PAGES; ?></th>
            <th><?php echo _OFME_ACTION; ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
        foreach ($data as $cur){
            echo '
                <tr>
                <td>' . $cur['orderId'] .'</td>
                <td>' . $cur['userEmail'] .'</td>
                <td>' . $cur['orderName'] . '</td>
                <td>' . $cur['orderAutor'] . '</td>
                <td>' . $cur['orderCount'] . '</td>
                <td> ' . $cur['orderPages'] . '</td>
                <td>
                <a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=block'.$cur['formatUplBlock'].'">'._OFME_GETDOC.'</a>
                <a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=blocklayot">'._OFME_GETPDF.'</a>
                <a class="replblock" id="' . $cur['orderId'] .'" href="' . $cur['userId'] .'"  onclick="return false;">'._OFME_REPLACEBLOCKPDF.'</a><br />';
                if (file_exists('../uploads/'.$cur['userId'].'/'.$cur['orderId'].'/'.$cur['orderId'].'_cover.pdf')){
                    echo '<a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=coverlayot">'._OFME_GETPDFC.'</a><br />';
                }


//                <a href="../../uploads/'.$cur['userId'].'/'.$cur['orderId'].'/'.$cur['orderId'].'_block_converted.pdf">Скачать PDF</a>
//                <a href="../../uploads/'.$cur['userId'].'/'.$cur['orderId'].'/'.$cur['orderId'].'_block.doc">Скачать DOC</a>
//                <a href="./index.php?do=ordersformanualedit&orderid='.$cur['orderId'].'&ok">Отправить в Типографию</a>
                if (!empty($cur['formatUplImg'])){
                    echo '<a href="../include/get.php?uid='.$cur['userId'].'&amp;oid='.$cur['orderId'].'&amp;o=coverdesign">'._OFME_GETCOVERDESIGN.'</a>';
                }
                echo '<a class="replcover" id="' . $cur['orderId'] .'" href="' . $cur['userId'] .'"  onclick="return false;">'._OFME_REPLACECOVERPDF.'</a><br />';


                echo '<a href="./index.php?do=ordersformanualedit&orderid='.$cur['orderId'].'&ok">'._OFME_NEXT.'</a>
                   </td>
                </tr>';

        }
    }
    ?>

</table>