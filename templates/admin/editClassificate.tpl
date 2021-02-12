<fieldset>
    <legend><?php echo _ECT_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _ECT_NAME; ?></td><td><?php echo _ECT_DEL; ?></td><td></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input name="classificate" type="text" value="<?php echo $cur['classificateName'] ?>" />
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['classificateId']; ?>" />
                            <input type="submit" value="<?php echo _ECT_EDIT; ?>" />
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
                        <input name="newclassificate" type="text" />
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _ECT_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>