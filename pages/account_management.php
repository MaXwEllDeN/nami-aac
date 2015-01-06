<?php
$account = '
       <section class="content">
            <h3>Account Management</h3>
            <center><h4 style="color: #25334a;">Welcome to your account Maxwell!</h4></center>            
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
                        </tr>
                        <tr class = "active" onclick="activeCharacter(this)">
                            <td>1.</td>
                            <td>
                            Max Kion<br/>                            
                            Elite Knight - Level 180
                            </td>
                            <td></td>
                            <td class="action" style="font-weight: 100;">
                                <center>
                                    <a href="index.php?subtopic=accountmanagement&show=editcharacter&character=Max Kion">[Edit]</a>
                                    <a href="index.php?subtopic=accountmanagement&show=deletecharacter&character=Max Kion">[Delete]</a>
                                </center>
                            </td>
                        </tr>           

                        <tr onclick="activeCharacter(this)">
                            <td>2.</td>
                            <td>
                            Gandowlf<br/>                            
                            Elder Druid - Level 178
                            <td>hidden</td>
                            
                            <td class="action" style="font-weight: 100; display:none;">
                                <center>
                                    <a href="index.php?subtopic=accountmanagement&show=editcharacter&character=Gandowlf">[Edit]</a>
                                    <a href="index.php?subtopic=accountmanagement&show=deletecharacter&character=Gandowlf">[Delete]</a>
                                </center>
                            </td>
                        </tr>                                                                            
                    </table>                        
                </div>
            </div>        
        </section>
';

$edit = '
       <section class="content">
            <h3>Edit Character Information</h3>
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
                            <td>Max Kion</td>
                        </tr>
                        <tr>
                            <td><strong>Sex</strong></td>
                            <td>Male</td>
                        </tr>
                    </table>
                </div>
            </div>
            <form action="#" method="get">
                <input type="hidden" name="action" value="edit_character">
                <table>
                    <tr>
                        <td>Hide Account</td>
                        <td><input type="checkbox" name="accountvisible"  value="hidden"/> check to hide your account information</td>
                    </tr>

                    <tr>
                        <td>Comment</td>
                        <td><textarea name="comment" rows="10" cols="50"></textarea></td>
                    </tr>

                    <tr>
                        <td><input type="submit" value="Submit"></td>
                        <td><input type="submit" value="Back"></td>
                    </tr>
                </table>
            </form>
            
       </section>
';


$char_error =  '
       <section class="content">
            <h3>Edit Character Information</h3>        
            <p style="color:red;">Character does not exist in this account!</p>
        </section>
        
';

if (($_GET["show"] == "deletecharacter" or $_GET["show"] == "editcharacter") and !empty($_GET["character"])){
    $char = strtolower($_GET["character"]);

    if ($char != "max kion") // Se o personagem não existir na conta do usuário
        $main_content .= $char_error;    
    elseif ($_GET["show"] == "editcharacter") // Conteúdo da página para editar um personagem
        $main_content .= $edit;    
    elseif ($_GET["show"] == "deletecharacter") // Conteúdo da Página para deletar um personagem
        $main_content .= '
        <section class="content">
            <h3>Delete Character</h3>
            <span>To delete this character enter your password and click on "Submit".<br>
You can undelete the character within the first 2 months (60 days) after the deletion.<br>
After this time the character is deleted for good and cannot be restored anymore!<br></span>
      
            <form action="#" method="get" style="margin-top: 20px;">
                <input type="hidden" name="action" value="edit_character">
                <table>
                    <tr>
                        <td><strong>Character Name</strong></td>
                        <td><strong style="color:darkblue">'. $_GET["character"] .'</strong></td>
                    </tr>

                    <tr>
                        <td><strong>Password</strong></td>
                        <td><input type="text" placeholder="Your password" name="password" required></textarea></td>
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
else
    $main_content .= $account; // Conteúdo da página Account Management
?>