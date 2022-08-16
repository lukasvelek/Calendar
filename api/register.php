<?php

require_once('Database.php');

$db = new Database();

$u = htmlspecialchars($_GET['u']);
$p = htmlspecialchars($_GET['p']);
$token = create_token(64);

if($db->check_user($u, $p)) {
    die('YOU HAVE ALREADY REGISTERED A TOKEN');
}

$db->save_token($token, $u, $p);

echo('TOKEN CREATED SUCCESSFULLY FOR USERNAME ' . $u . ' -> ' . $token);

function create_token($length) {
    $cs = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    $r = "";

    for($i = 0; $i < $length; $i++) {
        $x = rand(0, strlen($cs) - 1);

        $r = $r . $cs[$x];
    }

    return $r;
}

?>