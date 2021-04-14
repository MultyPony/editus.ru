<?php

  session_start();

  require_once './../config.inc.php';
  require_once 'db_class.php';
  require_once dirname(__FILE__) . '/../cdek/scripts/service.php';

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
        }
?>
            
  <h3>Бумага</h3>
  <table width="100%">
      <tr align="center">
          <?php echo $res; ?>
      </tr>
  </table> 
  <p><a class="more-link" href="new/online.html#paper" target="_blank">Какую бумагу лучше выбрать?</a></p>
  <h3>Дополнительно</h3>
  <table id="additionalcover">

<?php   
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
        $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight FROM papertypecostsblock WHERE ".$sql);
        while ($row = $db->fetch_array()) {
            if (!isset($res)) {
                $res = '';
            }
            $res .= '<td><label for="pb_'.$row['PaperTypeId'].'"><img src="img/paper.png" border="0" /><br />'.$row['PaperTypeName'].'<br />'.$row['PaperTypeWeight'].' гр/м<sup>2</sup></label>
			<input id="pb_'.$row['PaperTypeId'].'" type="radio" name="paperblock" value="'.$row['PaperTypeId'].'" data-weight="'.$row['PaperTypeWeight'].'"/>
			</td>';
           
        }
        ?>

        <h3>Бумага</h3>
        
        <table width="100%">
            <tr align="center">
                <?php echo $res; ?>
                
            </tr>
       
        </table>
        <p><a class="more-link" href="new/online.html#paper" target="_blank">Какую бумагу лучше выбрать?</a></p>
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
            $res1 .= '<td><label for="pf_'.$row['formatId'].'"><img src="img/paperformat_'.$row['formatId'].'.png" border="0" /></label><label for="pf_'.$row['formatId'].'">'.$row['formatName'].'</label>'.$row['formatWidth'].' x '.$row['formatHeight'].' мм<br /><p><input id="pf_'.$row['formatId'].'" type="radio" class="radio checker" name="size" value="'.$row['formatId'].'" data-format-name="'.$row['formatName'].'" data-format-size="'.$row['formatWidth'].'x'.$row['formatHeight'].'"/></p></td>';
           
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
        
        // $db->query("SELECT BindingType.BindingId, BindingType.BindingName 
        //             FROM BindingType WHERE BindingType.CoverType = '".$db->mres($_POST['cover'])."' 
        //                                  AND BindingType.BindingMin <= '".intval($_POST['pages'])."' 
        //                                  AND BindingType.BindingMax >= '".intval($_POST['pages'])."' "
        // );
        

        if (isset($_POST['orderid'])) {
            $db->query("SELECT orderPages  
                        FROM usersorders WHERE orderid = '".$_POST['orderid']."'");
            $pages = $db->fetch_array()[0];
        } else {
            $pages = intval($_POST['pages']);
        }

        $db->query("SELECT BindingType.BindingId, BindingType.BindingName, CoverType 
                    FROM BindingType WHERE BindingType.BindingMin <= '".$pages."' 
                                         AND BindingType.BindingMax >= '".$pages."' "
        );

        // $db->query("SELECT BindingId, BindingName, CoverType
        //             FROM bindingtype WHERE BindingMin <= '".intval($_SESSION['pages'])."' 
        //                                 AND BindingMax >= '".intval($_SESSION['pages'])."' "
        // );
        
        if ($db->num_rows() >= 1){
            while ($row = $db->fetch_array()) {
                if (!isset($res)){
                    $res = array();
                }
                $res[] = array(
                    'bindingId' => $row['BindingId'],
                    'bindingName' => htmlspecialchars($row['BindingName']),
                    'coverType' => htmlspecialchars($row['CoverType']),
                ); 
            }
        
            // echo json_encode($res, JSON_UNESCAPED_UNICODE);
            // echo json_encode(array('soft' => htmlspecialchars($res)));
            
            ?> 
        <?php
        } else {
            $res = false;
         
            $txt = '<h3>Крепление</h3><p>К сожалению, креплений для данного количества страниц нет</p>';
            
            
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
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
    
    if ($_POST['do'] == 'getISBNprice'){
        $db = new Db();
        $db->query("SELECT AdditionalServiceCost FROM AdditionalServiceCosts WHERE AdditionalServiceEnable = '1' AND AdditionalServiceId = '10' ");
        $row = $db->fetch_array();
        echo $row[0];
    }

    if ($_POST['do'] == 'getSessionDataForMassa') {
        // $_SESSION[];
        echo json_encode(array(
            'bookWidth' => $_SESSION['book_width'],
            'bookHeight' => $_SESSION['book_height'],
            'pageCount' => $_SESSION['pages'],
        ));
    }

    /** 
     * AJAX 
     * Шаг 2
     * Вывод выбранных параметров и итоговой стоимости
     * $_POST['']
     * кол-во стр
     * тип бумаги
     * orderId
    */
    if ($_POST['do'] == 'calc') {
        $db = new Db();
        
        /**
         * Блок проверок 
         * Проверять то, что передается в запросе
         */
        if (!isset($_SESSION['userId'])) {
            echo '<p class="tabletitle"><font color="#FF0000"><b>Время сессии истекло. Обновите страницу</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if ($_POST['printtype_block']!='color' && $_POST['printtype_block']!='black'){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите тип печати</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if (intval($_POST['papertype_block'])==0){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите бумагу</b></font></p>
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
		
        // Нужно придумать как передать orderId
        $db->query("SELECT orderPages
                    FROM UsersOrders
                    WHERE userId = '" . $_SESSION['userId'] . "'
                    AND orderId = '". $_POST['orderid'] ."' LIMIT 1");
        // @Кол-во страниц в блоке
        $pages = intval($db->fetch_array()[0]);

        //  @Тираж 
        $count = intval($_POST['count']);
        
        $db->query("SELECT PrintCost 
                    FROM PrintTypeCostsCover 
                    WHERE PrintType = '44' ");
        $row = $db->fetch_array();
        //  @ Стоимость блока 4+4 ???
        $pr_printtypecover = $row[0];
        
        $db->query("SELECT PaperTypeCost 
                            FROM PaperTypeCostsCover 
                            WHERE CoverType = '" . $_POST['papertype_cover'] . "' AND
                                  isDefault = '1'");
        $row = $db->fetch_array();
        // @ Цена обложки (мягк/тверд)
        $pr_papertypecover = $row[0];
        
        $db->query("SELECT orderSize
                    FROM UsersOrders
                    WHERE userId = '" . $_SESSION['userId'] . "'
                    AND orderId = '" . $_POST['orderid'] . "'");
        // @ Формат бумаги (А3, А4 ... )
        $size_paper = $db->fetch_array()[0];


        $db->query("SELECT formatInA3, formatName, formatWidth, formatHeight 
                    FROM PaperFormat 
                    WHERE formatId = '".intval($size_paper)."' ");
        $row = $db->fetch_array();
        // @ Cколько страниц умещается на А3
        $pr_pagesona3 = $row[0];
        $pr_pagesona3_name = $row[1];
        $pr_pagesona3_name_hw = $row['formatWidth'].'x'.$row['formatHeight'];
        
        $db->query("SELECT SUM(AdditionalCoverCost) 
                    FROM AdditionalCoverCosts 
                    WHERE isDefault = '1' ");
        $row = $db->fetch_array();
        // @ Стоимость ламинации обложки
        $pr_additionalcover = $row[0];

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
        // @Коэффициент в зав-ти от Тиража
        $koef = $row[0];
        

        


        $db->query("SELECT BindingCosts 
                    FROM BindingTypeCosts 
                    WHERE BindingMin <= '".$pages."' AND 
                          BindingMax >= '".$pages."' AND 
                          BindingId = '".intval($_POST['bind'])."' AND 
                          formatId = '".intval($size_paper)."' ");
        $row = $db->fetch_array();
        // @ Стоимость крепления в зав-ти от кол-ва страниц, типа крепления и формата бумаги
        $pr_bind = $row[0];

        $db->query("SELECT BindingName 
                    FROM BindingType 
                    WHERE BindingId = '".intval($_POST['bind'])."' ");
        $row = $db->fetch_array();
        $pr_bind_name = $row[0];

//        $koef=1;
        
        // Получить стоимость издательского пакета
        $db->query("SELECT AdditionalServiceCost FROM AdditionalServiceCosts WHERE AdditionalServiceEnable = '1' AND AdditionalServiceId = '10' ");
        $row = $db->fetch_array();
        $isbnPrice = $row[0];

        if ($_POST['isbnChecked'] == 'false') {
            $isbnPrice = 0;
        }
        
        $allblock = ceil((($pr_printtypeblock + $pr_papertypeblock) * $pages / $pr_pagesona3) * $count * $koef);
        $allcover = ceil((($pr_printtypecover + $pr_papertypecover + $pr_additionalcover ) / $pr_pagesona3 * 4) * $count * $koef);
        $allbind = ceil($pr_bind * $count * $koef);
        $correct = ($pages * 68);
		$maket = ($pages * 18);
        $total = ($allblock + $allcover + $allbind + $isbnPrice);
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

        $lamination = $_POST['lamination'] == 'matte' ? 'матовой' : 'глянцевой';


        // СДЭК - расчет стоимости доставки
        $massa = 0.4;

        $data = array();
        $data['shipment'] = array(
            'cityToId' => intval($_POST['city_id_for_CDEK']),
            'cityFromId' => '44',
            'type' => 'pickup',
            'goods' => array(
                array('weight' => $massa,
                'length' => 25,
                'width'  => 17,
                'height' => 7
                )
            ),
        );

        $res = ISDEKservice::calc($data, false);
        $delivcost = $res['result']['price'];

        
        echo json_encode(array(
            'total' => $total,
            'dateOfReadiness' => $d,
            'deliveryCost' => $delivcost,
            'printTypeBlockName' => $pr_printtypeblock_name,
            'paperTypeBlockName' => $pr_papertypeblock_name,
        ));
        return;
    ?>

    <table width="100%">
        <tr>
            <td colspan="2">
                <h3><?php echo $covers[$_POST['papertype_cover']][0] ; ?></h3>
            </td>
        </tr>
        <tr>
            <td><img src="<?php echo "img/bindtype_" . $_POST['bind'] . ".jpg"; ?>" border="0"></td>
            <td>Размер: <b><?php echo $pr_pagesona3_name; ?></b> <?php echo $pr_pagesona3_name_hw; ?><br> 
                Крепление: <?php echo $pr_bind_name; ?><br> 
                <!-- Обложка цветная с матовой ламинацией<br> -->
                Обложка цветная с <?php echo $lamination; ?> ламинацией<br>
                Блок: <?php echo "$pr_printtypeblock_name".', '.$pr_papertypeblock_name.', '.$pages." стр."; ?><br>
                Тираж: <b><?php echo $count.' экз. '.$ekz; ?></b><br>
                <?php echo $fixbind ?>
            </td>
        </tr> 
    </table>     

    <?php 
        if ($_POST['delivery_type'] == 'pickup') { 
    ?>
            <h2>Итого: <span class="label" id="vpr"><?php echo $total; ?></span> руб.</h2>Ориентировочная дата готовности: <?php echo $d; ?><br><br>
    <?php } else { ?>
            <table>
                <tr>
                    <td>Стоимость печати тиража: </td>
                    <td><?php echo $total; ?> руб.</td>
                </tr>
                <tr>
                    <td>Стоимость доставки: </td>
                    <td><?php echo $delivcost; ?> руб.</td>
                </tr>
            </table>
            <h2>Итого: <span class="label" id="vpr"><?php echo $total + $delivcost; ?></span> руб.</h2>Ориентировочная дата готовности: <?php echo $d; ?><br><br>
    <?php } ?>                                 
                                    
    <div class="alert">
        <strong> ВНИМАНИЕ: </strong>Стоимость указана за услуги печати с <strong>готовых</strong> оригинал-макетов. Выполните верстку <a href="new/verstka.html" target="_blank">самостоятельно</a> или <strong>закажите подготовку макета</strong> и получите <span class="label">Издательский пакет бесплатно! </span> <a href="offer.php">Подробнее >></a> 
    </div>
                                    
    <input type="hidden" name="totalor" id="totslpriceor" value="<?php echo $total; ?>"/>
    <input type="hidden" name="total" id="totslprice" value="<?php echo $total; ?>"/> 
              
              <?php 
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
    
    

    if ($_POST['do'] == 'calculator') {
        $db = new Db();
        
        /**
         * Блок проверок 
         * Проверять то, что передается в запросе
         */
        if ($_POST['printtype_block']!='color' && $_POST['printtype_block']!='black'){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите тип печати</b></font></p>
                  <script type="text/javascript">$("input[type=submit]").hide();</script>';
            return;
        }
        if (intval($_POST['papertype_block'])==0){
            echo '<p class="tabletitle"><font color="#FF0000"><b>Выберите бумагу</b></font></p>
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
		
        // @Кол-во страниц в блоке
        $pages = intval($_POST['pages']);

        //  @Тираж 
        $count = intval($_POST['count']);
        
        $db->query("SELECT PrintCost 
                    FROM PrintTypeCostsCover 
                    WHERE PrintType = '44' ");
        $row = $db->fetch_array();
        //  @ Стоимость блока 4+4 ???
        $pr_printtypecover = $row[0];
        
        $db->query("SELECT PaperTypeCost 
                            FROM PaperTypeCostsCover 
                            WHERE CoverType = '" . $_POST['papertype_cover'] . "' AND
                                  isDefault = '1'");
        $row = $db->fetch_array();
        // @ Цена обложки (мягк/тверд)
        $pr_papertypecover = $row[0];
        
        // @ Формат бумаги (А3, А4 ... )
        $size_paper = $_POST['size_paper'];


        $db->query("SELECT formatInA3, formatName, formatWidth, formatHeight 
                    FROM PaperFormat 
                    WHERE formatId = '".intval($size_paper)."' ");
        $row = $db->fetch_array();
        // @ Cколько страниц умещается на А3
        $pr_pagesona3 = $row[0];
        $pr_pagesona3_name = $row[1];
        $pr_pagesona3_name_hw = $row['formatWidth'].'x'.$row['formatHeight'];
        
        $db->query("SELECT SUM(AdditionalCoverCost) 
                    FROM AdditionalCoverCosts 
                    WHERE isDefault = '1' ");
        $row = $db->fetch_array();
        // @ Стоимость ламинации обложки
        $pr_additionalcover = $row[0];

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
        $db->query("SELECT OrderRate 
                    FROM OrdersRates 
                    WHERE OrderRateMin <= '".$count."' AND 
                          OrderRateMax >= '".$count."' ");
        $row = $db->fetch_array();
        // @Коэффициент в зав-ти от Тиража
        $koef = $row[0];
        

        


        $db->query("SELECT BindingCosts 
                    FROM BindingTypeCosts 
                    WHERE BindingMin <= '".$pages."' AND 
                          BindingMax >= '".$pages."' AND 
                          BindingId = '".intval($_POST['bind'])."' AND 
                          formatId = '".intval($size_paper)."' ");
        $row = $db->fetch_array();
        // @ Стоимость крепления в зав-ти от кол-ва страниц, типа крепления и формата бумаги
        $pr_bind = $row[0];

        $db->query("SELECT BindingName 
                    FROM BindingType 
                    WHERE BindingId = '".intval($_POST['bind'])."' ");
        $row = $db->fetch_array();
        $pr_bind_name = $row[0];


        
        // Получить стоимость издательского пакета
        $db->query("SELECT AdditionalServiceCost FROM AdditionalServiceCosts WHERE AdditionalServiceEnable = '1' AND AdditionalServiceId = '10' ");
        $row = $db->fetch_array();
        $isbnPrice = $row[0];

        if ($_POST['isbnChecked'] == 'false') {
            $isbnPrice = 0;
        }
        
        $allblock = ceil((($pr_printtypeblock + $pr_papertypeblock) * $pages / $pr_pagesona3) * $count * $koef);
        $allcover = ceil((($pr_printtypecover + $pr_papertypecover + $pr_additionalcover ) / $pr_pagesona3 * 4) * $count * $koef);
        $allbind = ceil($pr_bind * $count * $koef);
        $correct = ($pages * 68);
		$maket = ($pages * 18);
        // $total = ($allblock + $allcover + $allbind + $isbnPrice);
        $total = ($allblock + $allcover + $allbind);
		$sale = $total * 0.8;
        

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

        echo json_encode(array(
            'total' => $total,
            'dateOfReadiness' => $d,
            'printTypeBlockName' => $pr_printtypeblock_name,
            'paperTypeBlockName' => $pr_papertypeblock_name,
        ));
        return;
    }


} catch (Exception $exc) {
    echo 'Ошибка в файле ' . $exc->getFile() . ' на строке ' . $exc->getLine() . '<br /> Сообщение: ' . $exc->getMessage() . ' Код ошибки: ' . $exc->getCode() . '<br /> Ход выполнения: ' . $exc->getTraceAsString();
}

?>
