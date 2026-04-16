<?php
include 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $comment_id = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;

    if ($action === 'update_status') {
        $status = $_POST['status'];

        // Update comment status
        $query = "UPDATE comments SET status = '$status' WHERE id = $comment_id";
        if ($conn->query($query)) {
            echo json_encode(['status' => 'success', 'message' => 'Comment status updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        }
    } elseif ($action === 'delete') {
        // Delete comment
        $query = "DELETE FROM comments WHERE id = $comment_id";
        if ($conn->query($query)) {
            echo json_encode(['status' => 'success', 'message' => 'Comment deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
