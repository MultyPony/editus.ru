<fieldset>
    <legend class="orderstepname"><h3><?php echo mb_substr($mess['0'],0,20);?></h3></legend>
    <table width="100%">
        <tr><td style="text-align: right; width:35%;"><?php echo _VSM_YOUMESS; ?>:</td><td><textarea disabled="disabled" ><?php echo $this->xss($mess['1']);?></textarea></td></tr>
        <tr><td style="text-align: right; width:35%;"><?php echo _VSM_ANSWER;?>:</td><td><textarea disabled="disabled" ><?php echo $this->xss($ans['0']);?></textarea></td></tr>
    </table>
    <br /><a class="button" href="<?php echo $back;?>">&larr; <?php echo _VSM_BACK;?></a>
</fieldset>