<fieldset>
    <legend><?php echo _EPT_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _EPT_NAME; ?></td><td><?php echo _EPT_WEIGHT; ?></td><td><?php echo _EPT_TYPEPRINT; ?></td><td><?php echo _EPT_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input name="name" type="text" value="<?php echo $cur['PaperTypeName'] ?>" />
                        </td>
                        <td>
                            <input name="weight" type="text" value="<?php echo $cur['PaperTypeWeight'] ?>" />
                        </td>
                        <td>
                            <select name="color">
                                <?php foreach ($color as $key => $value) { 
                                    if ($cur['Color']==$key){
                                        $sel = 'selected="selected"';
                                    }?>
                                    <option <?php echo $sel; $sel = ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['PaperTypeId']; ?>" />
                            <input type="submit" value="<?php echo _EPT_EDIT; ?>" />
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
                        <input name="newname" type="text" />
                    </td>
                    <td>
                        <input name="newweight" type="text" />
                    </td>
                    <td>
                        <select name="newcolor">
                            <?php foreach ($color as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _ETP_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>