<?php

require_once('Database.php');

$db = new Database();

$title = post('title');
$date = post('date');
$description = post('description');
$location = post('location');
$color = post('color');

if($db->create_entry($title, $date, $description, $location, $color) === TRUE) {
    header('Location: index.php');
} else {
    die('error');
}

function post($n) {
    return htmlspecialchars($_POST[$n]);
}

?>