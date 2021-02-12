
<?php if($type=='ok'){?>

<p id="messid<?php echo $nh;?>" style="padding: 5px; margin: 0; border: none; clear: both; font-size: 12px; color: #33cc33; text-align: left;">
<?php echo $mess; ?></p>

<?php }
if($type=='error'){?>

<p id="messid<?php echo $nh;?>" style="padding: 5px; margin: 0; border: none; clear: both; font-size: 12px; color: #ff0000; text-align: left;">
<?php echo $mess; ?></p>

<?php }
if($type=='inf'){?>

<p id="messid<?php echo $nh;?>" style="color: #00ccff; padding: 5px; margin: 0; border: none; clear: both; font-size: 12px; text-align: left;">
<?php echo $mess; ?></p>
<?php }?>