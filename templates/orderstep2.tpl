<fieldset id="os2">
    <legend class="orderstepname"><h2><?php echo _OS2_ORDERSTEP2; ?></h2></legend>
    <form method="post" action="<?php echo $action; ?>" style="margin: 0;" >
            <?php if ($ftemplate['covdesign']!=1){ ?>
            <p><?php echo _OS2_TEXT; ?><?php echo _OS2_TEXT3;?>
            <a class="more-link" target="_blank" href="new/cover.html"><?php echo _OS2_TEXT2;?> <span class="meta-nav">→</span></a>
            </p>

            
            									<div class="alert info" id="templatecover">
                                                	<?php echo _OS2_REQIMG; ?>
                                                </div>
            <?php }else{?>
            									<p>
                                                	<?php echo _OS2_MESSDESIGN; ?>
                                                </p>
            <?php }?>
            
        <div>
             <?php if ($ftemplate['covdesign']!=1){ ?>
           <div> 
           	<div style="float:left; padding-right: 20px;"><a class="button" href="<?php echo $hrefcovertemplate; ?>" ><?php echo _OS2_DOWNLOADTEMPL; ?></a>
           	</div>
            <div><input type="button" class="button red" id="uploadcover" value="<?php echo _OS2_UPLOADCOVER; ?>" />
            </div>
           </div>
            <?php }else{?>
            <input type="button" class="button" id="uploadcover" value="<?php echo _OS2_UPLOADIMAGE; ?>" />
            <?php }?>
            <p id="loading" style="display: none;">
                &nbsp;<?php echo _OS2_LOADING; ?><br>
                <img src="img/ajax-loader.gif" alt="Loading" />
            </p>
            <p id="mess" style="display: none;"></p>
        </div>
        <div id="coverlayout" style="display: none;">
            <table>
                <tr><td><?php echo _OS2_UPLOADEDFILE;?></td>
                	<td><a href="<?php echo $hrefcover; ?>"><?php echo _OS2_DOWNLOAD;?></a></td>
                </tr>
                <tr><td><?php echo _OS2_LAYOUT;?></td>
                	<td><a href="<?php echo $hrefcoverpdf; ?>" target="_blank"><?php echo _OS2_DOWNLOAD;?></a></td>
                 </tr>
            </table>
            
            									<div class="alert">
                                                	<?php echo _OS1_ADOBEREADER;?>&nbsp;<a target="_blank" href="//get.adobe.com/reader/"><img style="height:25px; vertical-align: bottom;" src="img/get_adobe_reader.gif" alt="Adobe Reader" /></a>
                                                </div>
            
        </div>
<!--        <div>
            <table>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OS2_TOTALCOVERS;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $totalcover.' '._OS2_RUB; ?></td></tr>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _OS2_TOTALBINDS;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $totalbind.' '._OS2_RUB; ?></td></tr>
            </table>
        </div>-->
        <div >
            <input type="hidden" value="1" name="os2_newo" />
            <input type="hidden" value="<?php echo $orderid;?>" name="os2_orderid" id="os2_orderid" />
            <input type="hidden" value="<?php echo $userid;?>" name="os2_userid" id="os2_userid" />
            <?php if ($ftemplate['covdesign']!=1){ ?>
            
            <p id="os2_agreement" style="display: none;"><input type="checkbox" name="agreement"  id="os2_agreement_ch" /> <?php echo _OS2_AGREEMENT; ?></p>
            
            <input type="submit" style="display: none;" class="button red" id="tonextstep" value="<?php echo _OS2_NEXTSTEP; ?>" />
            <?php }else{ ?>
            <br>
            <input type="submit" class="button red" id="tonextstep" value="<?php echo _OS2_NEXTSTEP; ?>" />
            <?php } ?>
        </div>
    </form>
    
    <div id="buttonskip">
        <?php if ($ftemplate['covdesign']!=1){ ?>
        										<hr>
        										<h2>Какие есть варианты?</h2>
                                                
        										<p>
                                                	<?php echo _OS2_MESSADDDESIGN; ?>
                                                </p>
        
        <div>
            <form method="post" action="<?php echo $action; ?>" style="margin: 0;" >
                <input type="hidden" value="1" name="os2_newo" />
                <input type="hidden" value="1" name="os2_adddesign" />
                <input type="submit" class="button" value="<?php echo _OS2_SKIPSTEP; ?>" />
            </form>
        </div>
        <br>
        										<p>
                                                	<?php echo _OS2_MESSADDDESIGN2; ?>
                                                	<br><br>
													<a href="//maket.editus.ru" target="_blank" class="button">Выбрать</a>
                                                </p>
        
        <?php }?>
    </div>
</fieldset>