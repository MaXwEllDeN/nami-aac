<?php

if (empty($_REQUEST["login"]) or empty($_REQUEST["password"]))
    return include("last_news.php");

$main_content .= '
        <section class="content">
            <h3>Login</h3>';

$acc = new Account($_REQUEST["login"]);

if ($acc->getPassword() != $_REQUEST["password"])
    $main_content .= '<center><h4 style="color: darkred;">Invalid Account Name or Password.</h4></center>';
else{
    $main_content .= "<script type=\"text/javascript\">window.setTimeout(\"location.href='index.php?subtopic=accountmanagement';\", 3000);</script>";       
    $main_content .= '<center><h4 style="color: darkgreen;">You have logged in successfully.</h4></center>';    
    $_SESSION["login"] = $_REQUEST["login"];    
}

$main_content .= '
        </section>';

?>