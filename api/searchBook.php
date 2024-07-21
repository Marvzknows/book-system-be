<?php

require_once '../config/db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization, Content-Type');

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn = new Config();
    $pdo = $conn->conn();

    $headers = $conn->checkAuthToken();
    if(!$headers) {
        echo json_encode([
            "status" => 401,
            "message" => "Missing AuthToken"
        ]);
        exit();
    }

    $search = '%'.$_POST['search'].'%';

    $stmt = $pdo->prepare("SELECT * FROM books WHERE book_name LIKE :search");
    $stmt->bindParam(":search", $search);
    $result = $stmt->execute();

    if($result) {
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode([
            "status" => 200,
            "message" => "Book retrieved Successfully",
            "data" => $data
        ]);
        exit();
    }else {
        echo json_encode([
            "status" => 401,
            "message" => "Failed to Retrieved Books",
            "data" => $data
        ]);
        exit();
    }


}else {
    echo json_encode([
        "status" => 401,
        "message" => "Invalid Request Method"
    ]);
}

?>