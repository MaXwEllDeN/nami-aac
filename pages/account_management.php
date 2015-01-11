<?php
$account = '
       <section class="content">
            <h3>Account Management</h3>
            <center><h4 style="color: #25334a;">Welcome to your account, '. $ACCOUNT->getRealName() .'!</h4></center>            
            <div class="BoxInfo">
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
                        <div class="Content">Characters</div>
                    </div>
                </div>

                <div class="Content">
                    <table style="margin-top: 5px;">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 100%">Name</th>
                            <th>Description</th>
                            <th></th>
                        </tr>';

$counter = 0;
foreach($ACCOUNT->getCharacters() as $player){
    $char = $player->getInfo();
    $counter++;
    
    $account .= '
                        <tr onclick="activeCharacter(this)"';    
    if ($counter == 1)
        $account .= ' class = "active"';
    
    if ($char["deletion"] > 0)
        $account .= ' style="color:darkred;"';
              
    $account .= '>';
        
    
    $account .= '
                            <td>'. $counter .'.</td>
                            <td>
                            '. $char["name"] .'.<br/>                            
                            '. $config["server"]["vocations"][$char["vocation"]] .' - Level '. $char["level"] .'
                            </td>';
    if ($char["hidden"] == 0)
        $account .= '
                            <td></td>';
    else
        $account .= '
                            <td>hidden</td>';
    
    if ($counter == 1)
        $account .= '
                            <td class="action" style="font-weight: 100;">';
    else
        $account .= '
                            <td class="action" style="font-weight: 100; display:none;">';                            
                            
    $account .= '
                                <center>
                                    <a href="index.php?subtopic=accountmanagement&show=editcharacter&character='. $char["name"] .'">[Edit]</a>
                                    <a href="index.php?subtopic=accountmanagement&show=deletecharacter&character='. $char["name"];
                                    
    if ($char["deletion"] == 0)
        $account .= '
            ">[Delete]</a>
        ';    
    else
        $account .= '
            " style="font-weight: bold; color:darkred">[Undelete]</a>
        ';    
    $account .= '
                                    
                                </center>
                            </td>
                        </tr>';
}

$account .= '
                    </table>                        
                </div>
            </div>        
        </section>
';

$char_error =  '
       <section class="content">
            <h3>Error</h3>        
            <p style="color:red;">Character does not exist in this account!</p>
        </section>
        
';

