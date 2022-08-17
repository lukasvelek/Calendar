<?php

/**
 * Class Calendar is used as a function library for calendar creation
 * 
 * Author: Lukas Velek
 * Version: 2022/8/16
 * 
 * Revision 1: 2022/8/17
 */
class Calendar {
    /**
     * Database variable initialization
     */
    private $db;

    /**
     * The constructor; initialized variables have their values assigned here
     * 
     * Constructor expects database object (Database.php) => $db
     */
    function __construct($db) {
        $this->db = $db;
    }

    /**
     * Creates event overview with all saved data and also adds buttons
     * for control - edit, delete and go back to the calendar
     * 
     * Function expects event (entry) id
     */
    function createEvent($id) {
        $sql = "SELECT * FROM `calendar_entries`
                WHERE `id` LIKE '$id'";

        $event = $this->db->query($sql);

        if($this->db->get_num_rows($sql) == 1) {
            foreach($event as $e) {
                $date = $e['date'];
                $title = $e['title'];
                $description = $e['description'];
                $location = $e['location'];
                $color = $e['color'];

                $content = '
                    <h2 class="event-title">' . $title . '</h2>
                    <p class="event-description">Description: ' . $description . '</p>
                    <p class="event-data">Location: ' . $location . '</p>
                    <p class="event-data">Date: ' . $this->getFormattedDate($date) . '</p>
                    <p class="event-data">Color: <input type="color" value="' . $color . '" disabled></p>
                    <br>
                    <br>
                    <a class="event-link" href="index.php">Go back</a>
                    <a class="event-link" href="event-edit-form.php?id=' . $id . '">Edit</a>
                    <a class="event-link" href="event-delete.php?id=' . $id . '">Delete</a>
                    <a class="event-link" href="event-export-json.php?id=' . $id .  '">Export as JSON</a>
                ';

                echo($content);
            }
        }
    }

    function createDayView($y, $m, $d) {
        $meta_date = mktime(0, 0, 0, $m, $d, $y);
        $date_db = date('Y-m-d H:i:s', $meta_date);
        $date = date("l - F jS Y", $meta_date);

        $total_content = "";
        $content = "";

        $total_content = '
            <h2 class="day-title">' . $date . '</h2>';

        $sql = "SELECT * FROM `calendar_entries`
                WHERE `date` LIKE '$date_db'";

        $res = $this->db->query($sql);

        $x = $this->db->get_num_rows($sql);

        $total_content = $total_content . '<p class="day-data">Events: ' . $x . '</p>';

        if($x >= 1) {
            foreach($res as $r) {
                $id = $r['id'];
                $title = $r['title'];

                $content = '<a class="day-link" href="event.php?id=' . $id . '">' . $title . '</a><br>';
                $total_content = $total_content . $content;
            }
        }

        $total_content = $total_content . '<br><br><br><a class="day-link" href="index.php">Go back</a>';

        echo($total_content);
    }

    /**
     * The main function that creates the day view (day window)
     * 
     * It expects number of the day, month and year
     * 
     * It initializes variables that are used later with empty string. Then the date is created and entries (events) for that date
     * is gotten from the table in database. Then for each entry (event) it creates its own frame (that is also colorful)
     * and saves it to master variable that is later used to print the entries on the screen. It also distinguishes today and other days.
     * At the end it puts everything into HTML table cell and returns it.
     */
    function createDayWindow($day, $month, $year) {
        $class = "";
        $title = "";
        $day_name = "";
        $color = "#000";
        $text_color = "#fff";
        $total_content = "";
        $content_data = "";

        $meta_date = mktime(0, 0, 0, $month, $day, $year);
        $day_name = date("l", $meta_date);
        $date = $year . '-' . $month . '-' . $day . ' 00:00:00';
        $content_res = $this->db->get_date_entries($date);
        
        foreach($content_res as $entry) {
            $id = $entry['id'];

            $content = '<div style="text-align: center; background-color: ';
            $content_data = $entry['title'];
            $color = $entry['color'];

            $text_color = $this->get_text_light_dark($color);

            $content = $content . $color . '"><a class="table-event-link" style="color: ' . $text_color . '" href="event.php?id=' . $id . '">' . $content_data . '</a></div>';

            $total_content = $total_content . $content;
        }

        if($day == date('d') && $month == date('m') && $year == date('Y')) {
            $class = "day-window-today";
            $title = '<a class="day-window-title" href="day-view.php?y=' . $year . '&m=' . $month . '&d=' . $day . '">' . $day . '</a>';
        } else {
            $class = "day-window";
            $title = '<a class="day-window-title" href="day-view.php?y=' . $year . '&m=' . $month . '&d=' . $day . '">' . $day . '</a>';
        }
        
        $window = '<td class="' . $class . '">' . $title . '' . $total_content . '</td>';

        return $window;
    }

