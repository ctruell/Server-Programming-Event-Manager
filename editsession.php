<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Edit Session</h1>
        <form action="editsession.php" method="POST">
            <input type="text" name="name" placeholder="Name">
            <br />
            <input type="text" name="numberallowed" placeholder="Capacity">
            <br />
            <input type="text" name="event" placeholder="Event"><p>Input number for event see corrisponding numbers below</p>
            <br />
            <input type="text" name="start" placeholder="Start: 2019-10-27 17:00:00">
            <br />
            <input type="text" name="end" placeholder="End: 2019-10-27 17:00:00">
            <br />
            <input type="submit" name="update" value="Submit">
        </form>
        <h3>Delete Session</h3>
        <form action="editsession.php" method="POST">
            <input type="submit" name="delete" value="Delete">
        </form>
        <a href="admin.php">Back</a>
        <br />
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    echo $db->getAllEventsAsTable();

    //delete session
    if(isset($_POST['delete'])) {
        $db->deleteEvent($_GET['id']);
    }

    //update session
    if(isset($_POST['update'])) {
        $fields = array("name" => $_POST['name'], "capacity" => $_POST['numberallowed'], "event" => $_POST['event'], "start" => $_POST['start'], "end" => $_POST['end'], "id" => $_GET['id']);
        //var_dump($fields);
        $db->updateEvent($fields);
        //header("Location: admin.php");
    }
?>