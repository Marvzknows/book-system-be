<?php
    session_start();
    session_destroy();
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
?>