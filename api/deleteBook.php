<?php

require_once '../config/db.php';

header('Content-Type: Application/Json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

if($_SERVER["REQUEST_METHOD"] === 'POST') {

    $delete_id = $_POST['delete_id'];

    // Check headers
    $headers = apache_request_headers();

    if(!isset($headers['Authorization'])) {
        echo json_encode([
            "message" => "Missing AccessToken"
        ]);
        exit();
    }


    // Db Connections
    $conn = new Config();
    $pdo = $conn->conn();

    $stmt = $pdo->prepare("DELETE FROM books WHERE id = :id");
    $stmt->bindParam(':id', $delete_id);
    $result = $stmt->execute();

    if($result && $stmt->rowCount() > 0) {
        echo json_encode([
            "status" => 200,
            "message" => "Book Succesfully deleted"
        ]);
    }else {
        echo json_encode([
            "status" => 401,
            "message" => "Delete Failed"
        ]);
    }

}else {
    echo json_encode([
        "message" => "Invalid Request Method"
    ]);
    exit();
}

?>    