<?php foreach($datamess as $cur){
    if ($cur['replyId']==0 && $cur['subj']!= 'Re'){
        $dm[]=$cur;
    }
} 
if (count($dm)>0){?>
<fieldset>
    <legend><?php echo _SCA_MESSDONTREPLY;?></legend>
    <table>
        <?php foreach ($dm as $cur){ ?>
        <tr><td><a href="<?php echo $href.$cur['0'];?>"><?php echo substr($cur['2'],0,50);?></a>...</td><td><?php echo $cats[$cur['catId']][1];?></td><td><?php echo date("H:i d-m-Y", strtotime($cur['date'])); ?></td></tr>
        <?php } ?>            
    </table>
</fieldset>
<?php }
 if (count($archiv)>0){?>
<fieldset>
    <legend><?php echo _SCA_ARCHIVE;?></legend>
    <table>
        <?php foreach ($archiv as $cur){ ?>
        <tr><td><a href="<?php echo $href.$cur['0'];?>"><?php echo substr($cur['1'],0,50);?></a>...</td></tr>
        <?php } ?>            
    </table>
    <?php echo $pages;?>
</fieldset>
<?php  }?>