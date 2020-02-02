<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Insert Venue</h1>
        <form action="insertvenue.php" method="POST">
            <input type="text" name="name" placeholder="Name">
            <br />
            <input type="text" name="capacity" placeholder="Capacity">
            <br />
            <input type="submit" name="insert" value="Submit">
        </form>
        <a href="admin.php">Back</a>
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //insert venue
    if(isset($_POST['insert'])) {
        $name = strip_tags($_POST['name']);
        //$capacity = filter_var($_GET['capacity'], FILTER_SANATIZE_INT);
        $name = stripslashes($name);
        $capacity = filter_var($capacity, FILTER_VALIDATE_INT);

        $db->insertVenue($name, $capacity);
        //header("Location: admin.php");
    }
?>