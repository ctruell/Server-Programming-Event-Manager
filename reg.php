<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Registrations</h1>
        <button onclick="window.location.href = 'account.php';">Events</button>
        <?php
            require_once 'DB.class.php';
            //new instance of class
            $db = new DB();

            if (isset($_COOKIE[1]) || isset($_COOKIE[2])) {
                ?>
                <button onclick="window.location.href = 'admin.php';">Admin</button>
                <?php
                //echo "<a href='admin.php'>Admin</a>";
            }
        ?>
    </body>
</html>

<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //print table with data and link
    echo "<h2>Events</h2>";
    echo $db->getAllEventsAsTableAlt(4);
    echo "<a href='joinevent.php'>Join Event</a>";
?>