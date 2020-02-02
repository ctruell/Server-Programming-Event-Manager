<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="signup.php" id="right">Sign Up</a>
        <br />
        <div class="box">
            <h1>Login</h1>
            <form action="account.php" method="GET">
                <input type="text" class="i" name="user" placeholder="Username" required>
                <br />
                <input type="password" class="i" name="password" placeholder="Password" required>
                <input type="submit" class="i" value="Submit">
            </form>
        </div>
    </body>
</html>

<?php
    function userCheck() {
        $data = array();
        if ($stmt = $this->dbh->prepare("select idattendee, attendee.name, password, role.name from `attendee` join `role` on idrole = role")) {
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $name, $password, $role);
            if ($stmt->num_rows > 0) {
                while ($stmt->fetch()) {
                    $data[] = array("id"=>$id, "name"=>$name, "password"=>$password, "role"=>$role);
                }
            }
        }
        return $data;
    }

    require_once 'DB.class.php';
    $db = new DB();
?>