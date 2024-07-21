<?php

require_once '../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new Config();
    $pdo = $conn->conn();

    $authToken = $conn->checkAuthToken();

    if(!$authToken) {
        echo json_encode([
            "status" => 401,
            "message" => "Missing AuthToken"
        ]);
        exit();
    }

    $edit_id = $_POST['edit_id'];
    $book_name = $_POST['book_name'];
    $author_name = $_POST['author_name'];

    $stmt = $pdo->prepare("UPDATE books SET book_name = :book_name, author_name = :author_name WHERE id = :edit_id");
    $stmt->bindParam(":edit_id", $edit_id);
    $stmt->bindParam(":book_name", $book_name);
    $stmt->bindParam(":author_name", $author_name);
    $result = $stmt->execute();

    if($result && $stmt->rowCount() > 0) {
        echo json_encode([
            "status" => 200,
            "message" => "Book Successfully Updated",
            "rows_affected" => $stmt->rowCount()
        ]);
    }else {
        echo json_encode([
            "status" => 400,
            "message" => "Update Failed",
            "rows_affected" => $stmt->rowCount()
        ]);
        exit();
    }

}else {
    echo json_encode([
        "message" => "Invalid Request Method"
    ]);
}


?>