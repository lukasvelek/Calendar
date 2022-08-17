<?php

require_once('Utils.php');
require_once('Database.php');

$db = new Database();
$u = new Utils();

$id = $u->get('id');

$sql = "DELETE FROM `calendar_entries`
        WHERE `id` LIKE '$id'";

$res = $db->query($sql);

if($res === TRUE) {
    header('Location: index.php');
}

?>