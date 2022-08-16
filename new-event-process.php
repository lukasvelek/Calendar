<?php

require_once('Database.php');
require_once('Utils.php');

$db = new Database();
$utils = new Utils();

$title = $utils->post('title');
$date = $utils->post('date');
$description = $utils->post('description');
$location = $utils->post('location');
$color = $utils->post('color');

if($db->create_entry($title, $date, $description, $location, $color) === TRUE) {
    header('Location: index.php');
} else {
    die('error');
}

?>