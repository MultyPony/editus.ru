   
<table>
    <thead><tr><td><?php echo _ROLENAME; ?></td><td><?php echo _ROLEACCESS ?></td><td><?php echo _DELETEROLE; ?></td></tr></thead>
    <tbody>
        <?php foreach ($roles as $cur) {
            ?>

        <tr><td colspan="3">
                    <form action="<?php echo 'index.php?do=' . $_GET['do']; ?>" method="post">
                        <p>
                            <input name="editrolename" type="text" value="<?php echo $cur[1]; ?>" />
                            <a href="?do=editrole&amp;id=<?php echo $cur[0]; ?>"><?php echo _EDITACCESS; ?></a>
                            <input name="delrole" type="checkbox" />
                            <input name="idrole" type="hidden" value="<?php echo $cur[0]; ?>" />
                            <input type="submit" value="<?php echo _EDITROLE; ?>" />
                        </p>
                    </form>
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
<form action="<?php echo 'index.php?do=' . $_GET['do']; ?>" method="post">
    <table><tbody>
            <tr>
                <td>
                    <input name="newrolename" type="text" />
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" value="<?php echo _ADDROLE; ?>"/>
                </td>
            </tr>
        </tbody>
    </table>
</form>
