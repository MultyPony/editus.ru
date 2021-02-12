<?php
function listpaper() {
    $data[_LP_EDITPAPERTYPE]='index.php?do=editpapertype';
    $data[_LP_EDITPAPERFORMAT]='index.php?do=editpaperformat';

    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data));
    $tpl->fetch('listpaper.tpl');
    return $tpl->get_tpl();
}

function editpapertype() {
    $db = new Db();
    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM PaperTypeCostsBlock 
                    WHERE PaperTypeId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newname'])) {
        $db->query("INSERT INTO PaperTypeCostsBlock 
                     SET PaperTypeName = '".$db->mres($_POST['newname'])."',
                         PaperTypeWeight = '".intval($_POST['newweight'])."',
                         Color = '".intval($_POST['newcolor'])."' ");
    }
    if (isset($_POST['name']) ) {
        $db->query("UPDATE PaperTypeCostsBlock 
                    SET PaperTypeName = '".$db->mres($_POST['name'])."',
                        PaperTypeWeight = '".intval($_POST['weight'])."',
                        Color = '".intval($_POST['color'])."'
                    WHERE PaperTypeId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT PaperTypeId, PaperTypeName, PaperTypeWeight, Color
                FROM PaperTypeCostsBlock ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    $color = array('14'=>_EPT_COLORBLACK, '4'=> _EPT_COLOR, '1'=>_EPT_BLACK);
    
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'color'=>$color,'action'=> 'index.php?do=editpapertype'));
    $tpl->fetch('editpapertype.tpl');
    return $tpl->get_tpl();
}

function editpaperformat() {
    $db = new Db();
    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM PaperFormat 
                    WHERE formatId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newname'])) {
        $db->query("INSERT INTO PaperFormat 
                     SET formatName = '".$db->mres($_POST['newname'])."',
                         formatWidth = '".intval($_POST['newweight'])."',
                         formatHeight = '".intval($_POST['newheight'])."',
                         formatInA3 = '".intval($_POST['newina3'])."' ");
    }
    if (isset($_POST['name']) ) {
        $db->query("UPDATE PaperFormat 
                    SET formatName = '".$db->mres($_POST['name'])."',
                        formatWidth = '".intval($_POST['weight'])."',
                        formatHeight = '".intval($_POST['height'])."',
                        formatInA3 = '".intval($_POST['ina3'])."'
                    WHERE formatId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT formatId, formatName, formatWidth, formatHeight, formatInA3
                FROM PaperFormat ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
//    $color = array('14'=>_EPT_COLORBLACK, '4'=> _EPT_COLOR, '1'=>_EPT_BLACK);
    
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data,'action'=> 'index.php?do=editpaperformat'));
    $tpl->fetch('editpaperformat.tpl');
    return $tpl->get_tpl();}
?>
