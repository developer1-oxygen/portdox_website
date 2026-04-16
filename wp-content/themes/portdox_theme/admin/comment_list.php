<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Manage Comments</h2>

	<?php
	include 'db.php';

	// Fetch all comments
	$comments_query = "SELECT c.id, c.name, c.content, c.status, c.created_at, a.title AS article_title 
	                   FROM comments c 
	                   LEFT JOIN articles a ON c.article_id = a.id 
	                   ORDER BY c.created_at DESC";
	$comments_result = $conn->query($comments_query);
	?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Comment</th>
                <th>Article</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($comment = $comments_result->fetch_assoc()): ?>
                <tr>
                    <td><?= $comment['id'] ?></td>
                    <td><?= htmlspecialchars($comment['name']) ?></td>
                    <td><?= htmlspecialchars($comment['content']) ?></td>
                    <td><?= htmlspecialchars($comment['article_title']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($comment['status'])) ?></td>
                    <td>
                        <button class="btn btn-success btn-sm" onclick="updateStatus(<?= $comment['id'] ?>, 'approved')">Approve</button>
                        <button class="btn btn-warning btn-sm" onclick="updateStatus(<?= $comment['id'] ?>, 'rejected')">Reject</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteComment(<?= $comment['id'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Update comment status (Approve/Reject)
    function updateStatus(commentId, status) {
        $.ajax({
            url: 'comment_actions.php',
            type: 'POST',
            data: { action: 'update_status', comment_id: commentId, status: status },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Success', response.message, 'success').then(() => location.reload());
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong.', 'error');
            }
        });
    }

    // Delete comment
    function deleteComment(commentId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'comment_actions.php',
                    type: 'POST',
                    data: { action: 'delete', comment_id: commentId },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    }
</script>
</body>
</html>
