<fieldset>
    <legend><?php echo _EDC_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _EDC_NAME; ?></td><td><?php echo _EDC_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input name="name" style="width: 300px;" type="text" value="<?php echo $cur['CountryName'] ?>" />
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['CountryId']; ?>" />
                            <input type="submit" value="<?php echo _EDC_EDIT; ?>" />
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
                        <input type="submit" value="<?php echo _EDC_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>