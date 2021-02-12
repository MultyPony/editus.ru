<fieldset>
    <legend><?php echo _EPTC_TITLE;?></legend>
    <table>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <?php echo $type[$cur['CoverType']].' '.$cur['PaperTypeName'].' '.$cur['PaperTypeWeight'];?>
                        </td>
                        <td>
                            <input type="text" name="editprice" value="<?php echo $cur['PaperTypeCost'];?>" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['PaperTypeId']; ?>" />
                            <input type="submit" value="<?php echo _EPTC_EDIT; ?>" />
                        </td>
                    </tr>
                </form>
    <?php } ?>
        </tbody>
    </table>
</fieldset>
