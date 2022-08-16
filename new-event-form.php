<?php

require_once('Database.php');
require_once('Calendar.php');

$db = new Database();
$cal = new Calendar($db);

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
            <div id="form">
                <form action="new-event-process.php" method="POST">
                    <label for="title">Title: </label>
                    <br>
                    <input type="text" name="title" maxlength="1024" required>
                    <br>
                    <br>

                    <label for="date">Date: </label>
                    <br>
                    <input type="date" name="date" required>
                    <br>
                    <br>

                    <label for="description">Description: </label>
                    <br>
                    <input type="text" name="description" maxlength="1024">
                    <br>
                    <br>

                    <label for="location">Location: </label>
                    <br>
                    <input type="text" name="location" maxlength="1024">
                    <br>
                    <br>

                    <label for="color">Color: </label>
                    <br>
                    <input type="color" name="color">
                    <br>
                    <br>

                    <input type="submit" value="Create event">
                </form>
            </div>

            <br>

            <div id="form-links">
                    <a class="form-link" href="index.php">Delete event</a>
            </div>
        </div>
    </body>
</html>