<?php
    //starting and destroying session and redirecting to homepage
    session_start();
    session_destroy();
    header("Location: index.php");
?>