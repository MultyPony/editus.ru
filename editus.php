<?php
try {
//    ini_set( "display_errors", "1" );
//    ini_set( "error_reporting", "2047" );
    include_once 'include/engine_class.php';
    include_once 'bill/cardpay/CardPayAvangard.php';
    $engine = new Engine();
    $engine->load_lang_error();
    $engine->load_main_settings();
    if (!empty(Main_config::$sessiondir)){
        session_save_path(Main_config::$sessiondir);
    }
    session_set_cookie_params(10800); // время жизни сессионной куки 3 часа ???
    session_start();
    $engine->load_class('tpl');
    $tpl = new Template();
    // $tpl->addjs('jquery-1.4.2.min');
    $tpl->addjs('jquery-ui-1.8.4.custom.min');
    $tpl->addjs('ajaxupload');
    // $tpl->addjs('common');
    $tpl->addcss();
    if (Main_config::$serviceoff !=1 || isset($_SESSION['admin'])){
        $engine->tpl=&$tpl;
        $engine->load_class('db');
        $engine->load_class('user');
        $engine->load_lang('user');
        $engine->load_class('settings');
        $engine->settings = new Settings();
        $u = new User();
        $engine->do = isset($_GET['do']) ? $_GET['do'] : '';
        $t=array();
        
        /* Не понятно зачем тут вообще
        $db = new Db();
        $db->query("SELECT partnerMainPage
                    FROM PartnersData
                    WHERE userId = '".$_SESSION['userId']."'");
        $href = $db->fetch_array();
        $href = '//'.$href[0]; // В бд пусто, можно оставить нотис
        $logopath = '';
        */

        if (isset($_SESSION['myPartnerId'])){
            $logopath = './partner_logo/logo_'.$_SESSION['userId'].'.jpg';
        } else {
            if (isset($_SESSION['partnerId']) && $_SESSION['partnerId'] != 0){
                $logopath = './partner_logo/logo_'.$_SESSION['partnerId'].'.jpg';
            } else {
                $href = 'index.php';
                $logopath = './img/logo.gif';
            }
        }
        $t['logohref'] = $href;
        $t['logo'] = $logopath;
        
        if (!$u->is_user()) {
            // if ($_GET['pj']=='n'){
            //     $engine->do = 'listprojects';
            //     $engine->call_function($tpl,$u,1);
            // }
            if ($engine->do == 'login' || ($engine->do != 'fpr' && $engine->do != 'register_partner' &&  $engine->do != 'register' && $engine->do != 'recover_password' && $engine->do != 'activate')) {
                $t['auth'] = $u->login($engine);
            } else if ($engine->do == 'register') {
                 $t['auth'] = $u->register($engine);
            } else if($engine->do == 'register_partner') {
                $t['auth'] = $u->register_partner($engine);
            } else if ($engine->do == 'recover_password') {
                $t['auth'] = $u->recover_password($engine);
            } else if ($engine->do == 'activate') {
                $t['auth'] = $u->activate($engine);
            } else if ($engine->do == 'fpr') {
                $u->register_from_partner($engine);
            }
        } else {
            if ($engine->do == 'logout') {
                $u->logout();
            }
            if ($engine->do == 'fpr') {
                $action = 'project.php';
                header("Location: //".$_SERVER['HTTP_HOST'].'/'.$action);
            }
            if (empty($engine->do)) {
                $engine->do = 'listorders';
            }        
            $engine->call_function($tpl, $u);
            if (empty($tpl->menu)) {
                $tpl->menu = array('usermenu' => $engine->showusermenu($u));
            }
            $tpl->set_vars($tpl->menu);
        }
        $tpl->set_vars($t);
        $tpl->fetch('main.tpl');
        if ($_GET['a'] != 1) {
            $tpl->display();
        }else{
            echo $t['content'];
        }
    } else {
        $t['content'] = _SERVICEOFF;
        $tpl->set_vars($t);
        $tpl->fetch('main.tpl');
        $tpl->display();
    }
} catch (Exception $exc) {
    echo 'Ошибка в файле ' . $exc->getFile() . " на строке " . $exc->getLine() . "\nСообщение: " . $exc->getMessage() . "\nКод ошибки: " . $exc->getCode() . "\nХод выполнения: " . $exc->getTraceAsString()."\n User: ". $_SESSION['userId'];
    $engine->mail(Main_config::$debugmail, 'Error', 'Ошибка в файле ' . $exc->getFile() . " на строке " . $exc->getLine() . "\nСообщение: " . $exc->getMessage() . "\nКод ошибки: " . $exc->getCode() . "\nХод выполнения: " . $exc->getTraceAsString()."\n User: ". $_SESSION['userId']);
    header("Location: //".$_SERVER['HTTP_HOST'].'/'.Main_config::$main_file_name);
    exit;    
}

?>
