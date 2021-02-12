
<table>
    <thead><tr><td><?php echo _GROUPSNAME; ?></td><td><?php echo _ROLENEME ?></td><td><?php echo _ADMINACCESS; ?></td><td><?php echo _DELETEGROPUP; ?></td><td></td></tr></thead>
    <tbody>
        <?php foreach ($groups as $cur) {
            ?>
            <form action="<?php echo 'index.php?do=' . $_GET['do']; ?>" method="post">
                <tr>
                    <td>
                        <input name="editgroupsname" type="text" value="<?php echo $cur[1] ?>" />
                    </td>
                    <td>
                        <select name="editgroupsrole">
                            <?php
                            foreach ($roles as $cur2) {
                                if ($cur[3] == $cur2[0]) {
                                    $selected = 'selected="selected"';
                                };
                                ?>
                                <option <?php echo $selected;
                        $selected = ''; ?> value="<?php echo $cur2[0]; ?>"><?php echo $cur2[1]; ?></option>
    <?php } ?>
                        </select>
                    </td>
                    <td><?php
    if ($cur[2] == 1) {
        $checked = 'checked="checked"';
    }
    ?>
                        <input name="adminaccess" <?php echo $checked;
    $checked = ''; ?> type="checkbox" />
                    </td>                  
                    <td>
                        <input name="delgroups" type="checkbox" />
                    </td>
                    <td>
                        <input name="idgroup" type="hidden" value="<?php echo $cur[0]; ?>" />
                        <input type="submit" value="<?php echo _EDITGROUP; ?>" />
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
                    <input name="newgroupsname" type="text" />
                </td>
                <td>
                    <select name="newgroupsrole">
<?php foreach ($roles as $cur) { ?>
                            <option value="<?php echo $cur[0]; ?>"><?php echo $cur[1]; ?></option>
<?php } ?>
                    </select>
                </td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <input type="submit" value="<?php echo _ADDGROUPS; ?>"/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
