										<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=showcart">Корзина</a></li>
                                                        <li><a href="editus.php?do=listshoporders">Заказы</a></li>
                                                        <li><a href="editus.php?do=listshoparchive" class="active">Архив</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                 </div>
                                                 
                                                 <?php if (count($orders)>0) {?>
<table id="listshoparchive" class="dataview" style="width: 100%;">
    <thead>
        <tr>
            <th><?php echo _LSA_ORDERNUMBER;?></th>
            <th><?php echo _LSA_ORDERPRICE; ?></th>
            <th><?php echo _LSA_ORDERDATE; ?></th>
        </tr>
    </thead>
    <tbody align="center">
    <?php
    foreach ($orders as $cur){?>
       <tr><td>
                <a href="<?php echo $actionview.$cur['orderId'];?>">K<?php echo $cur['orderId'];?></a>
           </td><td><?php echo $cur['orderPriceTotal']._LSA_RUB;?></td>
           <td><?php echo date("H:i d.m.Y", strtotime($cur['orderDate']));?></td>
 </tr>
    <?php }
    ?>
    </tbody>
</table>
<?php echo $pages; ?>
<?php }else{ ?>
<p><?php echo _LSA_LISTORDERSEMPTY; ?></p>
<?php } ?>
<hr>
<a href="bookstore.php" class="button red">Новый заказ</a>
