<?php

class Template {

    private $vars=array();
    private $contents;
    private $path='templates/';
    private $pathjs = 'js/';
    private $pathcss = 'css/';
    var $menu = '';

    public function fetch($file) {
        if (file_exists($this->path . $file)) {

            ob_start();
            $path = $this->path;
            if (isset($this->vars)) {
                extract($this->vars);
            }
            include($this->path . $file);
            $this->contents = ob_get_contents();
            ob_end_clean();
            return true;
        } else {
            throw new Exception(_NOTEXISTTEMPLATE . $file, 2);
            return false;
        }
    }

    public function get_tpl() {
        return $this->contents;
    }

    public function display() {
        echo $this->contents;
    }

    public function set_vars($vars=array(),$e=1) {
        foreach ($vars as $key=>$var) {
            if ($e==1){
                $this->vars[$key]=$var;
            }else{
                $this->vars[$key].=$var;
            }
        }
    }

    public function clear_vars() {
        unset($this->vars);
    }
    public function set_path($path){
        $this->path=$path;
    }
    public function set_path_js($path){
        $this->pathjs=$path;
    }
    public function set_path_css($path){
        $this->pathcss=$path;
    }
    public function addjs($filename='common'){
        $sc = '<script type="text/javascript" src="'.$this->pathjs.$filename.'.js"></script>'."\n\t"; 
        $this->set_vars(array('headscripts'=>$sc), 0);
    }
    public function addcss($filename='styles'){
        $sc = '<link rel="stylesheet" type="text/css" href="'.$this->pathcss.$filename.'.css" media="all" />'."\n\t";
        $this->set_vars(array('headcss'=>$sc), 0);
    }    
    function xss($s){
        return htmlspecialchars($s,ENT_QUOTES);
        return $s;
    }

//		private function load_vars($file){
//        if(file_exists($this->path.$file)){
//						$file=file($this->path.$file);
//						foreach($file as $cur){
//						    if (strlen($cur)>1){
//										$temp_arr=explode('=',$cur);
//										$this->vars_inner[$temp_arr[0]]=$temp_arr[1];
//								}
//						}
//				    return true;
//				}else{
//            return false;
//        }
//		}
}
?>
