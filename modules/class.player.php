<?php
require_once "class.account.php";

class Player{
    private $info, $account; 
    
    public function __construct($param, $aux = true){
        $db = Database::getInstance();
        
        $query = "SELECT * FROM `players` WHERE `";
        
        if (is_integer($param))
            $query .= "id` = :param;";
        else
            $query .= "name` = :param;";
        
        
        $stm = $db->prepare($query);
        $stm->bindParam(":param", $param);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        
        
        if (!$result)
            return false;
        
        if ($aux)
            $this->account = new Account(intval($result["account_id"]));
        
        $this->info = array();
            
        foreach($result as $index => $value){
            $this->info[$index] = $value;
        }        
    }
    
    public function getInfo(){
        return $this->info;
    }    
    
    public function getAccount(){
        return $this->account;
    }
}
?>