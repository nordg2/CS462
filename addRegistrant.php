<?php

$string = file_get_contents('users.txt');
$users = json_decode($string);
foreach($users as $user) {
    if(strcmp($user->name, $_POST[registerName]) == 0){
        die('Error: registrants can\'t have the same name!');
    }
}
$blah = new stdClass();
$blah->name = "$_POST[registerName]";
array_push($users, $blah);
print_r($users);

file_put_contents('users.txt', json_encode($users));    

?>

<script type="text/javascript">
    window.location.replace("http://localhost/CS462/register.php");
</script>
