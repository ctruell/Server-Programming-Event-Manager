<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="logout.php" id="right">Log Out</a>
        <h1>Events</h1>
        <button onclick="window.location.href = 'reg.php';">Registrations</button>
        <!--<button onclick="window.location.href = 'admin.php';">Admin</button>-->
        <?php
            require_once 'DB.class.php';
            //new instance of class
            $db = new DB();

            if (isset($_GET['user'])) {
                $r = $db->getRole($_GET['user']);
            }
            if (isset($_GET['newuser'])) {
                $r = $db->getRole($_GET['newuser']);
            }
            if ($r[0]["role"] != 3) {
                ?>
                <button onclick="window.location.href = 'admin.php';">Admin</button>
                <?php
                //echo "<a href='admin.php'>Admin</a>";
            }
        ?>
    </body>
</html>

<?php
    session_start();
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    //print table with data and link
    echo $db->getAllEventsAsTable();

    //authenticating user validating/sanatizing input starting session
    if (isset($_GET['newuser'])) {
        $user = strip_tags($_GET['newuser']);
        $password = strip_tags($_GET['password']);
        $user = stripslashes($user);
        $password = stripslashes($password);
        $password = hash('sha256', $password);
        $role = filter_var($_GET['role'], FILTER_VALIDATE_INT);

        $db->insertUser($user, $password, $_GET['role']);
        session_name($_GET['newuser']);
        //session_start();
        $_SESSION['logged_in'] = true;
    }
    
    //authenticating user validating/sanatizing input
    if (isset($_GET['user']) && isset($_GET['password'])) {
        if ($_GET['user'] == "" || $_GET['password'] == "") {
            header("Location: login.php");
            //echo "Invalid login";
        }
        else {
            $u = $_GET['user'];
            $p = $_GET['password'];

            $user = strip_tags($u);
            $user = stripslashes($user);
            $password = strip_tags($p);
            $password = stripslashes($password);
            $password = hash('sha256', $password);

            $db->login($user, $password);
        }
    }

    /*if (isset($_GET['user']) && isset($_GET['password'])) {
        //session_name("session");
        //session_start();
        $user = $_GET['user'];
        $password = $_GET['password'];
        $data = array();
        if ($stmt = $this->dbh->prepare("select attendee.name, password from `attendee`")) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($name, $password);
            if ($stmt->num_rows > 0) {
                while ($stmt->fetch()) {
                    $data[] = array("name"=>$name, "password"=>$password);
                    if ($name == $_GET['user'] && $password == $_GET['password']) {
                        header("Location: account.php");
                    }
                    else {
                        header("Location: login.php");
                        echo "Invalid login!";
                    }
                }
            }
        }
    }*/
?>