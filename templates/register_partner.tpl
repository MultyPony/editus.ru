<div id="register">
    <?php if (!isset($send)) { ?>
        <form method="post" action="<?php echo $action[2]; ?>" enctype="multipart/form-data"  id="register_form">
         <p>   <div class="form">
                <label><?php echo _R_EMAIL ; ?><input class="inptext" type="text" id="userEmail" name="userEmail" /></label><br />
                <label><?php echo _R_PASSWORD; ?><input class="inptext" type="password" id="userPassword" name="userPassword" /></label><br />
                <label><?php echo _R_PASSWORDCONFIRM; ?><input class="inptext" type="password" id="userPasswordConf" name="userPasswordConf" /></label><br />
                <label><?php echo _R_USERIRSTNAME; ?><input class="inptext" id="userFirstName" name="userFirstName" type="text"  /></label><br />
                <label><?php echo _R_USERLASTNAME; ?><input class="inptext" id="userLastName" name="userLastName" type="text"  /></label>
             <br />   <label><?php echo _R_USERADDITIONALNAME; ?><input class="inptext" id="userAdditionalName" name="userAdditionalName" type="text"  /></label><br />
                <label><?php echo _R_USERTELEPHONE; ?><input class="inptext" id="userTelephone" name="userTelephone" type="text"  /></label>
            <label><?php echo _R_USERLOGO; ?><input class="inptext" id="userLogo" name="userLogo" type="file"  /></label>
            <label><?php echo _R_TITLE; ?><input class="inptext" id="userTitle" name="userTitle" type="text"  /></label>
        </div>
        <br />
                <input class="button" type="submit" value="<?php echo _R_REGISTER; ?>" /><br />
            </p>
        </form>
</div><div>
    <hr />
        <form method="post" action="<?php echo $action[0]; ?>" >
            <p>
                <label for="buttonsign" accesskey="s"></label><input id="buttonsign" class="button" type="submit" value="<?php echo _R_SIGN; ?>" />
            </p>
        </form>
        <form method="post" action="<?php echo $action[1]; ?>" >
            <p>
                <label for="buttonrecover_password" accesskey="p"></label><input id="buttonrecover_password" class="button" type="submit" value="<?php echo _R_RECOVER_PASSWORD; ?>" />
            </p>
        </form>
    <?php } else { ?>
        <form method="post" action="<?php echo $action[0]; ?>" >
            <p class="center">
                <label for="buttonsign" accesskey="s"></label><input id="buttonsign" class="button" type="submit" value="<?php echo _R_SIGN; ?>" />
            </p>
        </form>
    <?php } ?>
</div>