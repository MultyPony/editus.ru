<?php
function listdeliv() {
    $data[_LD_EDITDELIVCOUNTRY]='index.php?do=editdelivcountry';
    $data[_LD_EDITDELIVREGIONS]='index.php?do=editdelivregion';
    $data[_LD_EDITDELIVPROVIDERS]='index.php?do=editdelivproviders';

    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data));
    $tpl->fetch('listdeliv.tpl');
    return $tpl->get_tpl();
}
function editdelivcountry() {
    $db = new Db();

    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM DeliveryCountries 
                    WHERE CountryId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newname'])) {
        $db->query("INSERT INTO DeliveryCountries 
                     SET CountryName = '".$db->mres($_POST['newname'])."' ");
    }
    if (isset($_POST['name']) ) {
        $db->query("UPDATE DeliveryCountries 
                    SET CountryName = '".$db->mres($_POST['name'])."'
                    WHERE CountryId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT CountryId, CountryName
                FROM DeliveryCountries ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data, 'action'=> 'index.php?do=editdelivcountry'));
    $tpl->fetch('editdelivcountry.tpl');
    return $tpl->get_tpl();
}
function editdelivregion() {
    $db = new Db();
    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM DeliveryRegions 
                    WHERE RegionId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newname'])) {
        if (isset($_POST['newiscity'])){
            $asql = ", iscity = '1' ";
        }else{
            $asql = '';
        }
        $db->query("INSERT INTO DeliveryRegions 
                     SET RegionName = '".$db->mres($_POST['newname'])."',
                         CountryId = '".intval($_POST['newcountry'])."' ".$asql." ");
    }    
    if (isset($_POST['name']) ) {
        if (isset($_POST['iscity'])){
            $asql = ", iscity = '1' ";
        }else{
            $asql = ", iscity = '0' ";
        }
        $db->query("UPDATE DeliveryRegions 
                    SET RegionName = '".$db->mres($_POST['name'])."',
                        CountryId = '".intval($_POST['country'])."'
                            ".$asql."
                    WHERE RegionId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT CountryId, CountryName
                FROM DeliveryCountries ");
    while ($row = $db->fetch_array()) {
        $country[$row['CountryId']] = $row['CountryName'];
    }
    
    $db->query("SELECT RegionId, CountryId, RegionName, iscity
                FROM DeliveryRegions ORDER BY RegionName");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('country'=>$country,'data' => $data, 'action'=> 'index.php?do=editdelivregion'));
    $tpl->fetch('editdelivregion.tpl');
    return $tpl->get_tpl();
}
function editdelivproviders() {
    $db = new Db();

    if (isset($_POST['del'])) {
        $db->query("DELETE 
                    FROM DeliveryProviders 
                    WHERE DeliveryProviderId = '".intval($_POST['id'])."'");
    }
    if (isset($_POST['newname'])) {
        $db->query("INSERT INTO DeliveryProviders 
                    SET DeliveryProviderName = '".$db->mres($_POST['newname'])."' ");
    }
    if (isset($_POST['name']) ) {
        $db->query("UPDATE DeliveryProviders 
                    SET DeliveryProviderName = '".$db->mres($_POST['name'])."'
                    WHERE DeliveryProviderId = '".intval($_POST['id'])."' ");
    }
    $db->query("SELECT DeliveryProviderId, DeliveryProviderName, DeliveryProviderAvatarUrl
                FROM DeliveryProviders ");
    while ($row = $db->fetch_array()) {
        $data[] = $row;
    }
    
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_vars(array('data' => $data, 'action'=> 'index.php?do=editdelivproviders'));
    $tpl->fetch('editdelivproviders.tpl');
    return $tpl->get_tpl();
}
function editproviderscosts(){
    if (!isset($_GET['a'])){
        $db = new Db();
        if (!empty($_POST['newregion'])) {
            $db->query("INSERT INTO DeliveryProvidersCosts 
                        SET DeliveryProviderId = '".intval($_POST['newid'])."',
                            CountryId = '".intval($_POST['newcountry'])."',
                            RegionId = '".intval($_POST['newregion'])."',
                            minWeight = '".intval($_POST['newminw'])."',
                            maxWeight = '".intval($_POST['newmaxw'])."',
                            OverQuote = '".floatval($_POST['newoverquote'])."',
                            DeliveryProviderCosts = '".floatval($_POST['newcost'])."' ");
        }
        if (isset($_POST['delid'])){
            $db->query("DELETE 
                        FROM DeliveryProvidersCosts 
                        WHERE DeliveryProvidersCostsId = '".intval($_POST['delid'])."'");
        }
        
        
        $db->query("SELECT DeliveryProviders.DeliveryProviderName,
                           DeliveryProvidersCosts.DeliveryProvidersCostsId, 
                           DeliveryCountries.CountryName, 
                           DeliveryRegions.RegionName, 
                           DeliveryProvidersCosts.minWeight, 
                           DeliveryProvidersCosts.maxWeight, 
                           DeliveryProvidersCosts.OverQuote,
                           DeliveryProvidersCosts.DeliveryProviderCosts 
                    FROM DeliveryProvidersCosts, DeliveryRegions, DeliveryCountries, DeliveryProviders
                    WHERE DeliveryProvidersCosts.DeliveryProviderId = '".intval($_GET['id'])."' AND 
                          DeliveryProviders.DeliveryProviderId = '".intval($_GET['id'])."' AND 
                          DeliveryCountries.CountryId = DeliveryProvidersCosts.CountryId AND 
                          DeliveryRegions.RegionId = DeliveryProvidersCosts.RegionId ");
        while ($row = $db->fetch_array()) {
            $data[] = $row;
        }
        
        $db->query("SELECT CountryId, CountryName
                    FROM DeliveryCountries ");
        while ($row = $db->fetch_array()) {
            $country[$row['CountryId']] = $row['CountryName'];
        }
        
        $tpl = new Template();
        $tpl->set_path('../templates/admin/');
        $tpl->set_vars(array('mode'=>1,'country'=>$country,'data' => $data, 'action'=> 'index.php?do=editproviderscosts&amp;id='.intval($_GET['id'])));
        $tpl->fetch('editproviderscosts.tpl');
        return $tpl->get_tpl();
        
    }else{
        if ($_POST['do']=='getregion'){
            $db = new Db();
            $db->query("SELECT RegionId, RegionName
                        FROM DeliveryRegions
                        WHERE CountryId = '".  intval($_POST['countryid'])."' AND
                              RegionParentId ='0' ");
            while ($row = $db->fetch_array()) {
                $regions[] = $row;
            }
            $tpl = new Template();
            $tpl->set_path('../templates/admin/');
            $tpl->set_vars(array('mode'=>2,'regions'=>$regions));
            $tpl->fetch('editproviderscosts.tpl');
            $tpl->display();
        }
        
    }
 }
?>
