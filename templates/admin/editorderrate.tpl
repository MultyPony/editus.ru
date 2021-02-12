<fieldset>
    <legend><?php echo _EOR_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _EOR_MIN; ?></td><td><?php echo _EOR_MAX ?></td><td><?php echo _EOR_KOEF; ?></td><td><?php echo _EOR_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input name="min" type="text" value="<?php echo $cur['OrderRateMin'] ?>" />
                        </td>
                        <td>
                            <input name="max" type="text" value="<?php echo $cur['OrderRateMax'] ?>" />
                        </td>
                        <td>
                            <input name="rate" type="text" value="<?php echo $cur['OrderRate'] ?>" />
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['OrderRateId']; ?>" />
                            <input type="submit" value="<?php echo _EOR_EDIT; ?>" />
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
                        <input name="newmin" type="text" />
                    </td>
                    <td>
                        <input name="newmax" type="text" />
                    </td>
                    <td>
                        <input name="newrate" type="text" />
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _EOR_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>