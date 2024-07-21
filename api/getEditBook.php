<?php

require_once '../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

if($_SERVER["REQUEST_METHOD"] === 'POST') {

    $headers = apache_request_headers();

    if(!isset($headers['Authorization'])) {
        echo json_encode([
            "message" => "Missing Token"
        ]);
        exit();
    }

    $conn = new Config();
    $pdo = $conn->conn();

    $edit_id = $_POST['edit_id'];

    $stmt = $pdo->prepare("SELECT * FROM books WHERE id = :edit_id");
    $stmt->bindParam(":edit_id", $edit_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if($result) {
        echo json_encode([
            "status" => 200,
            "data" => $result
        ]);
        exit();
    }else {
        echo json_encode([
            "status" => 401,
            "message" => "No data found",
            "data" => []
        ]);
        exit();
    }
    

}else {
    echo json_encode([
        "message" => "Invalid Request method"
    ]);
}

?>