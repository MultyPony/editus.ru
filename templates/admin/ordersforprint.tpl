<h2>Заявки на Печать</h2>
<table class="dataview">
    <thead>
        <tr>
            <td><?php echo _ORDERIDADMIN ?></td>
            <td><?php echo _ORDERUSERNAMEADMIN ?></td>
            <td><?php echo _ORDERNAMEADMIN ?></td>
            <td><?php echo _ORDERAUTHORADMIN ?></td>
            <td><?php echo _ORDERPRICE ?></td>
            <td><?php echo _ORDERTODO ?></td>
           
            
            
            
        </tr>
    </thead>
    <?php
    if (count($data)>0){
    foreach ($data as $cur)
        echo '
            <tr>
            <td>' . $cur['orderId'] .'</td>
            <td>' . $cur['userEmail'] . '</td>
            <td>' . $cur['orderName'] . '</td>
            <td>' . $cur['orderAutor'] . '</td>
            <td> ' . $cur['orderPriceTotal'] . '</td>
            <td><a href="">'._ORDERTODOTASKTOPRINT.'</a> <a href="">'._ORDERTODOTASKTOBUH.'</a> <a href="">'._ORDERTODOTASKTOAKT.'</a></td>
            </tr>';
//    echo '
//        <tr>
//        <td><input type="text"></input></td>
//        <td><input type="text"></input></td>
//        <td><input type="text"></input></td>
//        <td><input type="text"></input></td>
//        </tr>';
    }
    ?>

</table>
<!--<input type="button" value="Add"></input>-->