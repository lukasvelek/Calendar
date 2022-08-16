<?php

require_once('../Utils.php');

$utils = new Utils();

$username = $utils->post("username");
$password = $utils->post("password");

$password_md5 = md5($password);

header('Location: register.php?u=' . $username . '&p=' . $password_md5);

?>