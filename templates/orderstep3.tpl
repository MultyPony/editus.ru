<?php if ($mode == 1) { ?>
    <fieldset id="os3">
        <legend class="orderstepname"><h2><?php echo _OS3_ORDERSTEP3; ?></h2></legend>
        <form method="post" action="<?php echo $action; ?>">
            <div>
                
                            <h3><?php echo $dataorder['cover']; ?></h3>
                        
                    <div class="row-fluid show-grid">
                            <div class="span3">
                        		<img src="img/bindtype_<?php echo $dataorder['orderBinding'];?>.jpg" border="0" alt="bindtype" />
                            </div>
                        	<div class="span4"><b><?php echo $dataorder['formatName'];?></b> <?php echo $dataorder['formatWidth'].'x'.$dataorder['formatHeight'];?> <br />
                            <?php echo $dataorder['orderPages'];?> стр.<br /> 
                            <?php echo _OS3_BIND;?> - <?php echo $dataorder['BindingName'];?><br /> 
                            <?php echo _OS3_BLOCK;?> <?php echo $dataorder['PaperTypeName'];?>, <?php echo $dataorder['PaperTypeWeight'];?><br />
                            <?php echo _OS3_COUNT;?> - <b><?php echo $dataorder['orderCount'];?> <?php echo _OS3_EKZ;?></b>
                        </div>
                      </div>
                <h4><?php echo _OS3_TOTALPRINT;?> <a ><?php echo $dataorder['totalPrice'];?></a> <?php echo _OS3_RUB;?></h4>
                <h4><?php echo _OS3_TOTALADDSERVICE;?> <a><?php echo $dataorder['orderPriceAdditService'];?></a> <?php echo _OS3_RUB;?></h4>

                <div class="entry-content">
                    <div id="os3_offer_text" style="display: none; max-width:100%; background:#FFFFFF; margin:100px; padding:30px;"><div style="overflow: hidden;"><?php echo Settings::getsetting('offerizd');?></div>
                    <p><a href="#" id="os3_offer_yes" class="os3_offer_close"><?php echo _OS3_OFFERCONF; ?></a><a href="#" style="margin-left: 30px;" id="os3_offer_close" class="os3_offer_close"><?php echo _OS3_AGREEMENT_CLOSE; ?></a></p></div>
                    <input id="os3_offer" type="checkbox" /><a id="os3_offer_lab" href="#"> <?php echo _OS3_OFFERCONF; ?></a>
                </div>
            </div>
            <div  id="delivery" style="display: none;" class="validate-form">
               								
                                                <h5><?php echo _OS3_TYPEDELIVER; ?></h5>
                    						
                                                <label class="inline-label">
                                                	<input type="radio" name="typedeliv" value="pickup" /> <?php echo _OS3_PICKUP; ?>
                                                </label>
                    
                                                <label class="inline-label">
                                                    <input type="radio" name="typedeliv" value="deliver" /> <?php echo _OS3_DELIV; ?>
                                                </label>

                                                <label class="inline-label cdek-label">
                                                    <input type="radio" name="typedeliv" value="pickup-point" onclick='cartWidjet.open()'/> <?php echo _OS3_PICKUP_POINT; ?>
                                                </label>
                
            </div>
           <?php if ($isorg==1){?>
            <table id="isorg" style="display: none; width:100%;">
                <tr>
                    <td style="text-align: right;"><?php echo _OS3_TYPEBILL; ?></td>
                    <td>
                        <label><input type="radio" name="isorg" value="1" checked="checked"/><?php echo _OS3_USERORG; ?></label> <br />
                        <label><input type="radio" name="isorg" value="0" /><?php echo _OS3_USERFIS; ?></label>
                    </td>
                </tr>
            </table> 
            <?php }else{?>
                <input type="hidden" name="isorg" value="0" />
            <?php } ?>
            
            <div id="pvz_cdek" style="display: none;">
                <div>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td style="text-align: right; width:35%">
                                    <span id="show_pvz_address">Адрес ПВЗ:</span>
                                </td>
                                <td style="text-align: left; vertical-align: middle;">
                                    <input id="os3_pvz_address" type="text" name="os3_pvz_address" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right; width:35%">
                                    <span id="show_delivery_price">Стоимость доставки:</span>
                                </td>
                                <td style="text-align: left; vertical-align: middle;">
                                    <input id="os3_delivery_price" type="text" readonly>
                                    <input id="hidden_del_price" type="hidden" value="0" name="os3_delivery_price"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>             
            </div>

            <div id="deliveryaddress" style="display: none;">
                <div>
                    <table width="100%">
                        <tr><td style="text-align: right; width:35%">
                                <span id="selectaddress"><?php echo _OS3_SELECTADDRESS; ?></span>
                                <span id="selectaddressbill" style="display: none;"><?php echo _OS3_SELECTADDRESSBILL; ?></span>
                            </td>
                            <td style="text-align: left; vertical-align: middle;">
                                <select id="os3_addresses_sel" name="os3_addreses">
                                    <?php
                                    foreach ($addreses as $cur) {
                                        if ($cur['addressId'] == $data2['11']) {
                                            $sel = 'selected="selected"';
                                        }
                                        ?><option <?php echo $sel;
                                $sel = ''; ?> value="<?php echo $cur['addressId'] ?>"><?php echo $this->xss($cur['addressIndex'] . ', ' . $cur['addressCity'] . ', ' . $cur['addressStr'] . ', ' . $cur['addressHouse'] . ', ' . $cur['addressApt']); ?></option><?php
                                }
                                    ?><option value="new"><?php echo _OS3_ADDADDRESE; ?></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
                <div id="newaddress" style="display: none;">
                    <table width="100%">
                        <tr>
                        	<td style="text-align: right; width:35%;"><label for="os30"><?php echo _OS3_ADDRESSCONTACT; ?></label></td>
                        <td ><input id="os30" type="text" name="os3_addresscontact" value="<?php
                                if (!empty($data2['0'])) {
                                    echo $this->xss($data2['0']);
                                } else {
                                    echo $this->xss($data['0']);
                                }
                                ?>" /></td>
                         </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os31"><?php echo _OS3_ADDRESSTELEPHONE; ?></label></td>
                            <td><input id="os31" type="text" name="os3_addresstelephone" value="<?php
                            if (!empty($data2['1'])) {
                                echo $this->xss($data2['1']);
                            } else {
                                echo $this->xss($data['4']);
                            }
                            ?>" /></td>
                        </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os3_country_sel"><?php echo _OS3_ADDRESSCOUNTRY; ?></label></td>
                            <td>
                                <select id="os3_country_sel" name="os3_country">
    <?php foreach ($countrys as $cur) {
        ?><option value="<?php echo $cur['CountryId'] ?>"><?php echo $cur['CountryName']; ?></option><?php
    }
    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os3_region_sel"><?php echo _OS3_ADDRESSREGION; ?></label></td>
                            <td>
                                <select id="os3_region_sel" name="os3_region">
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os34"><?php echo _OS3_ADDRESSINDEX; ?></label></td>
                            <td><input id="os34" type="text" name="os3_addressindex" value="" /></td>
                        </tr>
                        <tr id="os35_tr">
                        	<td style="text-align: right;"><label for="os35"><?php echo _OS3_ADDRESSCITY; ?></label></td>
                            <td><input id="os35" type="text" name="os3_addresscity" value="" /></td>
                        </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os36"><?php echo _OS3_ADDRESSSTR; ?></label></td>
                            <td><input id="os36" type="text" name="os3_addressstr" value="" /></td>
                       	</tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os37"><?php echo _OS3_ADDRESSHOUSE; ?></label></td>
                            <td><input id="os37" type="text" name="os3_addresshouse" value="" /></td>
                        </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os38"><?php echo _OS3_ADDRESSBUILD; ?></label></td>
                            <td><input id="os38" type="text" name="os3_addressbuild" value="" /></td>
                        </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os39"><?php echo _OS3_ADDRESSAPT; ?></label></td>
                            <td><input id="os39" type="text" name="os3_addressapt" value="" /></td>
                        </tr>
                        <tr>
                        	<td style="text-align: right;"><label for="os341"><?php echo _OS3_ADDRESSCOMMENT; ?></label></td>
                            <td><textarea id="os341" rows="15" cols="20" name="os3_addresscomment" style="height: 37px;"></textarea></td>
                        </tr>
                    </table>
                    <br>
                    
                        <input type="button" class="button" id="saveandselnewaddress" value="<?php echo _OS3_SAVEANDSEL; ?>" />
                    
                </div>
            </div>
            
            <div id="deliveryfirm" style="display: none;">
                <div id="providers" style="display: none;">
                    <table width="100%">
                        <tr>
                        	<td style="text-align: right; width:35%;"><?php echo _OS3_SELPROVIDERS; ?></td>
                        	<td>
                                <select id="os3_providers_sel" name="os3_providers">
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <input type="hidden" name="totalcosts" id="totalcosts" value ="<?php echo $dataorder['orderPriceAdditService']+$dataorder['totalPrice'];?>" />
            <hr>
            <h3 id="os3_total" style="display: none;">
                <?php echo _OS3_TOTAPRICE;?> 
                    <span class="label" id="prwithdeliv"></span> <?php echo _OS3_RUB;?>
            </h3>
            <div>
                <input type="hidden" value="1" name="os3_newo"/>
                <input type="hidden" value="<?php echo intval($_GET['o']); ?>" name="os3_orderid" id="os3_orderid" />
                <input type="hidden" value="<?php echo $_SESSION['userId']; ?>" name="os3_userid" id="os3_userid" />
                <input type="submit" style="display: none;" class="button red" id="completeorder" value="<?php echo _OS3_COMPLETEORDER; ?>" />
            </div>
        </form>
    </fieldset>
    <script type="text/javascript">
        var cartWidjet = new ISDEKWidjet({
            defaultCity: 'auto',
            cityFrom: 'Москва',
            hidedelt: true,
            popup: true,
            goods: [{
                length: 25,
                width: 17,
                height: 7,
                weight: <?php echo round($massa/1000,1); ?>
            }],
            onChoose: function(wat) {
                window.pvz = wat;
                window.showPvzFields();

            },
        });



    </script>
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
        <option <?php echo $sell; $sell = ''; ?> value="<?php echo $cur['addressId'] ?>"><?php echo $cur['addressIndex'] . ', ' . $cur['addressCity'] . ', ' . $cur['addressStr'] . ', ' . $cur['addressHouse'] . ', ' . $cur['addressApt']; ?></option><?php } ?><option value="new"><?php echo _OS3_ADDADDRESE; ?></option>
<?php } if ($mode == 4) { 
    if (count($providers)>0){ $fis = 'selected="selected"';?>
    <?php foreach ($providers as $cur) { ?>
        <option <?php echo $fis; ?> title="<?php echo $cur['DeliveryProvidersCosts']; ?>"  value="<?php echo $cur['DeliveryProvidersCostsId'] ?>"><?php echo $cur['DeliveryProviderName'] . ' (' . round($massa/1000,1) ._OS3_KG.'- '. $cur['DeliveryProvidersCosts'] . ' ' . _OS3_RUB . ')'; ?></option>
    <?php $fis= '';} 
    
    }else{?>
        <option value=""><?php echo _OS3_NOTDELIVPROVID; ?></option>
<?php } }?>
