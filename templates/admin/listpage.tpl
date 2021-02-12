<div style="text-align: center;">
    <?php
    for($i=($curpage-3);$i<=$curpage+3;$i++){
        if ($i>0 && $i<=$pages){
            if ($i!=$curpage){?>    
                <a href="<?php echo $action."&amp;p=".$i; ?>"><?php echo $i;?></a>  
            <?php }else{?>
                <?php echo $i;
            }
        }
    } ?>
</div>