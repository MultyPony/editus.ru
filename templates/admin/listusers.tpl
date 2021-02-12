<table id="listuser" class="dataview">
    <thead><tr><th><?php echo _LU_LASTNAME . ' ' . _LU_NAME . ' ' .  _LU_USERADDITIONALNAME; ?></th><th><?php echo _LU_USEREMAIL; ?></th><th><?php echo _LU_USERGROUP; ?></th><th><?php echo _LU_USERREGISTERDATE; ?></th></tr></thead>
    <?php
    foreach ($data as $cur)
        echo '<tr><td><a href=?do=edituser&id=' . $cur['userId'] . '>' . $cur['userLastName'] . ' ' . $cur['userFirstName'] . ' ' . $cur['userAdditionalName'] . '</a></td><td>' . $cur['userEmail'] . '</a></td><td> ' . $cur['groupName'] . '</a><td> ' . date("H:i d.m.Y", strtotime($cur['userRegistrationDate'])) . '</a></td></tr>';
    ?>
</table>
