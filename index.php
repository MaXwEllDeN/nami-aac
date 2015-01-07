<?php
ini_set("memory_limit",-1);
error_reporting(E_ALL ^ E_NOTICE); // Diz para o PHP informar qualquer erro que aconteça    
include("configs/config.php"); // Inclui arquivo de configurações

require_once "libs/class.database.php";
require_once "modules/class.player.php";

session_start(); // Inicia uma session

$subtopic = $_REQUEST["subtopic"]; /// Escolhe página a ser carregada

$account_logged = $_SESSION["login"]; // Pega a sessão do usuário

if (empty($subtopic)){    
    $subtopic = "lastnews";    
}

switch($subtopic){
    case "lastnews":
        include("pages/last_news.php");
        break;
    
    case "characters":
        include("pages/characters.php");
        break;
    
    case "createacc":
        if (!$account_logged)
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
        if ($account_logged)
            include("pages/account_management.php");
        else{
            include("pages/last_news.php");
            $subtopic = "lastnews";
        }

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
if (!$account_logged)
    echo '
            <form formaction="#" method="post">
                <input type="text" min="8" name="login" placeholder="Account name" size="10" required>
                <input type="password" min="8" name="password" placeholder="Password" size="10" required>
                <input type="hidden" name="action" value="login">
                <input type="submit" value="Login">
                <a href="index.php?subtopic=createacc"><img class="icon" src="layout/img/icon/account.gif" alt=""> Create Account</a>
            </form>
    ';

else
// Caso esteja logado, mostre no menu as opções de gerenciar a conta	
	echo '
			<li><a href="index.php?subtopic=accountmanagement"><img class="icon" src="layout/img/icon/book.gif" alt=""> Account Manager</a></li>
';
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
        
        <!-- Conteúdo do Website -->
        
<?php
    echo $main_content;  // Inclui o conteúdo principal na página
?>    
    </div> 

    <footer><p>
        &copy; 2014 Nami Acc Maker.<a href="https://github.com/MaXwEllDeN/nami-aac" target="_blank"><img style="vertical-align: -50%%;" src="https://assets-cdn.github.com/favicon.ico" alt="Github"></a></p>
    </footer>
</body>

</html>
