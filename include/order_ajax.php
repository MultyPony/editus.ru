<?php
require_once './../config.inc.php';
require_once 'db_class.php';
try {
    if (isset($_POST['do'])){
        if ($_POST['do'] == 'getPaperTypeCover'){
            $db = new Db();
            if ($_POST['cover'] == 'soft'){
                $sql= "CoverType <> 'hard'";
            }else{
                $sql= "CoverType <> 'soft'";
            }
            if (($_POST['color'] == 'black') || ($_POST['color']== 'blackds')){
                $sql.= " AND Color <> '4'";
            }else{
                $sql.= " AND Color <> '1'";
            }
            $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight, isDefault FROM PaperTypeCostsCover WHERE ".$sql);
            while ($row = $db->fetch_array()) {
                $ch ='';
                if ($row['isDefault']==1){
                    $ch = 'checked="checked"';
                }
                $res .= '<td><label for="pc_'.$row['PaperTypeId'].'"><img src="img/paper.png" border="0"  /><br />'.$row['PaperTypeName'].'<br />'.$row['PaperTypeWeight'].' гр/м<sup>2</sup></label></td>';
                $res2 .= '<td style="width: 100px;"><input id="pc_'.$row['PaperTypeId'].'" type="radio" name="papercover" value="'.$row['PaperTypeId'].'" '.$ch.' /></td>';
            }?>
            <hr align="left" width="500" size="1" noshade="noshade" />
            <p class="tabletitle">Бумага</p>
            <table class="infotable">
                <tr style="text-align: center;">
                    <?php echo $res; ?>
                </tr>
                <tr style="text-align: center;">
                    <?php echo $res2; ?>
                </tr>
            </table> 
            <hr align="left" width="500" size="1" noshade="noshade" />
            <p class="tabletitle">Дополнительно</p>
            <table class="infotable" id="additionalcover"><?php   
            $db->query("SELECT AdditionalCoverId, AdditionalCoverName, helphref, isDefault FROM AdditionalCoverCosts");
            while ($row2 = $db->fetch_array()) {
                $ch ='';
                if ($row2['isDefault']==1){
                    $ch = 'checked="checked"';
                }
                $res3 .='<tr><td><label><input type="checkbox" name="additionalcover[]" value="'.$row2['AdditionalCoverId'].'" '.$ch.' />'.$row2['AdditionalCoverName'];
                if (strlen($row['helphref'])>3){
                    $res3 .='(<a href="info.html#correct" target="_blank">?</a>)';
                }
                $res3 .= '</label></td></tr>';
            }
            echo $res3;?>
            </table>
            <?php
        }
    }

    if ($_POST['do'] == 'getPaperTypeBlock'){
        $db = new Db();
        if ($_POST['color'] == 'black'){
            $sql= "Color <> '4'";
        }else{
            $sql= "Color <> '1'";
        }
        $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight FROM PaperTypeCostsBlock WHERE ".$sql);
        while ($row = $db->fetch_array()) {
            $res .= '<td><label for="pb_'.$row['PaperTypeId'].'"><img src="img/paper.png" border="0" /><br />'.$row['PaperTypeName'].'<br />'.$row['PaperTypeWeight'].' гр/м<sup>2</sup></label></td>';
            $res2 .= '<td style="width: 100px;"><input id="pb_'.$row['PaperTypeId'].'" type="radio" name="paperblock" value="'.$row['PaperTypeId'].'" /></td>';
        }?>
        <hr>
        <h3>Бумага</h3>
        <table>
            <tr align="center">
                <?php echo $res; ?>
            </tr>
            <tr align="center">
                <?php echo $res2; ?>
            </tr>
        </table><?php
    } 
    if ($_POST['do'] == 'getPaperSizeBlock'){
        $db = new Db();
        ?><hr align="left" width="500" size="1" noshade="noshade" />
        <p class="tabletitle">Размер</p>
        <table class="infotable">
            <tr align="center">     <?php   
        $db->query("SELECT formatId, formatName, formatWidth, formatHeight FROM PaperFormat WHERE usedForBlock = '1'");
        while ($row = $db->fetch_array()) {
            $res1 .= '<td style="width: 80px;" ><label for="pf_'.$row['formatId'].'"><img src="img/paperformat_'.$row['formatId'].'.png" border="0" /></label></td>';
            $res2 .= '<td valign="top"><label for="pf_'.$row['formatId'].'">'.$row['formatName'].'</label></td>';
            $res3 .= '<td valign="top">'.$row['formatWidth'].' x <br />'.$row['formatHeight'].' мм</td>';
            $res4 .= '<td><input id="pf_'.$row['formatId'].'" type="radio" name="size" value="'.$row['formatId'].'" /></td>';
        }
        echo $res1;
        ?>
        </tr>
        <tr align="center">
        <?php
        echo $res2;
        ?></tr>
        <tr align="center" class="infotable"><?php
        echo $res3;
        ?></tr>
            <tr align="center">
        <?php
        echo $res4;
        ?></tr>
        </table><?php
    }    
    if ($_POST['do'] == 'getPaperTypeBind'){
        $db = new Db();
        $db->query("SELECT BindingType.BindingId, BindingType.BindingName FROM BindingType WHERE BindingType.CoverType = '".$db->mres($_POST['cover'])."' AND BindingType.BindingMin <= '".intval($_POST['pages'])."' AND BindingType.BindingMax >= '".intval($_POST['pages'])."' ");
        if ($db->num_rows() >= 1){
            while ($row = $db->fetch_array()) {
                $res .='<td width="150" valign="bottom"><label for="bt_'.$row['BindingId'].'"><img src="img/bindtype_'.$row['BindingId'].'.jpg" border="0" /></label></td>';
                $res2 .= '<td><label for="bt_'.$row['BindingId'].'" >'.$row['BindingName'].'</label></td>';
                $res3 .= '<td><input id="bt_'.$row['BindingId'].'" type="radio" name="binding" value="'.$row['BindingId'].'" /></td>';
            }?> 
            <hr align="left" width="500" size="1" noshade="noshade" />
            <p class="tabletitle">Крепление</p>
            <table class="infotable">
                <tr align="center">
                    <?php echo $res; ?>
                </tr>
                <tr align="center">
                    <?php echo $res2; ?>
                </tr>
                <tr align="center">
                    <?php echo $res3; ?>
                </tr>
            </table><?php
        }else{
            ?><hr align="left" width="500" size="1" noshade="noshade" />
            <p class="tabletitle">Крепление</p>
            <p>К сожалению, креплений для данного количества страниц нет</p><?php
        }
    }   
    if ($_POST['do'] == 'AdditionalService'){
        $db = new Db();
        $db->query("SELECT * FROM AdditionalServiceCosts WHERE AdditionalServiceEnable = '1' ");
        while ($row = $db->fetch_array()) {
            $res .='<tr><td><label><input type="checkbox" name="additionalservice[]" value="'.$row['AdditionalServiceId'].'" />'.$row['AdditionalServiceName'];
            if (strlen($row['helphref'])>3){
                $res .='(<a href="info.html#correct" target="_blank">?</a>)';
            }
            $res .= '</label></td></tr>';
        }
        echo $res;
    }    
    if ($_POST['do']=='calc'){
        $db = new Db();
        if (!empty($_POST['additional_cover'])){
            $sql = str_replace(':',"' OR AdditionalCoverId = '",substr($_POST['additional_cover'],0,-1));
            $db->query("SELECT SUM(AdditionalCoverCost) FROM AdditionalCoverCosts WHERE AdditionalCoverId = '".$sql."' ");
            $row = $db->fetch_array();
            $pr_additionalcover = $row[0];
        }else{
            $pr_additionalcover = 0;
        }
        $pages = intval($_POST['pages']);
        $count = intval($_POST['count']);
        $db->query("SELECT PrintCost FROM PrintTypeCostsCover WHERE PrintType = '".intval($_POST['printtype_cover'])."' ");
        $row = $db->fetch_array();
        $pr_printtypecover = $row[0];
        $db->query("SELECT PaperTypeCost FROM PaperTypeCostsCover WHERE PaperTypeId = '".intval($_POST['papertype_cover'])."' ");
        $row = $db->fetch_array();
        $pr_papertypecover = $row[0];
        $db->query("SELECT formatInA3 FROM PaperFormat WHERE formatId = '".intval($_POST['size_paper'])."' ");
        $row = $db->fetch_array();
        $pr_pagesona3 = $row[0];
        $onecover = ($pr_printtypecover+$pr_printtypecover+$pr_additionalcover)/$pr_pagesona3;
        
        $db->query("SELECT PrintCost FROM PrintTypeCostsBlock WHERE PrintType = '".intval($_POST['printtype_block'])."' ");
        $row = $db->fetch_array();
        $pr_printtypeblock = $row[0];
        $db->query("SELECT PaperTypeCost FROM PaperTypeCostsBlock WHERE PaperTypeId = '".intval($_POST['papertype_block'])."' ");
        $row = $db->fetch_array();
        $pr_papertypeblock = $row[0];
        $oneblock = ($pr_printtypeblock + $pr_papertypeblock)*$pages/$pr_pagesona3;
        $db->query("SELECT OrderRate FROM OrdersRates WHERE OrderRateMin <= '".$count."' AND OrderRateMax >= '".$count."' ");
        $row = $db->fetch_array();
        $koef = $row[0];
        //TODO цена за крепление
        $db->query("SELECT BindingCosts FROM BindingTypeCosts WHERE BindingMin <= '".$pages."' AND BindingMax >= '".$pages."' AND BindingId = '".intval($_POST['bind'])."' AND formatId = '".intval($_POST['size_paper'])."' ");
        $row = $db->fetch_array();
        $pr_bind = $row[0];
        $total = (($oneblock+$onecover+$pr_bind)*$count*$koef);
        echo '<p>Цена за одну обложку: '.$onecover.' руб. <br />
                 Цена за один блок: '.$oneblock.' руб. <br />
                 Цена за крепление: '.$pr_bind.' руб.<br />
                 Итог(без учета дополнительных услуг): '.$total.' руб.<br />
                <input type="hidden" name="total" value="'.$total.'" ';
    }
} catch (Exception $exc) {
    echo 'Ошибка в файле ' . $exc->getFile() . ' на строке ' . $exc->getLine() . '<br /> Сообщение: ' . $exc->getMessage() . ' Код ошибки: ' . $exc->getCode() . '<br /> Ход выполнения: ' . $exc->getTraceAsString();
}
?>
