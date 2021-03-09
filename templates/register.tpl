<div id="register">
    <?php if (!isset($send)) { ?>
        <form method="post" action="<?php echo $action[2]; ?>"  id="register_form">
            <div>
                <p><label><?php echo _R_EMAIL ; ?></label><input class="inptext" type="text" id="userEmail" name="userEmail" /></p>
                <p><label><?php echo _R_PASSWORD; ?></label><input class="inptext" type="password" id="userPassword" name="userPassword" /></p>
                <p><label><?php echo _R_PASSWORDCONFIRM; ?></label><input class="inptext" type="password" id="userPasswordConf" name="userPasswordConf" /></p>
                <p><label><?php echo _R_USERIRSTNAME; ?></label><input class="inptext" id="userFirstName" name="userFirstName" type="text"  /></p>
                <p><label><?php echo _R_USERLASTNAME; ?></label><input class="inptext" id="userLastName" name="userLastName" type="text"  /></p>
             	<p><label><?php echo _R_USERADDITIONALNAME; ?></label><input class="inptext" id="userAdditionalName" name="userAdditionalName" type="text"  /></p>
                <p><label><?php echo _R_USERTELEPHONE; ?></label><input class="inptext" id="userTelephone" name="userTelephone" type="text"  /></p>
				
</div>

                <p><input class="button" type="submit" value="<?php echo _R_REGISTER; ?>" />
                <p><label>Регистрируясь, я принимаю условия <a href="//editus-dev.ru/new/terms.html">Пользовательского соглашения</a> и даю согласие на обработку своих персональных данных в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных».</label></p>
            </p>
        </form>
</div>
    <hr />
    <div>
        <form method="post" action="<?php echo $action[0]; ?>" >
            <h4>
                <label for="buttonsign" accesskey="s"></label><a href="editus.php?do=login" class="head"><?php echo _R_SIGN; ?> <span class="icon-circle-arrow-right"></span></a>
            </h4>
        </form>
        <form method="post" action="<?php echo $action[1]; ?>" >
            <h4>
                <label for="buttonrecover_password" accesskey="p"></label><a href="editus.php?do=recover_password" class="head"><?php echo _R_RECOVER_PASSWORD; ?> <span class="icon-circle-arrow-right"></span></a>
            </h4>
        </form>
    <?php } else { ?>
        <form method="post" action="<?php echo $action[0]; ?>" >
            <h4>
                <label for="buttonsign" accesskey="s"></label><a href="editus.php?do=login"><?php echo _R_SIGN; ?> <span class="icon-circle-arrow-right"></span></a>
            </h4>
           
        </form>
        
       
    <?php } ?>
		
</div>