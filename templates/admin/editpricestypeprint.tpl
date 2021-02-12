<fieldset>
    <legend><?php echo _EPTPR_TITLE;?></legend>
    <table>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <?php echo $cur['PrintTypeName'];?>
                        </td>
                        <td>
                            <input type="text" name="editprice" value="<?php echo $cur['PrintCost'];?>" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['PrintTypeId']; ?>" />
                            <input type="submit" value="<?php echo _EPTPR_EDIT; ?>" />
                        </td>
                    </tr>
                </form>
    <?php } ?>
        </tbody>
    </table>
</fieldset>
