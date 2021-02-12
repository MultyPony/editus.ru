<fieldset>
    <legend><?php echo $namerole; ?></legend>
    <form action="<?php echo 'index.php?do=' . $_GET['do'] .'&amp;id='. $_GET['id']; ?>" method="post" >
        <table class="dataview" style="width: 100%;">
            <thead><tr><td></td><td><?php echo _FUNCNAMEDESC; ?></td><td><?php echo _ACCESS; ?></td></tr></thead>
            <?php
            foreach ($listfunction as $cur) {
                if (in_array($cur[0], $roles)) {
                    $checked = 'checked="checked"';
                };
                ?>
            <tr><td><?php echo $cur[1];?></td><td><?php echo $cur[2] . '(' . $cur[3] . ')'; ?></td><td><input <?php echo $checked;
                        $checked = ''; ?> type="checkbox" name="<?php echo $cur[0]; ?>"/></td></tr>
    <?php } ?>
        </table>
        <input type="hidden" name="idrole" value="<?php echo $idrole; ?>"/>
        <input type="submit" value="<?php echo _EDITROLE; ?>"/>
    </form>
</fieldset>