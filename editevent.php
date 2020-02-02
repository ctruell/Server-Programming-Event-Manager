<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Edit Event</h1>
        <form action="editevent.php" method="POST">
            <input type="text" name="name" placeholder="Name">
            <br />
            <input type="text" name="start" placeholder="Start: 2019-10-27 17:00:00">
            <br />
            <input type="text" name="end" placeholder="End: 2019-10-27 17:00:00">
            <br />
            <input type="text" name="numberallowed" placeholder="Capacity">
            <br />
            <input type="text" name="venue" placeholder="Venue"><p>Input number for venue see corrisponding numbers below</p>
            <br />
            <input type="submit" name="update" value="Submit">
        </form>
        <h3>Delete Event</h3>
        <form action="editevent.php" method="POST">
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

    echo $db->getAllVenuesAsTable();

    //delete event
    if(isset($_POST['delete'])) {
        $db->deleteEvent($_GET['id']);
    }

    //update event
    if(isset($_POST['update'])) {
        $fields = array("name" => $_POST['name'], "start" => $_POST['start'], "end" => $_POST['end'], "capacity" => $_POST['numberallowed'], "venue" => $_POST['venue'], "id" => $_GET['id']);
        //var_dump($fields);
        $db->updateEvent($fields);
        //header("Location: admin.php");
    }
?>