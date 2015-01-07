<?php

$config = array(    
    // Server Info
    "server_name" => "Nami",
    
    // Database Config    
    "db_driver" => "mysql",
    "db_host" => "localhost",
    "db_name" => "otserver",
    "db_user" => "root",
    "db_pass" => "asdjkl123",    
    
    // SMTP Config
    "smtp_host" => "mx1.hostinger.com.br",
    "smtp_port" => "2525",
    "smtp_user" => "no-reply@nami.esy.es",
    "smtp_pass" => "",
    
    
    "server" => array(
        "vocations" => array(
            0 => "No Vocation",
            1 => "Sorcerer",
            2 => "Druid",
            3 => "Paladin",
            4 => "Knight",
            5 => "Master Sorcerer",
            6 => "Elder Druid",
            7 => "Royal Paladin",
            8 => "Elite Knight"
                        
        ),
        
        "towns" => array(
            0 => "Thais" ,
            1 => "Liberty Bay"
        )
        
        
    )
);



?>