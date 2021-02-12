<fieldset>
    <legend style="font-weight: bold;"><?php echo _PVO_ORDERNUMBLEG.$data['orderId']; ?></legend>
    <table>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_OREDERNAME;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_AUTHOR;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderAutor']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_COUNT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderCount']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_PAGES;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPages']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_SYMB;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderSymb']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_COVER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $covers[$data['orderCover']]; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_FORMAT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['formatName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_PAPERTYPE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['PaperTypeName'].' '.$data['PaperTypeWeight']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_BIND;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['BindingName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_COLOR;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['PrintTypeName']; ?></td></tr>
    <?php if (!empty($addedads)){ ?>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_ADDSERVICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $addedads; ?></td></tr>
    <?php }?>    
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_BLOCKPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceBlock'].' '._PVO_RUB; ?></td></tr>-->
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_ADDSERVPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceAdditService'].' '._PVO_RUB; ?></td></tr>-->
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_COVERPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceCover'].' '._PVO_RUB; ?></td></tr>-->
<!--            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_BINDPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceBind'].' '._PVO_RUB; ?></td></tr>-->
        <?php if ($data['DeliveryProviderId']==0){ ?>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_TYPEDELIVER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo _PVO_PICKUP; ?></td></tr>
        <?php }else{ ?>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_PROVIDER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $namedeliv; ?></td></tr>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_ADDRESS;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataadres['CountryName'].', '.$dataadres['RegionName'].', '.$dataadres['addressIndex'].', '._PVO_CT.$dataadres['addressCity'].', '._PVO_STR.$dataadres['addressStr'].', '._PVO_H.$dataadres['addressHouse'].'('._PVO_B.$dataadres['addressBuild'].'), '._PVO_APT.$dataadres['addressApt'].' ( '.$dataadres['addressContact'].' - '.$dataadres['addressTelephone'].' )'; ?></td></tr>
                <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_DELIVPRICE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $data['orderPriceDeliver'].' '._PVO_RUB; ?></td></tr>    
        <?php } ?>
            <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _PVO_TOTAL;?></td><td style="text-align: left; vertical-align: middle;"><?php echo ($data['orderPriceBind']+$data['orderPriceCover']+$data['orderPriceAdditService']+$data['orderPriceBlock']+$data['orderPriceDeliver']).' '._PVO_RUB; ?></td></tr>    

    </table>
</fieldset>