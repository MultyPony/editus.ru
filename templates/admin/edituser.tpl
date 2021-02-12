<form action="<?php echo 'index.php?do=' . $_GET['do'] . '&id=' . $_GET['id']; ?>" method="post">
    <table>
        <tr><td><?php echo _USERFIRSTNAME; ?></td><td><input name="edituserfirstname" type="text" value="<?php echo $data[1]; ?>"  /></td></tr>
        <tr><td><?php echo _USERLASTNAME; ?></td><td><input name="edituserlastname" type="text" value="<?php echo $data[2]; ?>"/></td></tr>
        <tr><td><?php echo _USERADDITIONALNAME; ?></td><td><input name="edituseradditionalname" type="text" value="<?php echo $data[3]; ?>"/></td></tr>
        <tr><td><?php echo _USEREMAIL; ?></td><td><input disabled="disbled" name="edituseremail" type="text" value="<?php echo $data[4]; ?>"/></td></tr>
        <tr><td><?php echo _USERPASSWORD; ?></td><td><input name="edituserpassword" type="text" /></td></tr>
        <tr><td><?php echo _USERGROUP; ?></td>
            <td>
                <select name="editusergroup">
                    <option>...</option>
                    <?php
                    foreach ($groups as $cur) {
                        if ($cur[0] == $data[6]) {
                            $selected = 'selected ';
                        };
                        ?>
                        <option <?php echo $selected;
                        $selected = ''; ?> value="<?php echo $cur[0]; ?>"><?php echo $cur[1]; ?></option>
<?php } ?>
                </select>                
            </td>
        </tr>

        <tr><td><?php echo _USERTELEPHONE; ?></td><td><input name="editusertelephone" type="text" value="<?php echo $data[7]; ?>"/></td></tr>
        <tr><td><?php echo _USERINFORMATION; ?></td><td><textarea name="edituserinformation"><?php echo $data[8]; ?></textarea></td></tr>
<?php if ($data[10] == 1) {
    $checked = 'checked="checked"';
} ?>
        <tr><td><?php echo _USERACTIVATION; ?></td><td><input <?php echo $checked;
$checked = ''; ?>name="edituseractivation" type="checkbox" value="<?php echo $data[6]; ?>"/></td></tr>
        <tr><td><?php echo _USERDELETE; ?></td><td><input name="deluserid" type="checkbox" /></td></tr>
        <tr><td><?php echo _USERREGISTERDATE; ?></td><td><input disabled="disbled" name="edituserregisterdate" type="text" value="<?php echo $data[11]; ?>" /></td></tr>
    </table>
    <input name="edituserid" type="hidden" value="<?php echo $data[0]; ?>" />
    <input type="submit" value ="<?php echo _EDITUSER; ?>" />
</form>