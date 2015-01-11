<?php
error_reporting(E_ALL ^ E_NOTICE); // Diz para o PHP informar qualquer erro que aconteça    
ini_set('display_errors', 1);
?>

<?php
include("configs/config.php"); // Inclui arquivo de configurações

require_once "libs/class.database.php";
require_once "modules/class.player.php";

session_start(); // Inicia uma session

$subtopic = $_REQUEST["subtopic"]; /// Escolhe página a ser carregada
$action = $_REQUEST["action"];

if ($action == "logout"){
    session_unset("login");
}

if ($action == "login"){
    $subtopic = "login";    
}

if (empty($subtopic)){    
    $subtopic = "lastnews";    
}

$ACCOUNT = null;

if (isset($_SESSION["login"]))
    $ACCOUNT = new Account($_SESSION["login"]);

switch($subtopic){
    case "lastnews":
        include("pages/last_news.php");
        break;
    
    case "characters":
        include("pages/characters.php");
        break;
    
    case "createacc":
        if (!$ACCOUNT)
            include("pages/create_account.php");
        else{
            include("pages/last_news.php");
            $subtopic = "lastnews";
        }

        break;
    
    case "rules":
        include("pages/tibia_rules.php");
        break;
    
    case "guilds":
        include("pages/guilds.php");
        break;
    
    case "accountmanagement":
        if ($ACCOUNT)
            include("pages/account_management.php");
        else{
            include("pages/last_news.php");
            $subtopic = "lastnews";
        }

        break;    
    
    case "login";
        if ($ACCOUNT)
            include("pages/account_management.php");
        else
            include("pages/login.php");

        break;
    
    case "adminpanel":
        if ($ACCOUNT and $ACCOUNT->getAccess() >= 3)
            include("pages/admin_panel.php");
        else
            include("pages/last_news.php");

        break;    
    case "error":
        include("pages/error.php");
        break;
        
    default:        
        include("pages/error.php");
}


$db = Database::getInstance();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title><?php echo $config["server_name"] ?></title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <script src="js/main.js"></script>
    <script type="text/javascript" src="js/nicEdit.js"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() {
            new nicEditor({fullPanel : true}).panelInstance('area2');
        });
        //]]>
    </script>        
</head>

<body>    
    <header></header>

    <nav>
        <ul>
            <li><a href="index.php?subtopic=lastnews"><img class="icon" src="layout/img/icon/news.gif" alt=""> Home</a></li>
            <li><a href="index.php?subtopic=characters"><img class="icon" src="layout/img/icon/community.gif" alt=""> Community</a></li>
            <li><a href="index.php?subtopic=guilds"><img class="icon" src="layout/img/icon/guilds.gif" alt=""> Guilds</a></li>
<?php
// Se não estiver logado, mostra menu para logar
if (!$ACCOUNT)
    echo '
            <form formaction="#" method="post">
                <input type="password" min="8" name="login" placeholder="Account name" size="10" required>
                <input type="password" min="8" name="password" placeholder="Password" size="10" required>
                <input type="hidden" name="action" value="login">
                <input type="submit" value="Login">
                <a href="index.php?subtopic=createacc"><img class="icon" src="layout/img/icon/account.gif" alt=""> Create Account</a>
            </form>';

else{
// Caso esteja logado, mostre no menu as opções de gerenciar a conta
	echo '
			<li><a href="index.php?subtopic=accountmanagement"><img class="icon" src="layout/img/icon/book.gif" alt=""> Account Manager</a></li>
            <li style="float:right"><a href="index.php?action=logout"><img class="icon" src="layout/img/icon/exit.png" alt=""> Logout</a></li>';
    
    if ($ACCOUNT->getAccess() >= 3){
        echo '
			<li><a href="index.php?subtopic=adminpanel"><img style="position:relative;left: -8px;top: 3px;" src="layout/img/icon/admin.png" alt=""> Admin Panel</a></li>';        
    }
    
}
?>       
            
        </ul>
    </nav>

   <div class="container">
        <div class="menu_container">
            <div class="menu_content">
                <h2>Server Status</h2>
                <table>
                    <tr>
                        <td><img style="margin-bottom: 20%;" src="layout/img/warrior.png" alt=""></td>
                        <td style="color: darkred; font-weight: bold;">Server Offline.</td>
                    </tr>
                </table>
            </div>
            
            <div class="menu_content">
                <h2>Highscores</h2>
                <table>
<?php
$stm = $db->prepare("SELECT * FROM `players` ORDER BY `experience` DESC LIMIT 5;");
$stm->execute();
$counter = 0;

while($result = $stm->fetch(PDO::FETCH_ASSOC)){
    $counter++;
    
echo '
                    <tr>
                        <td><strong>'. $counter .'.</strong></td>
                        <td><a href="index.php?subtopic=characters&name='. $result["name"] .'">'. $result["name"].'</a></td>
                        <td class="level">Lvl. '. $result["level"].'</td>
                    </tr>
';
}
?>
        
                                                          
                </table>
            </div>              
                                           
        </div>                          
        
        <!--  Conteúdo do site  -->        
<?php
    echo $main_content;  // Inclui o conteúdo principal na página
?>    
    </div> 

    <footer><p>
        &copy; 2014 Nami Acc Maker.<a href="https://github.com/MaXwEllDeN/nami-aac" target="_blank"><img style="vertical-align: -50%%;" src="https://assets-cdn.github.com/favicon.ico" alt="Github"></a></p>
    </footer>
</body>

</html>
