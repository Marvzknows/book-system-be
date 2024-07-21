<?php

require_once '../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Authorization, Content-Type');
header('Access-Control-Allow-Origin: *');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Check Access Token
    $headers = apache_request_headers();
    if(!isset($headers['Authorization'])) {
        echo json_encode([
            "message" => 'Missing accessToken'
        ]);
        exit();
    }
    // DB Connection
    $conn = new Config();
    $pdo = $conn->conn();

    $book_name = $_POST['book_name'];
    $book_author = $_POST['book_author'];

    $stmt = $pdo->prepare("INSERT INTO books (book_name	, author_name) VALUES (:book_name, :book_author)");
    $stmt->bindParam(":book_name", $book_name);
    $stmt->bindParam(":book_author", $book_author);
    $result = $stmt->execute();

    if($result && $stmt->rowCount() > 0) {
        echo json_encode([
            "status" => 200,
            "message" => $book_name. "Successfully Added"
        ]);
        // exit();
    }else {
        echo json_encode([
            "status" => 401,
            "message" => "Failed"
        ]);
        // exit();
    }

}else {
    echo json_encode([
        "message" => "Invalid Request Method"
    ]);
}

?>