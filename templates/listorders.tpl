											<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=listprojects">Проекты</a></li>
                                                        <li><a href="editus.php?do=listorders" class="active">Заказы</a></li>
                                                        <li><a href="editus.php?do=listarchive">Архив</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                    </div>
<?php if (count($orders)>0) {?>
<table id="listorders" class="dataview" style="width: 100%;">
    <thead><tr>
            <th><?php echo _LO_ORDERNUMBER;?></th><th><?php echo _LO_ORDERNAME; ?></th><th><?php echo _LO_ORDERAUTOR; ?></th><th><?php echo _LO_ORDERCOUNT; ?></th><th><?php echo _LO_ORDERDATE; ?></th><th><?php echo _LO_ORDERSTATUS; ?></th><th><?php echo _LO_ORDERDEL; ?></th></tr>
    </thead>
    <tbody align="center">
    <?php
    foreach ($orders as $cur){?>
       <tr><td>
                <a href="<?php echo $actionview.$cur['orderId'];?>"><?php echo $cur['orderId'];?></a>
           </td><td><?php echo $cur['orderName'];?></td><td><?php echo $cur['orderAutor'];?></td><td><?php echo $cur['orderCount'];?></td><td><?php echo date("H:i d.m.Y", strtotime($cur['orderDate']));?></td>
           <td>
               <?php if ($cur['orderstep'] < 3 ){
                   ?><a href="<?php echo $hrefcont.$cur['orderId']; ?>"><?php echo _LP_CONTIN; ?></a>
               <?php }elseif ($cur['orderstep'] == 3 ){ ?>
                   <a href="<?php echo $hrefcont.$cur['orderId']; ?>"><?php echo $status[$cur['stateId']]; ?></a>
                <?php } else {
                    if ($cur['stateId'] == 2){
                        echo '<a>' . $status[$cur['stateId']] . '</a>';
                    } else{
                        echo $status[$cur['stateId']];
                    }

                }  ?>
           </td>
           <td><?php if ($cur['stateId'] < 2 ){?>
               <form action="<?php echo $actiondel; ?>" method="post">
                    <input type="hidden" name="orderdel" value="<?php echo $cur['orderId'];?>" />
                    <button style="background:none;"><i class="icon-trash"></i></button>
                </form><?php } ?>
               </td></tr>
    <?php }
    ?>
    </tbody>
</table>
<?php echo $pages; ?>
<?php }else{ ?>
<p><?php echo _LO_LISTORDERSEMPTY; ?></p>
<?php } ?>
<hr>
<a href="project.php" class="button red">Новый заказ</a>
 <div class="alert" style="margin-top:20px;">
                                                	<strong> ВНИМАНИЕ: </strong>в личном кабинете отображаются заказы только на <strong>печать книги</strong>.
                                                </div>