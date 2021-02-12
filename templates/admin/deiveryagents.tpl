<table style="border: 1px solid;">
    <thead>
        <tr>
            <td><?php echo _ORDERIDADMIN ?></td>
            <td><?php echo _ORDERNAMEADMIN ?></td>
            <td><?php echo _ORDERAUTHORADMIN ?></td>
            <td><?php echo _ORDERCOUNTADMIN ?></td>
            <td><?php echo _ORDERLISTSADMIN ?></td>
            <td><?php echo _ORDERCHARSADMIN ?></td>
            <td><?php echo _ORDERPRICEADMIN ?></td>
            <td><?php echo _ORDERPRICEADDADMIN ?></td>
            
            
            
        </tr>
    </thead>
    <?php
    foreach ($data as $cur)
        echo '
            <tr>
            <td>' . $cur[0] .'</td>
            <td>' . $cur[1] . '</td>
            </tr>';
//    echo '
//        <tr>
//        <td><input type="text"></input></td>
//        <td><input type="text"></input></td>
//        <td><input type="text"></input></td>
//        <td><input type="text"></input></td>
//        </tr>';
    ?>

</table>
<!--<input type="button" value="Add"></input>-->