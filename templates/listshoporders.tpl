										<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=showcart">Корзина</a></li>
                                                        <li><a href="editus.php?do=listshoporders" class="active">Заказы</a></li>
                                                        <li><a href="editus.php?do=listshoparchive">Архив</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                 </div>
                                                 
                                                 <?php if (count($orders)>0) {?>
<table id="listshoporders" class="dataview" style="width: 100%;">
    <thead>
        <tr>
            <th><?php echo _LSO_ORDERNUMBER;?></th>
            <th><?php echo _LSO_ORDERPRICE; ?></th>
<!--            <th><?php echo _LO_ORDERAUTOR; ?></th>
            <th><?php echo _LSO_ORDERCOUNT; ?></th>-->
            <th><?php echo _LSO_ORDERDATE; ?></th>
            <th><?php echo _LSO_ORDERSTATUS; ?></th>
            <th><?php echo _LSO_ORDERDEL; ?></th>
        </tr>
    </thead>
    <tbody align="center">
    <?php
    foreach ($orders as $cur){?>
       <tr><td>
            <a href="<?php echo $actionview.$cur['orderId'];?>">K<?php echo $cur['orderId'];?></a>
           </td><td><?php echo $cur['orderPriceTotal']._LSO_RUB;?></td>
           <td><?php echo date("H:i d.m.Y", strtotime($cur['orderDate']));?></td>
           <td>
               <?php if ($cur['orderstep'] < 1 ){
                   ?><a href="<?php echo $hrefcont.$cur['orderId']; ?>"><?php echo _LSO_CONTIN; ?></a>
               <?php }elseif ($cur['orderstep'] == 1 ){ ?>
                   <a href="<?php echo $hrefcont.$cur['orderId']; ?>"><?php echo $status[$cur['stateId']]; ?></a>
                <?php } else {
                    echo $status[$cur['stateId']];
                }  ?>
           </td>
           <td valign="top"><?php if ($cur['stateId'] < 2 ){?>
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
<p><?php echo _LSO_LISTORDERSEMPTY; ?></p>
<?php } ?>
<hr>
<a href="bookstore.php" class="button red">Новый заказ</a>
