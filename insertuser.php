<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Insert User</h1>
        <form action="insertuser.php" method="POST">
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
            <input type="submit" name="insert" value="Submit">
        </form>
        <a href="admin.php">Back</a>
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //insert user
    if(isset($_POST['insert'])) {
        $user = stripslashes($_GET['user']);
        $password = stripslashes($_GET['password']);
        $user = strip_tags($user);
        $password = strip_tags($password);
        $role = filter_var($_GET['role'], FILTER_VALIDATE_INT);
        $db->insertUser($user, $password, $_POST['role']);
        //header("Location: admin.php");
    }

    //var_dump($_POST['role']);
?>