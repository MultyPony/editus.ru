<fieldset>
    <legend><?php echo _EPB_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _EPB_BIND; ?></td><td><?php echo _EPB_MIN ?></td><td><?php echo _EPB_MAX; ?></td><td><?php echo _EPB_FORMAT; ?></td><td><?php echo _EPB_PRICE; ?></td><td><?php echo _EPB_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <select name="bindid">
                                <?php
                                foreach ($bind as $cur2) {
                                    if ($cur['BindingId'] == $cur2['BindingId']) {
                                        $selected = 'selected="selected"';
                                    };
                                    ?>
                                    <option <?php echo $selected; $selected = ''; ?> value="<?php echo $cur2['BindingId']; ?>"><?php echo $cur2['BindingName']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input name="min" type="text" value="<?php echo $cur['BindingMin'] ?>" />
                        </td>
                        <td>
                            <input name="max" type="text" value="<?php echo $cur['BindingMax'] ?>" />
                        </td>
                        <td>
                            <select name="formatid">
                                <?php
                                foreach ($format as $cur3) {
                                    if ($cur['formatId'] == $cur3['formatId']) {
                                        $selected = 'selected="selected"';
                                    };
                                    ?>
                                    <option <?php echo $selected; $selected = ''; ?> value="<?php echo $cur3['formatId']; ?>"><?php echo $cur3['formatName']; ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input name="price" type="text" value="<?php echo $cur['BindingCosts'] ?>" />
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['BindingCostsId']; ?>" />
                            <input type="submit" value="<?php echo _EPB_EDIT; ?>" />
                        </td>
                    </tr>
                </form>
    <?php } ?>
        </tbody>
    </table>
    <form method="post">
        <table>
            <tbody>
                <tr>
                    <td>
                        <select name="newbindid">
                            <?php
                            foreach ($bind as $cur2) { ?>
                                <option value="<?php echo $cur2['BindingId']; ?>"><?php echo $cur2['BindingName']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input name="newmin" type="text" value="" />
                    </td>
                    <td>
                        <input name="newmax" type="text" value="" />
                    </td>
                    <td>
                        <select name="newformatid">
                            <?php
                            foreach ($format as $cur3) {?>
                                <option value="<?php echo $cur3['formatId']; ?>"><?php echo $cur3['formatName']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input name="newprice" type="text" value="" />
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _EPB_ADD; ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>