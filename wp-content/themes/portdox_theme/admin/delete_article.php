<?php
session_start();
include 'db.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $response = [];

    // Retrieve the image name to delete it from the directory
    $query = "SELECT image FROM articles WHERE id = $id";
    $result = $conn->query($query);
    $article = $result->fetch_assoc();

    if ($article) {
        // Delete the image file if it exists
        $uploadDir = __DIR__ . '/../article_images/';
        if (!empty($article['image']) && file_exists($uploadDir . $article['image'])) {
            unlink($uploadDir . $article['image']);
        }

        // Delete the article from the database
        $query = "DELETE FROM articles WHERE id = $id";
        if ($conn->query($query) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Article deleted successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to delete article: ' . $conn->error];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Article not found'];
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
