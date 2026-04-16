<?php
include_once("admin/db.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = isset($_POST['article_id']) ? (int)$_POST['article_id'] : 0;
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    $query = "INSERT INTO comments (article_id, name, email, content, status, created_at) 
              VALUES ($article_id, '$name', '$email', '$message', 'pending', NOW())";
    if ($conn->query($query)) {
        echo json_encode([
            'success' => true,
            'name' => $name,
            'message' => $message,
            'created_at' => date('d M Y, H:i')
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save comment.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request.']);
}
?>
