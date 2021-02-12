<table id="listuser" class="dataview">
    <thead><tr><th><?php echo _LP_LASTNAME . ' ' . _LP_NAME . ' ' .  _LP_USERADDITIONALNAME; ?></th><th><?php echo _LP_USEREMAIL; ?></th><th><?php echo _LP_USERGROUP; ?></th><th><?php echo _LP_USERREGISTERDATE; ?></th></tr></thead>
    <?php
    foreach ($data as $cur)
        echo '<tr><td><a href=?do=editpartner&id=' . $cur['userId'] . '>' . $cur['userLastName'] . ' ' . $cur['userFirstName'] . ' ' . $cur['userAdditionalName'] . '</a></td><td>' . $cur['userEmail'] . '</a></td><td> ' . $cur['groupName'] . '</a><td> ' . date("H:i d.m.Y", strtotime($cur['userRegistrationDate'])) . '</a></td></tr>';
    ?>
</table>
