
<?php
if ($_POST["action"] == "register"){
    $errors = "";
    $data = array("account_name", "email", "password", "checkpassword", "real_name", "character_name", "character_sex", "terms");

    foreach($data as $value){
        if (empty($_POST[$value])){
            
            switch($value){
                case "account_name";
                    $errors .= "Please enter an account name!<br>";
                    break;
                case "email";
                    $errors .= "Please enter your email address!<br>";
                    break;
                case "password";
                    $errors .= "Please enter a password!<br>";
                    break;
                case "checkpassword";
                    $errors .= "Please verify your password!<br>";
                    break;
                case "real_name";
                    $errors .= "Please enter your name!<br>";
                    break;
                case "character_name";
                    $errors .= "Please enter your character name!<br>";
                    break;
                case "character_sex";
                    $errors .= "Please choose your character sex!<br>";
                    break;            
                case "terms";
                    $errors .= "Please accept the rules!<br>";
                    break;            

            }        
        }
    }
    
    $db = Database::getInstance();
    
    $stm = $db->prepare("SELECT * FROM `accounts` WHERE `name` = :name;");
    $stm->bindValue(":name", $_POST["account_name"]);
    $stm->execute();
    
    if ($stm->fetch(PDO::FETCH_ASSOC))// Se retornar alguma coisa
        $errors .= "This Account Name is already used. Please select another one!<br>";
    else{
        $allowed = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
        
        if (strlen($_POST["account_name"]) != strspn($_POST["account_name"], $allowed))
            $errors .= "Account Name contains illegal chars (a-z, A-Z and 0-9 only!).<br>";        
    }
        
    
    $stm = $db->prepare("SELECT * FROM `accounts` WHERE `email` = :email;");
    $stm->bindValue(":email", $_POST["email"]);
    $stm->execute();
    
    if ($stm->fetch(PDO::FETCH_ASSOC))// Se retornar alguma coisa
        $errors .= "This email address is already used. Please enter another email address!<br>";
        
    if (strlen($_POST["password"]) < 8 or strlen($_POST["password"]) > 30)
        $errors .= "The password must have at least 8 and less than 30 letters!<br>";
        
    if ($_POST["password"] != $_POST["checkpassword"])
        $errors .= "Passwords does not match!<br>";
    else{
        $allowed = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789- ";
        
        if (strlen($_POST["password"]) != strspn($_POST["password"], $allowed))
            $errors .= "Password contains illegal chars (a-z, A-Z and 0-9 only!) or length.<br>";
    }
    
    $stm = $db->prepare("SELECT * FROM `players` WHERE `name` = :name;");
    $stm->bindValue(":name", $_POST["character_name"]);
    $stm->execute();
               
    if ($stm->fetch(PDO::FETCH_ASSOC))
        $errors .= "This Character Name is already used. Please select another one!<br>";
               
    $allowed = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM ";
        
    if (strlen($real_name) > 22 or strlen($_POST["real_name"]) != strspn($_POST["real_name"], $allowed))
            $errors .= "Real Name contains illegal chars (a-z and A-Z only!) or lenght.<br>";
    
    if ($errors != "")
        $content_box = HTML_Box("Error", "<span style=\"color:red;\">". $errors . "</span>");
    else{
        $stm = $db->prepare("INSERT INTO `accounts`(name, password, email, creation, real_name) VALUES(:name, :password, :email, :creation, :real);");
        $stm->bindValue(":name", $_POST["account_name"]);
        $stm->bindValue(":password", $_POST["password"]);
        $stm->bindValue(":email", $_POST["email"]);
        $stm->bindValue(":creation", time());
        $stm->bindValue(":real", $_POST["real_name"]);
        $stm->execute();
        
        // Criando personagem
        $stm = $db->prepare("SELECT `id` FROM `accounts` WHERE name = :name;");
        $stm->bindValue(":name", $_POST["account_name"]);
        $stm->execute();
        $acc_id = $stm->fetch(PDO::FETCH_ASSOC)["id"];
        
        $stm = $db->prepare("INSERT INTO `players`(name, account_id, vocation, town_id, sex) VALUES(:name, :account_id, :vocation, :town, :sex);");
        $stm->bindValue(":name", $_POST["character_name"]);
        $stm->bindValue(":account_id", $acc_id);
        $stm->bindValue(":vocation", 0);
        $stm->bindValue(":town", 0);
        $stm->bindValue(":sex", $_POST["character_sex"]);
        $stm->execute();
    

        $box = "<span style=\"color: darkgreen; font-weight: bold;\">Your account has been successfully created.</span>";
        $content_box = HTML_Box("Account created!", $box);        
        $main_content .= "<script type=\"text/javascript\">window.setTimeout(\"location.href='index.php';\", 5000);</script>";   
        
        $_SESSION["login"] = $_POST["account_name"];
    }        
        
}

$main_content .= '
        <section class="content">
            '. $content_box .'
            <h3><img class="icon" src="layout/img/icon/account.gif" alt=""> Create account</h3>
            <form action="#" method="post">
                <input type="hidden" name="action" value="register">
                <table>
                    <tr>
                        <td>Account name</td>
                        <td><input type="text" min="8" name="account_name" placeholder="Account name" required></td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td><input type="email" min="8" name="email" placeholder="Email" required></td>
                    </tr>                
                    <tr>
                        <td>Password</td>
                        <td><input type="password" min="8" name="password" placeholder="Password" required></td>
                    </tr>

                    <tr>
                        <td>Check password</td>
                        <td><input type="password" min="8" name="checkpassword" placeholder="Password" required></td>
                    </tr>                 
                    
                    <tr>
                        <td>Real name</td>
                        <td><input type="text" min="8" name="real_name" placeholder="Real Name" required></td>
                    </tr>                 
                </table>
                
                <h3 style="border-color: transparent;">Create your first character</h3>                
                <table>
                    <tr>
                        <td>Character name</td>
                        <td><input type="text" pattern=".{4,}" title="4 characters minimun" name="character_name" placeholder="Character name" required></td>
                    </tr>
                    <tr>
                        <td>Sex</td>
                        <td>
                            <input id="sex_m" type="radio" name="character_sex" value="1" required> <label for="sex_m">Male</label>
                            <input id="sex_f" type="radio" name="character_sex" value="0" required> <label for="sex_f">Female</label>                        
                        </td>                        
                    </tr>
                </table>
                
                <h3 style="border-color: transparent;">Please select the following check box:</h3>                
                <input type="checkbox" name="terms" required><strong>I agree to the <a href="?subtopic=rules">Tibia Rules</a>.</strong>
                <center style="margin-top: 10px;"><input type="submit" value="Register"></center>
            </form>
        </section>
';

?>