    function getDayNumberFromName($name) {
        switch($name) {
            case "Monday":
                return 1;
            case "Tuesday":
                return 2;
            case "Wednesday":
                return 3;
            case "Thursday":
                return 4;
            case "Friday":
                return 5;
            case "Saturday":
                return 6;
            case "Sunday":
                return 7;
        }
    }

    /**
     * This function creates the calendar itself. It gets days in the current month and loops through and creates
     * window (using createDayWindow() function) and prints it onto the screen. It also creates a new line after
     * every 7 days (representing a week).
     */
    function createCalendar($month, $year) {
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $d = 1;

        for($i = 1; $i <= $days_in_month; $i++) {
            if($d == 1) {
                echo('<tr>');
            }

            $meta_date = mktime(0, 0, 0, $month, $i, $year);
            $day_name = date("l", $meta_date);

            $n = $this->GetDayNumberFromName($day_name);

            if($i == 1 && $n != 1) {
                $skip = $n - 1;

                for($j = 1; $j <= $skip; $j++) {
                    echo('<td></td>');

                    $d++;
                }
            }
            
            $dw = $this->createDayWindow($i, $month, $year);
            echo($dw);
            
            if(($d % 7) == 0) {
                echo('</tr>');
            }

            $d++;
        }
    }

    function getFormattedDate($date) {
        $dt = explode(' ', $date)[0];

        $y = explode('-', $dt)[0];
        $m = explode('-', $dt)[1];
        $d = explode('-', $dt)[2];

        $meta_date = mktime(0, 0, 0, $m, $d, $y);

        return date('F d Y', $meta_date);
    }

    /**
     * Returns name of the day in a week
     */
    function getDayName($num) {
        if($num > 0 && $num < 8) {
            switch($num) {
                case 1:
                    return "Monday";
                case 2:
                    return "Tuesday";
                case 3:
                    return "Wednesday";
                case 4:
                    return "Thursday";
                case 5:
                    return "Friday";
                case 6:
                    return "Saturday";
                case 7:
                    return "Sunday";
            }
        } else {
            return "";
        }
    }

    /**
     * Returns the color for the text based on the background color
     */
    function get_text_light_dark($color) {
        $hsl = $this->rgb_to_hsl($this->hex_to_rgb($color));

        if($hsl->lightness > 150) {
            $text_color = "#000";
        } else {
            $text_color = "#fff";
        }

        return $text_color;
    }

    /**
     * Returns a JSON export of entry with given id
     */
    function exportEntryAsJson($id) {
        $json = "";

        $sql = "SELECT * FROM `calendar_entries`
                WHERE `id` LIKE '$id'";

        $data = $this->db->query($sql);

        if($this->db->get_num_rows($sql) == 1) {
            foreach($data as $d) {
                $title = $d['title'];
                $description = $d['description'];
                $date = $d['date'];
                $location = $d['location'];
                $color = $d['color'];

                $json = '
                {
                    "title": "' . $title . '",
                    "date": "' . $date . '",
                    "description": "' . $description . '",
                    "location": "' . $location . '",
                    "color": "' . $color . '"
                }';
            }
        }

        return $json;
    }

