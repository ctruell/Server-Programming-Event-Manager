<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Insert Event</h1>
        <form action="insertevent.php" method="POST">
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
            <input type="submit" name="insert" value="Submit">
        </form>
        <a href="admin.php">Back</a>
        <br />
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //show venues with ids and specify number must be added
    echo $db->getAllVenuesAsTable();

    //insert event
    if(isset($_POST['insert'])) {
        $name = stripslashes($_POST['name']);
        //$capacity = stripslashes($_GET['numberallowed']);
        //$venue = filter_var($_GET['venue'], FILTER_SANATIZE_INT);
        $start = stripslashes($_POST['start']);
        $end = stripslashes($_POST['end']);
        $name = strip_tags($name);
        $start = strip_tags($start);
        $end = strip_tags($end);
        $capacity = filter_var($capacity, FILTER_VALIDATE_INT);
        $venue = filter_var($venue, FILTER_VALIDATE_INT);

        $db->insertEvent($name, $start, $end, $capacity, $venue);
        //header("Location: admin.php");
    }
?>