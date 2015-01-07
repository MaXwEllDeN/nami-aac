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
                   <td>Last seen</td>
                   <td>'. date('m/d/Y, H:i:s', $row["lastlogin"]) .'</td>
               </tr>            
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
                        <td>May 25 2011, 03:26:05 CEST</td>
                    </tr>

                    <tr>
                        <td>Real name</td>
                        <td>Maxwell</td>
                    </tr>

                    <tr>
                        <td>Skype</td>
                        <td><strong>MaXwEllDeN</strong></td>
                    </tr>
                </table>
                ';

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
                    </tr>                              
                </table>';

            }
        }

        $main_content .= '        
            </section>';
    }
}    


$main_content .= '
        <section class="content">
           <h3>Search character</h3>
           
            <form style="display: inline" formaction="#" method="post">
                <input type="text" min="8" name="name" placeholder="Character name" required>
                <input type="submit" value="Search">
            </form>
       </section>        

';
?>
