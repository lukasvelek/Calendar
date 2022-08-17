<?php

require_once('Database.php');
require_once('Calendar.php');
require_once('Utils.php');

$db = new Database();
$cal = new Calendar($db);
$utils = new Utils();

$id = $utils->get("id");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/style.css">
        
        <meta charset="utf-8" name="CHARSET" content="UTF-8">
        <meta name="AUTHOR" content="Lukas Velek">

        <title>Event - Calendar</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="event">
                <?php
                
                $cal->createEvent($id);
                
                ?>
            </div>
        </div>
    </body>
</html>