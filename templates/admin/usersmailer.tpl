<?php
    foreach ($users as $cur){
        $nm[$cur['userGroupId']][] = $cur;
    }
?>
<h2 id="usersmailer"><?php echo _UM_TITLE; ?></h2>
<form method="post" action="index.php?do=usersmailer"> 
    <?php 
        foreach ($nm as $key=>$cur){
            ?><fieldset id="<?php echo $key; ?>">
                <legend> <?php echo $cur[0][3]; ?></legend>
                <a href="#" class="hideshow" style="margin:0;padding:0;float:left;"><?php echo _UM_SHOWHIDE; ?></a><br />
                <?php
                foreach ($cur as $cur2 ){
                    ?><label style="display: block; float: left; min-width: 270px;"><input class="mails" type="checkbox" name="umails[]" value="<?php echo $cur2['userEmail']; ?>" /><?php echo $cur2['userFirstName'].' - ( '.$cur2['userEmail'].' )'; ?></label><?php
                }
                ?></fieldset> <?php
        }
    ?>
    <fieldset>
        <label><?php echo _UM_VARS; ?></label><br />
        <label><?php echo _UM_SUBJ; ?><input style="width: 600px; margin-left: 50px;" type="text" name="subj"/></label><br />
        <label style="vertical-align: top;"><?php echo _UM_MESS; ?><textarea style="margin-left: 5px;" name="mess" rows="25" cols="90" /><?php echo _UM_UNSUBSCTEXT; ?></textarea></label>
        <br /><br /><input style="margin-left: 60px;" type="submit" value="<?php echo _UM_SEND; ?>" />
    </fieldset>
</form>
<fieldset>
<legend> <?php echo _UM_EMAILERS; ?></legend>
<table class="dataview">
<?php 
foreach($data as $cur){
    ?>
    <tr>
        <td><?php 
        $t = implode(', ', unserialize($cur['usersEmail']));
        if (strlen($t)<30){
            echo $t;
        }else{
            echo mb_substr($t, 0, 30).'<a class="mail" href="#" id="mail'.$cur['mailerId'].'"> '._UM_ALL.'</a><span id="allmail'.$cur['mailerId'].'" style="display:none;">'.mb_substr($t, 30).'</span>';
        }
        ?>
        </td>
        <td><?php echo $cur['subj'];?></td>
        <td><?php 
         if (strlen($cur['mess'])<65){
             echo $cur['mess'];
         }else{
             echo mb_substr($this->xss($cur['mess']), 0, 64).'<a class="mess" href="#" id="'.$cur['mailerId'].'"> '._UM_ALL.'</a><span id="all'.$cur['mailerId'].'" style="display:none;">'.mb_substr($this->xss($cur['mess']), 64).'</span>';
         }
        ?>
        </td>
        <td><?php echo $cur['mailerDate'];?></td>
    </tr><?php
}
?>
</table>
 <?php echo $pages;?>
</fieldset>