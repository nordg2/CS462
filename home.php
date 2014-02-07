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
            $string = file_get_contents('users.txt');
            $users = json_decode($string);
            
define('OAUTH_HOST', 'http://' . $_SERVER['SERVER_NAME']);
$id = 1;
 
// Init the OAuthStore
$options = array(
    'consumer_key' => 'TVNJ0HMXZU2MRZB4QBL5SIO14TQVBNZUOZXRCLZNWQ20ESLR',
    'consumer_secret' => 'YMHA2Y0WXCNU52HL4SY2BZFWRMGWE3EG1ARLPYP1KXCMTC4B',
    'server_uri' => OAUTH_HOST,
    'request_token_uri' => OAUTH_HOST . '/home.php',
    'authorize_uri' => OAUTH_HOST . '/home.php',
    'access_token_uri' => OAUTH_HOST . '/home.php'
);
OAuthStore::instance('Session', $options);
 
if (empty($_GET['oauth_token'])) {
    // get a request token
    $tokenResultParams = OauthRequester::requestRequestToken($options['consumer_key'], $id);
 
    header('Location: ' . $options['authorize_uri'] .
        '?oauth_token=' . $tokenResultParams['token'] . 
        '&oauth_callback=' . urlencode('http://' .
            $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF']));
}
else {
    // get an access token
    $oauthToken = $_GET['oauth_token'];
    $tokenResultParams = $_GET;
    OAuthRequester::requestAccessToken($options['consumer_key'],
        $tokenResultParams['oauth_token'], $id, 'POST', $_GET);
    $request = new OAuthRequester(OAUTH_HOST . '/test_request.php',
        'GET', $tokenResultParams);
    $result = $request->doRequest(0);
    if ($result['code'] == 200) {
        var_dump($result['body']);
    }
    else {
        echo 'Error';
    }
}
        ?>
        
        
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <ul class="nav">
                        <?php 
                            $json = file_get_contents('userSignedIn.txt');
                            $signedInUser = json_decode($json);
                            if(count($signedInUser) > 0) {
                                echo '<li><a href="#" />Welcome '.$signedInUser[0].'!</a></li>';
                            } else {
                                echo '<li><a href="#" /></a></li>';
                            }
                        ?>
                        <li class="active"><a href="#">CS 462</a></li>
                        <li><a href="signIn.php">Sign-in</a></li>
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
                            if(strcmp($signedInUser[0], $_POST[userSelected]) == 0 && count($signedInUser) > 0) {
                               echo "This is your page!";
                               echo "<a href='https://foursquare.com/oauth2/authenticate?client_id=TVNJ0HMXZU2MRZB4QBL5SIO14TQVBNZUOZXRCLZNWQ20ESLR&response_type=code&redirect_uri=http://ec2-54-197-123-215.compute-1.amazonaws.com/CS462/home.php'>SignIn with Foursquare</a>";
                               
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
