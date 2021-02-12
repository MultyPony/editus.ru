<div id="recover_password">
        <?php if (!isset($send)) {?>
        <form method="post" action="<?php echo $action[1];?>" id="recover_password_form">
            <div>
                <p><label><?php echo _RP_EMAIL; ?></label><input type="text" name="userEmail" class="rpemail"  /></p></div>
                <p><input class="button" type="submit" value="<?php echo _RP_SENDNEWDPASS ?>"  />
            </p>
        </form>
</div><hr />
<div>
        <form method="post" action="<?php echo $action[0];?>" >
            <h4>
                <label accesskey="s"><a href="editus.php?do=login" class="head" ><?php echo _RP_SIGN; ?> <span class="icon-circle-arrow-right"></span></a></label>
            </h4>
        </form>
        <?php }else{ ?>
        <form method="post" action="<?php echo $action[0];?>">
            <h4>
                <a href="editus.php?do=login" class="head" ><?php echo _RP_SIGN; ?> <span class="icon-circle-arrow-right"></span></a>
            </h4>
        </form>
    <?php } ?>
</div>