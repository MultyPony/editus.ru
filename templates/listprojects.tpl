												<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=listprojects" class="active">Проекты</a></li>
                                                        <li><a href="editus.php?do=listorders">Заказы</a></li>
                                                        <li><a href="editus.php?do=listarchive">Архив</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                 </div>
                                                 
                                                 <?php if (count($data)>0) {?>
<table id="listprojects" class="dataview" style="width: 100%;">
    <thead><tr><th><?php echo _LP_PROJECTNUMBER; ?></th><th><?php echo _LP_PROJECTNAME; ?></th><th><?php echo _LP_PROJECTCOUNT; ?></th><th><?php echo _LP_PROJECTTOTAL; ?></th><th><?php echo _LP_PROJECTREG; ?></th><th><?php echo _LP_PROJECTDEL; ?></th></tr>
    </thead>
    <tbody align="center">
    <?php
    foreach ($data as $cur){
        ?><tr><td><?php echo $cur[0];?></td><td><?php echo _LP_PROJECTSUFF.$cur[0];?></td><td class="editcount" id="<?php echo $cur[0];?>"><?php echo $cur[1];?></td><td id="<?php echo $cur[0];?>res"><?php echo ceil($cur[2]);?> <?php echo _LP_RUB;?></td><td>
                <form action="<?php echo $actionnext,$cur[0]; ?>" method="post">
<!--                    <input type="submit" class="button-s" value="<?php echo _LP_CONTREG;?>" />-->
                    <a href="/<?php echo $actionnext,$cur[0]; ?>"><?php echo _LP_CONTREG;?></a>
                </form>
            </td><td>
                <form action="<?php echo $actiondel; ?>" method="post">
                    <input type="hidden" name="projdel" value="<?php echo $cur[0];?>" />
<!--                    <input type="submit" class="button-s" value="<?php echo _LP_PROJECTDEL;?>" />-->
                    <button style="background:none;"><i class="icon-trash"></i></button>

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
<hr>
<a href="project.php" class="button red">Новый заказ</a>
 <div class="alert" style="margin-top:20px;">
                                                	<strong> ВНИМАНИЕ: </strong>в личном кабинете отображаются заказы только на <strong>печать книги</strong>.
                                                </div>