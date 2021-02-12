<h2><?php echo _LI_TITLE; ?></h2>
<form method="get" action="index.php"> 
    <fieldset>
        <legend> <?php echo _LI_SEARCH; ?></legend>
        <input type="hidden" name="do" value="listitems" />
        <input style="width: 300px" type="text" name="searchline" value="<?php echo $_GET['searchline'];?>" /><?php echo _LI_SEARCHCOMMENT;?>
        <br><input type="submit" value="<?php echo _LI_FIND; ?>" />
    </fieldset>
</form>
<table class="dataview" id="listitems">
    <thead>
        <th><?php echo _LI_COVERIMG; ?></th>
        <th><?php echo _LI_NAME; ?></th>
        <th><?php echo _LI_AUTHOR; ?></th>
        <th><?php echo _LI_ANNOTATION; ?></th>
        <th><?php echo _LI_CLASSIFICATE; ?></th>
        <th><?php echo _LI_ISBN; ?></th>
        <th><?php echo _LI_PUBLISH; ?></th>
        <th><?php echo _LI_PAGES; ?></th>
        <th><?php echo _LI_COVERTYPE; ?></th>
        <th><?php echo _LI_TYPEPRINT; ?></th>
        <th><?php echo _LI_FORMAT; ?></th>
        <th><?php echo _LI_PRICE; ?></th>
        <th><?php echo _LI_HREFAUTHOR; ?></th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach ($data as $cur){
            echo '<tr><td class="pict"><img src="../items/'.$cur['itemId'].'/'.$cur['itemId'].'_thumb_cover.png" /></td>
                      <td>'.$cur['itemName'].'</td><td>'.$cur['itemAuthor'].'</td><td>'.$cur['itemAnnotation'].'</td>
                      <td>'.$cur['classificateName'].'</td>
                      <td>'.$cur['itemISBN'].'</td>
                      <td>'.$cur['itemPublish'].'</td>
                      <td>'.$cur['itemPages'].'</td>
                      <td>'.$cur['itemTypeCover'].'</td>
                      <td>'.$cur['PrintTypeName'].'</td>
                      <td>'.$cur['formatName'].'</td>
                      <td>'.$cur['itemPrice'].'</td>
                      <td><a href ="'.$cur['itemAuthorUrl'].'">'.$cur['itemAuthorUrl'].'</a></td>
                      <td><a href ="?do=shopedititem&amp;iditem='.$cur['itemId'].'">'._LI_EDIT.'</a></td></tr>';
        }?>
    </tbody>
</table>
 <?php echo $pages;?>
