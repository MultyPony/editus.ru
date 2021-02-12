<fieldset>
    <legend><?php echo _EDF_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _EDF_NAME; ?></td><td><?php echo _EDF_COUNTRY; ?></td><td><?php echo _EDF_ISCITY; ?></td><td><?php echo _EDF_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input style="width: 200px;" name="name" type="text" value="<?php echo $cur['RegionName'] ?>" />
                        </td>
                        <td>
                            <select name="country">
                                <?php foreach ($country as $key => $value) { 
                                    if ($cur['CountryId']==$key){
                                        $sel = 'selected="selected"';
                                    }?>
                                    <option <?php echo $sel; $sel = ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <?php 
                            if ($cur['iscity']==1){
                                $checked = 'checked="checked"';
                            }?>
                            <input <?php echo $checked; $checked = ''; ?> name="iscity" type="checkbox" />
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['RegionId']; ?>" />
                            <input type="submit" value="<?php echo _EDF_EDIT; ?>" />
                        </td>
                    </tr>
                </form>
    <?php } ?>
        </tbody>
    </table>
    <form method="post">
        <table><tbody>
                <tr>
                    <td>
                        <input style="width: 200px;" name="newname" type="text" />
                    </td>
                    <td>
                        <select name="newcountry">
                            <?php foreach ($country as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input name="newiscity" type="checkbox" />
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _EDF_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>