<fieldset>
    <legend><?php echo _EPAS_TITLE;?></legend>
    <table>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <?php echo $cur['AdditionalServiceName'];?>
                        </td>
                        <td>
                            <input type="text" name="editprice" value="<?php echo $cur['AdditionalServiceCost'];?>" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['AdditionalServiceId']; ?>" />
                            <input type="submit" value="<?php echo _EPAS_EDIT; ?>" />
                        </td>
                    </tr>
                </form>
    <?php } ?>
        </tbody>
    </table>
</fieldset>
