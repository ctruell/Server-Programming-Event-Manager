<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Admin</h1>
        <button onclick="window.location.href = 'account.php';">Events</button>
        <button onclick="window.location.href = 'reg.php';">Registrations</button>
        <br />
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //print table with data and link
    echo "<h2>Users</h2>";
    echo $db->getAllUsersAsTable();
    echo "<a href='insertuser.php'>Add User</a>";
    echo "<h2>Venues</h2>";
    echo $db->getAllVenuesAsTable();
    echo "<a href='editvenue.php'>Add Venue</a>";
    echo "<h2>Events</h2>";
    echo $db->getAllEventsAsTable();
    echo "<a href='editevent.php'>Add Event</a>";
    echo "<h2>Sessions</h2>";
    echo $db->getAllSessionsAsTable();
    echo "<a href='editsession.php'>Add Session</a>";

    /*if ($_GET['role'] == 3) {
        header("Location: account.php");
    }*/
?>