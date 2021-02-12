<h2><?php echo _ET_TITLE; ?></h2>
<br />
<form action="index.php?do=edittext" method="post">
<label><?php echo _ET_PUBLRULES; ?><br />
<textarea name="publrules" rows="15" cols="80"><?php echo $this->xss(Settings::getsetting('publrules'));?></textarea></label><br />
<input type="submit" value="<?php echo _ET_SAVE; ?>" />
</form>
<br />

<form action="index.php?do=edittext" method="post">
<label><?php echo _ET_OFFERIZD; ?><br />
<textarea name="offerizd" rows="15" cols="80"><?php echo $this->xss(Settings::getsetting('offerizd'));?></textarea></label><br />
<input type="submit" value="<?php echo _ET_SAVE; ?>" />
</form>
<br />

<form action="index.php?do=edittext" method="post">
<label><?php echo _ET_OFFERSHOP; ?><br />
<textarea name="offershop" rows="15" cols="80"><?php echo $this->xss(Settings::getsetting('offershop'));?></textarea></label><br />
<input type="submit" value="<?php echo _ET_SAVE; ?>" />
</form>
<br />

<form action="index.php?do=edittext" method="post">
<label><?php echo _ET_MAILGEDORDER; ?></label><br />
<label><?php echo _ET_VARS; ?></label><br />
<label><?php echo _ET_SUBJ; ?><input style="width: 400px;" type="text" name="mailgetorder_subj" value="<?php echo $this->xss((Settings::getsetting('mailgetorder','mailgetorder_subj')));?>" /></label><br />
<label><?php echo _ET_TEXT; ?><br /><textarea name="mailgetorder_text" rows="15" cols="80"><?php echo $this->xss((Settings::getsetting('mailgetorder','mailgetorder_text')));?></textarea></label><br />
<input type="submit" value="<?php echo _ET_SAVE; ?>" />
</form>
<br />

<form action="index.php?do=edittext" method="post">
<label><?php echo _ET_MAILGEDSHOPORDER; ?></label><br />
<label><?php echo _ET_VARS; ?></label><br />
<label><?php echo _ET_SUBJ; ?><input style="width: 400px;" type="text" name="mailgetshoporder_subj" value="<?php echo $this->xss((Settings::getsetting('mailgetshoporder','mailgetshoporder_subj')));?>" /></label><br />
<label><?php echo _ET_TEXT; ?><br /><textarea name="mailgetshoporder_text" rows="15" cols="80"><?php echo $this->xss((Settings::getsetting('mailgetshoporder','mailgetshoporder_text')));?></textarea></label><br />
<input type="submit" value="<?php echo _ET_SAVE; ?>" />
</form>
<br />

<form action="index.php?do=edittext" method="post">
<label><?php echo _ET_MAILRECOVERPASS; ?></label><br />
<label><?php echo _ET_VARS2; ?></label><br />
<label><?php echo _ET_SUBJ; ?><input style="width: 400px;" type="text" name="mailrecoverpass_subj" value="<?php echo $this->xss((Settings::getsetting('mailrecoverpass','mailrecoverpass_subj')));?>" /></label><br />
<label><?php echo _ET_TEXT; ?><br /><textarea name="mailrecoverpass_text" rows="15" cols="80"><?php echo $this->xss((Settings::getsetting('mailrecoverpass','mailrecoverpass_text')));?></textarea></label><br />
<input type="submit" value="<?php echo _ET_SAVE; ?>" />
</form>
<br />

<form action="index.php?do=edittext" method="post">
<label><?php echo _ET_MAILREGISTER; ?></label><br />
<label><?php echo _ET_VARS3; ?></label><br />
<label><?php echo _ET_SUBJ; ?><input style="width: 400px;" type="text" name="mailregister_subj" value="<?php echo $this->xss((Settings::getsetting('mailregister','mailregister_subj')));?>" /></label><br />
<label><?php echo _ET_TEXT; ?><br /><textarea name="mailregister_text" rows="15" cols="80"><?php echo $this->xss((Settings::getsetting('mailregister','mailregister_text')));?></textarea></label><br />
<input type="submit" value="<?php echo _ET_SAVE; ?>" />
</form>