if (($_GET["show"] == "deletecharacter" or $_GET["show"] == "editcharacter") and !empty($_GET["character"])){
    $db = Database::getInstance();
    $player = null;
    $char_count = 0;
    
    foreach($ACCOUNT->getCharacters() as $char){
        $char_count++;
        $info = $char->getInfo();
        if (strtolower($info["name"]) == strtolower($_GET["character"])){
            $player = $char->getInfo();
            break;
        }        
        
    }
    
    if (!$player) // Se o personagem não existir na conta do usuário
        $main_content .= $char_error;  
    elseif ($_GET["show"] == "editcharacter"){ // Conteúdo da página para editar um personagem        
        if ($_POST["action"] == "edit_character"){
            if (strlen($_POST["comment"]) > 0 and strlen($_POST["comment"]) < 10){
                $error_box = HTML_Box("Error", "<span>Your comment have few words.</span>");           
            }
            else{
                $stm = $db->prepare("UPDATE `players` SET `hidden` = :hidden, `comment` = :comment WHERE `id` = :id;");

                if ($_POST["accountvisible"] == "hidden")
                    $stm->bindValue(":hidden", 1);
                else
                    $stm->bindValue(":hidden", 0);

                $stm->bindValue(":comment", $_POST["comment"]);
                $stm->bindValue(":id", $player["id"]);
                $stm->execute();

                header("Location: index.php?subtopic=accountmanagement");
                return true;                            
            }
            

        }
        
        $main_content .= '
       <section class="content">
            <h3>Edit Character Information</h3>
            '. $error_box .'
            <div class="BoxInfo" style="margin-bottom: 30px">
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
                        <div class="Content">Character data</div>
                    </div>
                </div>

                <div class="Content">
                    <table>
                        <tr>
                            <td style="width:10%"><strong>Name</strong></td>
                            <td>'. $player["name"] .'</td>
                        </tr>
                        <tr>
                            <td><strong>Sex</strong></td>';
            if ($player["sex"] == 0)
                $main_content .= '
                                <td>Female</td>';
            else
                $main_content .= '
                                <td>Male</td>';

            $main_content .= '
                            </tr>
                        </table>
                    </div>
                </div>
                <form action="#" method="post">
                    <input type="hidden" name="action" value="edit_character">
                    <table>
                        <tr>
                            <td>Hide Account</td>';

            if ($player["hidden"] == 1)
                $main_content .= '
                            <td><input type="checkbox" name="accountvisible" value="hidden" checked/> check to hide your account information</td>';
            else
                $main_content .= '
                            <td><input type="checkbox" name="accountvisible" value="hidden"/> check to hide your account information</td>';

            $main_content .= '
                        </tr>

                        <tr>
                            <td>Comment</td>
                            <td><textarea name="comment" rows="10" cols="50">'. $player["comment"] .'</textarea></td>
                        </tr>

                        <tr>
                            <td><input type="submit" value="Submit"></td>
                            <td><input type="submit" value="Back"></td>
                        </tr>
                    </table>
                </form>

           </section>
    ';
    }    
    elseif ($_GET["show"] == "deletecharacter"){ // Conteúdo da Página para deletar um personagem
        if ($player["deletion"] == 0){
            if ($_POST["action"] == "delete_character" and !empty($_POST["password"])){
                if ($ACCOUNT->getPassword() != $_POST["password"]){
                    $main_content .= '            
                    <script type="text/javascript">window.setTimeout("location.href=\'index.php?subtopic=accountmanagement\';", 3000);</script>            
                    <section class="content">
                        <h3>Delete Character</h3>
                        <h4 style="text-align: center; color:darkred">Password is not correct!</h4>
                    </section>';
                }else{
                    $stm = $db->prepare("UPDATE `players` SET `deletion` = :delete WHERE `id` = :id;");
                    $stm->bindValue(":delete", time() + $config["days_to_delete"] * 86400);
                    $stm->bindValue(":id", $player["id"]);
                    $stm->execute();

                    $main_content .= '
                    <script type="text/javascript">window.setTimeout("location.href=\'index.php?subtopic=accountmanagement\';", 10000);</script>            
                    <section class="content">
                        <h3>Delete Character</h3>
                        <h4 style="text-align: center; color:darkred">The character '. $player["name"] .' has been scheduled for deletion. It will be removed permanently from your account on '. date('d \of F Y, H:i A', time() + $config["days_to_delete"] * 86400) . '.</h4>
                    </section>';

                }

            }
            else{
                if (count($ACCOUNT->getCharacters()) == 1)
                    $main_content .= '            
                    <script type="text/javascript">window.setTimeout("location.href=\'index.php?subtopic=accountmanagement\';", 3000);</script>            
                    <section class="content">
                        <h3>Delete Character</h3>
                        <h4 style="text-align: center; color:darkred">You can not delete your only character.</h4>
                    </section>';
                else{
                    $main_content .= '
                    <section class="content">
                        <h3>Delete Character</h3>
                        <span>To delete this character enter your password and click on "Submit".<br>
            You can undelete the character within the first '. $config["days_to_delete"] .' day(s) after the deletion.<br>
            After this time the character is deleted for good and cannot be restored anymore!<br></span>

                        <form action="#" method="post" style="margin-top: 20px;">
                            <input type="hidden" name="action" value="delete_character">
                            <table>
                                <tr>
                                    <td><strong>Character Name</strong></td>
                                    <td><strong style="color:darkblue">'. $_GET["character"] .'</strong></td>
                                </tr>

                                <tr>
                                    <td><strong>Password</strong></td>
                                    <td><input type="password" placeholder="Your password" name="password" required></textarea></td>
                                </tr>

                                <tr>
                                    <td><input type="submit" value="Submit"></td>
                                    <td><input type="submit" value="Back">AEAEHUHAEUHUE</td>
                                </tr>
                            </table>
                        </form>      

                    </section>';
                }
            }
        }
        else{
            if ($_POST["action"] == "delete_character"){
                $stm = $db->prepare("UPDATE `players` SET `deletion` = :delete WHERE `id` = :id;");
                $stm->bindValue(":delete", 0);
                $stm->bindValue(":id", $player["id"]);
                $stm->execute();
                
                $main_content .= '
                    <script type="text/javascript">window.setTimeout("location.href=\'index.php?subtopic=accountmanagement\';", 5000);</script>            
                    <section class="content">
                        <h3>Delete Character</h3>
                        <h4 style="text-align: center; color:darkgreen">The character '. $player["name"] .' has been removed from delete schedule.</h4>
                    </section>';            
            }else
                $main_content .= '     
                    <section class="content">
                        <h3>Delete Character</h3>
                        <h4 style="text-align: center; color:darkred">The character '. $player["name"] .' has been scheduled for deletion. It will be removed permanently from your account on '. date('d \of F Y, H:i A', $player["deletion"]) . '.</h4>                    
                        <form action="#" method="post" style="margin-top: 20px;">
                            <input type="hidden" name="action" value="delete_character">
                            <center><input style="font-size: 16px; font-weight:bold;" type="submit" value="Undelete '. $player["name"] .'"></center>
                        </form>
                    </section>';
        }
    }
}
else
    $main_content .= $account; // Conteúdo da página Account Management
?>