<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Edit User</h1>
        <form action="edituser.php" method="POST">
            <input type="text" name="user" placeholder="Name">
            <br />
            <input type="password" name="password" placeholder="Password">
            <br />
            <select name="role">
                <option value="1">Admin</option>
                <option value="2">Event Manager</option>
                <option value="3">Attendee</option>
            </select>
            <br />
            <input type="submit" name="update" value="Submit">
        </form>
        <h3>Delete User</h3>
        <form action="edituser.php" method="POST">
            <input type="submit" name="delete" value="Delete">
        </form>
        <a href="admin.php">Back</a>
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //delete user
    if(isset($_POST['delete'])) {
        $db->deleteUser($_GET['id']);
    }

    //update user
    if(isset($_POST['update'])) {
        $fields = array("name" => $_POST['user'], "password" => $_POST['password'], "role" => $_POST['role'], "id" => $_GET['id']);
        $db->updateUser($fields);
        //header("Location: admin.php");
    }

    /*if ($_GET['del']) {
        $db->deleteUser($_GET['del']);
    }*/
?>