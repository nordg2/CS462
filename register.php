<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='bootstrap/css/bootstrap.css'  type='text/css'/>
        <script src='http://code.jquery.com/jquery-1.10.1.min.js'></script>
        <script src='bootstrap/js/bootstrap.js'></script>
        <title>Register</title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <?php 
                            $json = file_get_contents('userSignedIn.txt');
                            $signedInUser = json_decode($json);
                            if(count($signedInUser) > 0){
                                echo '<li><a href="#" />Welcome '.$signedInUser[0]->name .'!</a></li>';
                            }else{
                                echo '<li><a href="#" /></a></li>';
                            }
                        ?>
                        <li><a href="home.php">CS 462</a></li>
                        <li><a href="signin.php">Sign-in</a></li>
                        <li class="active"><a href="#">Register</a></li>
                        <?php
                            if(count($signedInUser) > 0) {
                               echo '<li><a href="signout.php"/>Sign Out</a></li>'; 
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <form action="addRegistrant.php" method="post">
            <table class="offset1">
                <tr>
                    <td>
                        Name:
                    </td>
                    <td>
                        <input name="registerName"/><input type="submit" value='Create'>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
