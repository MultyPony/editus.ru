<h2>Заказы</h2>
<table class="dataview" id="orderlistsadmin" style="width: 900px;">
    <thead>
        <tr>
            <th><?php echo _PLO_DATE ?></th>
            <th><?php echo _PLO_OREDERNUM ?></th>
            <th><?php echo _PLO_CLIENTEMAIL ?></th>
            <th><?php echo _PLO_BOOKTITLE ?></th>
            <th><?php echo _PLO_AUTHOR ?></th>
            <th><?php echo _PLO_COUNT ?></th>
            <th><?php echo _PLO_TOTAL ?></th>
            <th><?php echo _PLO_STATUS ?></th>
        </tr>
    </thead>
    <?php
    if (count($data)>0){
        foreach ($data as $cur){
            if ($cur['orderstep']>=3){
                $state = $states[$cur['stateId']];
            } if ($cur['orderstep']==1){
                $state = _PLO_NOTCOMPCOVER;
            }
            if ($cur['orderstep']==2){
                $state = _PLO_NOTCOMPDELIV;
            }
            echo '
                <tr>
                    <td>' . date("H:i d-m-Y", strtotime($cur['orderDate'])). '</td>
                    <td><a href="?do=partnervieworder&amp;o='.$cur['orderId'].'" >' . $cur['orderId'].'</a></td>
                    <td><a href="?do=partnerviewuser&amp;id='.$cur['userId'].'">' . $cur['userEmail'] . '</a></td>
                    <td>' . $cur['orderName'] . '</td>
                    <td>' . $cur['orderAutor'] . '</td>
                    <td>' . $cur['orderCount'] .'</td>
                    <td> ' . $cur['orderPriceTotal'] . '</td>
                    <td> ' . $state . '</td>
                </tr>';
        }
    }
    ?>

</table>
 <?php echo $pages;?>