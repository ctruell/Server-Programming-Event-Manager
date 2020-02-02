<?php
    require_once 'DB.class.php';
    //new instance of class
    $db = new DB();

    $db->addEvent($_GET['id']);

    header("Location: reg.php");
?>