<?php

require_once('Database.php');
require_once('Calendar.php');
require_once('Utils.php');

$db = new Database();
$cal = new Calendar($db);
$utils = new Utils();

$id = $utils->get("id");

$sql = "SELECT * FROM `calendar_entries`
        WHERE `id` LIKE '$id'";

$data = $db->query($sql);

if($db->get_num_rows($sql) == 1) {
    foreach($data as $d) {
        $title = $d['title'];
        $description = $d['description'];
        $location = $d['location'];
        $date = $d['date'];
        $color = $d['color'];
    }
}

$date = explode(' ', $date)[0];

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
            <div id="form">
                <form action="event-edit-process.php" method="POST">
                    <label for="title">Title: </label>
                    <br>
                    <input type="text" name="title" maxlength="1024" value="<?php echo($title); ?>" required>
                    <br>
                    <br>

                    <label for="date">Date: </label>
                    <br>
                    <input type="date" name="date" value="<?php echo($date); ?>" required>
                    <br>
                    <br>

                    <label for="description">Description: </label>
                    <br>
                    <input type="text" name="description" maxlength="1024" value="<?php echo($description); ?>">
                    <br>
                    <br>

                    <label for="location">Location: </label>
                    <br>
                    <input type="text" name="location" maxlength="1024" value="<?php echo($location); ?>">
                    <br>
                    <br>

                    <label for="color">Color: </label>
                    <br>
                    <input type="color" name="color" value="<?php echo($color); ?>">
                    <br>
                    <br>

                    <input type="text" name="id" value="<?php echo($id); ?>" hidden>

                    <input type="submit" value="Save event">
                </form>
            </div>

            <br>

            <div id="form-links">
                    <a class="form-link" href="event.php?id=<?php echo($id); ?>">Go back</a>
            </div>
        </div>
    </body>
    <br>
    <footer>
        <p>Author: <b>Lukas Velek</b></p>
        <p>GitHub project link: <b><a style="color: black; text-decoration: none" href="https://github.com/lukasvelek/Calendar">Calendar (GitHub)</a></b></p>
    </footer>
</html>