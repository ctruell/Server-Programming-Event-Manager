<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Edit Venue</h1>
        <form action="editvenue.php" method="POST">
            <input type="text" name="name" placeholder="Name">
            <br />
            <input type="text" name="capacity" placeholder="Capacity">
            <br />
            <input type="submit" name="update" value="Submit">
        </form>
        <h3>Delete Venue</h3>
        <form action="editvenue.php" method="POST">
            <input type="submit" name="delete" value="Delete">
        </form>
        <a href="admin.php">Back</a>
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //delete venue
    if(isset($_POST['delete'])) {
        $db->deleteVenue($_GET['id']);
    }

    //update venue
    if(isset($_POST['update'])) {
        $fields = array("name" => $_POST['name'], "capacity" => $_POST['capacity'], "id" => $_GET['id']);
        //var_dump($fields);
        $db->updateVenue($fields);
        //header("Location: admin.php");
    }
?>