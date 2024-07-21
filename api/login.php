<?php
session_start();
require_once '../config/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');

    $conn = new Config();
    $pdo = $conn->conn();

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE username = :username AND password = :password");
    
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $password);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user) {
        // Store the token in the database here
        $token = bin2hex(random_bytes(10));

        $userStmt = $pdo->prepare("UPDATE accounts SET token = :token WHERE username = :username AND password = :password");
        $userStmt->bindParam(":username", $username);
        $userStmt->bindParam(":password", $password);
        $userStmt->bindParam(":token", $token);
        
        $result = $userStmt->execute();

        if($result && $userStmt->rowCount() > 0) {
            echo json_encode([
                "status_code" => 200,
                "status" => 'success',
                "message" => 'Successfully Logged in',
                "access_token" => $token
            ]);
        }else {
            echo json_encode([
                "status_code" => 401,
                "status" => 'error',
                "message" => 'Login Failed',
            ]);
        }

       
        
    } else {
        echo json_encode(["status_code" => 401, "status" => "error", "message" => "Invalid username or password"]);
    }
}
?>
