<?php
    if (isset($_GET['user']) && isset($_GET['password'])) {
        $user = $_GET['user'];
        $password = $_GET['password'];
        //name and start session
        session_name($user);
        session_start();
        require_once "DB.class.php";
        /*function getAttendees($user) {
            try {
                $data = array();
                $stmt = $this->dbh->prepare("select * from attendee where attendee=':user'");
                $stmt->execute(array("user"=>$user));
                while ($row = $stmt->fetch()) {
                    $data[] = $row;
                    if ($row['password'] == $password) {
                        header('Location: account.php');
                    }
                }
                return $data;
            }
            catch (PDOException $e) {
                echo $e->getMessage();
                die();
            }
        }*/
        //redirect to events page if the user is in the db
        $data = array();
        if ($stmt = $this->dbh->prepare("select * from attendee where attendee='?'")) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($user);
            if ($stmt->num_rows > 0) {
                while ($stmt-> fetch()) {
                    if ($stmt['password'] == $password) {
                        header('Location: account.php');
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="login.php" id="right">Log In</a>
        <br />
        <h1>Clare's Event Management System</h1>
    </body>
</html>