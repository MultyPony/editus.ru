<div id="login">
    <?php
    if ($err != '') {
        echo "<p class='error'>" . $err . "</p>";
    }
    ?>
    <form method="post" action="" id="login_form">
        <p>  
            <label>E-mail:<input class="inpemail" type="text" name="userEmail" /></label><br />
            <label>Пароль:<input class="inppassword" type="password" name="userPassword" /></label><br />
            <input class="button" type="submit" value="<?php echo _SIGN; ?>" /><br />
        </p>
    </form>
</div>
