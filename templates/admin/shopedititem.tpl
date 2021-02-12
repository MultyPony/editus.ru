<?php echo $res; ?>
<form action="<?php echo 'index.php?do=' . $_GET['do']; ?>" method="post" enctype="multipart/form-data">
    <table>
        <tbody>
            <tr>
                <td>
                    <label for="sei_newItemName"><?php echo _SEI_NAME;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" id="sei_newItemName" name="newItemName" type="text" value="<?php echo $data['itemName'];?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sei_newItemAuthor"><?php echo _SEI_AUTHOR;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" id="sei_newItemAuthor" name="newItemAuthor" type="text" value="<?php echo $data['itemAuthor'];?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sei_newItemCoverImg"><?php echo _SEI_COVERIMG;?></label>
                </td>                
                <td>
                    <img src="../items/<?php echo $data['itemId'].'/'.$data['itemId'];?>_thumb_cover.png" /><br />
                    <input id="sei_newItemCoverImg" name="newItemCoverImg" type="file" />
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sei_newItemAnnotation"><?php echo _SEI_ANNOTATION;?></label>
                </td>                
                <td>
                    <textarea id="sei_newItemAnnotation" name="newItemAnnotation"><?php echo $data['itemAnnotation'];?></textarea>
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sei_newItemClassificate"><?php echo _SEI_CLASSIFICATE;?></label>
                </td>                
                <td>
                    <select id="sei_newItemClassificate" name="newItemClassificate"><?php 
                    foreach ($classificate as $key => $value) {
                        if ($key == $data['classificateId']){
                            $sel='selected="selected"';
                        }
                        ?><option <?php echo $sel;$sel='';?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr> 
            <tr>
                <td>
                    <label for="sei_newItemNumISBN"><?php echo _SEI_NUMISBN;?></label>
                </td>                
                <td>
                    <input style="width: 200px;" type="text" id="sei_newItemNumISBN" name="newItemNumISBN"  value="<?php echo $data['itemISBN'];?>"/>
                </td>
            </tr>     
            <tr>
                <td>
                    <label for="sei_newItemPublish"><?php echo _SEI_PUBLISH;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" type="text" id="sei_newItemPublish" name="newItemPublish"  value="<?php echo $data['itemPublish'];?>" />
                </td>
            </tr>   
            <tr>
                <td>
                    <label for="sei_newItemPages"><?php echo _SEI_PAGES;?></label>
                </td>                
                <td>
                    <input style="width: 100px;" id="sei_newItemPages" name="newItemPages" value="<?php echo $data['itemPages'];?>" />
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sei_newItemTypeCover"><?php echo _SEI_TYPECOVER;?></label>
                </td>                
                <td>
                    <select id="sei_newItemTypeCover" name="newItemTypeCover"><?php 
                    foreach ($cover as $key => $value) {
                        if ($key == $data['itemTypeCover']){
                            $sel='selected="selected"';
                        }
                        ?><option <?php echo $sel;$sel='';?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr> 
            <tr>
                <td>
                    <label for="sei_newItemTypePrint"><?php echo _SEI_TYPEPRINT;?></label>
                </td>                
                <td>
                    <select id="sei_newItemTypePrint" name="newItemTypePrint"><?php 
                    foreach ($typeprint as $key => $value) {
                        if ($key == $data['PrintTypeId']){
                            $sel='selected="selected"';
                        }
                        ?><option <?php echo $sel;$sel='';?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr> 
            <tr>
                <td>
                    <label for="sei_newItemPageFormat"><?php echo _SEI_PAGEFORMAT;?></label>
                </td>                
                <td>
                    <select id="sei_newItemPageFormat" name="newItemPageFormat"><?php 
                    foreach ($formats as $key => $value) {
                        if ($key == $data['formatId']){
                            $sel='selected="selected"';
                        }
                        ?><option <?php echo $sel;$sel='';?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sei_newItemPaperType"><?php echo _SEI_PAPERTYPE;?></label>
                </td>                
                <td>
                    <select id="sei_newItemPaperType" name="newItemPaperType"><?php 
                    foreach ($papertype as $key => $value) {
                        if ($key == $data['papertTypeId']){
                            $sel='selected="selected"';
                        }
                        ?><option <?php echo $sel;$sel='';?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sai_newItemPaperType"><?php echo _SAI_BINDIGTYPE;?></label>
                </td>                
                <td>
                    <select id="sai_newItemBindingType" name="newItemBindingType"><?php 
                    foreach ($binding as $key => $value) {
                        if ($key == $data['bindingId']){
                            $sel='selected="selected"';
                        }
                        ?><option <?php echo $sel;$sel='';?> value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr>               
            <tr>
                <td>
                    <label for="sei_newItemPrice"><?php echo _SEI_PRICE;?></label>
                </td>                
                <td>
                    <input id="sei_newItemPrice" name="newItemPrice" value="<?php echo $data['itemPrice'];?>" /><?php echo _SEI_RUB;?>
                </td>
            </tr>      
            <tr>
                <td>
                    <label for="sei_newItemAuthorUrl"><?php echo _SEI_AUTHORURL;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" type="text" id="sei_newItemAuthorUrl" name="newItemAuthorUrl" value="<?php echo $data['itemAuthorUrl'];?>" />
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sei_newItemFileBook"><?php echo _SEI_FILEBOOK;?></label>
                </td>                
                <td>
                    <?php if (file_exists('./../items/'.$data['itemId'].'/'.$data['itemId'].'_block.pdf')){ ?>
                    <a href="../include/shopget.php?itemid=<?php echo $data['itemId']; ?>&o=block"><?php echo _SEI_DOWNLOAD; ?></a>
                    <?php } ?>
                    <input type="file" id="sei_newItemFileBook" name="newItemFileBook"  value="" />
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sai_newItemFileBook"><?php echo _SEI_FILECOVER;?></label>
                </td>                
                <td>
                    <?php if (file_exists('./../items/'.$data['itemId'].'/'.$data['itemId'].'_cover.pdf')){ ?>
                    <a href="../include/shopget.php?itemid=<?php echo $data['itemId']; ?>&o=cover"><?php echo _SEI_DOWNLOAD; ?></a>
                    <?php } ?>
                    <input type="file" id="sai_newItemFileCover" name="newItemFileCover" />
                </td>
            </tr>   
            <tr>
                <td>
                    <label for="sai_newItemFileBook"><?php echo _SEI_FILEPREVIEW;?></label>
                </td>                
                <td>
                    <?php if (file_exists('./../items/'.$data['itemId'].'/'.$data['itemId'].'_preview.pdf')){ ?>
                    <a href="../include/shopget.php?itemid=<?php echo $data['itemId']; ?>&o=preview"><?php echo _SEI_DOWNLOAD; ?></a>
                    <?php } ?>
                    <input type="file" id="sai_newItemFilePreview" name="newItemFilePreview" />
                </td>
            </tr>             
            <tr>
                <td>
                    <label for="sei_delete"><?php echo _SEI_DELETE;?></label>
                </td>                
                <td>
                    <input type="checkbox" id="sei_delete" name="delete" />
                </td>
            </tr> 
        </tbody>
    </table>
    <input type="hidden" name="itemid" value="<?php echo $data['itemId'];?>" />
    <input type="submit" value="<?php echo _SEI_EDIT;?>" />
</form>
