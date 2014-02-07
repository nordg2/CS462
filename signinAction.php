
<?php
    $string = file_get_contents('users.txt');
    $users = json_decode($string);
    $found = false;
    //echo print_r($users);
    foreach($users as $user1) {
        //echo 'user';
        //echo $user1->name;
        if(strcmp($user1->name, $_POST[signInName]) == 0) {
            $found = true;
            
            $user = array($user1);
            //echo '$found';
        }
    }
    if(!$found) {
        die('Error: you must have an account to sign-in');
    }
    //echo 'a';
    //$user = array();
    //echo 'b';
    array_push($user, $_POST[signInName]);
    //echo print_r($user);

    file_put_contents('userSignedIn.txt', json_encode($user));    
?>

<script type="text/javascript">
    window.location.replace("/CS462/home.php");
</script>
