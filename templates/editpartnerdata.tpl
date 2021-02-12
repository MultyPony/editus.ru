<?php if ($mode == 1){ ?>
<form action="<?php echo $action;?>" method="post" enctype="multipart/form-data">
    <fieldset id="dataclient">
        <legend><?php echo _EPD_MAINDATA;?></legend>
        <table>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><label for="ecd1"><?php echo _EPD_KEY;?></label></td><td><input id="ecd1" type="text" name="epd_key" value="<?php echo ($this->xss($data['partnerKey']));?>" /></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><label for="ecd2"><?php echo _EPD_PAGEPARTNER;?></label></td><td><input id="ecd2" type="text" name="epd_page" value="<?php echo $this->xss($data['partnerPage']);?>" /></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><label for="ecd6"><?php echo _EPD_PAGEMAINPARTNER;?></label></td><td><input id="ecd6" type="text" name="epd_mainpage" value="<?php echo $this->xss($data['partnerMainPage']);?>" /></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><label for="ecd3"><?php echo _EPD_NAME;?></label></td><td><input id="ecd3" type="text  " name="epd_title" value="<?php echo $this->xss($data['partnerName']);?>" /></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><label for="ecd4"><?php echo _EPD_LOGO;?></label></td><td><input id="ecd4" type="file" name="epd_logo" value="" /></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><label for="ecd5"><?php echo _EPD_PERCENT;?></label></td><td><input id="ecd5" type="text" disabled="disabled" value="<?php echo $this->xss($data['percent']);?>" /></td></tr>
        </table>
        <div style="text-align: left; padding-left: 260px; padding-top: 10px;"><input type="submit" class="button" value="<?php echo _ECD_SAVE;?>" /></div>
    </fieldset>
</form>
<a name="adr"></a>

<?php } if ($mode == 2){
 foreach ($regions as $cur) { 
     if ($cur['iscity']==1){
        $c = 'class="iscity"';
     }else{
        $c = '';
     }
     if ($cur['RegionId']==$sel){
        $sele ='selected="selected"';
     }?>
    <option <?php echo $sele,' '.$c;$sele=''; ?> value="<?php echo $cur['RegionId']?>"><?php echo $cur['RegionName']; ?></option>
<?php }
} ?>
