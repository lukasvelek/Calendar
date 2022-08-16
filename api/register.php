<?php

require_once('Database.php');
require_once('Utils.php');

$db = new Database();
$utils = new Utils();

$u = $utils->get("u");
$p = $utils->get("p");
$token = $utils->create_token(64);

if($db->check_user($u, $p)) {
    die('YOU HAVE ALREADY REGISTERED A TOKEN');
}

$db->save_token($token, $u, $p);

echo('TOKEN CREATED SUCCESSFULLY FOR USERNAME ' . $u . ' -> ' . $token);

?>