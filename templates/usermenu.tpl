<?php
       foreach ($menuitems as $cur) { 
            $m[$cur['groupName']][] = $cur;
       }
?>
<div class="toggle">

<?php foreach ($m as $key=>$val){
    foreach ($val as $cur){
        if ($cur['active']==1){
            $f='acttab';
        }
    }
    if (empty($f)){
        $h = 'hidem';
    }else{
        $h = 'showm';
    }
    ?>
    <h4 class=" <?php echo $f;?>"><span><?php echo $key;?></span></h4>
    	<div class="toggle-content">
            <ul class="usermenuul <?php echo $h;?>">
    <?php foreach ($val as $cur){
        if ($cur['active']==1){
            $f2='sel';
        }
    ?>
            <li class="<?php echo $f2;?>">   
                <?php if (strlen($cur['href']) < 3) {?>
                <a href="<?php echo Main_config::$main_file_name; ?>?do=<?php echo $cur['functionName']; ?>"><?php echo $cur['menuName']; ?></a>
                <?php } else { ?>
                <a href="<?php echo $cur['href']; ?>"><?php echo $cur['menuName']; ?></a>
                <?php } ?>
            </li>

    <?php $f2=''; } ?>
    		</ul>
           </div>
        <?php
    $f='';$h='';
}?>
</div>
<div style="height: 30px; clear: both;"></div>
