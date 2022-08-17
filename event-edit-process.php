<?php

require_once('Database.php');
require_once('Utils.php');

$db = new Database();
$u = new Utils();

$id = $u->post('id');
$title = $u->post('title');
$description = $u->post('description');
$location = $u->post('location');
$color = $u->post('color');
$date = $u->post('date');

$sql = "UPDATE `calendar_entries` SET   `title`='$title',
                                        `description`='$description',
                                        `location`='$location',
                                        `color`='$color',
                                        `date`='$date'
        WHERE `id` LIKE '$id'";

$res = $db->query($sql);

if($res === TRUE) {
    header('Location: event.php?id=' . $id);
} else {
    die('COULD NOT UPDATE EVENT!');
}

?>