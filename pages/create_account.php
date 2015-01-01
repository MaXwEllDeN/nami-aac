<?php
$main_content .= '
        <section class="content">
            <h3><img class="icon" src="layout/img/icon/account.gif" alt=""> Create account</h3>
            <form action="#" method="post">
                <input type="hidden" name="action" value="register">
                <table>
                    <tr>
                        <td>Account name</td>
                        <td><input type="text" min="8" name="login" placeholder="Account name" required></td>
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
                            <input id="sex_m" type="radio" name="sex" value="male" required> <label for="sex_m">Male</label>
                            <input id="sex_f" type="radio" name="sex" value="female" required> <label for="sex_f">Female</label>                        
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