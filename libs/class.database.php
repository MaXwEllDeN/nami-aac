<?php
/**
 * Classe que conversa com o banco de dados
 **/

class Database{
    public static $instance;
    
    private function __construct(){
        // EMPTY
    }
    public static function getInstance(){        
        if (!isset(self::$instance)){
            $dns = $GLOBALS["config"]["db_driver"] .":host=". $GLOBALS["config"]["db_host"] . ";dbname=". $GLOBALS["config"]["db_name"];
            //array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            self::$instance = new PDO($dns, $GLOBALS["config"]["db_user"], $GLOBALS["config"]["db_pass"]);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
          }
        
        return self::$instance;
    }
    
}
?>
