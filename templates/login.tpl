<div id="login">
        <form method="post" action="<?php echo $action[0];?>" id="login_form">
            <div class="form">
                <p>
                <label><?php echo _L_EMAIL; ?></label><input class="inpemail" type="text" name="userEmail" />
                </p>
                <p>
                <label><?php echo _L_PASSWORD; ?></label><input class="inppassword" type="password" name="userPassword" />
                </p>
                <p>
                <input type="hidden" name="lastdo" value="<?php echo $lastdo;?>" /></p></div>
                <p><input class="button" type="submit" value="<?php echo _L_SIGN; ?>" />
            </p>
        </form>
</div>
        <hr />
        <div>
                                                   		
        <form method="post" action="<?php echo $action[2];?>" >
            <h4>
                <a href="editus.php?do=register" class="head"><?php echo _L_REGISTER; ?> <span class="icon-circle-arrow-right"></span></a> 
            </h4>
            
        </form>
        <form method="post" action="<?php echo $action[1];?>" >
            <h4>
                <label for="buttonrecover_password" accesskey="p"></label><a class="head" href="editus.php?do=recover_password"><?php echo _L_RECOVER_PASSWORD; ?> <span class="icon-circle-arrow-right"></span></a>  
            </h4>
        </form>
</div>