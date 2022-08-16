<?php

require_once('../Database.php');

$db = new Database();

$id = htmlspecialchars($_GET['id']);

$data = $db->get_data("calendar_entries", $id);
$count = $db->get_data_count("calendar_entries", $id);

$i = 0;

foreach($data as $d) {
    $id = $d['id'];
    $date = $d['date'];
    $title = $d['title'];
    $description = $d['description'];
    $location = $d['location'];
    $color = $d['color'];

    $json = '
        {
            "id": "' . $id . '",
            "date": "' . $date . '",
            "title": "' . $title . '"
            "description": "' . $description . '"
            "location": "' . $location . '"
            "color": "' . $color . '"
        }
    ';

    if(($i + 1) == $count) {
        // last
        echo($json);
    } else {
        echo($json . ',<br>');
    }

    $i++;
}

?>