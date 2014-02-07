<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='bootstrap/css/bootstrap.css'  type='text/css'/>
        <script src='http://code.jquery.com/jquery-1.10.1.min.js'></script>
        <script src='bootstrap/js/bootstrap.js'></script>
        <script type='text/javascript'>
            
            function submitForm() {
               document.getElementById("form").submit();
            }
        </script>
        <title>Lab 1</title>
    </head>
    
    <body>
        <?php
        require_once 'auth.php';
        // Set your client key and secret
	$client_key = "TVNJ0HMXZU2MRZB4QBL5SIO14TQVBNZUOZXRCLZNWQ20ESLR";
	$client_secret = "YMHA2Y0WXCNU52HL4SY2BZFWRMGWE3EG1ARLPYP1KXCMTC4B";
        $redirect_uri = "http://ec2-54-197-123-215.compute-1.amazonaws.com/CS462/home.php";	
// Load the Foursquare API library

        $string = file_get_contents('users.txt');
        $users = json_decode($string);
        $json = file_get_contents('userSignedIn.txt');
        $signedInUser = json_decode($json);
	$foursquare = new FoursquareAPI($client_key,$client_secret);
	if(array_key_exists("code",$_GET)){
		$token = $foursquare->GetToken($_GET['code'],$redirect_uri);
                foreach($users as $user) {
                    if(count($signedInUser) > 0 && strcmp($user->name, $signedInUser[0]->name) == 0) {
                        //echo 'user: '. $user->name.' '.$signedInUser[0]->name;
                        //echo $token;
                        $user->token = $token;
                    }
                }
                file_put_contents('users.txt', json_encode($users));
                    
	}
        $users = json_decode($string);
        

        //$location = array_key_exists("location",$_GET) ? $_GET['location'] : "Montreal, QC";
            
        
            
            ?>
        
        
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <?php 
                            
                            if(count($signedInUser) > 0) {
                                echo '<li><a href="#" />Welcome '.$signedInUser[0]->name.'!</a></li>';
                            } else {
                                echo '<li><a href="#" /></a></li>';
                            }
                        ?>
                        <li class="active"><a href="#">CS 462</a></li>
                        <li><a href="sign.php">Sign-in</a></li>
                        <li><a href="register.php">Register</a></li>
                        <?php
                            if(count($signedInUser) > 0) {
                               echo '<li><a href="signout.php"/>Sign Out</a></li>'; 
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <form id='form' action='home.php' method='post'>
            <table class="offset1">
                <tr>
                    <td>
                        Users:
                    </td>
                    <td>
                        <select name='userSelected' onchange="submitForm();">
                            <option value="*">Select User to View Page</option>
                            <?php
                                foreach($users as $user) {
                                    $selected = '';
                                    if(strcmp($user->name, $_POST[userSelected]) == 0) {
                                        $selected = 'selected';
                                    }
                                    echo '<option value="'. $user->name . '" '.$selected.'>'. $user->name .'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <table class="offset2">
                <tr>
                    <td>
                        <?php
                            if(strcmp($signedInUser[0]->name, $_POST[userSelected]) == 0 && count($signedInUser) > 0) {
                               echo "This is your page!";
                               
                               if(!isset($token)){ 
                                    echo "<a href='".$foursquare->AuthenticationLink($redirect_uri)."'>Connect to this app via Foursquare</a>";
                                // Otherwise display the token
                                } else {
                                    echo "Your auth token: $token";
                                }
                               
                            } else if($_POST[userSelected] == null || strcmp($_POST[userSelected], "*") == 0) {
                               echo"Select a User";
                            } else {
                               echo"This is not your page!"; 
                            }
                        ?>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
