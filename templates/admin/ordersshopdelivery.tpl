<?php 
       foreach ($data as $cur) { 
            $m[$cur['DeliveryProviderId']][] = $cur;
//            $m[$cur['DeliveryProviderId']][] = ;
       }
?>
<h2 id="ordersshopdelivery"><?php echo _OSD_TITLE; ?></h2>
<p style="margin: 0;">
    <span style="border-bottom: 1px solid #000;">
    <input type="hidden" id="activetab" value="<?php echo $activtab;?>"/>
    <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="createdeliver" class="but" value="<?php echo _OSD_CREATEDELIVER;?>" />
    <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="dispatch" class="but" value="<?php echo _OSD_DISPATCHT;?>" />    
    <input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="pickup" class="but" value="<?php echo _OSD_PICKUP;?>" />    
    <?php
    foreach ($m as $key => $val){
           ?><input style="border: 1px solid #000; border-bottom: 0; background: transparent;" type="button" id="provider<?php echo $key;?>" class="but" value="<?php echo $val[0]['DeliveryProviderName'];?>" /> <?php
           echo "\n";
    }
    ?>
    </span>
</p>
<div id="createdeliver-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
    <form method="post">
        <input type="hidden" name="createdeliver" value="1" />
        <label style="font-size: 36px;" >K<input style="font-size: 36px;" type="text" name="orderid" class="orderid" value="<?php echo $orderid; ?>" /></label>
        <input style="font-size: 36px;"  type="submit" value="<?php echo _OSD_GETDATAORDER; ?>"/>
    </form>
    <?php if ($chang[0]){
        echo '<p>'._OSD_CHANGESTATUS1.'</p>';
    } ?>
</div>
<div id="dispatch-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
    <form method="post">
        <input type="hidden" name="dispatch" value="1" />
        <label style="font-size: 36px;">K<input style="font-size: 36px;" type="text" name="orderid" class="orderid" value="<?php echo $orderid; ?>" /></label>
        <input style="font-size: 36px;"  type="submit" value="<?php echo _OSD_DISPATCH; ?>"/>
    </form>
    <?php if ($chang[1]){
        echo '<p>'._OSD_CHANGESTATUS2.'</p>';
    } ?>
</div>
<div id="pickup-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
    <?php foreach($pickup as $cur){
        ?><?php echo _OSD_ORDERNUM; ?>K<?php echo $cur['orderId'];?><br /><?php
    }
?>
</div>
<?php 
    foreach ($m as $key => $val){
        ?>
        <div id="provider<?php echo $key;?>-tab" class="tab" style="border: 1px solid #000; padding: 3px;">
            <?php 
            foreach ($val as $cur){
                echo _OSD_ORDERNUM.'K'.$cur['orderId'].' - '.$cur['CountryName'].', '.$cur['RegionName'].', '.$cur['addressIndex'].', '._OSD_CT.$cur['addressCity'].', '._OSD_STR.$cur['addressStr'].', '._OSD_H.$cur['addressHouse'].'('._OSD_B.$cur['addressBuild'].'), '._OSD_APT.$cur['addressApt'].' ( '.$cur['addressContact'].' - '.$cur['addressTelephone'].' )<br />';
            }
            ?>
        </div>
        <?php
    }
?>