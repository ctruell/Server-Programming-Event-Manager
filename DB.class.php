<?php
    class DB {
        private $dbh;

        function __construct() {
            $this->dbh = new mysqli($_SERVER['DB_SERVER'], $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'], $_SERVER['DB']);
            if ($this->dbh->connect_error) {
                //don't do in production code
                echo "Connection failed: ".mysqli_connect_error();
                die();
            }
        }

        //function to get all people
        function getAllEvents() {
            $data = array();
            if ($stmt = $this->dbh->prepare("select idevent, event.name, datestart, dateend, event.numberallowed, session.name, venue.name from `event` join venue on idvenue = venue join session on idevent = `event`")) {
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id, $name, $datestart, $dateend, $numberallowed, $session, $venue);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        $data[] = array("id"=>$id, "name"=>$name, "datestart"=>$datestart, "dateend"=>$dateend, "numberallowed"=>$numberallowed, "session"=> $session, "venue"=>$venue);
                    }
                }
            }
            return $data;
        }

        //function to get all people
        function getAllEventsAlt($iden) {
            $data = array();
            if ($stmt = $this->dbh->prepare("select idevent, event.name, datestart, dateend, event.numberallowed, session.name, venue.name from `event` join venue on idvenue = venue join session on idevent = session.event join attendee_event on idevent = attendee_event.event join attendee on attendee = idattendee where idattendee = ?")) {
                $stmt->bind_param("i", $iden);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id, $name, $datestart, $dateend, $numberallowed, $session, $venue);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        $data[] = array("id"=>$id, "name"=>$name, "datestart"=>$datestart, "dateend"=>$dateend, "numberallowed"=>$numberallowed, "session"=> $session, "venue"=>$venue);
                    }
                }
            }
            return $data;
        }

        //function to display people in table
        function getAllEventsAsTable() {
            $data = $this->getAllEvents();
            //$venue = $this->getAllVenues();
            if (count($data) > 0) {
                $bigString = "<table border='1'>\n
                    <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Capacity</th>
                    <th>Session</th>
                    <th>Venue</th>
                    </tr>\n";
                foreach ($data as $row) {
                    $bigString .= "<tr>
                    <td><a href='editevent.php?id={$row['id']}'>{$row['id']}</a></td>
                    <td>{$row['name']}</td>
                    <td>{$row['datestart']}</td>
                    <td>{$row['dateend']}</td>
                    <td>{$row['numberallowed']}</td>
                    <td>{$row['session']}</td>
                    <td>{$row['venue']}</td>
                    </tr>\n";
                }
                $bigString .= "</table>\n";
            }
            else {
                $bigString = "<h2>No events exist.</h2>";
            }
            return $bigString;
        }

        //add displays events
        function joinEvent() {
            $data = $this->getAllEvents();
            //$venue = $this->getAllVenues();
            if (count($data) > 0) {
                $bigString = "<table border='1'>\n
                    <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Capacity</th>
                    <th>Session</th>
                    <th>Venue</th>
                    </tr>\n";
                foreach ($data as $row) {
                    $bigString .= "<tr>
                    <td><a href='joinevent2.php?{$row['id']}'>{$row['id']}</a></td>
                    <td>{$row['name']}</td>
                    <td>{$row['datestart']}</td>
                    <td>{$row['dateend']}</td>
                    <td>{$row['numberallowed']}</td>
                    <td>{$row['session']}</td>
                    <td>{$row['venue']}</td>
                    </tr>\n";
                }
                $bigString .= "</table>\n";
            }
            else {
                $bigString = "<h2>No events exist.</h2>";
            }
            return $bigString;
        }

        //adds attendee to an event
        function addEvent($id) {
            if (isset($_COOKIE[2])) {
                $pid = 1;
                $queryString = "insert into manager_event (event, manager) values (?, ?)";
                $insertId = -1;
                if ($stmt = $this->dbh->prepare($queryString)) {
                    $stmt->bind_param("ii", $id, $pid);
                    $stmt->execute();
                    $stmt->store_result();
                    $insertId = $stmt->insert_id;
                }
                return $insertId;
            }
            else if (isset($_COOKIE[3])) {
                $pid = 2;
                $queryString = "insert into attendee_event (event, attendee, paid) values (?, ?, ?)";
                $insertId = -1;
                if ($stmt = $this->dbh->prepare($queryString)) {
                    $stmt->bind_param("iii", $id, $pid, 100);
                    $stmt->execute();
                    $stmt->store_result();
                    $insertId = $stmt->insert_id;
                }
                return $insertId;
            }
        }

        //function to display people in table
        function getAllEventsAsTableAlt($id) {
            $data = $this->getAllEventsAlt($id);
            //$venue = $this->getAllVenues();
            if (count($data) > 0) {
                $bigString = "<table border='1'>\n
                    <tr>
                    <th>ID</th>
                    <th>Event Name</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    <th>Capacity</th>
                    <th>Session</th>
                    <th>Venue</th>
                    </tr>\n";
                foreach ($data as $row) {
                    $bigString .= "<tr>
                    <td><a href='editevent.php?id={$row['id']}'>{$row['id']}</a></td>
                    <td>{$row['name']}</td>
                    <td>{$row['datestart']}</td>
                    <td>{$row['dateend']}</td>
                    <td>{$row['numberallowed']}</td>
                    <td>{$row['session']}</td>
                    <td>{$row['venue']}</td>
                    </tr>\n";
                }
                $bigString .= "</table>\n";
            }
            else {
                $bigString = "<h2>No events exist.</h2>";
            }
            return $bigString;
        }

        function getAllVenues() {
            $data = array();
            if ($stmt = $this->dbh->prepare("select * from venue")) {
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id, $name, $capacity);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        $data[] = array("id"=>$id, "name"=>$name, "capacity"=>$capacity);
                    }
                }
            }
            return $data;
        }

        //function to display people in table
        function getAllVenuesAsTable() {
            $data = $this->getAllVenues();
            //$venue = $this->getAllVenues();
            if (count($data) > 0) {
                $bigString = "<table border='1'>\n
                    <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Capacity</th>
                    </tr>\n";
                foreach ($data as $row) {
                    $bigString .= "<tr>
                    <td><a href='editvenue.php?id={$row['id']}'>{$row['id']}</a></td>
                    <td>{$row['name']}</td>
                    <td>{$row['capacity']}</td>
                    </tr>\n";
                }
                $bigString .= "</table>\n";
            }
            else {
                $bigString = "<h2>No venues exist.</h2>";
            }
            return $bigString;
        }

        //function to get all people
        function getAllUsers() {
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

        //function to display people in table
        function getAllUsersAsTable() {
            $data = $this->getAllUsers();
            if (count($data) > 0) {
                $bigString = "<table border='1'>\n
                    <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Password</th>
                    <th>Role</th>
                    </tr>\n";
                foreach ($data as $row) {
                    $bigString .= "<tr>
                    <td><a href='edituser.php?id={$row['id']}'>{$row['id']}</a></td>
                    <td>{$row['name']}</td>
                    <td>{$row['password']}</td>
                    <td>{$row['role']}</td>
                    </tr>\n";
                }
                $bigString .= "</table>\n";
            }
            else {
                $bigString = "<h2>No attendees exist.</h2>";
            }
            return $bigString;
        }

        //function to get all people
        function getAllSessions() {
            $data = array();
            if ($stmt = $this->dbh->prepare("select idsession, session.name, session.numberallowed, event.name, startdate, enddate from `session` join event on idevent = `event`")) {
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id, $name, $numberallowed, $event, $datestart, $dateend);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        $data[] = array("id"=>$id, "name"=>$name, "numberallowed"=>$numberallowed, "event"=> $event, "datestart"=>$datestart, "dateend"=>$dateend);
                    }
                }
            }
            return $data;
        }

        //function to display people in table
        function getAllSessionsAsTable() {
            $data = $this->getAllSessions();
            //$venue = $this->getAllVenues();
            if (count($data) > 0) {
                $bigString = "<table border='1'>\n
                    <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Capacity</th>
                    <th>Event</th>
                    <th>Date Start</th>
                    <th>Date End</th>
                    </tr>\n";
                foreach ($data as $row) {
                    $bigString .= "<tr>
                    <td><a href='editsession.php?id={$row['id']}'>{$row['id']}</a></td>
                    <td>{$row['name']}</td>
                    <td>{$row['numberallowed']}</td>
                    <td>{$row['event']}</td>
                    <td>{$row['datestart']}</td>
                    <td>{$row['dateend']}</td>
                    </tr>\n";
                }
                $bigString .= "</table>\n";
            }
            else {
                $bigString = "<h2>No sessions exist.</h2>";
            }
            return $bigString;
        }

        //function to insert entry into database
        function insertUser($name, $password, $role) {
            $queryString = "insert into attendee (name, password, role) values (?, ?, ?)";
            $insertId = -1;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("ssi", $name, $password, $role);
                $stmt->execute();
                $stmt->store_result();
                $insertId = $stmt->insert_id;
            }
            return $insertId;
        } 

        //function to update entry in database
        function updateUser($fields) {
            $queryString = "update attendee set ";
            $updateId = 0;
            $numRows = 0;
            $items = array();
            $types = "";
            foreach ($fields as $k=>$v) {
                switch($k) {
                    case "name":
                        $queryString .= "name = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change from $items[] = &$v
                        $types .= "s";
                        break;
                    case "password":
                        $queryString .= "password = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "role":
                        $queryString .= "role = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "i";
                        break;
                    case "id":
                        $updateId = intVal($v);
                        break;
                }
            }
            $queryString = trim($queryString, ",");
            $queryString .= " where idattendee = ?";
            $types .= "i";
            $items[] = &$updateId;
            //var_dump($queryString,$types,$items);
            if ($stmt = $this->dbh->prepare($queryString)) {
                $refArr = array_merge(array($types), $items);
                $ref = new ReflectionClass("mysqli_stmt");
                $method = $ref->getMethod("bind_param");
                $method->invokeArgs($stmt, $refArr);
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }

            return $numRows;
        }

        //function to delete entry from database
        function deleteUser($id) {
            $queryString = "delete from attendee where idattendee = ?";
            $numRows = 0;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("i", intVal($id));
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }
            return $numRows;
        }

        //function to insert entry into database
        function insertVenue($name, $capacity) {
            $queryString = "insert into venue (name, capacity) values (?, ?)";
            $insertId = -1;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("si", $name, $capacity);
                $stmt->execute();
                $stmt->store_result();
                $insertId = $stmt->insert_id;
            }
            return $insertId;
        } 

        //function to update entry in database
        function updateVenue($fields) {
            $queryString = "update venue set ";
            $updateId = 0;
            $numRows = 0;
            $items = array();
            $types = "";
            foreach ($fields as $k=>$v) {
                switch($k) {
                    case "name":
                        $queryString .= "name = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "capacity":
                        $queryString .= "capacity = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "i";
                        break;
                    case "id":
                        $updateId = intVal($v);
                        break;
                }
            }
            $queryString = trim($queryString, ",");
            $queryString .= " where idvenue = ?";
            $types .= "i";
            $items[] = &$updateId;

            if ($stmt = $this->dbh->prepare($queryString)) {
                $refArr = array_merge(array($types), $items);
                $ref = new ReflectionClass("mysqli_stmt");
                $method = $ref->getMethod("bind_param");
                $method->invokeArgs($stmt, $refArr);
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }

            return $numRows;
        }

        //function to delete entry from database
        function deleteVenue($id) {
            $queryString = "delete from venue where idvenue = ?";
            $numRows = 0;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("i", intVal($id));
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }
            return $numRows;
        }

        //function to insert entry into database
        function insertEvent($name, $start, $end, $capacity, $venue) {
            $queryString = "insert into event (name, datestart, dateend, numberallowed, venue) values (?, ?, ?, ?, ?)";
            $insertId = -1;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("sssii", $name, $start, $end, $capacity, $venue);
                $stmt->execute();
                $stmt->store_result();
                $insertId = $stmt->insert_id;
            }
            return $insertId;
        } 

        //function to update entry in database
        function updateEvent($fields) {
            $queryString = "update event set ";
            $updateId = 0;
            $numRows = 0;
            $items = array();
            $types = "";
            foreach ($fields as $k=>$v) {
                switch($k) {
                    case "name":
                        $queryString .= "name = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "start":
                        $queryString .= "datestart = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "end":
                        $queryString .= "dateend = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "capacity":
                        $queryString .= "numberallowed = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "i";
                        break;
                    case "venue":
                        $queryString .= "venue = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "i";
                        break;
                    case "id":
                        $updateId = intVal($v);
                        break;
                }
            }
            $queryString = trim($queryString, ",");
            $queryString .= " where idevent = ?";
            $types .= "i";
            $items[] = &$updateId;

            if ($stmt = $this->dbh->prepare($queryString)) {
                $refArr = array_merge(array($types), $items);
                $ref = new ReflectionClass("mysqli_stmt");
                $method = $ref->getMethod("bind_param");
                $method->invokeArgs($stmt, $refArr);
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }

            return $numRows;
        }

        //function to delete entry from database
        function deleteEvent($id) {
            $queryString = "delete from event where idevent = ?";
            $numRows = 0;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("i", intVal($id));
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }
            return $numRows;
        }

                //function to insert entry into database
        function insertSession($name, $start, $end, $capacity, $venue) {
            $queryString = "insert into session (name, numberallowed, event, datestart, dateend) values (?, ?, ?, ?, ?)";
            $insertId = -1;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("siiss", $name, $capacity, $event, $start, $end);
                $stmt->execute();
                $stmt->store_result();
                $insertId = $stmt->insert_id;
            }
            return $insertId;
        } 

        //function to update entry in database
        function updateSession($fields) {
            $queryString = "update session set ";
            $updateId = 0;
            $numRows = 0;
            $items = array();
            $types = "";
            foreach ($fields as $k=>$v) {
                //use print statements to check what is going wrong
                switch($k) {
                    case "name":
                        $queryString .= "name = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "capacity":
                        $queryString .= "numberallowed = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "i";
                        break;
                    case "event":
                        $queryString .= "event = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "i";
                        break;
                    case "start":
                        $queryString .= "datestart = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "end":
                        $queryString .= "dateend = ?,";
                        $items[] = &$fields[$k]; //may have to come back and change
                        $types .= "s";
                        break;
                    case "id":
                        $updateId = intVal($v);
                        break;
                }
            }
            $queryString = trim($queryString, ",");
            $queryString .= " where idsession = ?";
            $types .= "i";
            $items[] = &$updateId;

            if ($stmt = $this->dbh->prepare($queryString)) {
                $refArr = array_merge(array($types), $items);
                $ref = new ReflectionClass("mysqli_stmt");
                $method = $ref->getMethod("bind_param");
                $method->invokeArgs($stmt, $refArr);
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }

            return $numRows;
        }

        //function to delete entry from database
        function deleteSession($id) {
            $queryString = "delete from session where idsession = ?";
            $numRows = 0;
            if ($stmt = $this->dbh->prepare($queryString)) {
                $stmt->bind_param("i", intVal($id));
                $stmt->execute();
                $stmt->store_result();
                $numRows = $stmt->affected_rows;
            }
            return $numRows;
        }
        //get the role of user from name
        function getRole($name) {
            $data = array();
            if ($stmt = $this->dbh->prepare("select role from `attendee` where name = ?")) {
                $stmt->bind_param("s", $name);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($role);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        $data[] = array("role"=>$role);
                    }
                }
            }
            //var_dump($data);
            return $data;
        }

        //get the role of user from id
        function getRoleID($id) {
            $data = array();
            if ($stmt = $this->dbh->prepare("select role from `attendee` where idattendee = ?")) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($role);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        $data[] = array("role"=>$role);
                    }
                }
            }
            //var_dump($data);
            return $data;
        }

        //function to login
        function login($user, $password) {
            $data = array();
            if ($stmt = $this->dbh->prepare("select name, password from attendee where name = ? and password = ?")) {
                $stmt->bind_param('ss', $user, $password);
                $stmt->execute();
                $stmt->bind_result($user, $password);
                if ($stmt->num_rows > 0) {
                    while ($stmt->fetch()) {
                        $data[] = array("user"=>$user, "password"=>$password);
                    }
                }
                session_name($_GET['user']);
                //session_start();
                $d = $this->getRole($user);
                setcookie($d[0]["role"], true);
                setcookie($_GET['user'], $_GET['user']);
            }
            else {
                header("Location: login.php");
                echo "The username or password is incorrect!";
            }
        }
    }