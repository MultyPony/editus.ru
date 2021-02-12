<fieldset>
    <legend style="font-weight: bold;"><?php echo $dataitem['itemName']; ?></legend>
    <table>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_AUTHOR;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['itemAuthor']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_CLASSIFICATE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['classificateName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_ISBN;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['itemISBN']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_PUBLISH;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['itemPublish']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_PAGES;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['itemPages']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_COVER;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['itemTypeCover']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_PRINTTYPE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['PrintTypeName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_FORMAT;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['formatName']; ?></td></tr>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_PAPERTYPE;?></td><td style="text-align: left; vertical-align: middle;"><?php echo $dataitem['PaperTypeName'].' '.$dataitem['PaperTypeWeight']; ?></td></tr>
        <?php if (file_exists('./../items/'.$dataitem['itemId'].'/'.$dataitem['itemId'].'_block.pdf')){ ?>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_GETBLOCK;?></td><td style="text-align: left; vertical-align: middle;"><a href="../include/shopget.php?itemid=<?php echo $dataitem['itemId']; ?>&o=block"><?php echo _SVI_DOWNLOAD; ?></a></td></tr>
        <?php } if (file_exists('./../items/'.$dataitem['itemId'].'/'.$dataitem['itemId'].'_cover.pdf')){ ?>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_GETCOVER;?></td><td style="text-align: left; vertical-align: middle;"><a href="../include/shopget.php?itemid=<?php echo $dataitem['itemId']; ?>&o=cover"><?php echo _SVI_DOWNLOAD; ?></a></td></tr>
        <?php } if (file_exists('./../items/'.$dataitem['itemId'].'/'.$dataitem['itemId'].'_preview.pdf')){ ?>
        <tr><td style="text-align: right; vertical-align: middle; width: 250px;"><?php echo _SVI_GETPREVIEW;?></td><td style="text-align: left; vertical-align: middle;"><a href="../include/shopget.php?itemid=<?php echo $dataitem['itemId']; ?>&o=preview"><?php echo _SVI_DOWNLOAD; ?></a></td></tr>
        <?php } ?>
    </table>
</fieldset>