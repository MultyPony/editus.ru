<fieldset>
    <legend><?php echo _EPF_TITLE;?></legend>
    <table>
        <thead><tr><td><?php echo _EPF_NAME; ?></td><td><?php echo _EPF_WEIGHT; ?></td><td><?php echo _EPF_HEIGHT; ?></td><td><?php echo _EPF_INA3; ?></td><td><?php echo _EPF_DEL; ?></td></tr></thead>
        <tbody>
            <?php foreach ($data as $cur) {
                ?>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <input name="name" type="text" value="<?php echo $cur['formatName'] ?>" />
                        </td>
                        <td>
                            <input name="weight" type="text" value="<?php echo $cur['formatWidth'] ?>" />
                        </td>
                        <td>
                            <input name="height" type="text" value="<?php echo $cur['formatHeight'] ?>" />
                        </td>
                        <td>
                            <input name="ina3" type="text" value="<?php echo $cur['formatInA3'] ?>" />
                        </td>
                        <td>
                            <input name="del" type="checkbox" />
                        </td>
                        <td>
                            <input name="id" type="hidden" value="<?php echo $cur['formatId']; ?>" />
                            <input type="submit" value="<?php echo _EPT_EDIT; ?>" />
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
                        <input name="newname" type="text" />
                    </td>
                    <td>
                        <input name="newweight" type="text" />
                    </td>
                    <td>
                        <input name="newheight" type="text" />
                    </td>
                    <td>
                        <input name="newina3" type="text"  />
                    </td>
                    <td>
                        <input type="submit" value="<?php echo _ETP_ADD; ?>"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</fieldset>