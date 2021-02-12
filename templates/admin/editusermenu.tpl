    <table>
        <thead><tr><td><?php echo _MENUITEMORDER; ?></td><td><?php echo _MENUITEM; ?></td><td><?php echo _FUNCTION ?></td><td><?php echo _DELETEHREF; ?></td><td><?php echo _MENUGROUP; ?></td><td><?php echo _DELETEMENUITEM; ?></td><td></td></tr></thead>
        <tbody>
            <?php foreach ($menuitems as $cur) {
                ?>
            <form action="<?php echo 'index.php?do=' . $_GET['do']; ?>" method="post">
                <tr>
                    <td>
                        <input name="editmenuorder" type="text" value="<?php echo $cur[1] ?>" />
                    </td>                    
                    <td>
                        <input name="editmenuname" type="text" value="<?php echo $cur[3] ?>" />
                    </td>
                    <td>
                        <select name="editmenufunction">
                            <?php
                            foreach ($functions as $cur2) {
                                if ($cur[2] == $cur2[0]) {
                                    $selected = 'selected="selected"';
                                };
                                ?>
                                <option <?php echo $selected; $selected = ''; ?> value="<?php echo $cur2[0]; ?>"><?php echo $cur2[2]; ?></option>
                                <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input name="editmenuhref" type="text" value="<?php echo $cur[4]; ?>" />
                    </td>   
                    <td>
                        <input name="editmenugroup" type="text" value="<?php echo $cur[5]; ?>" />
                    </td>  
                    <td>
                        <input name="delmenuitem" type="checkbox" />
                    </td>
                    <td>
                        <input name="idmenuitem" type="hidden" value="<?php echo $cur[0]; ?>" />
                        <input type="submit" value="<?php echo _EDITMENUITEM; ?>" />
                    </td>
                </tr>
            </form>
            <?php } ?>
        </tbody>
    </table>
<form action="<?php echo 'index.php?do=' . $_GET['do']; ?>" method="post">
    <table><tbody>
            <tr>
                <td>
                    <input name="newmenuitemorder" type="text" />
                </td>                
                <td>
                    <input name="newmenuitemname" type="text" />
                </td>
                <td>
                    <select name="newmenufunction">
                        <?php foreach ($functions as $cur) { ?>
                            <option value="<?php echo $cur[0]; ?>"><?php echo $cur[2]; ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><input name="newmenuhref" type="text" value="" /></td>
                <td><input name="newmenugroup" type="text" value="" /></td>
            </tr>
            <tr>
                <td colspan="3">
                    <input type="submit" value="<?php echo _ADDMENUITEM; ?>"/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