    /**
     * Returns a JSON export of entries for selected day. If there's no event -> no event will be given and therefore only day info will be returned.
     */
    function exportDayAsJson($day, $month, $year) {
        $meta_date = mktime(0, 0, 0, $month, $day, $year);
        $date_db = date("Y-m-d H:i:s", $meta_date);
        $date = date("Y-m-d", $meta_date);

        $json = '
        {
            "date": "' . $date . '",';

        $sql = "SELECT `id` FROM `calendar_entries`
                WHERE `date` LIKE '$date_db'";

        $data = $this->db->query($sql);

        $x = $this->db->get_num_rows($sql);

        if($x > 0) {
            $json = $json . '"events": [';
        }

        if($x == 1) {
            foreach($data as $d) {
                $json = $json . $this->exportEntryAsJson($d['id']);
            }

            $json = $json . ']';
        } else if($x > 1) {
            $z = 1;

            foreach($data as $d) {
                if(($z + 1) == $x) {
                    $json = $json . $this->exportEntryAsJson($d['id']);
                } else {
                    $json = $json . $this->exportEntryAsJson($d['id']) . ',';
                }

                $z++;
            }

            $json = $json . ']';
        }

        $json = $json . ', "event_count": "' . $x . '"}';

        return $json;
    }

    // DESIGN STUFF

    /**
     * Converts hexadecimal color to rgb color
     * 
     * Credits: https://stackoverflow.com/questions/12228644/how-to-detect-light-colors-with-php @Peter
     */
    function hex_to_rgb($hex) {
        if($hex[0] == "#") {
            $hex = substr($hex, 1);
        }

        if(strlen($hex) == 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }

        $r = hexdec($hex[0] . $hex[1]);
        $g = hexdec($hex[2] . $hex[3]);
        $b = hexdec($hex[4] . $hex[5]);

        return $b + ($g << 0x8) + ($r << 0x10);
    }

    /**
     * Converts rgb color to hsl color
     * 
     * Credits: https://stackoverflow.com/questions/12228644/how-to-detect-light-colors-with-php @Peter
     */
    function rgb_to_hsl($rgb) {
        $r = 0xFF & ($rgb >> 0x10);
        $g = 0xFF & ($rgb >> 0x8);
        $b = 0xFF & $rgb;

        $r = ((float)$r) / 255.0;
        $g = ((float)$g) / 255.0;
        $b = ((float)$b) / 255.0;

        $maxC = max($r, $g, $b);
        $minC = min($r, $g, $b);

        $l = ($maxC + $minC) / 2.0;

        if($maxC == $minC)
        {
            $s = 0;
            $h = 0;
        }
        else
        {
            if($l < .5) {
                $s = ($maxC - $minC) / ($maxC + $minC);
            } else {
                $s = ($maxC - $minC) / (2.0 - $maxC - $minC);
            }

            if($r == $maxC) {
                $h = ($g - $b) / ($maxC - $minC);
            }

            if($g == $maxC) {
                $h = 2.0 + ($b - $r) / ($maxC - $minC);
            }

            if($b == $maxC) {
                $h = 4.0 + ($r - $g) / ($maxC - $minC);
            }

            $h = $h / 6.0; 
        }

        $h = (int)round(255.0 * $h);
        $s = (int)round(255.0 * $s);
        $l = (int)round(255.0 * $l);

        return (object) Array('hue' => $h, 'saturation' => $s, 'lightness' => $l);
    }

    /**
     * Returns today's date
     */
    function getTodayDate() {
        return $this->today_date;
    }

    /**
     * Returns today's date in a prettier form
     */
    function getTodayDateFormatted() {
        return $this->getCurrentMonthName() . " " . date("Y");
    }

    /**
     * Returns entered date in a prettier form
     */
    function getDateFormatted($month, $year) {
        return $this->getMonthName($month) . " " . $year;
    }

    /**
     * Returns name of entered month
     */
    function getMonthName($month) {
        $meta_date = mktime(0, 0, 0, $month, 1, 2020);

        return date('F', $meta_date);
    }

    /**
     * Returns name of the current month
     */
    function getCurrentMonthName() {
        return date("F");
    }

    /**
     * Returns name of the current day
     */
    function getTodayDayName() {
        return date("l");
    }
}

?>