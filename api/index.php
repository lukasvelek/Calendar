<?php

require_once('../Database.php');
require_once('../Utils.php');

$db = new Database();
$utils = new Utils();

$token = "";

if(isset($_GET['token'])) {
    $token = $utils->get("token");
} else {
    die('YOU MUST ENTER TOKEN! <a href="register-token-form.php">Register token</a>');
}

if(!$db->check_token($token)) {
    die('YOUR TOKEN IS NOT REGISTERED! <a href="register-token-form.php">Register token</a>');
}

if(isset($_GET['o'])) {
    $operation = $utils->get("o");

    $table = "";
    $id = "";

    if(isset($_GET['table'])) {
        $table = $utils->get("table");
    } else {
        die('NO TABLE PROVIDED!');
    }

    if(isset($_GET['id'])) {
        $id = $utils->get("id");
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