<form action="<?php echo 'index.php?do=' . $_GET['do'] . '&id=' . $_GET['id']; ?>" method="post" enctype="multipart/form-data">
    <table>
        <tr><td><?php echo _EP_PARTNERTITLE; ?></td><td><input name="ep_title" type="text" value="<?php echo $data['partnerName']; ?>"  /></td></tr>
        <tr><td><?php echo _EP_PARTNERKEY; ?></td><td><input name="ep_key" type="text" value="<?php echo $data['partnerKey']; ?>"/></td></tr>
        <tr><td><?php echo _EP_RETURNPAGE; ?></td><td><input name="ep_returnpage" type="text" value="<?php echo $data['partnerPage']; ?>"/></td></tr>
        <tr><td><?php echo _EP_MAINPAGE; ?></td><td><input  name="ep_mainpage" type="text" value="<?php echo $data['partnerMainPage']; ?>"/></td></tr>
        <tr><td><?php echo _EP_PERCENT; ?></td><td><input name="ep_percent" type="text" value="<?php echo $data['percent']; ?>" /></td></tr>
        <tr><td><?php echo _EP_STATUS; ?></td>
            <td>
                <select name="ep_status">
                    <option>...</option>
                    <?php
                    foreach ($statuses as $key => $value) {
                        if ($key == $data['status']) {
                            $selected = 'selected ';
                        };
                        ?>
                        <option <?php echo $selected;
                        $selected = ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php } ?>
                </select>                
            </td>
        </tr>
    </table>
    <input name="edituserid" type="hidden" value="<?php echo $data[0]; ?>" />
    <input type="submit" value ="<?php echo _EP_SAVEBTN; ?>" />
</form>