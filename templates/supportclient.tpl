								<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=editclientdata">Профиль</a></li>
                                                        <li><a href="editus.php?do=supportclient" class="active">Помощь</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                 </div>
                                                 
                                                 <?php foreach($datamess as $cur){
    if ($cur['replyId']==0 && $cur['subj']!= 'Re'){
        $dm[]=$cur;
    }elseif($cur['is_read_ans']==0 && $cur['subj']!= 'Re'){
        $dmr[]=$cur;
    }
} 
if (count($dm)>0){?>
<fieldset>
    <legend class="orderstepname"><h3><?php echo _SC_MESSDONTREPLY;?></h3></legend>
    <table width="100%">
        <?php foreach ($dm as $cur){ ?>
        <tr><td><a href="<?php echo $href.$cur['0'];?>"><?php echo mb_substr($cur['2'],0,50);?></a>...</td></tr>
        <?php } ?>            
    </table>
</fieldset>
<?php } if (count($dmr)>0){?>
<fieldset>
    <legend class="orderstepname"><h3><?php echo _SC_MESSNEWREPLY;?></h3></legend>
    <table width="100%">
        <?php foreach ($dmr as $cur){ ?>
        <tr><td><a style="font-weight: bold;" href="<?php echo $href.$cur['0'];?>"><?php echo mb_substr($cur['2'],0,50);?></a>...</td></tr>
        <?php } ?>            
    </table>
</fieldset>
<?php } ?>

<form action="<?php echo $action;?>" method="post">
    <fieldset>
        <legend class="orderstepname"><h3><?php echo _SC_TITLE;?></h3></legend>
        <table width="100%">
            <tr><td style="text-align: right;  width:35%;"><label for="sc_cat"><?php echo _SC_CATEGORY;?></label></td><td>
                    <select id="sc_cat" name="sc_cat">
                        <?php foreach ( $cats as $cur){
                            if ($cur['1'] == $userdata['sc_cat']){
                                $sel = 'selected="selected"';
                            }
                        ?>
                        <option <?php echo $sel;$sel=''; ?> value="<?php echo $cur['1']; ?>"><?php echo $cur['0'];?></option>
                        <?php
                        } ?>
                    </select>
                </td></tr>
            <tr><td style="text-align: right; width:35%;"><label for="sc_subject"><?php echo _SC_SUBJECT;?></label></td><td><input id="sc_subject" type="text" name="sc_subject" value="<?php echo $userdata['sc_subject'];?>" /></td></tr>
            <tr><td style="text-align: right; width:35%;"><label for="sc_message"><?php echo _SC_MESSAGE;?></label></td><td><textarea id="sc_message" name="sc_message"><?php echo $userdata['sc_message'];?></textarea></td></tr>
        </table>
        <br>
        <div>
            <input type="submit" class="button" value="<?php echo _SC_SEND;?>" />
        </div>
    </fieldset>
</form>
<?php if (count($archiv)>0){?>
<fieldset>
    <legend class="orderstepname"><h3><?php echo _SC_ARCHIVE;?></h3></legend>
    <table width="100%">
        <?php foreach ($archiv as $cur){ ?>
        <tr><td><a href="<?php echo $href.$cur['0'];?>"><?php echo mb_substr($cur['1'],0,50);?></a>...</td></tr>
        <?php } ?>            
    </table>
    <?php echo $pages;?>
</fieldset>
<?php  }?>