<h2>Службы доставки</h2>
<table style="border: 1px solid;">
    <thead>
        <tr>
            <td><?php echo _DELYVERYAGENTNAMEADMIN ?></td>
            <td><?php echo _DELYVERYAGENTAVATARADMIN ?></td>
            <td><?php echo _DOMOREADMIN ?></td>
       
            
            
            
        </tr>
    </thead>
    <?php
    foreach ($data as $cur)
        echo '
            <tr>
            <td>' . $cur['DeliveryProviderName'] .'</td>
            <td>' . $cur['DeliveryProviderAvatarUrl'] . '</td>
            <td><a href="./index.php?do=deliveryagents&more='.$cur['DeliveryProviderId'].'">Дополнительно</a></td>
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
<form action="index.php?do=deliveryagents" method="post">
<input type="text" name="addnew"></input>
<input type="submit" value="Добавить"></input>
</form>