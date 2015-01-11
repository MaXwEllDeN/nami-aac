<?php
$player = new Player($_REQUEST["name"]);
$info = $player->getInfo();

if ($info){
    $acc = $player->getAccount();
    
    $main_content .= '
        <section class="content">
           <h3>Character information</h3>                       
           <table>
               <tr>
                   <td>Name</td>
                   <td>'. $info["name"] .'</td>
               </tr>
                <tr>
                   <td>Sex</td>
                   <td>'. (($info["sex"] == 0) ? "Female" : "Male") .'</td>
               </tr>
               <tr>
                   <td>Profession</td>
                   <td>'. $config["server"]["vocations"][$info["vocation"]] .'</td>
               </tr>
               <tr>
                   <td>Level</td>
                   <td>'. $info["level"] .'</td>
               </tr>';

    
    
    if ($TEMCASA) // Verificações caso o player tenha House
        $main_content .= '
               <tr>
                   <td>House</td>
                   <td><a href="#">Central Circle 1</a> (Edron)</td>
               </tr>';
    
    
    
    if ($TEMGUILD) // Verificações caso o player tenha guild
        $main_content .= '
               <tr>
                   <td>Guild membership</td>
                   <td>Leader of the <strong><a href="?subtopic=guilds&name=Headhunters">Headhunters</a></strong></td>
               </tr>';
    
    
    
    
    $main_content .= '
               <tr>
                   <td>Residence</td>
                   <td>'. $config["server"]["towns"][$info["town_id"]] .'</td>
               </tr>                       
               <tr>
                   <td>Last seen</td>';
    
    if ($row["lastlogin"] == 0)
        $main_content .= "
                    <td>Never logged in.</td>";
    else
        $main_content .= '
                   <td>'. date('d \of F Y, H:i A', $row["lastlogin"]) .'</td>';
    
    
    $main_content .= '
               </tr>';
        
    if ($info["comment"] != "")
        $main_content .= '
               <tr>
                   <td>Comment</td>
                   <td style="padding: 10px;"><span>'. $info["comment"] .'</span></td>';
    
    $main_content .= '           
               <tr>
                   <td>Account Status</td>';

    if ($acc->getPremDays() > 0)
        $main_content .= '
                   <td style="font-weight: bold; color: darkgreen">Premium Account</td>
        ';
    else
        $main_content .= '
                   <td style="font-weight: bold; color: darkred">Free Account</td>        
        ';

$main_content .= '
               </tr>
           </table>
        </section>      
    ';
    
    if ($info["hidden"] == 0){
        $main_content .= '
            <section class="content">
               <h3>Account information</h3>
                <table>
                    <tr>
                        <td>Created</td>
                        <td>'. date('d \of F Y, H:i A', $acc->getCreationTime()) .'</td>
                    </tr>

                    <tr>
                        <td>Real name</td>
                        <td>'. $acc->getRealName() .'</td>
                    </tr>
                </table>';

        $chars = array();

        foreach($acc->getCharacters() as $char){
            $aux = $char->getInfo();
            if ($aux["hidden"] == 0){
                array_push($chars, $char);
            }
        }

        if (count($chars) > 0){
            $main_content .= '
                <h3 style="border-color: transparent;">Characters</h3>
                <table>
                    <th>Name</th>
                    <th>World</th>                
                    <th>Status</th>
            ';

            foreach($chars as $char){
                $aux = $char->getInfo();
                $main_content .= '
                    <tr>
                        <td><a href="?subtopic=characters&name='. $aux["name"] .'">'. $aux["name"] .'</a></td>
                        <td>Thera</td>';

                if ($info["onlinetime"] > 0)
                    $main_content .= '
                        <td style="font-weight: bold; color: darkgreen">Online</td>';
                else
                    $main_content .= '
                        <td style="font-weight: bold; color: darkred">Offline</td>';

                $main_content .= '
                    </tr>';

            }
            
            $main_content .= '
                </table>';            
        }

        $main_content .= '        
            </section>';
    }
}elseif(!empty($_REQUEST["name"])){
    $error = '
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
                        <div class="Content">Could not find character</div>
                    </div>
                </div>

                <div class="Content">
                    <span>Character <b>'. $_REQUEST["name"] .'</b> does not exist.</span>
                </div>
            </div>            
    
    ';
}


$main_content .= '
        <section class="content">   
           '. $error .'        
           <h3>Search character</h3>
            <form style="display: inline" formaction="#" method="post">
                <input type="text" min="8" name="name" placeholder="Character name" required>
                <input type="submit" value="Search">
            </form>
       </section>        

';
?>
