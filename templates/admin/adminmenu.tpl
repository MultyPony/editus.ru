<?php
       foreach ($menuitems as $cur) { 
            $m[$cur['groupName']][] = $cur;
       }
?>
<style>
    #usermenu{
        padding: 0 0 0 5px;
        margin: 0;
    }
    #usermenu, #usermenu ul{
        list-style: none;
    }
    #usermenu > li{
        float: left;
        padding: 3px 7px 0 7px;
    }
    .hidem{
        display: none;
    }
    .showm{
        position: absolute;
        left: 160px;
/*        height: 25px;*/
    }
    .sel a{
        color: #FF0000 !important;
    }
    #tabmenu{
        margin: 0;
        padding: 0;
    }
    .tabb span{
        cursor: pointer;
    }
    .acttab{
        box-shadow: 0 0 2px #666666;
        color: #FF0000;
        border-top: 1px solid #E5E5E5;
        border-left: 1px solid #E5E5E5;
        border-right: 1px solid #E5E5E5;
        border-bottom: 0px;
        border-radius: 5px 5px 0 0;
        background-color: #F2F2F2;
    }
    .usermenuul {
        background-color: #F2F2F2;
        box-shadow: 0 2px 2px #666666;
        border: 1px solid #E5E5E5;
        border-radius: 5px;
        width: 800px;
        padding: 5px 0 0 15px;
        padding-bottom: 3px;
    }
    .usermenuul li{
        float: left;
        margin-right: 10px;
    }
</style>
<div id="tabmenu">
<ul id="usermenu">
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
    <li class="tabb <?php echo $f;?>"><span><?php echo $key;?></span><ul class="usermenuul <?php echo $h;?>">
    <?php foreach ($val as $cur){
        if ($cur['active']==1){
            $f2='sel';
        }
    ?>
            <li class="<?php echo $f2;?>">   
                <?php if (strlen($cur['href']) < 3) {?>
                <a href="/admin/index.php?do=<?php echo $cur['functionName']; ?>"><?php echo $cur['menuName']; ?></a>
                <?php } else { ?>
                <a href="<?php echo $cur['href']; ?>"><?php echo $cur['menuName']; ?></a>
                <?php } ?>
            </li>

    <?php $f2=''; } ?></ul></li><?php
    $f='';$h='';
}?>
</ul>
</div>
<div style="height: 30px; clear: both;"></div>