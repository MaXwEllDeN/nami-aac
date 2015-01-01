<?php
$show_all_guilds = '
        <section class="content">
            <h3>Guilds</h3>
            
            <table>                
                <th>Logo</th>
                <th>Description</th>
                
                <tr>
                    <td class="guild_logo"><img src="system/guilds/logos/Headhunters.gif" alt="" class="guild_logo"></td>
                    <td style="padding:10px;">
                        <strong><a href="index.php?subtopic=guilds&guild=Headhunters">Headhunters</a></strong><br/>
                        <span>Galera, obrigatório o uso do ts.</span>
                    </td>
                </tr>
                
                <tr>
                    <td class="guild_logo"><img src="system/guilds/logos/default_logo.gif" alt="" class="guild_logo"></td>
                    <td style="padding:10px;">
                        <strong><a href="index.php?subtopic=guilds&guild=Mithos">Mithos</a></strong><br/>
                        <span>New guild. Leader must edit this text :)</span>
                    </td>
                </tr>                
            </table>
        </section>
        
        <section class="content">
            <h3>Create guild</h3>
            
            <form action="index.html?subtopic=guilds" method="get">
                <input type="hidden" name="action" value="create">
                <table>
                    <tr>
                        <td>Leader</td>
                        <td>
                          <select class="form-control" id="sel1">
                            <option>Max Kion</option>
                            <option>Gandowlf</option>
                          </select>                        
                        </td>
                    </tr>
                    
                       <tr>
                        <td>Guild name</td>
                        <td><input type="text" min="8" name="guild_name" placeholder="Guild Name" required></td>
                    </tr>                   
                </table>
                                
                <center style="margin-top: 10px;"><input type="submit" value="Create Guild"></center>
            </form>            
        </section>
';


$current_guild = '
        <section class="content">                        
            <h3>
                <center>Headhunters</center>                
                <img style="float:left;" src="system/guilds/logos/Headhunters.gif" alt="">
                <img style="float:right;" src="system/guilds/logos/Headhunters.gif" alt="">
            
            </h3>
            
            <div style="clear:both;">
                <h3 style="border-color: transparent;">Guild characters</h3>                
                <table>
                    <th>Rank</th>
                    <th>Name and title</th>
                    <th>Vocation</th>
                    <th>Level</th>
                    <th>Joining Date</th>
                    <th>Status</th>
                    <tr>
                        <td>Leader</td>
                        <td><a href="index.php?subtopic=characters&name=Max+Kion">Max Kion</a></td>
                        <td>Elite Knight</td>
                        <td>180</td>
                        <td>Nov 26 2014</td>
                        <td><strong style="color:darkgreen">Online</strong></td>
                    </tr>
                    <tr>
                        <td>Vice Leader</td>
                        <td><a href="index.php?subtopic=characters&name=Gandowlf">Gandowlf</a> (Healer)</td>
                        <td>Elder Druid</td>                        
                        <td>178</td>
                        <td>Nov 27 2014</td>
                        <td><strong style="color:darkred">Offline</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="index.php?subtopic=characters&name=Smadok">Smadok</a></td>
                        <td>Royal Paladin</td>
                        <td>167</td>
                        <td>Nov 27 2014</td>
                        <td><strong style="color:darkred">Offline</strong></td>
                    </tr>
                    <tr>
                        <td>Member</td>
                        <td><a href="index.php?subtopic=characters&name=Lawkz">Lawkz</a></td>
                        <td>Elite Knight</td>
                        <td>134</td>
                        <td>Nov 27 2014</td>
                        <td><strong style="color:darkred">Offline</strong></td>
                    </tr>                    
                    <tr>
                        <td></td>
                        <td><a href="index.php?subtopic=characters&name=Soono+Supremo">Soono Supremo</a> (Dorme pakas)</td>
                        <td>Master Sorcerer</td>
                        <td>18</td>
                        <td>Nov 27 2014</td>
                        <td><strong style="color:darkgreen">Online</strong></td>
                    </tr>                                        
                </table>
            </div>
            
            <h3 style="border-color: transparent;">Invited characters</h3>                
            <table>
                <th>Name</th>
                <th>Invitation Date</th>
                
                <tr>
                    <td><a href="index.php?subtopic=characters&name=Lord\'Paulistinha">Lord\'Paulistinha</a></td>
                    <td>Dec 29 2014</td>
                </tr>
            </table>
        </section>
        
        <section class="content">
            <h3>Guild information</h3>
            <h4>&ang; Description</h4>
            <p>Galera, obrigatório o uso do ts.</p>
            <span>The guild was founded on Nov 26 2014.</span>           
        </section>
        
        <section class="content">
            <h3>Guild wars</h3>
                <span>The guild Headhunters is currently not involved in a guild war.</span>
        </section>
';
if (empty($_REQUEST["guild"]))
    $main_content .= $show_all_guilds;
else
    $main_content .= $current_guild;
?>