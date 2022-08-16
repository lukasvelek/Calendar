<?php

require_once('Database.php');
require_once('Calendar.php');
require_once('Utils.php');

$db = new Database();
$cal = new Calendar($db);
$utils = new Utils();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/style.css">
        
        <meta charset="utf-8" name="CHARSET" content="UTF-8">
        <meta name="AUTHOR" content="Lukas Velek">

        <title>Calendar</title>
    </head>
    <body>
        <div id="wrapper">
            <div id="calendar">
                <p class="calendar-title">
                    <?php
                    
                    $m = 0;
                    $y = 0;

                    if(isset($utils->get("m")) && isset($utils->get("y"))) {
                        $m = $utils->get("m");
                        $y = $utils->get("y");
                    } else {
                        $m = date('m');
                        $y = date('Y');
                    }

                    $before = "";
                    $next = "";

                    if($m == 1) {
                        $before = "?m=12&y=" . ($y - 1);
                    } else if($m == 12) {
                        $next = "?m=01&y=" . ($y + 1);
                    } else {
                        if($m > 10) {
                            $before = "?m=" . ($m - 1) . "&y=$y";
                            $next = "?m=" . ($m + 1) . "&y=$y";
                        } else if($m == 10) {
                            $before = "?m=0" . ($m - 1) . "&y=$y";
                            $next = "?m=" . ($m + 1) . "&y=$y";
                        } else if($m == 9) {
                            $before = "?m=0" . ($m - 1) . "&y=$y";
                            $next = "?m=" . ($m + 1) . "&y=$y";
                        } else {
                            $before = "?m=0" . ($m - 1) . "&y=$y";
                            $next = "?m=0" . ($m + 1) . "&y=$y";
                        }
                    }

                    $before_link = '<a class="change-date-left" href="' . $before . '"><</a>';
                    $next_link = '<a class="change-date-right" href="' . $next . '">></a>';
                    
                    echo($before_link);

                    ?>

                    <b><?php echo($cal->getDateFormatted($m, $y)); ?></b>

                    <?php
                    
                    echo($next_link);
                    
                    ?>
                </p>

                <table id="calendar-table">
                    <?php
                    
                    $cal->createCalendar($m, $y);
                    
                    ?>
                </table>

                <div id="calendar-links">
                    <a class="calendar-link" href="new-event-form.php">New event</a>
                </div>
            </div>
        </div>
    </body>
</html>