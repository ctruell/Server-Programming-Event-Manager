<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Clare's Event Management System</title>
    </head>
    <body>
        <a href="login.php" id="right">Login</a>
        <br />
        <div class="box">
            <h1>Sign Up</h1>
            <form action="account.php" method="GET">
                <input type="text" class="i" name="newuser" placeholder="Username" required>
                <br />
                <input type="password" class="i" name="password" placeholder="Password" required>
                <select name="role" id="center">
                    <option value="1">Admin</option>
                    <option value="2">Event Manager</option>
                    <option value="3">Attendee</option>
                </select>
                <input type="submit" class="i" value="Submit">
            </form>
        </div>
    </body>
</html>