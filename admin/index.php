<?php
try {
    // error_reporting(E_ERROR | E_PARSE);


//       ini_set( "display_errors", "1" );
//ini_set( "error_reporting", "2047" );
    include_once '../include/engine_class.php';
    $engine = new Engine();
    $engine->set_path_to_root('../');
    $engine->set_path_to_module('admin/');
    $engine->load_lang_error();
    $engine->load_main_settings();
    $engine->set_path_to_lang('include/lang/admin/');

    if (!empty(Main_config::$sessiondir)){
        session_save_path('../'.Main_config::$sessiondir);
    }
    session_set_cookie_params(14400);
    session_start();

    $engine->load_class('tpl');
    $tpl = new Template();
    $tpl->set_path('../templates/admin/');
    $tpl->set_path_js('../js/');
    $tpl->addjs('jquery-1.4.2.min');
    $tpl->addjs('jquery-ui-1.8.4.custom.min');
    $tpl->addjs('commonAdmin');
    $engine->load_class('db');
    $engine->load_class('user');
    $engine->load_class('settings');
    $engine->settings = new Settings();
    $engine->load_lang('user');

    $u = new User();
    $u->engine = &$engine;
    $do = $_GET['do'];
    $engine->do = $_GET['do'];
    $t=array();
    if (!$u->is_admin()) {
        $tpl->set_vars(array('err' => $u->adminlogin()));
        $tpl->fetch('login.tpl');
        $t['auth'] = $tpl->get_tpl();
    } else {
        if($do=='logout'){
            $u->logout();
        }
        if ($do != '') {
            $engine->call_function($tpl,$u);
        }
        $t['adminmenu'] = $engine->showadminmenu($u);
    }
    $tpl->set_vars($t);
    $tpl->fetch('main.tpl');
    if ($_GET['a']!=1){
        $tpl->display();
    }else{
        echo $t['content'];
    }
} catch (Exception $exc) {
    $error = 'Ошибка в файле ' . $exc->getFile() . ' на строке ' . $exc->getLine() . '<br /> Сообщение: ' . $exc->getMessage() . ' Код ошибки: ' . $exc->getCode() . '<br /> Ход выполнения: ' . $exc->getTraceAsString();
    $t['content'].= $error;
    $tpl->set_vars($t);
    $tpl->fetch('main.tpl');
    $tpl->display();
    
}

?>
