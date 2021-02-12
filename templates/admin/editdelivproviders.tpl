<fieldset>
    <legend><?php echo _EDP_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _EDP_NAME; ?></td><td><?php echo _EDP_EDITPRICE; ?></td><td><?php echo _EDP_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input name="name" style="width: 300px;" type="text" value="<?php echo $cur['DeliveryProviderName'] ?>" />
                        </td>
                        <td>
                            <a href="?do=editproviderscosts&amp;id=<?php echo $cur['DeliveryProviderId']; ?>"><?php echo _EDP_EDITP; ?></a>
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['DeliveryProviderId']; ?>" />
                            <input type="submit" value="<?php echo _EDP_EDIT; ?>" />
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
                        <input name="newname" style="width: 300px;" type="text" />
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _EDP_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>