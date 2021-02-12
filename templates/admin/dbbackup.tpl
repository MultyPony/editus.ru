<table id="dbbackup" class="dataview">
    <thead>
        <tr>
            <th><?php echo _DBB_NAME; ?></th><th></th><th></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($files as $cur){
            echo '<tr><td>'.$cur.'</td><td><form method="post" action="'.$action.'">
                <input value="'.$cur.'" type="hidden" name="filename" />
                <input class="button" type="submit" value="'._DBB_GET.'" /><br />
        </form></td><td><form method="post" action="'.$action.'">
                <input value="'.$cur.'" type="hidden" name="deldump" />
                <input class="button" type="submit" value="'._DBB_DELL.'" /><br />
        </form></td></tr>';
        }
        ?>
    </tbody>
</table>
<div>
        <form method="post" action="<?php echo $action;?>">
            <p>
                <input value="1" type="hidden" name="savedump" />
                <input class="button" type="submit" value="<?php echo _DBB_SAVE; ?>" /><br />
            </p>
        </form>
</div>
<fieldset>
    <legend><?php echo _DBB_TITLE;?></legend>
    <form method="post" action="<?php echo $action;?>" enctype="multipart/form-data">
        <input type="file" name="uploadsql" />
        <input type="submit" class="button" value="<?php echo _DBB_RESTORE; ?>"  onclick="return confirm('Вы уверены что хотите продолжить?')"/>
    </form>
</fieldset>