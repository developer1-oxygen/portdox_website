<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Fetch all articles
$query = "SELECT * FROM articles ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Article List</h2>
    <a href="article_add.php" class="btn btn-success mb-3">Add New Article</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Short Content</th>
                
                <th>Article Date</th>
                <th>Tags</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
       	<tbody>
		    <?php while ($row = $result->fetch_assoc()) : ?>
		        <tr>
		            <td><?= $row['id'] ?></td>
		            <td><?= htmlspecialchars($row['title']) ?></td>
		            <td><?= htmlspecialchars($row['short_content']) ?></td>
                   
		            <td><?= htmlspecialchars($row['article_date']) ?></td>
		            <td><?= htmlspecialchars($row['tags']) ?></td>
		            <td>
		                <?php if (!empty($row['image'])): ?>
		                    <img src="../article_images/<?= $row['image'] ?>" width="100" alt="Article Image">
		                    <br>
		                    <a href="../article_images/<?= $row['image'] ?>" download="<?= $row['image'] ?>" class="btn btn-info btn-sm mt-2">Download</a>
		                <?php else: ?>
		                    No Image
		                <?php endif; ?>
		            </td>
		            <td>
		                <a href="article_edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
		                <button class="btn btn-danger btn-sm delete-btn" data-id="<?= $row['id'] ?>">Delete</button>
		            </td>
		        </tr>
		    <?php endwhile; ?>
		</tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Handle delete button click
    $('.delete-btn').click(function () {
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the article!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete the article
                $.ajax({
                    url: 'delete_article.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to delete the article', 'error');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
