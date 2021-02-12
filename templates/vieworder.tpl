<fieldset>
    <legend class="orderstepname"><h3><?php echo _VO_ORDERNUMBLEG.$data['orderId']; ?></h3></legend>
    <table width="100%">
        <tr><td style="text-align: right; width:35%;"><?php echo _VO_OREDERNAME;?></td><td><?php echo $data['orderName']; ?></td></tr>
        <tr><td style="text-align: right; width:35%;"><?php echo _VO_AUTHOR;?></td><td><?php echo $data['orderAutor']; ?></td></tr>
        <tr><td style="text-align: right; width:35%;"><?php echo _VO_COUNT;?></td><td><?php echo $data['orderCount']; ?></td></tr>
        <tr><td style="text-align: right; width:35%;"><?php echo _VO_PAGES;?></td><td><?php echo $data['orderPages']; ?></td></tr>
        <tr><td style="text-align: right; width:35%;"><?php echo _VO_SYMB;?></td><td><?php echo $data['orderSymb']; ?></td></tr>
        <tr><td style="text-align: right;"><?php echo _VO_COVER;?></td><td><?php echo $covers[$data['orderCover']]; ?></td></tr>
        <tr><td style="text-align: right;"><?php echo _VO_FORMAT;?></td><td><?php echo $data['formatName']; ?></td></tr>
        <tr><td style="text-align: right;"><?php echo _VO_PAPERTYPE;?></td><td><?php echo $data['PaperTypeName'].' '.$data['PaperTypeWeight']; ?></td></tr>
        <tr><td style="text-align: right;"><?php echo _VO_BIND;?></td><td><?php echo $data['BindingName']; ?></td></tr>
        <tr><td style="text-align: right;"><?php echo _VO_COLOR;?></td><td><?php echo $data['PrintTypeName']; ?></td></tr>
    <?php if (!empty($addedads)){?>
        <tr><td style="text-align: right;"><?php echo _VO_ADDSERVICE;?></td><td><?php echo $addedads; ?></td></tr>
    <?php } if ($data['orderstep']>2){?>    
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VO_BLOCKPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceBlock'].' '._VO_RUB; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VO_ADDSERVPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceAdditService'].' '._VO_RUB; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VO_COVERPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceCover'].' '._VO_RUB; ?></td></tr>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VO_BINDPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceBind'].' '._VO_RUB; ?></td></tr>-->
        <?php if ($data['DeliveryProviderId']==0){?>
                <tr><td style="text-align: right;"><?php echo _VO_TYPEDELIVER;?></td><td><?php echo _VO_PICKUP; ?></td></tr>
        <?php }else{ ?>
                <tr><td style="text-align: right;"><?php echo _VO_PROVIDER;?></td><td><?php echo $namedeliv; ?></td></tr>
                <tr><td style="text-align: right;"><?php echo _VO_ADDRESS;?></td><td><?php echo $dataadres['CountryName'].', '.$dataadres['RegionName'].', '.$dataadres['addressIndex'].', '._VO_CT.$dataadres['addressCity'].', '._VO_STR.$dataadres['addressStr'].', '._VO_H.$dataadres['addressHouse'].'('._VO_B.$dataadres['addressBuild'].'), '._VO_APT.$dataadres['addressApt'].' ( '.$dataadres['addressContact'].' - '.$dataadres['addressTelephone'].' )'; ?></td></tr>
                <tr><td style="text-align: right;"><?php echo _VO_DELIVPRICE;?></td><td><?php echo $data['orderPriceDeliver'].' '._VO_RUB; ?></td></tr>    
        <?php } ?>
            <tr><td style="text-align: right;"><?php echo _VO_TOTAL;?></td><td><?php echo ($data['orderPriceBind']+$data['orderPriceCover']+$data['orderPriceAdditService']+$data['orderPriceBlock']+$data['orderPriceDeliver']).' '._VO_RUB; ?></td></tr>    
            <tr><td style="text-align: right;"><?php echo _VO_DBLOCK;?>:</td><td><a href="<?php echo $dhref[0]; ?>"><?php echo _VO_DOWNLOAD;?></a></td></tr>    
            <tr><td style="text-align: right;"><?php echo _VO_DBLOCKPDF;?>:</td><td><a href="<?php echo $dhref[1] ?>"><?php echo _VO_DOWNLOAD;?></a></td></tr>    
            <?php if (count($dhref)>2){ ?>
            <tr><td style="text-align: right;"><?php echo _VO_DCOVER;?>:</td><td><a href="<?php echo $dhref[2]; ?>"><?php echo _VO_DOWNLOAD;?></a></td></tr>    
            <tr><td style="text-align: right;"><?php echo _VO_DCOVERPDF;?>:</td><td ><a href="<?php echo $dhref[3]; ?>"><?php echo _VO_DOWNLOAD;?></a></td></tr>  
            <?php }  if ($data['stateId']==5){?>
            <tr style="color: #ff3300;"><td style="text-align: right;"><?php echo _VO_CAUSEDENY;?></td><td><?php echo $denycause;?></td></tr>    
            <?php } ?>
        <?php }else{ ?>
        <?php }?>

    </table>
    <br>
    <a class="button red" href="<?php echo $hrefcont.$data['orderId']; ?>"><?php echo _VO_CONTIN; ?></a>
</fieldset>