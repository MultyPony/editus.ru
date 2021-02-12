<fieldset>
    <legend style="font-weight: bold;"><?php echo _VSOA_ORDERNUMBLEG.$data['orderId']; ?></legend>
    <table>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VSOA_COMPOSITION;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $comp; ?></td></tr>
    <?php if ($data['orderstep']>0){?>    
        <?php if ($data['DeliveryProviderId']==0){?>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VSOA_TYPEDELIVER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo _VSOA_PICKUP; ?></td></tr>
        <?php }else{ ?>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VSOA_PROVIDER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $namedeliv; ?></td></tr>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VSOA_ADDRESS;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataadres['CountryName'].', '.$dataadres['RegionName'].', '.$dataadres['addressIndex'].', '._VSOA_CT.$dataadres['addressCity'].', '._VSOA_STR.$dataadres['addressStr'].', '._VSOA_H.$dataadres['addressHouse'].'('._VSOA_B.$dataadres['addressBuild'].'), '._VSOA_APT.$dataadres['addressApt'].' ( '.$dataadres['addressContact'].' - '.$dataadres['addressTelephone'].' )'; ?></td></tr>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VSOA_DELIVPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceDeliver'].' '._VSOA_RUB; ?></td></tr>    
        <?php } ?>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VSOA_TOTAL;?></td><td style="text-align: left; vertical-align: middle;"><?php echo ($data['orderPriceTotal']).' '._VSOA_RUB; ?></td></tr>    
            <?php if ($data['stateId']==5){?>
            <tr style="color: #ff3300;"><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VSOA_CAUSEDENY;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $denycause;?></td></tr>    
            <?php } ?>
        <?php }else{ ?>
            <tr><td colspan="2" style="text-align: center; vertical-align: middle;"><a href="<?php echo $hrefcont.$data['orderId']; ?>"><?php echo _VSO_CONTIN; ?></a></td></tr>    
    <?php }?>
    </table>
</fieldset>