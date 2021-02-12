										<div class="tabs">
													<!-- .tab-titles -->
                                                	<ul class="tab-titles">
                                                    	<li><a href="editus.php?do=showcart" class="active">Корзина</a></li>
                                                        <li><a href="editus.php?do=listshoporders">Заказы</a></li>
                                                        <li><a href="editus.php?do=listshoparchive">Архив</a></li>
                                                    </ul>
                                                    <br>
                                                    <!-- .tab-titles -->
                                                 </div>
                                                 
                                                 <?php if (count($data)>0) {?>
<table id="showcart" class="dataview" style="width: 100%;">
    <thead><tr><th></th><th><?php echo _SC_NAME; ?></th><th><?php echo _SC_COUNT; ?></th><th><?php echo _SC_SUM; ?></th><th><?php echo _SC_DEL; ?></th></tr>
    </thead>
    <tbody>
    <?php
    foreach ($data as $cur){?>
        <tr align="center">
            <td><img src="items/<?php echo $cur['itemsId'];?>/<?php echo $cur['itemsId'];?>_thumbmini_cover.png" alt="<?php echo $cur['itemName'];?>" /></td>
            <td><?php echo $cur['itemName'];?></td>
            <td class="editcount" id="<?php echo $cur['id'];?>"><?php echo $cur['amount'];?></td><td class="sum" style="white-space: nowrap;" id="<?php echo $cur[0];?>res"><?php echo $cur['sum']._SC_RUB;?></td>
            <td>
                <form action="<?php echo $actiondel; ?>" method="post">
                    <input type="hidden" name="itemdel" value="<?php echo $cur[0];?>" />
                    <input type="submit" style="background: transparent url('img/proj_del.png') no-repeat; height: 16px; width: 16px; border: 0; cursor: pointer;" value="" />
                </form>
            </td>
        </tr>
    <?php 
    $i++;
    $sum +=$cur['sum'];
    }
    ?>
    </tbody>
</table>
<p><?php echo _SC_COMMENT; ?></p>
<h4><?php echo _SC_SUMPRINT;?> <a id="sum_res"><?php echo $sum;?></a> <?php echo _SC_RUB; ?></h4>
<br>
<form method="post" action="<?php echo $action;?>">
    <input type="hidden" name="so_new" value="1" />
    <input type="submit" value="<?php echo _SC_CONTIN;?>" class="button red" />
</form>

<?php }else{ ?>
<p><?php echo _SC_CARTEMPTY; ?></p>
<?php } ?>
<hr>
<a href="bookstore.php" class="button red">Новый заказ</a>