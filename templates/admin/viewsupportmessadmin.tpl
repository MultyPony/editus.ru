<fieldset>
    <legend><?php echo $mess['subj'];?></legend>
    <form action="<?php echo $action;?>" method="post">
    <table>
        <tr><td style="text-align: right; vertical-align: middle;"><?php echo _VSMA_USER; ?></td><td><?php echo '<a href="index.php?do=edituser&amp;id='.$mess['userId'].'">'.$mess['userLastName'].' '.$mess['userFirstName'].' '.$mess['userAdditionalName'].' ( '.$mess['userEmail'].' )</a> ';?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle;"><?php echo _VSMA_YOUMESS; ?></td><td><textarea disabled="disabled" style="width: 600px; height: 200px;"><?php echo $this->xss($mess['mess']);?></textarea></td></tr>
        <?php if (empty($ans['0'])){ ?>
        <tr><td style="text-align: right; vertical-align: middle;"><?php echo _VSMA_ANSWER;?></td><td>
        <textarea id="sc_message" style="width: 600px; height: 200px;" name="sc_message"><?php echo $this->xss($ans['0']);?></textarea>
        </td></tr>
    </table>
        <div style="text-align: left; padding-left: 210px; padding-top: 10px;">
            <input type="hidden" name="userid" value="<?php echo $mess['userId'];?>" />
            <input type="hidden" name="sc_cat" value="<?php echo $mess[3];?>" />
            <input type="hidden" name="replyId" value="<?php echo intval($_GET['id']);?>" />
            <input type="submit" class="button" value="<?php echo _VSMA_SEND;?>" />
        </div>
        <?php }else {?>
                <tr><td style="text-align: right; vertical-align: middle;"><?php echo _VSMA_ANSWER;?></td><td><textarea disabled="disabled" style="width: 600px; height: 200px;"><?php echo $this->xss($ans['0']);?></textarea></td></tr></table>
<?php }?>
    </form>
    <br /><a href="<?php echo $back;?>"><?php echo _VSMA_BACK;?></a>
</fieldset>