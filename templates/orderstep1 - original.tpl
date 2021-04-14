<fieldset id="os1">
    <legend class="orderstepname"><h2><?php echo _OS1_ORDERSTEP1; ?>
        <span id="nameandauthorleg"><?php echo _OS1_NAMEANDAUTHORLEG; ?></span>
        <span id="resblockleg" style="display: none;"><?php echo _OS1_RESULTBLOCK; ?></span></h2>
    </legend>
    <form method="post" action="<?php echo $action; ?>" style="margin: 0; " >
        <div id="authorname">
            <p><label for="os1_name"><?php echo _OS1_NAMEORDER; ?></label>
            <input id="os1_name" type="text" name="os1_name" placeholder="<?php echo $this->xss(_OS1_PROJECTSUFF . $orderid); ?> "  onfocus="this.value='';"/>
            </p>
            <p>
            <label for="os1_author"><?php echo _OS1_AUTHOR; ?></label>
            <input id="os1_author" type="text" name="os1_author" placeholder="<?php echo $this->xss($author); ?> "  onfocus="this.value='';"/>
            
            
            <div>
                <input type="button" class="button red" id="toresultblock" value="<?php echo _OS1_NEXT; ?>" />
            </div>
        </div>
        <div id="resultblock" style="display: none;" >
            
            <p><?php echo _OS1_TEXT.$sizep,'.'._OS1_TEXT2.' '; ?><?php echo _OS1_TEXT4;?></p>

									
            									<div class="alert">
                                                	<?php echo _OS1_TEXT5;?>
                                                </div>
            
            <p><?php echo _OS1_TEXT6;?></p>
            <!-- .entry-content -->
                                    <div class="entry-content">
                                        <p>
                                        <a href="template.php" class="more-link" target="_blank"><?php echo _OS1_TEXT3;?> <span class="meta-nav">→</span></a></p>
                                    </div>
                                    <!-- .entry-content -->
            <div>
                <div style="float:left; padding-right: 20px;"><a class="button" href="<?php echo $hrefblock; ?>" ><?php echo _OS1_DOWNLOADLAYOT; ?></a>
                											
           	</div>
            <div>
                <input type="button" class="button red" id="uploadblock" value="<?php echo _OS1_UPLOADBLOCK; ?>" />
                </div>
                </div>
               
                <span style="display: none; cursor:pointer;" id="uploadblock_after"><?php echo _OS1_UPLOADBLOCK_AFTER; ?></span>
                <p id="loading" style="display: none;">
                     &nbsp;<?php echo _OS1_LOADING;?><br>
                    <img src="img/ajax-loader.gif" alt="Loading" />
                </p>
                <p id="messerror" style="display: none;"></p>
            </div>
            <div id="os1_res" style="display: none;" >
            <br>
                								<div class="alert error" id="correctpages" style="display: none;">
                                                	<?php echo _OS1_CORRECTPAGES;?>
                                                </div>
                
                <table>
                    <tr><td><?php echo _OS1_YOUPAGES;?></td>
                    	<td style="padding-left:10px;" id="os1_userpages"><?php echo $data['volume']; ?></td>
                     </tr>
                    <tr><td><?php echo _OS1_CURPAGES;?></td>
                    	<td style="padding-left:10px;" id="os1_curpages"></td>
                    </tr>
                    <tr><td><?php echo _OS1_COUNTSYMB;?></td>
                    	<td style="padding-left:10px;" id="os1_countsymb"></td>
                     </tr>
<!--                    <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OS1_COUNT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['projectCount']; ?></td></tr>-->
<!--                    <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OS1_TOTALBLOCKS;?></td><td style="text-align: left; vertical-align: middle;"><span id="os1_totalblocks"></span> <?php echo _OS1_RUB;?></td></tr>-->
<!--                    <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OS1_TOTALADDSERVICE;?></td><td style="text-align: left; vertical-align: middle;"><span id="os1_totaladds"></span> <?php echo _OS1_RUB;?></td></tr>-->
                    <tr id="hidepdf">
                    	<td><?php echo _OS1_UPLOADEDFILE;?></td>
                        <td style="padding-left:10px;"><a id="os1_uploadedblock" href=""><?php echo _OS1_DOWNLOAD;?></a></td>
                    </tr>
                    <tr>
                    	<td><?php echo _OS1_LAYOUT;?>:</td>
                        <td style="padding-left:10px;"><a id="os1_layout" href=""><?php echo _OS1_DOWNLOAD;?></a></td>
                    </tr>
                </table>
                								
                
                                               
                                                <div class="alert">
                                                	<?php echo _OS1_TEXT7;?> <?php echo _OS1_ADOBEREADER;?>&nbsp;<a target="_blank" href="//get.adobe.com/reader/"><img style="height:25px; vertical-align: bottom;" src="img/get_adobe_reader.gif" alt="Adobe Reader" /></a>
                                                </div>
                <p><?php echo _OS1_TEXT8;?> <?php echo _OS1_TEXT9;?>
                                                </p>
            </div>
            <div id="newbind" style="display: none; margin: 0; padding: 0;">
                								<br>
                                                <div class="alert error">
                                                	<?php echo _OS1_CONFPAGE; ?>
                                                </div>
                <p id="newbindtd"></p>
            </div>
            <div id="os1_agree" style="display: none;" >
                <div id="os1_agreement_text" style="display: none; max-width:100%; background:#FFFFFF; margin:100px; padding:30px;">
                	<?php echo Settings::getsetting('publrules');?>
                    	<p><a href="#" id="os1_agreement_yes" class="os1_agreement_close"><?php echo _OS1_AGREEMENT_1; ?> <?php echo _OS1_AGREEMENT; ?></a><a href="#" style="margin-left: 20px;" id="os1_agreement_close" class="os1_agreement_close"><?php echo _OS1_AGREEMENT_CLOSE; ?></a></p></div>
                			
                			<input type="checkbox" name="agreement" id="os1_agreement" /> <?php echo _OS1_AGREEMENT_1; ?> <a href="#" id="os1_agreement_lab"> <?php echo _OS1_AGREEMENT; ?></a> <?php echo _OS1_AGREEMENT2; ?>
                            <label class="inline-label"></label>
               
            </div>
            <div>
                <div style="display: none;" id="debug">
                </div>
                <input type="hidden" value="1" name="os1_newo"/>
                <input type="hidden" value="<?php echo $orderid;?>" name="os1_orderid" id="os1_orderid" />
                <input type="hidden" value="<?php echo $userid;?>" name="os1_userid" id="os1_userid" />
                <!--<p><a class="button" style="cursor:pointer;" id="toauthorname"><?php echo _OS1_BACK; ?></a></p>-->
                <br>
                <input type="submit" style="display: none;" class="button red" id="tonextstep" value="<?php echo _OS1_NEXTSTEP; ?>" />
            </div>
        </div>
    </form>
</fieldset>