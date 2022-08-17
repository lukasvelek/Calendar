<?php

require_once('Database.php');
require_once('Calendar.php');
require_once('Utils.php');

$db = new Database();
$cal = new Calendar($db);
$u = new Utils();

$id = $u->get("id");

echo($cal->exportEntryAsJson($id));

?>