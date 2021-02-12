<fieldset>
    <legend><?php echo _ESC_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _ESC_NAME; ?></td></td><td><?php echo _ESC_GROUP; ?></td><td><?php echo _ESC_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input name="name" type="text" value="<?php echo $cur['catName'] ?>" />
                        </td>

                        <td>
                            <select name="group">
                                <?php foreach ($groups as $cur2) { 
                                    if ($cur['userGroupId']==$cur2['groupId']){
                                        $sel = 'selected="selected"';
                                    }?>
                                    <option <?php echo $sel; $sel = ''; ?> value="<?php echo $cur2['groupId']; ?>"><?php echo $cur2['groupName']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['catId']; ?>" />
                            <input type="submit" value="<?php echo _ESC_EDIT; ?>" />
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
                        <select name="newgroup">
                               <?php foreach ($groups as $cur2) { ?>
                                    <option value="<?php echo $cur2['groupId']; ?>"><?php echo $cur2['groupName']; ?></option>
                                <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _ESC_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>