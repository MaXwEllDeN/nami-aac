<?php
require_once "class.player.php";
class Account{
    private $id, $name, $password, $email, $premdays, $creation, $real_name, $access;
    private $characters = array(); 
    
    public function __construct($param){
        $db = Database::getInstance();
        $query = "SELECT * FROM `accounts` WHERE `";
        
        if (is_integer($param))
            $query .= "id` = :param;";
        else
            $query .= "name` = :param;";

        $stm = $db->prepare($query);
        $stm->bindValue(":param", $param);        
        $stm->execute();
        
        $row = $stm->fetch(PDO::FETCH_ASSOC);        

        if (!$row)
            return false;
        
        $this->id = $row["id"];
        $this->name = $row["name"];
        $this->password = $row["password"];
        $this->email = $row["email"];
        $this->premdays = $row["premdays"];
        $this->realName = $row["real_name"];
        $this->creation = $row["creation"]; 
        $this->access = $row["type"];
        
        $stm = $db->prepare("SELECT * FROM `players` WHERE `account_id` = :acc;");
        $stm->bindValue(":acc", $row["id"]);        
        $stm->execute();
        
        while ($player = $stm->fetch(PDO::FETCH_ASSOC)){
            array_push($this->characters, new Player($player["name"], false));
        }        
    }
    
    public function getRealName(){
        return $this->realName;
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    public function getAccess(){
        return $this->access;
    }
    public function getCreationTime(){
        return $this->creation;
    }
    
    public function getPremDays(){
        return $this->premdays;
    }
    
    public function getCharacters(){
        return $this->characters;
    }
    
}
?>