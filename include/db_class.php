<?php

class Db {

    private $db;
    public $dbn;
    private $res;
    private $eng;
    private $tpl;
    private $debug; 

    function __construct(&$e='',&$t='',&$u='') {
        $this->debug = Main_config::$debug;
        if ($e!=''){
            $this->eng=$e;
        }
        if ($t!=''){
            $this->tpl->$t;
        }
        
        @ $this->db = new mysqli(Main_config::$host, Main_config::$user, Main_config::$password);
        if (mysqli_connect_errno ()) {
            throw new Exception(_MYSQLCONNECTERROR, 1);
        } else {
            $this->db->select_db(Main_config::$db);
            $this->dbn=$this->db;
        }
    }

    function query($sql) {
        if ($this->debug==1){
            echo $sql.'<br>';
        }
        switch (strtoupper(substr($sql, 0, 6))) {
            case 'SELECT':
                if (!$this->res=$this->db->query($sql)){
                    throw new Exception(_MYSQLQUERYERROR, 3);
                }
                break;
            case 'INSERT':
                if (!$this->res=$this->db->query($sql)){
                    throw new Exception(_MYSQLQUERYERROR, 3);
                };
                break;
            case 'UPDATE':
                if (!$this->res=$this->db->query($sql)){
                    throw new Exception(_MYSQLQUERYERROR, 3);
                };
                break;
            case 'DELETE':
                if (!$this->res=$this->db->query($sql)){
                    throw new Exception(_MYSQLQUERYERROR, 3);
                };
                break;                
            default:
                echo'otheer';
                break;
        }
    }
    function num_rows(){
        return $this->res->num_rows;
    }
    function fetch_array(){
        return $this->res->fetch_array();
    }
    function fetch_object(){
        return $this->res->fetch_object();
    }
    function  __destruct() {
        $this->db->close();
    }
    function mres($var){
        return $this->db->real_escape_string($var);
    }
}
