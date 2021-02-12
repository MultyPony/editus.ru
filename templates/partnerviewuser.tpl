<fieldset>
    <legend style="font-weight: bold;"><?php echo _PVU_USERLEGEND.$data['userEmail']; ?></legend>
    <table>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVU_USERNAME;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['userFirstName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVU_LASTNAME;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['userLastName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVU_ADDNAME;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['userAdditionalName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVU_EMAIL;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['userEmail']; ?></td></tr>
    </table>
</fieldset>