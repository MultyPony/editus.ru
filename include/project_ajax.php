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
            
            <h3>Бумага</h3>

            <table width="100%">
                <tr align="center">
                    <?php echo $res; ?>
                    
                </tr>
               
            </table> 
<p><a class="more-link" href="//editus-dev.ru/new/online.html#paper" target="_blank">Какую бумагу лучше выбрать?</a></p>
            <h3>Дополнительно</h3>
            <table id="additionalcover"><?php   
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
            if (!isset($res)) {
                $res = '';
            }
            $res .= '<td><label for="pb_'.$row['PaperTypeId'].'"><img src="img/paper.png" border="0" /><br />'.$row['PaperTypeName'].'<br />'.$row['PaperTypeWeight'].' гр/м<sup>2</sup></label>
			<input id="pb_'.$row['PaperTypeId'].'" type="radio" name="paperblock" value="'.$row['PaperTypeId'].'" />
			</td>';
           
        }
        ?>

        <h3>Бумага</h3>
        
        <table width="100%">
            <tr align="center">
                <?php echo $res; ?>
                
            </tr>
       
        </table>
        <p><a class="more-link" href="//editus-dev.ru/new/online.html#paper" target="_blank">Какую бумагу лучше выбрать?</a></p>
        <?php
    } 
    if ($_POST['do'] == 'getPaperSizeBlock'){
        $db = new Db();
        ?>
        <h3>Размер</h3>
        <table width="100%">
            <tr align="center">     <?php   
        $db->query("SELECT formatId, formatName, formatWidth, formatHeight FROM PaperFormat WHERE usedForBlock = '1'");
        while ($row = $db->fetch_array()) {
            if (!isset($res1)) {
                $res1 = '';
            }
            $res1 .= '<td><label for="pf_'.$row['formatId'].'"><img src="img/paperformat_'.$row['formatId'].'.png" border="0" /></label><label for="pf_'.$row['formatId'].'">'.$row['formatName'].'</label>'.$row['formatWidth'].' x '.$row['formatHeight'].' мм<br /><p><input id="pf_'.$row['formatId'].'" type="radio" class="radio checker" name="size" value="'.$row['formatId'].'" /></p></td>';
           
        }
        echo $res1;
        ?>
        </tr>
        <tr align="center">
        <?php
        echo (isset($res2) ? $res2 : '');
        ?></tr>
        <tr align="center" class="infotable"><?php
        echo (isset($res3) ? $res3 : '');
        ?></tr>
            <tr align="center">
        <?php
        echo (isset($res4) ? $res4 : '');
        ?></tr>
        </table><?php
    }    
    if ($_POST['do'] == 'getPaperTypeBind'){
        $db = new Db();
        $db->query("SELECT BindingType.BindingId, BindingType.BindingName FROM BindingType WHERE BindingType.CoverType = '".$db->mres($_POST['cover'])."' AND BindingType.BindingMin <= '".intval($_POST['pages'])."' AND BindingType.BindingMax >= '".intval($_POST['pages'])."' ");
        if ($db->num_rows() >= 1){
            while ($row = $db->fetch_array()) {
                if (!isset($res)){
                    $res = '';
                }
                $res .='<td><label for="bt_'.$row['BindingId'].'"><img src="img/bindtype_'.$row['BindingId'].'.jpg" border="0" /></label><label for="bt_'.$row['BindingId'].'" >'.$row['BindingName'].'</label><input id="bt_'.$row['BindingId'].'" type="radio" name="binding" value="'.$row['BindingId'].'" /></td>';
 
            }?> 

            <h3>Крепление</h3>
            <table width="100%">
                <tr align="center">
                    <?php echo $res; ?>
                </tr>
               
            </table>
            <p><a class="more-link" href="//editus-dev.ru/new/pereplet.html" target="_blank">Какой переплет выбрать?</a></p><?php
        }else{
            ?>
            
            <h3>Крепление</h3>
            <p>К сожалению, креплений для данного количества страниц нет</p><?php
        }
    }   
    if ($_POST['do'] == 'AdditionalService'){
        $db = new Db();
        $db->query("SELECT * FROM AdditionalServiceCosts WHERE AdditionalServiceEnable = '1' ");
        while ($row = $db->fetch_array()) {
            if ($row['MetricType']!='pub'){
                $row['AdditionalServiceCost']=0;
            }else{
                if ($row['label']=='addtoisdpack'){
                    $row['AdditionalServiceCost'] = ceil($row['AdditionalServiceCost']) + ceil($_POST['addtoisdpack']);
                }
                if (!isset($res)) {
                    $res = '';
                }
                $res .='<tr><td><input type="hidden" id="'.$row['AdditionalServiceId'].'" name="'.$row['AdditionalServiceId'].'" value="'.ceil($row['AdditionalServiceCost']).'" /><label><input type="checkbox" name="additionalservice[]" value="'.$row['AdditionalServiceId'].'" /> '.$row['AdditionalServiceName'];
                if (strlen($row['helphref'])>3){
                    $res .=' ( <a href="'.$row['helphref'].'" target="_blank">?</a> ) ';
                }
                $res .= '</label></td></tr>';
            }
        }
        $res .= '';
        echo $res;
    }    
    if ($_POST['do']=='calc'){
        $db = new Db();
//        if (!empty($_POST['additional_cover'])){
//            $sql = str_replace(':',"' OR AdditionalCoverId = '",substr($_POST['additional_cover'],0,-1));
//            $db->query("SELECT SUM(AdditionalCoverCost) FROM AdditionalCoverCosts WHERE AdditionalCoverId = '".$sql."' ");
//            $row = $db->fetch_array();
//            $pr_additionalcover = $row[0];
//        }else{
//            $pr_additionalcover = 0;
//        }
        
        // if (intval($_POST['printtype_block'])!='color' && intval($_POST['printtype_block'])!='black'){
        if ($_POST['printtype_block']!='color' && $_POST['printtype_block']!='black'){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите тип печати</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if (intval($_POST['size_paper'])==0){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите размер бумаги</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if (intval($_POST['papertype_block'])==0){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите бумагу</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if (intval($_POST['pages'])==0){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Укажите количество страниц</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if (intval($_POST['count'])==0){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Укажите тираж</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if (intval($_POST['bind'])==0){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите крепление</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
		
        
        $pages = intval($_POST['pages']);
        $count = intval($_POST['count']);
        
        $db->query("SELECT PrintCost 
                    FROM PrintTypeCostsCover 
                    WHERE PrintType = '44' ");
        $row = $db->fetch_array();
        $pr_printtypecover = $row[0];
        
        $db->query("SELECT PaperTypeCost 
                            FROM PaperTypeCostsCover 
                            WHERE CoverType = '" . $_POST['papertype_cover'] . "' AND
                                  isDefault = '1'");
        $row = $db->fetch_array();
        $pr_papertypecover = $row[0];
        
        $db->query("SELECT formatInA3, formatName, formatWidth, formatHeight 
                    FROM PaperFormat 
                    WHERE formatId = '".intval($_POST['size_paper'])."' ");
        $row = $db->fetch_array();
        $pr_pagesona3 = $row[0];
        $pr_pagesona3_name = $row[1];
        $pr_pagesona3_name_hw = $row['formatWidth'].'x'.$row['formatHeight'];
        
        $db->query("SELECT SUM(AdditionalCoverCost) 
                    FROM AdditionalCoverCosts 
                    WHERE isDefault = '1' ");
        $row = $db->fetch_array();
        $pr_additionalcover = $row[0];
//        $onecover = ($pr_printtypecover+$pr_printtypecover+$pr_additionalcover)/$pr_pagesona3;
        if ($_POST['printtype_block']=='black'){
            $colorblock = 11;
        }elseif($_POST['printtype_block']=='color'){
            $colorblock = 44;
        }
        $db->query("SELECT PrintCost, PrintTypeName
                    FROM PrintTypeCostsBlock 
                    WHERE PrintType = '".$colorblock."' ");
        $row = $db->fetch_array();
        $pr_printtypeblock = $row[0];
        $pr_printtypeblock_name = $row[1];
        
        $db->query("SELECT PaperTypeCost, PaperTypeName, PaperTypeWeight
                    FROM PaperTypeCostsBlock 
                    WHERE PaperTypeId = '".intval($_POST['papertype_block'])."' ");
        $row = $db->fetch_array();
        $pr_papertypeblock = $row[0];
        $pr_papertypeblock_name = $row[1].' '.$row[2];
//        $oneblock = ($pr_printtypeblock + $pr_papertypeblock)*$pages/$pr_pagesona3;
        $db->query("SELECT OrderRate 
                    FROM OrdersRates 
                    WHERE OrderRateMin <= '".$count."' AND 
                          OrderRateMax >= '".$count."' ");
        $row = $db->fetch_array();
        $koef = $row[0];
        
//		$count16 = $count + 16;
//		$db->query("SELECT OrderRate 
//                    FROM OrdersRates 
//                    WHERE OrderRateMin <= '".$count16."' AND 
//                          OrderRateMax >= '".$count16."' ");
//        $row16 = $db->fetch_array();
//        $koef16 = $row16[0];
		
        $db->query("SELECT BindingCosts 
                    FROM BindingTypeCosts 
                    WHERE BindingMin <= '".$pages."' AND 
                          BindingMax >= '".$pages."' AND 
                          BindingId = '".intval($_POST['bind'])."' AND 
                          formatId = '".intval($_POST['size_paper'])."' ");
        $row = $db->fetch_array();
        $pr_bind = $row[0];

        $db->query("SELECT BindingName 
                    FROM BindingType 
                    WHERE BindingId = '".intval($_POST['bind'])."' ");
        $row = $db->fetch_array();
        $pr_bind_name = $row[0];

//        $koef=1;
        
        $allblock = ceil((($pr_printtypeblock + $pr_papertypeblock) * $pages / $pr_pagesona3) * $count * $koef);
        $allcover = ceil((($pr_printtypecover + $pr_papertypecover + $pr_additionalcover ) / $pr_pagesona3 * 4) * $count * $koef);
        $allbind = ceil($pr_bind * $count * $koef);
        $correct = ($pages * 68);
		$maket = ($pages * 18);
        $total = ($allblock+$allcover+$allbind);
		$sale = $total * 0.8;
        
//        $allblock16 = ceil((($pr_printtypeblock + $pr_papertypeblock) * $pages / $pr_pagesona3) * $count16 * $koef16);
//        $allcover16 = ceil((($pr_printtypecover + $pr_papertypecover + $pr_additionalcover ) / $pr_pagesona3 * 4) * $count16 * $koef16);
//        $allbind16 = ceil($pr_bind * $koef16 * $count16);
        
//        $total16 = ($allblock16+$allcover16+$allbind16-$total);
        $total16=($total/$count)*16;
        $covers['soft'][0]='Мягкая обложка';
        $covers['hard'][0]='Твердая обложка';
		
		if (($_POST['papertype_cover'] == 'soft') && intval($_POST['count'])<=16){
                $srok=5;
				$ISBN = '<div class="alert error" id="bookstore" style="display:none;">
                                                	Укажите тираж с учетом отправки 16 обязательных экземпляров в Российскую книжную палату.</div>';
				$ekz = '<span id="countdisp" style="color:#ff0000; display:none;"></span>';
		}
				
		if (($_POST['papertype_cover'] == 'soft') && intval($_POST['count'])>16 && intval($_POST['count'])<20){
                $srok=5;
				$ekz = '<span id="countdisp1" style="color:#ff0000; display:none;"></span>';
		}
		if (($_POST['papertype_cover'] == 'soft') && intval($_POST['count'])>=20 && intval($_POST['count'])<100){
                $srok=7;
				$ekz = '<span id="countdisp1" style="color:#ff0000; display:none;"></span>';
		}
		if (($_POST['papertype_cover'] == 'soft') && intval($_POST['count'])>=100){
                $srok=10;
				$ekz = '<span id="countdisp1" style="color:#ff0000; display:none;"></span>';
		}
		if (($_POST['papertype_cover'] == 'hard') && intval($_POST['count'])<10){
                $srok=7;
				$ISBN = '<div class="alert error" id="bookstore" style="display:none;">
                                                	Укажите тираж с учетом отправки 16 обязательных экземпляров в Российскую книжную палату.
                                                </div>';
				$ekz = '<span id="countdisp" style="color:#ff0000; display:none;"></span>';
				$fixbind = '<div class="alert">
                                                	ВНИМАНИЕ: возможно изменение крепления на ПУР-клей.
                                                </div>';
		}
		if (($_POST['papertype_cover'] == 'hard') && intval($_POST['count'])>=10 && intval($_POST['count'])<=16){
                $srok=10;
				$ISBN = '<div class="alert error" id="bookstore" style="display:none;">
                                                	Укажите тираж с учетом отправки 16 обязательных экземпляров в Российскую книжную палату.
                                                </div>';
				$ekz = '<span id="countdisp" style="color:#ff0000; display:none;"></span>';
		}
		if (($_POST['papertype_cover'] == 'hard') && intval($_POST['count'])>16 && intval($_POST['count'])<100){
                $srok=10;
				$ekz = '<span id="countdisp1" style="color:#ff0000; display:none;"></span>';
		}
		if (($_POST['papertype_cover'] == 'hard') && intval($_POST['count'])>=100){
                $srok=14;
				$ekz = '<span id="countdisp1" style="color:#ff0000; display:none;"></span>';
		}
		
		
		$d = date ( "d.m.Y" , mktime(0, 0, 0, date("m"), date("d")+$srok, date("Y")));
	
        $fixbind = isset($fixbind) ? $fixbind : "";
            echo '<table width="100%">
                    <tr>
                        <td colspan="2">
                            <h3>'.$covers[$_POST['papertype_cover']][0].'</h3>
                        </td>
                    </tr>
                    <tr>
                        <td><img src="img/bindtype_'.$_POST['bind'].'.jpg" border="0"></td>
                        <td>Размер: <b>'.$pr_pagesona3_name.'</b> '.$pr_pagesona3_name_hw.'<br> 
                            Крепление: '.$pr_bind_name.'<br> 
                            Обложка цветная с матовой ламинацией<br>
							Блок: '.$pr_printtypeblock_name.', '.$pr_papertypeblock_name.', '.$pages.' стр.<br>
                            Тираж: <b>'.$count.' экз. '.$ekz.'</b><br>
							'.$fixbind.'
                        </td>
                    </tr> 
              </table>     
              
              <table id="ads"></table>'.$ISBN.'
              								
            <h2>Стоимость печати тиража: <span class="label" id="vpr">'.($total).'</span> руб.</h2>
Ориентировочная дата готовности: '.$d.'

<br><br>

												
												
              <div class="alert">
                                                	<strong> ВНИМАНИЕ: </strong>Стоимость указана за услуги печати с <strong>готовых</strong> оригинал-макетов. Выполните верстку <a href="new/verstka.html" target="_blank">самостоятельно</a> или <strong>закажите подготовку макета</strong> и получите <span class="label">Издательский пакет бесплатно! </span> <a href="//editus-dev.ru/offer.php">Подробнее >></a> 
                                                </div>
												
              <input type="hidden" name="totalor" id="totslpriceor" value="'.($total).'"/>
              <input type="hidden" name="total" id="totslprice" value="'.($total).'"/> 
              ';
	}
    if ($_POST['do'] == 'getPagesCorrect'){
        $db = new Db();
        $db->query("SELECT BindingMultiplicity FROM BindingType WHERE BindingId = '".intval($_POST['bind'])."' ");
        $row = $db->fetch_array();
        if (($_POST['pages']%$row[0])!=0){
            echo $row[0]-($_POST['pages']%$row[0]);
        }else{
            echo 0;
        }
    }        
} catch (Exception $exc) {
    echo 'Ошибка в файле ' . $exc->getFile() . ' на строке ' . $exc->getLine() . '<br /> Сообщение: ' . $exc->getMessage() . ' Код ошибки: ' . $exc->getCode() . '<br /> Ход выполнения: ' . $exc->getTraceAsString();
}
?>
