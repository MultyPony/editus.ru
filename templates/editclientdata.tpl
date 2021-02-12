							<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=editclientdata" class="active">Профиль</a></li>
                                                        <li><a href="editus.php?do=supportclient">Помощь</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                 </div>
                                                 
                                                 <?php if ($mode == 1){ ?>
<form action="<?php echo $action;?>" method="post">
    <fieldset id="dataclient">
        <legend class="orderstepname"><h3><?php echo _ECD_MAINDATA;?></h3></legend>
        <table width="100%">
            <!--<tr><td style="text-align: right; width:35%;"><label for="ecd0"><?php echo _ECD_USERTYPE;?></label></td>
                <td><select id="ecd0" name="ecd_type">
                        <?php if ($data['isOrg']==0){
                            $st = 'style="display: none;"';
                            $sele = 'selected="selected"';
                        }else{
                            $st = ' ';
                            $sele2 = 'selected="selected"';
                        }?>
                        <option <?php echo $sele;?> value="0"><?php echo _ECD_USERFIS; ?></option>
                        <option <?php echo $sele2;?> value="1"><?php echo _ECD_USERORG; ?></option>
                    </select>
                </td>
            </tr>-->
            <tr><td style="text-align: right; width:35%;"><label for="ecd1"><?php echo _ECD_USERLASTNAME;?></label></td><td><input id="ecd1" type="text" name="ecd_lastname" value="<?php echo ($this->xss($data['userLastName']));?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd2"><?php echo _ECD_USERFIRSTNAME;?></label></td><td><input id="ecd2" type="text" name="ecd_firsname" value="<?php echo $this->xss($data['userFirstName']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd3"><?php echo _ECD_USERADDITIONALNAME;?></label></td><td><input id="ecd3" type="text" name="ecd_additionalname" value="<?php echo $this->xss($data['userAdditionalName']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd4"><?php echo _ECD_USEREMAIL;?></label></td><td><input id="ecd4" type="text" disabled="disabled" value="<?php echo $this->xss($data['userEmail']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd5"><?php echo _ECD_USERPASSWORD;?></label></td><td><input id="ecd5" type="password" name="ecd_password" value="" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd6"><?php echo _ECD_USERPASSWORDCONF;?></label></td><td><input id="ecd6" type="password" name="ecd_passwordconf" value="" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd7"><?php echo _ECD_USERTELEPHONE;?></label></td><td><input id="ecd7" type="text" name="ecd_telephone" value="<?php echo $this->xss($data['userTelephone']);?>" /></td></tr>
            
            <tr class="orgdata" <?php echo $st; ?>><td style="text-align: right;"><label for="ecd25"><?php echo _ECD_ORGNAME;?></label></td><td><input id="ecd25" type="text" name="ecd_orgname" value="<?php echo $this->xss($data['orgName']);?>" /></td></tr>
            <tr class="orgdata" <?php echo $st; ?>><td style="text-align: right;"><label for="ecd26"><?php echo _ECD_ORGINN;?></label></td><td><input id="ecd26" type="text" name="ecd_orginn" value="<?php echo $this->xss($data['orgINN']);?>" /></td></tr>
            <tr class="orgdata" <?php echo $st; ?>><td style="text-align: right;"><label for="ecd27"><?php echo _ECD_ORGKPP;?></label></td><td><input id="ecd27" type="text" name="ecd_orgkpp" value="<?php echo $this->xss($data['orgKPP']);?>" /></td></tr>            
            
            <tr><td style="text-align: right;"><label for="ecd8"><?php echo _ECD_USERINFORMATION;?></label></td><td><textarea id="ecd8" name="ecd_information"><?php echo $this->xss($data['userInformation']);?></textarea></td></tr>
            <?php if($data['subscMailer']==1){$s='checked="checked"';} ?>
            <tr><td style="text-align: right;"><label for="ecd91"><?php echo _ECD_SUBSCMAILER;?></label></td><td><input <?php echo $s;$s=''; ?>  type="checkbox" name="ecd_subscmailer" /></td></tr>
        </table>
        <br><input type="submit" class="button" value="<?php echo _ECD_SAVE;?>" />
    </fieldset>
</form>
<a name="adr"></a>
<fieldset style="margin-top: 40px;">
    <legend class="orderstepname"><h3><?php echo _ECD_ADDRESES;?></h3></legend>
    <form id="ecd_addresses" action="<?php echo $action;?>#adr" method="post">
        <p>
            <select id="ecd_addresses_sel" name="ecd_addreses" style="width:100%;">
                <option value="new"><?php echo _ECD_ADDADDRESE;?></option>
            <?php foreach ($addreses as $cur){ 
                if ($cur['addressId']==$data2['11']){
                    $sel ='selected="selected"';
                }
                echo "/n";?><option <?php echo $sel;$sel=''; ?> value="<?php echo $cur['addressId']?>"><?php echo $this->xss($cur['addressCity'].', '.$cur['addressStr'].', '.$cur['addressHouse'].', '.$cur['addressApt']); ?></option><?php
            }
            ?>
        </select><input id="ecd_addresses_sub" type="submit" class="button" value="<?php echo _ECD_SAVE;?>" /></p>
    </form>
    <form action="<?php echo $action;?>" method="post">
        <table width="100%">
            <tr><td style="text-align: right; width:35%;"><label for="ecd8"><?php echo _ECD_ADDRESSCONTACT;?></label></td><td><input id="ecd8" type="text" name="ecd_addresscontact" value="<?php if (!empty($data2['0'])){echo $this->xss($data2['0']);}else{echo $this->xss($data['0']);}?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd9"><?php echo _ECD_ADDRESSTELEPHONE;?></label></td><td><input id="ecd9" type="text" name="ecd_addresstelephone" value="<?php if (!empty($data2['1'])){echo $this->xss($data2['1']);}else{echo $this->xss($data['4']);}?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd10"><?php echo _ECD_ADDRESSCOUNTRY;?></label></td>
                <td>
                    <select id="ecd_country_sel" name="ecd_addresscountry">
                    <?php foreach ($countrys as $cur){ 
                            if ($cur['CountryId']==$data2['2']){
                                $sel ='selected="selected"';
                            }?><option <?php echo $sel;$sel=''; ?> value="<?php echo $cur['CountryId']?>"><?php echo $cur['CountryName']; ?></option>
                            <?php
                    }
                    ?>
                    </select>
                </td></tr>
            <tr><td style="text-align: right;"><label for="ecd11"><?php echo _ECD_ADDRESSREGION;?></label></td>
                <td>
                    <select id="ecd_region_sel" name="ecd_addressregion">
                    </select>
                </td></tr>
            <tr style="display:none;"><td style="text-align: right;"><label for="ecd12"><?php echo _ECD_ADDRESSINDEX;?></label></td><td><input id="ecd12" type="text" name="ecd_addressindex" value="<?php echo $this->xss($data2['4']);?>" /></td></tr>
            <tr id="ecd13_tr"><td style="text-align: right;"><label for="ecd13"><?php echo _ECD_ADDRESSCITY;?></label></td><td><input id="ecd13" type="text" name="ecd_addresscity" value="<?php echo $this->xss($data2['5']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd14"><?php echo _ECD_ADDRESSSTR;?></label></td><td><input id="ecd14" type="text" name="ecd_addressstr" value="<?php echo $this->xss($data2['6']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd15"><?php echo _ECD_ADDRESSHOUSE;?></label></td><td><input id="ecd15" type="text" name="ecd_addresshouse" value="<?php echo $this->xss($data2['7']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd16"><?php echo _ECD_ADDRESSBUILD;?></label></td><td><input id="ecd16" type="text" name="ecd_addressbuild" value="<?php echo $this->xss($data2['8']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd17"><?php echo _ECD_ADDRESSAPT;?></label></td><td><input id="ecd17" type="text" name="ecd_addressapt" value="<?php echo $this->xss($data2['9']);?>" /></td></tr>
            <tr><td style="text-align: right;"><label for="ecd18"><?php echo _ECD_ADDRESSCOMMENT;?></label></td><td><textarea id="ecd18" name="ecd_addresscomment" style="height: 37px;"><?php echo $this->xss($data2['10']);?></textarea></td></tr>
            <?php if (isset($data2['11'])){ ?>
            <tr><td style="text-align: right;"><label for="ecd19"><?php echo _ECD_ADDRESSDELETE;?></label></td><td><input id="ecd19" type="checkbox" name="ecd_deladdress" /></td></tr>
            <?php } ?>            
        </table>
        <br>
            <input type="hidden" name="ecd_editaddress" value="<?php echo $data2['11'];?>" />
            <input type="submit" class="button" value="<?php echo _ECD_SAVE;?>" />
    </form>
</fieldset>

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
