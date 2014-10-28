

<?php

$host = "eu-cdbr-azure-west-b.cloudapp.net";
$user = "bc0d2908cbe0d6";
$pwd = "699c9790";
$db = "anwebsiAgJpKdW5p";

try {
    $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(Exception $e){
    die(var_dump($e));
}

?>