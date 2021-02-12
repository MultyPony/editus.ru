												<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=listprojects">Проекты</a></li>
                                                        <li><a href="editus.php?do=listorders">Заказы</a></li>
                                                        <li><a href="editus.php?do=listarchive" class="active">Архив</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                 </div>
<?php if (count($orders)>0){ ?>
<table id="listarchive" class="dataview" style="width: 100%;">
    <thead><tr>
            <th><?php echo _LA_ORDERNUMBER;?></th><th><?php echo _LA_ORDERNAME; ?></th><th><?php echo _LA_ORDERAUTOR; ?></th><th><?php echo _LA_ORDERCOUNT; ?></th><th><?php echo _LA_ORDERDATE; ?></th><th><?php echo _LA_TOTAL; ?></th></tr>
    </thead>
    <tbody align="center">
    <?php
    foreach ($orders as $cur){?>
        <tr><td>
               <a href="<?php echo $actionview.$cur['orderId'];?>"><?php echo $cur['orderId'];?></a>
            </td><td><?php echo $cur['orderName'];?></td><td><?php echo $cur['orderAutor'];?></td><td><?php echo $cur['orderCount'];?></td><td><?php echo date("H:i d-m-Y", strtotime($cur['orderDate']));?></td>
           <td><?php echo $cur['total'].' '._LA_RUB;?></td>
        </tr>
    <?php }
    ?>
    </tbody>
</table>
<?php echo $pages; ?>
<?php }else{ ?>
    <p><?php echo _LA_ARCHIVEMPTY;?></p>
<?php } ?>
<hr>
<a href="project.php" class="button red">Новый заказ</a>
 <div class="alert" style="margin-top:20px;">
                                                	<strong> ВНИМАНИЕ: </strong>в личном кабинете отображаются заказы только на <strong>печать книги</strong>.
                                                </div>