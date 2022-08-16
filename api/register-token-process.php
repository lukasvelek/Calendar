<?php

$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);

$password_md5 = md5($password);

header('Location: register.php?u=' . $username . '&p=' . $password_md5);

?>