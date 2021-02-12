<fieldset>
    <legend><h3><?php echo _VSO_ORDERNUMBLEG.'K'.$data['orderId']; ?></h3></legend>
    <table>
        <tr><td style="text-align: right; width: 35%;"><?php echo _VSO_COMPOSITION;?></td><td><?php echo $comp; ?></td></tr>
    <?php if ($data['orderstep']>0){?>    
        <?php if ($data['DeliveryProviderId']==0){?>
                <tr><td style="text-align: right;"><?php echo _VSO_TYPEDELIVER;?></td><td><?php echo _VSO_PICKUP; ?></td></tr>
        <?php }else{ ?>
                <tr><td style="text-align: right;"><?php echo _VSO_PROVIDER;?></td><td><?php echo $namedeliv; ?></td></tr>
                <tr><td style="text-align: right;"><?php echo _VSO_ADDRESS;?></td><td><?php echo $dataadres['CountryName'].', '.$dataadres['RegionName'].', '.$dataadres['addressIndex'].', '._VSO_CT.$dataadres['addressCity'].', '._VSO_STR.$dataadres['addressStr'].', '._VSO_H.$dataadres['addressHouse'].'('._VSO_B.$dataadres['addressBuild'].'), '._VSO_APT.$dataadres['addressApt'].' ( '.$dataadres['addressContact'].' - '.$dataadres['addressTelephone'].' )'; ?></td></tr>
                <tr><td style="text-align: right;"><?php echo _VSO_DELIVPRICE;?></td><td><?php echo $data['orderPriceDeliver'].' '._VSO_RUB; ?></td></tr>    
        <?php } ?>
            <tr><td style="text-align: right;"><?php echo _VSO_TOTAL;?></td><td><?php echo ($data['orderPriceTotal']).' '._VSO_RUB; ?></td></tr>    
            <?php if ($data['stateId']==5){?>
            <tr style="color: #ff3300;"><td style="text-align: right;"><?php echo _VSO_CAUSEDENY;?></td><td><?php echo $denycause;?></td></tr>    
            <?php } ?>
        <?php }else{ ?>
            <tr><td colspan="2"><a class="button red" href="<?php echo $hrefcont.$data['orderId']; ?>"><?php echo _VSO_CONTIN; ?></a></td></tr>    
    <?php }?>
    </table>
    
</fieldset>