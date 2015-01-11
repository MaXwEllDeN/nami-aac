<?php
$db = Database::getInstance();

if ($_GET["page"] == "news"){    
    if ($_GET["show"] == "editnews"){
        $main_content .= '
            <section class="content">
                <h3>Admin Panel ~ Edit news</h3>';
        
        if ($_POST["action"] == "update"){
            if ($_POST["text"] == "<br>" or empty($_POST["text"])){
                $main_content .= HTML_Box("Error", '<span style="color:darkred; font-weight: bold;">Text field can not be empty.</span>');
            }
            else{
                $stm = $db->prepare("UPDATE `nami_news` SET `author` = :author, `text` = :text, `creation` = :create WHERE `id` = :id;");
                $stm->bindValue(":author", $_POST["author"]);
                $stm->bindValue(":text", $_POST["text"]);
                $stm->bindValue(":create", time());
                $stm->bindValue(":id", $_POST["id"], PDO::PARAM_INT);
                $stm->execute();
                
                $main_content .= "<script type=\"text/javascript\">window.setTimeout(\"location.href='index.php?subtopic=adminpanel&page=news';\", 3000);</script>";   
                $main_content .= HTML_Box("Success", '<span style="font-weight: bold; color:darkgreen;">Post successfully edited.</span>');            
                
            }
            
        }
        
        $stm = $db->prepare("SELECT * FROM `nami_news` WHERE `id` = :id;");
        $stm->bindValue(":id", $_GET["id"]);
        $stm->execute();
        
        $data = $stm->fetch(PDO::FETCH_ASSOC);
        
        if (count($data) != 1){
            $author = new Player(intval($data["author"]));
            $main_content .= '
                <form action="index.php?subtopic=adminpanel&page=news&id='. $_GET["id"] .'&show=editnews" method="post" id="form_news">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="'. $data["id"] .'">
                    <table>                
                        <tr>
                            <td>Title</td>
                            <td><input type="text" name="title" size="70" value="'. $data["title"] .'" required></td>
                        </tr>

                        <tr>
                            <td>Author</td>
                            <td>
                                <select name="author" form="form_news">
                                    <option value="'. $data["id"] .'">'. $author->getInfo()["name"] .'</option>';
            
            foreach($ACCOUNT->getCharacters() as $char){
                $player = $char->getInfo();
                if (intval($player["id"]) != $data["author"])
                    $main_content .= '<option value="'. $player["id"] .'">'. $player["name"] .'</option>';
            }

            $main_content .= '
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td>Text</td>
                            <td>
                                <textarea style="height: 100px;" cols="70" id="area2" name="text">'. $data["text"] .'</textarea>
                            </td>
                        </tr>                    
                    </table> 
                    <center>
                        <input type="submit" value="Send" onclick="nicEditors.findEditor(\'area2\').saveContent();">
                    </center>
                </form>
            </section>';
        }
        else
            $main_content .= '<h4 style="color: darkred; text-align:center">Our servers could not find this post.</h4>';
            
        $main_content .= '
            </section>
        ';
    }
    elseif ($_GET["show"] == "addnews"){
        $main_content .= '
            <section class="content">
                <h3>Admin Panel ~ News</h3>';
        
        if ($_POST["action"] == "add"){
            if ($_POST["text"] == "<br>" or empty($_POST["text"])){
                $main_content .= HTML_Box("Error", "Text field can not be empty.");
            }
            else{
                $stm = $db->prepare("INSERT INTO `nami_news`(title, author, text, creation) VALUES(:title, :author, :text, :create);");
                $stm->bindValue(":title", $_POST["title"]);
                $stm->bindValue(":author", $_POST["author"]);
                $stm->bindValue(":text", $_POST["text"]);
                $stm->bindValue(":create", time());
                $stm->execute();
                
                $main_content .= HTML_Box("Success", "Your news has been successfully posted.");
            }
            
        }
        
        $main_content .= '
                <form action="index.php?subtopic=adminpanel&page=news&show=addnews" method="post" id="form_news">
                    <input type="hidden" name="action" value="add">
                    <table>                
                        <tr>
                            <td>Title</td>
                            <td><input type="text" name="title" size="70" required></td>
                        </tr>

                        <tr>
                            <td>Author</td>
                            <td>
                                <select name="author" form="form_news">';
        foreach($ACCOUNT->getCharacters() as $char){
            $player = $char->getInfo();
            $main_content .= '<option value="'. $player["id"] .'">'. $player["name"] .'</option>';
        }

        $main_content .= '
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td>Text</td>
                            <td>
                                <textarea style="height: 100px;" cols="70" id="area2" name="text"></textarea>
                            </td>
                        </tr>                    
                    </table> 
                    <center>
                        <input type="submit" value="Send" onclick="nicEditors.findEditor(\'area2\').saveContent();">
                    </center>
                </form>
            </section>';
    }
    else{
        $main_content .= '
            <section class="content">
                <h3>Admin Panel ~ News</h3>
                
                <table>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Created on</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>';
        
        $stm = $db->prepare("SELECT * FROM `nami_news` ORDER BY `creation` DESC;");
        $stm->execute();

        while($data = $stm->fetch(PDO::FETCH_ASSOC)){
            $author = new Player(intval($data["author"]));
            $author = $author->getInfo();        
            
            $main_content .= '
                    <tr>
                        <td>'. $data["id"] .'</td>
                        <td><a href="index.php?subtopic=lastnews&id='. $data["id"] .'">'. $data["title"] .'</a></td>
                        <td><a href="index.php?subtopic=characters&name='. $author["name"].'">'. $author["name"] .'</a></td>
                        <td>'. date('d \of F Y, H:i A', $data["creation"]) .'</td>
                        
                        <td><a href="index.php?subtopic=adminpanel&page=news&show=editnews&id='. $data["id"] . '">
                            <img src="layout/img/pencil_small.png" alt="Edit">
                        </a></td>    
                        
                        <td><a href="">
                            <img src="layout/img/erase.png" alt="Delete">
                        </a></td>
                    </tr>';            
        }
        
        $main_content .= '
                </table>
                <a href="index.php?subtopic=adminpanel&page=news&show=addnews">Create</a>
            </section>';
    }
}
else
    $main_content .= '
        <section class="content">
            <h3>Admin Panel</h3>            
            <center>            
                <table style="width:20%; margin-top: 20px;">            
                <tr >
                    <td class="apanel_icon"><a href="index.php?subtopic=adminpanel&page=news"><img src="layout/img/document.png" alt=""><br>News</a></td>
                    <td class="apanel_icon"><a href="index.php?subtopic=adminpanel&page=shop"><img src="layout/img/cart.png" alt=""><br>Shop</a></td>
                    <td class="apanel_icon"><a href="index.php?subtopic=adminpanel&page=tickets"><img src="layout/img/tickets.png" alt=""><br>Tickets</a></td>
                </tr>
                </table>
            </center>                            
        </section>
';
?>