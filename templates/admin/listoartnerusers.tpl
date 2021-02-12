<?php if (count($data)>0) {?>
<table id="listoartnerusers" class="dataview" style="width: 100%;">
    <thead><tr><th><?php echo _LP_PROJECTNUMBER; ?></th><th><?php echo _LP_PROJECTNAME; ?></th><th><?php echo _LP_PROJECTCOUNT; ?></th><th><?php echo _LP_PROJECTTOTAL; ?></th><th><?php echo _LP_PROJECTREG; ?></th><th><?php echo _LP_PROJECTDEL; ?></th></tr>
    </thead>
    <tbody>
    <?php
    foreach ($data as $cur){
        ?><tr><td style="padding: 3px;"><?php echo $cur[0];?></td><td><?php echo _LP_PROJECTSUFF.$cur[0];?></td><td class="editcount" id="<?php echo $cur[0];?>"><?php echo $cur[1];?></td><td id="<?php echo $cur[0];?>res"><?php echo ceil($cur[2]);?> <?php echo _LP_RUB;?></td><td>
                <form action="<?php echo $actionnext,$cur[0]; ?>" method="post">
<!--                    <input type="submit" class="button-s" value="<?php echo _LP_CONTREG;?>" />-->
                    <a href="/<?php echo $actionnext,$cur[0]; ?>"><?php echo _LP_CONTREG;?></a>
                </form>
            </td><td>
                <form action="<?php echo $actiondel; ?>" method="post">
                    <input type="hidden" name="projdel" value="<?php echo $cur[0];?>" />
<!--                    <input type="submit" class="button-s" value="<?php echo _LP_PROJECTDEL;?>" />-->
                    <input type="submit" style="background: transparent url('img/proj_del.png') no-repeat; height: 16px; width: 16px; border: 0; cursor: pointer;" value="" />
                </form>
            </td></tr>
    <?php }
    ?>
    </tbody>
</table>
<p><?php echo _LP_COMMENT; ?></p>
<?php echo $pages; ?>
<?php }else{ ?>
<p><?php echo _LP_LISTPROJECTSEMPTY; ?></p>
<?php } ?>
