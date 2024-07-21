<?php
    require_once '../config/db.php';

    header("Content-Type: Application/json");
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Authorization, Content-Type");

    if($_SERVER["REQUEST_METHOD"] === 'GET') {

        $header = apache_request_headers();

        if(!isset($header['Authorization'])) {
            echo json_encode([
                "message" => 'Accesstoken Missing'
            ]);
            exit();
        }
        
        $conn = new Config();
        $pdo = $conn->conn();

        // GETTING DATA
        $stmt = $pdo->prepare("SELECT * FROM books");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($result) {
            echo json_encode([
                "status" => 200,
                "data" => $result
            ]);
        }else {
            echo json_encode([
                "status" => 200,
                "message" => "No books found",
                // "data" => $result
            ]);
        }

    }
?>