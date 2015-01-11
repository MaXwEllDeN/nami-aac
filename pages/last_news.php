<?php
$db = Database::getInstance();
$page = $_REQUEST["page"];

$stm = $db->prepare("SELECT * FROM `nami_news` WHERE `id` > :page ORDER by `creation` DESC LIMIT :limit;");
$stm->bindValue(":page", $page * 5);
$stm->bindValue(":limit", $config["news_limit"], PDO::PARAM_INT);
$stm->execute();

while($data = $stm->fetch(PDO::FETCH_ASSOC)){

    $author = new Player(intval($data["author"]));
    $author = $author->getInfo();
    
    $main_content .= '
        <section class="content">
            <h3>'. $data["title"].'</h3>
            <p>'. $data["text"] .'</p>
            <span style="margin-top: 20px;" class="author">By <a href="index.php?subtopic=characters&name='. $author["name"].'">'. $author["name"].'</a> at '.
        date('d \of F Y, H:i A', $data["creation"]) .'</span>
        </section>';
    
}
?>