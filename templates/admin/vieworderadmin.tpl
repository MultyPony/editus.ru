<fieldset>
    <legend style="font-weight: bold;"><?php echo _VOA_ORDERNUMBLEG.$data['orderId']; ?></legend>
    <table>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_OREDERNAME;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_AUTHOR;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderAutor']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_COUNT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderCount']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_PAGES;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPages']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_SYMB;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderSymb']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_COVER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $covers[$data['orderCover']]; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_FORMAT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['formatName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_PAPERTYPE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['PaperTypeName'].' '.$data['PaperTypeWeight']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_BIND;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['BindingName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_COLOR;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['PrintTypeName']; ?></td></tr>
    <?php if (!empty($addedads)){?>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_ADDSERVICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $addedads; ?></td></tr>
    <?php }?>    
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_BLOCKPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceBlock'].' '._VOA_RUB; ?></td></tr>-->
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_ADDSERVPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceAdditService'].' '._VOA_RUB; ?></td></tr>-->
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_COVERPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceCover'].' '._VOA_RUB; ?></td></tr>-->
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_BINDPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceBind'].' '._VOA_RUB; ?></td></tr>-->
        <?php if ($data['DeliveryProviderId']==0){?>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_TYPEDELIVER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo _VOA_PICKUP; ?></td></tr>
        <?php }else{ ?>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_PROVIDER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $namedeliv; ?></td></tr>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_ADDRESS;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataadres['CountryName'].', '.$dataadres['RegionName'].', '.$dataadres['addressIndex'].', '._VOA_CT.$dataadres['addressCity'].', '._VOA_STR.$dataadres['addressStr'].', '._VOA_H.$dataadres['addressHouse'].'('._VOA_B.$dataadres['addressBuild'].'), '._VOA_APT.$dataadres['addressApt'].' ( '.$dataadres['addressContact'].' - '.$dataadres['addressTelephone'].' )'; ?></td></tr>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_DELIVPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceDeliver'].' '._VOA_RUB; ?></td></tr>    
        <?php } ?>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_TOTAL;?></td><td style="text-align: left; vertical-align: middle;"><?php echo ($data['orderPriceBind']+$data['orderPriceCover']+$data['orderPriceAdditService']+$data['orderPriceBlock']+$data['orderPriceDeliver']).' '._VOA_RUB; ?></td></tr>    

            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_DBLOCK;?></td><td style="text-align: left; vertical-align: middle;"><a href="<?php echo $dhref[2]; ?>">Скачать</a></td></tr>    
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_DBLOCKPDF;?></td><td style="text-align: left; vertical-align: middle;"><a href="<?php echo $dhref[3] ?>">Скачать</a></td></tr>    
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_DCOVER;?></td><td style="text-align: left; vertical-align: middle;"><a href="<?php echo $dhref[0]; ?>">Скачать</a></td></tr>    
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _VOA_DCOVERPDF;?></td><td style="text-align: left; vertical-align: middle;"><a href="<?php echo $dhref[1]; ?>">Скачать</a></td></tr>    

    </table>
</fieldset>