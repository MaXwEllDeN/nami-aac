<?php

$config = array(    
    // Server Info
    "server_name" => "Nami",
    "days_to_delete" => 10, // Quantos dias para deletar um personagem marcado para ser excluído
    "news_limit" => 5, // Quantas notícias mostrará por página.
    
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
    
    // Server Configs
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


function HTML_Box($title, $content){
    
    return '    
<div class="BoxInfo" style="margin-top: 20px; margin-bottom: 20px;">
   <div class="CaptionContainer">
        <div class="Caption">
            <span class="borderEdge" style="top: -2px; left: -2px;"/></span>
            <span class="borderEdge" style="top: -2px; right: -2px;"/></span>                    
            <span class="borderH" style="top: -1px;"></span>
            <span class="borderV" style="left: -1px;"/></span>
            <span class="borderV" style="right: -1px;"/></span>
            <span class="borderH" style="bottom: -2px;"></span>                    
            <span class="borderEdge" style="left: -2px; bottom: -3px;"></span>
            <span class="borderEdge" style="right: -2px; bottom: -3px;"></span>
            <div class="Content">'. $title . '</div>
        </div>
    </div>

    <div class="Content">
        '. $content .'
    </div>
</div>';
    
}

?>