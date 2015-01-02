<?php
if (!empty($_REQUEST["name"]))
    $main_content .= '
        <section class="content">
           <h3>Character information</h3>                       
           <table>
               <tr>
                   <td>Name</td>
                   <td>Max Kion</td>
               </tr>
                <tr>
                   <td>Sex</td>
                   <td>Male</td>
               </tr>
               <tr>
                   <td>Profession</td>
                   <td>Elite Knight</td>
               </tr>
               <tr>
                   <td>Level</td>
                   <td>180</td>
               </tr>                       
               <tr>
                   <td>House</td>
                   <td><a href="#">Central Circle 1</a> (Edron)</td>
               </tr>                   
               <tr>
                   <td>Guild membership</td>
                   <td>Leader of the <strong><a href="?subtopic=guilds&name=Headhunters">Headhunters</a></strong></td>
               </tr>
               <tr>
                   <td>Residence</td>
                   <td>Thais</td>
               </tr>                       
               <tr>
                   <td>Last seen</td>
                   <td>Nov 29 2014, 13:13:44 CET</td>
               </tr>            
               <tr>
                   <td>Account Status</td>
                   <td style="font-weight: bold; color: darkgreen">Premium Account</td>
               </tr>
           </table>
        </section>      
        
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
            
            <h3 style="border-color: transparent;">Characters</h3>
            <table>
                <th>Name</th>
                <th>World</th>                
                <th>Status</th>
                
                <tr>
                    <td><a href="?subtopic=characters&name=Max Kion">Max Kion</a></td>
                    <td>Thera</td>
                    <td style="font-weight: bold; color: darkgreen">Online</td>
                </tr>
                
                <tr>
                    <td><a href="?subtopic=characters&name=Gandowlf">Gandowlf</a></td>
                    <td>Samera</td>
                    <td></td>
                </tr>                
            </table>
        </section>
';

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