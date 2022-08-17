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
                <table id="calendar-title-table">
                    <tr>
                        <?php

                        $m = 0;
                        $y = 0;

                        if(isset($_GET['m']) && isset($_GET['y'])) {
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
                            $next = "?m=" . ($m + 1) . "&y=" . $y;
                        } else if($m == 12) {
                            $before = "?m=" . ($m - 1) . "&y=" . $y;
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

                        ?>
                        <td><b class="calendar-title-table-text"><?php echo($before_link); ?></b></td>
                        <td><b class="calendar-title-table-text"><?php echo($cal->getDateFormatted($m, $y)); ?></b></td>
                        <td><b class="calendar-title-table-text"><?php echo($next_link); ?></b></td>
                    </tr>
                </table>

                <table id="calendar-table">
                    <tr>
                        <th class="day-title">Monday</th>
                        <th class="day-title">Tuesday</th>
                        <th class="day-title">Wednesday</th>
                        <th class="day-title">Thursday</th>
                        <th class="day-title">Friday</th>
                        <th class="day-title">Saturday</th>
                        <th class="day-title">Sunday</th>
                    </tr>

                    <?php
                    
                    $cal->createCalendar($m, $y);
                    
                    ?>
                </table>

                <div id="calendar-links">
                    <a class="calendar-link" href="new-event-form.php">New event</a>
                    <a class="calendar-link" href="?">Today</a>
                </div>
            </div>
        </div>
    </body>
</html>