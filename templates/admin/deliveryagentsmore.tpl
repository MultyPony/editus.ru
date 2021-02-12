<table style="border: 1px solid;">
    <thead>
        <tr>
            <td><?php echo _DELYVERYAGENTCOUNTRYADMIN ?></td>
            <td><?php echo _DELYVERYAGENTREGIONADMIN ?></td>
            <td><?php echo _DELYVERYAGENTCOSTSADMIN ?></td>
       
            
            
            
        </tr>
    </thead>
    <?php
    if (count($data)>0)
    {
    foreach ($data as $cur)
        echo '
            <tr>
            <td>' . $cur['CountryName'] .'</td>
            <td>' . $cur['RegionName'] . '</td>
            <td>'.$cur['DeliveryProviderCosts']._CURRENCY.' </td>
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
<form action="./index.php?do=deliveryagents" method="post">
<table>
    <tr>
        <td>Страна</td>
        <td>Регион</td>
        <td>Цена</td>
        <td>Страна</td>
    </tr>
    <tr>
        <td>
<SELECT NAME="countryid">
    <?php foreach ($data2 as $cur)
        echo '<OPTION VALUE="'.$cur['CountryId'].'">'.$cur['CountryName'].'</OPTION>';
        ?>
</SELECT>
            </td>
            <td>
<SELECT NAME="regionid">
    <?php foreach ($data3 as $cur)
        echo '<OPTION VALUE="'.$cur['RegionId'].'">'.$cur['RegionName'].'</OPTION>';
        ?>
</SELECT>
                </td>
<td>
    <input type="text" name="deliverycost"></input>
    </td>
    <td>
        <input type="hidden" name="more" value="<?php echo $agentid ?>"></input>
<input type="submit" value="Добавить"></input>
</td>
</tr>
</table>
    </form>