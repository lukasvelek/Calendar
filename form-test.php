<?php

if(isset($_POST['date'])) {
    echo($_POST['date']);
}

?>

<form action="" method="post">
    <input type="date" name="date">
    <input type="submit">
</form>