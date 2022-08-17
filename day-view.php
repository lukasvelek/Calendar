<?php

require_once('Database.php');
require_once('Calendar.php');
require_once('Utils.php');

$db = new Database();
$cal = new Calendar($db);
$utils = new Utils();

$y = $utils->get("y");
$m = $utils->get("m");
$d = $utils->get("d");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/style.css">
        
        <meta charset="utf-8" name="CHARSET" content="UTF-8">
        <meta name="AUTHOR" content="Lukas Velek">

        <title>Day view - Calendar</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="event">
                <?php
                
                $cal->createDayView($y, $m, $d);
                
                ?>
            </div>
        </div>
    </body>
</html>