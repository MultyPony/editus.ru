<?php echo $res; ?>
<form action="<?php echo 'index.php?do=' . $_GET['do']; ?>" method="post" enctype="multipart/form-data">
    <table>
        <tbody>
            <tr>
                <td>
                    <label for="sai_newItemName"><?php echo _SAI_NAME;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" id="sai_newItemName" name="newItemName" type="text" value="<?php echo $_POST['newItemName'];?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sai_newItemAuthor"><?php echo _SAI_AUTHOR;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" id="sai_newItemAuthor" name="newItemAuthor" type="text" value="<?php echo $_POST['newItemAuthor'];?>" />
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sai_newItemCoverImg"><?php echo _SAI_COVERIMG;?></label>
                </td>                
                <td>
                    <input id="sai_newItemCoverImg" name="newItemCoverImg" type="file" />
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sai_newItemAnnotation"><?php echo _SAI_ANNOTATION;?></label>
                </td>                
                <td>
                    <textarea id="sai_newItemAnnotation" name="newItemAnnotation"><?php echo $_POST['newItemAnnotation'];?></textarea>
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sai_newItemClassificate"><?php echo _SAI_CLASSIFICATE;?></label>
                </td>                
                <td>
                    <select id="sai_newItemClassificate" name="newItemClassificate"><?php 
                    foreach ($classificate as $key => $value) {
                        ?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr> 
            <tr>
                <td>
                    <label for="sai_newItemNumISBN"><?php echo _SAI_NUMISBN;?></label>
                </td>                
                <td>
                    <input style="width: 200px;" type="text" id="sai_newItemNumISBN" name="newItemNumISBN"  value="<?php echo $_POST['newItemNumISBN'];?>"/>
                </td>
            </tr>     
            <tr>
                <td>
                    <label for="sai_newItemPublish"><?php echo _SAI_PUBLISH;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" type="text" id="sai_newItemPublish" name="newItemPublish"  value="<?php echo $_POST['newItemPublish'];?>" />
                </td>
            </tr>   
            <tr>
                <td>
                    <label for="sai_newItemPages"><?php echo _SAI_PAGES;?></label>
                </td>                
                <td>
                    <input style="width: 100px;" id="sai_newItemPages" name="newItemPages" value="<?php echo $_POST['newItemPages'];?>" />
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sai_newItemTypeCover"><?php echo _SAI_TYPECOVER;?></label>
                </td>                
                <td>
                    <select id="sai_newItemTypeCover" name="newItemTypeCover"><?php 
                    foreach ($cover as $key => $value) {
                        ?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr> 
            <tr>
                <td>
                    <label for="sai_newItemTypePrint"><?php echo _SAI_TYPEPRINT;?></label>
                </td>                
                <td>
                    <select id="sai_newItemTypePrint" name="newItemTypePrint"><?php 
                    foreach ($typeprint as $key => $value) {
                        ?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr> 
            <tr>
                <td>
                    <label for="sai_newItemPageFormat"><?php echo _SAI_PAGEFORMAT;?></label>
                </td>                
                <td>
                    <select id="sai_newItemPageFormat" name="newItemPageFormat"><?php 
                    foreach ($formats as $key => $value) {
                        ?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="sai_newItemPaperType"><?php echo _SAI_PAPERTYPE;?></label>
                </td>                
                <td>
                    <select id="sai_newItemPaperType" name="newItemPaperType"><?php 
                    foreach ($papertype as $key => $value) {
                        ?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php
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
                        ?><option value="<?php echo $key;?>"><?php echo $value;?></option><?php
                    }
                    ?></select>
                </td>
            </tr>            
            <tr>
                <td>
                    <label for="sai_newItemPrice"><?php echo _SAI_PRICE;?></label>
                </td>                
                <td>
                    <input id="sai_newItemPrice" name="newItemPrice" value="<?php echo $_POST['newItemPrice'];?>" /><?php echo _SAI_RUB;?>
                </td>
            </tr>      
            <tr>
                <td>
                    <label for="sai_newItemAuthorUrl"><?php echo _SAI_AUTHORURL;?></label>
                </td>                
                <td>
                    <input style="width: 300px;" type="text" id="sai_newItemAuthorUrl" name="newItemAuthorUrl" value="<?php echo $_POST['newItemAuthorUrl'];?>" />
                </td>
            </tr>  
            <tr>
                <td>
                    <label for="sai_newItemFileBook"><?php echo _SAI_FILEBOOK;?></label>
                </td>                
                <td>
                    <input type="file" id="sai_newItemFileBook" name="newItemFileBook" />
                </td>
            </tr>       
            <tr>
                <td>
                    <label for="sai_newItemFileBook"><?php echo _SAI_FILECOVER;?></label>
                </td>                
                <td>
                    <input type="file" id="sai_newItemFileCover" name="newItemFileCover" />
                </td>
            </tr>   
                        <tr>
                <td>
                    <label for="sai_newItemFileBook"><?php echo _SAI_FILEPREVIEW;?></label>
                </td>                
                <td>
                    <input type="file" id="sai_newItemFilePreview" name="newItemFilePreview" />
                </td>
            </tr>   
        </tbody>
    </table>
    <input type="submit" value="<?php echo _SAI_SEND;?>" />
</form>
