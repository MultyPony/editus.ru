<?php

function listprices() {
    $data[_LPRI_PRICESTYPEPAPER]='index.php?do=editpricestypepaper';
    $data[_LPRI_PRICETYPEPRINT]='index.php?do=editpricestypeprint';
    $data[_LPRI_PRICETYPECOVER]='index.php?do=editpricestypecover';
    $data[_LPRI_ORDERRATE]='index.php?do=editorderrate';
    $data[_LPRI_PRICEBIND]='index.php?do=editpricebind';
    $data[_LPRI_PRICEADDSERVICE]='index.php?do=editpriceaddservice';
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data));
    $tpl->fetch('listprices.tpl');
    return $tpl->get_tpl();
}
function editpriceaddservice() {
    $db = new Db();
    
    if (isset($_POST['editprice']) ) {
        $db->query("UPDATE AdditionalServiceCosts 
                    SET AdditionalServiceCost = '".floatval($_POST['editprice'])."'
                    WHERE AdditionalServiceId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT AdditionalServiceId, AdditionalServiceName, AdditionalServiceCost
                FROM AdditionalServiceCosts 
                WHERE AdditionalServiceEnable = '1'");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }

    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'action'=> 'index.php?do=editpriceaddservice'));
    $tpl->fetch('editpriceaddservice.tpl');
    return $tpl->get_tpl();
}
function editpricestypepaper() {
    $db = new Db();
    
    if (isset($_POST['editprice']) ) {
        $db->query("UPDATE PaperTypeCostsBlock 
                    SET PaperTypeCost = '".floatval($_POST['editprice'])."'
                    WHERE PaperTypeId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight, PaperTypeCost
                FROM PaperTypeCostsBlock ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }

    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'action'=> 'index.php?do=editpricestypepaper'));
    $tpl->fetch('editpricestypepaper.tpl');
    return $tpl->get_tpl();
}
function editpricestypeprint() {
    $db = new Db();
    
    if (isset($_POST['editprice']) ) {
        $db->query("UPDATE PrintTypeCostsBlock 
                    SET PrintCost = '".floatval($_POST['editprice'])."'
                    WHERE PrintTypeId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT PrintTypeId, PrintTypeName, PrintCost
                FROM PrintTypeCostsBlock ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }

    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'action'=> 'index.php?do=editpricestypeprint'));
    $tpl->fetch('editpricestypeprint.tpl');
    return $tpl->get_tpl();
}

function editpricestypecover() {
    $db = new Db();
    
    if (isset($_POST['editprice']) ) {
        $db->query("UPDATE PaperTypeCostsCover 
                    SET PaperTypeCost = '".floatval($_POST['editprice'])."'
                    WHERE PaperTypeId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight, CoverType, PaperTypeCost
                FROM PaperTypeCostsCover 
                WHERE isDefault = '1'");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $type['hard']=_EPTC_HARD;
    $type['soft']=_EPTC_SOFT;
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'type'=>$type,'action'=> 'index.php?do=editpricestypecover'));
    $tpl->fetch('editpricestypecover.tpl');
    return $tpl->get_tpl();
}


function editorderrate() {
    $db = new Db();
    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM OrdersRates 
                    WHERE OrderRateId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newrate'])) {
        $db->query("INSERT INTO OrdersRates 
                     SET OrderRateMin = '".intval($_POST['newmin'])."',
                         OrderRateMax = '".intval($_POST['newmax'])."',
                         OrderRate = '".floatval($_POST['newrate'])."' ");
    }
    if (isset($_POST['rate']) ) {
        $db->query("UPDATE OrdersRates 
                    SET OrderRateMin = '".intval($_POST['min'])."',
                        OrderRateMax = '".intval($_POST['max'])."',
                        OrderRate = '".floatval($_POST['rate'])."'
                    WHERE OrderRateId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT OrderRateId, OrderRateMin, OrderRateMax, OrderRate
                FROM OrdersRates ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $type['hard']=_EPTC_HARD;
    $type['soft']=_EPTC_SOFT;
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'type'=>$type,'action'=> 'index.php?do=editorderrate'));
    $tpl->fetch('editorderrate.tpl');
    return $tpl->get_tpl();
}

function editpricebind() {
    $db = new Db();
    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM BindingTypeCosts 
                    WHERE BindingCostsId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newprice'])) {
        $db->query("INSERT INTO BindingTypeCosts 
                     SET BindingId = '".intval($_POST['newbindid'])."',
                         BindingMin = '".intval($_POST['newmin'])."',
                         BindingMax = '".intval($_POST['newmax'])."',
                         formatId = '".intval($_POST['newformatid'])."',
                         BindingCosts = '".floatval($_POST['newprice'])."' ");
    }
    if (isset($_POST['price']) ) {
        $db->query("UPDATE BindingTypeCosts 
                    SET BindingId = '".intval($_POST['bindid'])."',
                        BindingMin = '".intval($_POST['min'])."',
                        BindingMax = '".intval($_POST['max'])."',
                        formatId = '".intval($_POST['formatid'])."',
                        BindingCosts = '".floatval($_POST['price'])."'
                    WHERE BindingCostsId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT BindingCostsId, BindingId, BindingMin, BindingMax, formatId, BindingCosts
                FROM BindingTypeCosts ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $db->query("SELECT BindingId, BindingName
                FROM BindingType ");
    while ($row = $db->fetch_array()) {
        $bind[] = $row;
    }
    $db->query("SELECT formatId, formatName
                FROM PaperFormat ");
    while ($row = $db->fetch_array()) {
        $format[] = $row;
    }

    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'bind'=>$bind,'format'=>$format,'action'=> 'index.php?do=editpricebind'));
    $tpl->fetch('editpricebind.tpl');
    return $tpl->get_tpl();
}

?>
