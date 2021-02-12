<fieldset id="dataclient">
    <legend><?php echo _PS_TITLE;?></legend>
    <form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
    <label for="datefrom"><?php echo _PS_DATEFROM;?></label><input id="datefrom" type="text" name="ps_datefrom" value="<?php echo date('Y-m-d h:i');?>" /><label for="dateto"><?php echo _PS_DATETO;?></label><input id="dateto" type="text" name="ps_dateto" value="<?php echo date('Y-m-d h:i');?>" />
    <input type="submit" class="button" value="<?php echo _PS_GEN;?>" />
    </form>
    <?php if (isset($data['countnewusers'])){ ?>
    <table>
        <tr><td><?php echo _PS_REGISTERUSERS;?></td><td><?php echo $data['countnewusers']; ?></td></tr>
        <tr><td><?php echo _PS_COUNTORDERS;?></td><td><?php echo $data['countorders']; ?></td></tr>
        <tr><td><?php echo _PS_TOTALCOASTS;?></td><td><?php echo $data['totalcoast']._PS_RUB; ?></td></tr>
    </table>
    <?php } ?>
</fieldset>
