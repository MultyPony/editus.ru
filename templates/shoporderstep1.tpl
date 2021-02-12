<?php if ($mode == 1) { ?>
    <fieldset id="so1">
        <legend class="orderstepname"><h2><?php echo _SO1_SHOPORDER1; ?></h2></legend>
        <form method="post" action="<?php echo $action; ?>" style="font-family: Palatino Linotype,Book Antiqua,Times New Roman;">
            <div>
                <div class="row-fluid show-grid dataview">
                            
                    <?php
                    foreach ($dataorder as $cur){
                        $i = 0;?>
                        <div class="span3"><img src="items/<?php echo $cur['itemsId'];?>/<?php echo $cur['itemsId'];?>_cover.png" alt="<?php echo $cur['itemName'];?>" />
                        </div>
                        <div class="span4">
                        <h3><?php echo $cur['itemName'];?></h3></div>
                        <div class="span3" style="text-align:right;"><h3> x <?php echo $cur['amount'];?></h3></div>
                        <div style="clear:both;"></div>
                    <?php 
                        $sum +=$cur['sum'];
                    }
                    ?>
                    </div>
                    
                <h4><?php echo _SO1_TOTALPRINT;?> <a><?php echo $sum;?></a> <?php echo _SO1_RUB;?></h4>

                <div class="entry-content">
                    <div id="so1_offer_text" style="display: none; max-width:100%; background:#FFFFFF; margin:100px; padding:30px;">
                        <div style="overflow: hidden;"><?php echo Settings::getsetting('offershop');?></div>
                        <p>
                            <a href="#" id="so1_offer_yes" class="so1_offer_close"><?php echo _SO1_OFFERCONF; ?></a>
                            <a href="#" style="margin-left: 30px;" id="so1_offer_close" class="so1_offer_close"><?php echo _SO1_AGREEMENT_CLOSE; ?></a>
                        </p>
                    </div>
                    <input id="so1_offer" type="checkbox" /> <a id="so1_offer_lab" href="#"><?php echo _SO1_OFFERCONF; ?></a>
                </div>
            </div>
            <div  id="delivery" style="display: none;" class="validate-form">
               								
                                                <h5><?php echo _SO1_TYPEDELIVER; ?></h5>
                    						
                                                <label class="inline-label">
                                                	<input type="radio" name="typedeliv" value="pickup" /> <?php echo _SO1_PICKUP; ?>
                                                </label>
                    
                                                <label class="inline-label">
                                                    <input type="radio" name="typedeliv" value="deliver" /> <?php echo _SO1_DELIV; ?>
                                                </label>
                
            </div>
            
           <?php if ($isorg==1){?>
            <table id="isorg" style="display: none; width:100%;">
                <tr>
                    <td style="text-align: right;"><?php echo _SO1_TYPEBILL; ?></td>
                    <td>
                        <label><input type="radio" name="isorg" value="1" checked="checked"/><?php echo _SO1_USERORG; ?></label> <br />
                        <label><input type="radio" name="isorg" value="0" /><?php echo _OS1_USERFIS; ?></label>
                    </td>
                </tr>
            </table> 
            <?php }else{?>
                <input type="hidden" name="isorg" value="0" />
            <?php } ?>
            <div id="deliveryaddress" style="display: none;">
                <div>
                    <table width="100%">
                        <tr><td style="text-align: right; width:35%">
                                <span id="selectaddress"><?php echo _SO1_SELECTADDRESS; ?></span>
                                <span id="selectaddressbill" style="display: none;"><?php echo _SO1_SELECTADDRESSBILL; ?></span>
                            </td>
                            <td>
                                <select id="so1_addresses_sel" name="so1_addreses">
                                    <?php
                                    foreach ($addreses as $cur) {
                                        if ($cur['addressId'] == $data2['11']) {
                                            $sel = 'selected="selected"';
                                        }
                                        echo "/n";
                                        ?><option <?php echo $sel;
                                $sel = ''; ?> value="<?php echo $cur['addressId'] ?>"><?php echo $this->xss($cur['addressIndex'] . ', ' . $cur['addressCity'] . ', ' . $cur['addressStr'] . ', ' . $cur['addressHouse'] . ', ' . $cur['addressApt']); ?></option><?php
                                }
                                    ?><option value="new"><?php echo _SO1_ADDADDRESE; ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="newaddress" style="display: none;">
                    <table width="100%">
                        <tr><td style="text-align: right; width:35%;"><label for="so10"><?php echo _SO1_ADDRESSCONTACT; ?></label></td>
                        	<td><input id="so10" type="text" name="so1_addresscontact" value="<?php
                                if (!empty($data2['0'])) {
                                    echo $this->xss($data2['0']);
                                } else {
                                    echo $this->xss($data['0']);
                                }
                                ?>" /></td></tr>
                        <tr><td style="text-align: right;"><label for="so11"><?php echo _SO1_ADDRESSTELEPHONE; ?></label></td>
                        	<td><input id="so11" type="text" name="so1_addresstelephone" value="<?php
                            if (!empty($data2['1'])) {
                                echo $this->xss($data2['1']);
                            } else {
                                echo $this->xss($data['4']);
                            }
                            ?>" /></td></tr>
                        <tr><td style="text-align: right;"><label for="so1_country_sel"><?php echo _SO1_ADDRESSCOUNTRY; ?></label></td>
                            <td>
                                <select id="so1_country_sel" name="so1_country">
    <?php foreach ($countrys as $cur) {
        echo "/n"; ?><option value="<?php echo $cur['CountryId'] ?>"><?php echo $cur['CountryName']; ?></option><?php
    }
    ?>
                                </select>
                            </td></tr>
                        <tr><td style="text-align: right;"><label for="so1_region_sel"><?php echo _SO1_ADDRESSREGION; ?></label></td>
                            <td>
                                <select id="so1_region_sel" name="so1_region">
                                </select>
                            </td></tr>
                        <tr><td style="text-align: right;"><label for="so14"><?php echo _SO1_ADDRESSINDEX; ?></label></td>
                        	<td><input id="so14" type="text" name="so1_addressindex" value="" /></td></tr>
                        <tr id="so15_tr">
                        	<td style="text-align: right;"><label for="so15"><?php echo _SO1_ADDRESSCITY; ?></label></td>
                            <td><input id="so15" type="text" name="so1_addresscity" value="" /></td></tr>
                        <tr><td style="text-align: right;"><label for="so16"><?php echo _SO1_ADDRESSSTR; ?></label></td>
                        	<td><input id="so16" type="text" name="so1_addressstr" value="" /></td></tr>
                        <tr><td style="text-align: right;"><label for="so17"><?php echo _SO1_ADDRESSHOUSE; ?></label></td>
                        	<td><input id="so17" type="text" name="so1_addresshouse" value="" /></td></tr>
                        <tr><td style="text-align: right;"><label for="so18"><?php echo _SO1_ADDRESSBUILD; ?></label></td>
                        	<td><input id="so18" type="text" name="so1_addressbuild" value="" /></td></tr>
                        <tr><td style="text-align: right;"><label for="so19"><?php echo _SO1_ADDRESSAPT; ?></label></td>
                        	<td><input id="so19" type="text" name="so1_addressapt" value="" /></td></tr>
                        <tr><td style="text-align: right;"><label for="so141"><?php echo _SO1_ADDRESSCOMMENT; ?></label></td>
                        	<td><textarea id="so141" name="so1_addresscomment" ></textarea></td></tr>
                    </table>
                    <br>
                        <input type="button" class="button" id="saveandselnewaddress" value="<?php echo _SO1_SAVEANDSEL; ?>" />
                </div>
            </div>
            
            <div id="deliveryfirm" style="display: none;">
                <div id="providers" style="display: none;">
                    <table width="100%">
                        <tr><td style="text-align: right; width:35%;"><?php echo _SO1_SELPROVIDERS; ?></td>
                        	<td>
                                <select id="so1_providers_sel" name="so1_providers">

                                </select>
                            </td></tr>
                    </table>
                </div>
            </div>
            <input type="hidden" name="totalcosts" id="totalcosts" value ="<?php echo $sum;?>" />
            <hr>
            <h3 id="so1_total" style="display: none;"><?php echo _SO1_TOTAPRICE;?> <span class="label" id="prwithdeliv"></span> <?php echo _SO1_RUB;?></h3>
            <div>
                <input type="hidden" value="1" name="so1_newo"/>
                <input type="hidden" value="<?php echo intval($_GET['o']); ?>" name="so1_orderid" id="so1_orderid" />
                <input type="hidden" value="<?php echo $_SESSION['userId']; ?>" name="so1_userid" id="so1_userid" />
                <input type="submit" style="display: none;" class="button red" id="completeorder" value="<?php echo _SO1_COMPLETEORDER; ?>" />
            </div>
        </form>
    </fieldset>
    <?php
}
if ($mode == 2) {
    foreach ($regions as $cur) {
        if ($cur['iscity']==1){
            $c = 'class="iscity"';
        }else{
            $c = '';
        }
        ?>
        <option <?php echo $c; ?> value="<?php echo $cur['RegionId']; ?>"><?php echo $cur['RegionName']; ?></option>
        <?php
    }
}
if ($mode == 3) {
    foreach ($addreses as $cur) {
        if ($cur['addressId'] == $sel) {
            $sell = 'selected="selected"';
        }
        ?>
        <option <?php echo $sell; $sell = ''; ?> value="<?php echo $cur['addressId'] ?>"><?php echo $cur['addressIndex'] . ', ' . $cur['addressCity'] . ', ' . $cur['addressStr'] . ', ' . $cur['addressHouse'] . ', ' . $cur['addressApt']; ?></option><?php } ?><option value="new"><?php echo _SO1_ADDADDRESE; ?></option>
<?php } if ($mode == 4) { 
    if (count($providers)>0){?>
    <?php foreach ($providers as $cur) { $fis = 'selected="selected"'; ?>
        <option title="<?php echo $cur['DeliveryProvidersCosts']; ?>"  value="<?php echo $cur['DeliveryProvidersCostsId'] ?>"><?php echo $cur['DeliveryProviderName'] . ' (' . round($massa/1000,1) ._SO1_KG.'- '. $cur['DeliveryProvidersCosts'] . ' ' . _SO1_RUB . ')'; ?></option>
    <?php $fis= ''; } 
    
    }else{?>
        <option value="0"><?php echo _SO1_NOTDELIVPROVID; ?></option>
<?php } 

}?>
