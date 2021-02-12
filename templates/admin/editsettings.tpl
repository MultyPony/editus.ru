<?php 
//print_r (Settings::$v); 
define(_ES_MAINSET,'Основные настройки');
define(_ES_TITLE,'Настройки');
define(_ES_ONPAGE,'Элементов на странице:');
define(_ES_DEFGROUP,'Группа для вновь зарегистрированных');
define(_ES_SAVE,'Сохранить');
define(_ES_SMTPON,'SMTP');
define(_ES_SMTPHOST,'Host');
define(_ES_SMTPAUTH,'SMTP аутентификация');
define(_ES_SMTPPORT,'SMTP порт');
define(_ES_SMTPUSER,'SMTP пользователь');
define(_ES_SMTPPASS,'SMTP пароль');
define(_ES_SMTPSECURE,'SMTP secure');
define(_ES_SMTPDEFFROM,'По-умолчанию адрес отправителя');
define(_ES_SMTP,'Настройки SMTP');
define(_ES_FTP,'Настйроки FTP');
define(_ES_FTPSERV,'Host');
define(_ES_FTPUSER,'Пользователь');
define(_ES_FTPPASS,'Пароль');
define(_ES_MANAGEGROUP,'Группа менеджеров');
define(_ES_TYPOGRATHMANAGEGROUP,'Группа менеджеров типографии');
?>

<h2><?php echo _ES_TITLE; ?></h2>
<fieldset>
    <legend><?php echo _ES_MAINSET; ?></legend>
    <form method="post" action="index.php?do=editsettings"> 
        <label><?php echo _ES_ONPAGE; ?><input type="text" name="onpage" value="<?php echo Settings::$v['onpage'];?>" /></label><br />
        <label><?php echo _ES_DEFGROUP; 
        ?><select name="defgroup"><?php
        foreach ($groups as $cur){
            if(Settings::$v['defgroup']== $cur['groupId']){
                $s = 'selected="selected"';
            }
            ?><option <?php echo $s;$s=''; ?> value="<?php echo $cur['groupId']; ?>"><?php echo $cur['groupName']; ?></option><?php
        }
        ?></select></label><br />
        <label><?php echo _ES_MANAGEGROUP; 
        ?><select name="managegroup"><?php
        foreach ($groups as $cur){
            if(Settings::$v['managegroup']== $cur['groupId']){
                $s = 'selected="selected"';
            }
            ?><option <?php echo $s;$s=''; ?> value="<?php echo $cur['groupId']; ?>"><?php echo $cur['groupName']; ?></option><?php
        }
        ?></select></label><br />
        <label><?php echo _ES_TYPOGRATHMANAGEGROUP; 
        ?><select name="typograthgroup"><?php
        foreach ($groups as $cur){
            if(Settings::$v['typograthgroup']== $cur['groupId']){
                $s = 'selected="selected"';
            }
            ?><option <?php echo $s;$s=''; ?> value="<?php echo $cur['groupId']; ?>"><?php echo $cur['groupName']; ?></option><?php
        }
        ?></select></label><br /><input type="submit" value="<?php echo _ES_SAVE; ?>" />
    </form>
</fieldset>
<fieldset>
    <legend><?php echo _ES_SMTP; ?></legend>
    <form method="post" action="index.php?do=editsettings"> 
        <?php if(Settings::$v['mail']['smtp']==1){$s='checked="checked"';} ?>
        <label><?php echo _ES_SMTPON; ?><input <?php echo $s;$s='';?> type="checkbox" name="mail[smtp]" value="1" /></label><br />
        <label><?php echo _ES_SMTPHOST; ?><input type="text" name="mail[smtp_host]" value="<?php echo Settings::$v['mail']['smtp_host'];?>" /></label><br />
        <?php if(Settings::$v['mail']['smtp_auth']==1){$s2='checked="checked"';} ?>
        <label><?php echo _ES_SMTPAUTH; ?><input <?php echo $s2;$s2='';?> type="checkbox" name="mail[smtp_auth]" value="1" /></label><br />
        <label><?php echo _ES_SMTPPORT; ?><input type="text" name="mail[smtp_port]" value="<?php echo Settings::$v['mail']['smtp_port'];?>" /></label><br />
        <label><?php echo _ES_SMTPUSER; ?><input type="text" name="mail[smtp_user]" value="<?php echo Settings::$v['mail']['smtp_user'];?>" /></label><br />
        <label><?php echo _ES_SMTPPASS; ?><input type="text" name="mail[smtp_pass]" value="<?php echo Settings::$v['mail']['smtp_pass'];?>" /></label><br />
        <label><?php echo _ES_SMTPSECURE; ?><input type="text" name="mail[smtp_secure]" value="<?php echo Settings::$v['mail']['smtp_secure'];?>" /></label><br />
        <label><?php echo _ES_SMTPDEFFROM; ?><input type="text" name="mail[def_from]" value="<?php echo Settings::$v['mail']['def_from'];?>" /></label>
        <br /><input type="submit" value="<?php echo _ES_SAVE; ?>" />
    </form>
</fieldset>
<fieldset>
    <legend><?php echo _ES_FTP; ?></legend>
    <form method="post" action="index.php?do=editsettings"> 
        <label><?php echo _ES_FTPSERV; ?><input type="text" name="ftp[serv]" value="<?php echo Settings::$v['ftp']['serv'];?>" /></label><br />
        <label><?php echo _ES_FTPUSER; ?><input type="text" name="ftp[user]" value="<?php echo Settings::$v['ftp']['user'];?>" /></label><br />
        <label><?php echo _ES_FTPPASS; ?><input type="text" name="ftp[pass]" value="<?php echo Settings::$v['ftp']['pass'];?>" /></label>
        <br /><input type="submit" value="<?php echo _ES_SAVE; ?>" />
    </form>
</fieldset>