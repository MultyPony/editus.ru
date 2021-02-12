<?php if ($mode == 1){ ?>
<fieldset id="editproviderscosts">
    <legend><?php echo _EPC_TITLE.$data[0][0];?></legend>
    <table>
        <thead><tr><td><?php echo _EPC_COUNTRY; ?></td><td><?php echo _EPC_REGION; ?></td><td><?php echo _EPC_MINWEIGHT; ?></td><td><?php echo _EPC_MAXWEIGHT; ?></td><td><?php echo _EPC_COSTS; ?></td><td><?php echo _EPC_COSTSKG; ?></td><td><?php echo _EPC_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                    <tr>
                        <td>
                            <?php echo $cur['CountryName']; ?>
                        </td>
                        <td>
                            <?php echo $cur['RegionName']; ?>
                        </td>
                        <td>
                            <?php echo $cur['minWeight']; ?>
                        </td>
                        <td>
                            <?php echo $cur['maxWeight']; ?>
                        </td>
                        <td>
                            <?php echo $cur['DeliveryProviderCosts']._EPC_RUB; ?>
                        </td>
                        <td>
                            <?php echo $cur['OverQuote']; ?>
                        </td>
                        <td>
                            <form action="<?php echo $action; ?>" method="post">
                                <input name="delid" type="hidden" value="<?php echo $cur['DeliveryProvidersCostsId']; ?>" />
                                <input type="submit" value="<?php echo _EPC_DEL; ?>" />
                            </form>
                        </td>
                    </tr>
    <?php } ?>
        <tr>
            <form action="<?php echo $action; ?>" method="post">
                <td>
                    <select name="newcountry" id="newcountry">
                        <?php foreach ($country as $key => $value) { 
                            if ($cur['CountryId']==$key){
                                $sel = 'selected="selected"';
                            }?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select name="newregion" id="newregion">
                        
                    </select>
                </td>
                <td><input name="newminw" type="text" /></td>
                <td><input name="newmaxw" type="text" /></td>
                <td><input name="newcost" type="text" /></td>
                <td><input name="newoverquote" type="text" /></td>
                <td><input name="newid" type="hidden" value="<?php echo intval($_GET['id']); ?>" /><input type="submit" value="<?php echo _EPC_ADD; ?>"/></td>
            </form>
        </tr>
        </tbody>
    </table>
</fieldset>
<?php } if ($mode == 2){
 foreach ($regions as $cur) { ?>
    <option <?php echo $sele,' '.$c;$sele=''; ?> value="<?php echo $cur['RegionId']?>"><?php echo $cur['RegionName']; ?></option>
<?php }
} ?>