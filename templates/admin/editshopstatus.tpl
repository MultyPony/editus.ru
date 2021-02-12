<fieldset>
    <legend><?php echo _ESS_TITLE. ' - '.$_GET['id'];?></legend>
    <table>
        <thead><tr><td><?php echo _ESS_NAME; ?></td><td><?php echo _ESS_CURSTATE ?></td><td><?php echo _ESS_ACTION; ?></td></tr></thead>
        <tbody>
            <form action="<?php echo $action; ?>" method="post">
                <tr>
                    <td>
                        <?php echo _ESS_STATUS; ?>
                    </td>
                    <td>
                        <select name="status">
                        <?php foreach ($statuses as $cur) { 
                            if ($cur['stateId']==$curstate[0]){
                                $sel = 'selected="selected"';
                            }?>
                            <option <?php echo $sel; $sel = ''; ?> value="<?php echo $cur['stateId']; ?>"><?php echo $cur['stateName']; ?></option>
                        <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input name="idstatus" type="hidden" value="<?php echo intval($_GET['id']); ?>" />
                        <input type="submit" value="<?php echo _ESS_APPLY; ?>" />
                    </td>
                </tr>
            </form>
                <form action="<?php echo $action; ?>" method="post">
                    <tr>
                        <td>
                            <?php echo _ESS_STEP; ?>
                        </td>
                        <td>
                            <select name="step">
                            <?php foreach ($oform as $key => $value) { 
                                if ($key==$curstate[1]){
                                    $sels = 'selected="selected"';
                                }?>
                                <option <?php echo $sels; $sels = ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                            </select>
                        </td>
                        <td>
                            <input name="idstep" type="hidden" value="<?php echo intval($_GET['id']); ?>" />
                            <input type="submit" value="<?php echo _ESS_APPLY; ?>" />
                        </td>
                    </tr>
                </form>
        </tbody>
    </table><br /><br /><br />
            <form action="<?php echo $action; ?>" method="post">
                <label><?php echo _ESS_FULLDELETE; ?><input name="idstatusfulldelete" type="hidden" value="<?php echo intval($_GET['id']); ?>" /></label>
                <input type="submit" onclick="return confirm('<?php echo _ESS_CONFDELETE; ?>')" value="<?php echo _ESS_DELETE; ?>" />
            </form>
</fieldset>