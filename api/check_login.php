<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
// $_SESSION['logged_in'] = true;
if (isset($_SESSION['logged_in'])) {
    $loggedIn = $_SESSION['logged_in'];
} else {
    $loggedIn = 'not set';
}

echo json_encode([
    "success" => isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true,
    "message" => $loggedIn
]);
?>
