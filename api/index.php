<?php

require_once('Database.php');

$db = new Database();

$token = "";

if(isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);
} else {
    die('YOU MUST ENTER TOKEN! <a href="register-token-form.php">Register token</a>');
}

if(!$db->check_token($token)) {
    die('YOUR TOKEN IS NOT REGISTERED! <a href="register-token-form.php">Register token</a>');
}

if(isset($_GET['o'])) {
    $operation = htmlspecialchars($_GET['o']);

    $table = "";
    $id = "";

    if(isset($_GET['table'])) {
        $table = htmlspecialchars($_GET['table']);
    } else {
        die('NO TABLE PROVIDED!');
    }

    if(isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
    } else {
        $id = "*";
    }

    if($operation == "get") {
        header('Location: ' . $table . '/' . $operation . '.php?id=' . $id);
    } else if($operation == "post") {

    }
} else {
    die('NO OPERATION PROVIDED!');
}

?>