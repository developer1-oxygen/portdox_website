<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Get the article ID from the URL
$id = $_GET['id'];

// Fetch the current article details
$query = "SELECT * FROM articles WHERE id = $id";
$result = $conn->query($query);
$article = $result->fetch_assoc();

if (!$article) {
    die("Article not found.");
}

// Handle AJAX form submission for updating the article
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $article_date = $_POST['article_date'];
    $short_content = $_POST['short_content'];
    $tags = $_POST['tags'];
    $category_id = $_POST['category_id'];

    $response = [];

    // Directory to store images
    $uploadDir = __DIR__ . '/../article_images/';

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        // Validate file type (only jpg and png allowed)
        if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            $imageName = uniqid('img_', true) . '.' . $fileType;
            $targetFile = $uploadDir . $imageName;

            // Move uploaded file to target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                // Delete the old image if it exists
                if (!empty($article['image']) && file_exists($uploadDir . $article['image'])) {
                    unlink($uploadDir . $article['image']);
                }

                // Update the article with new image path
                $query = "UPDATE articles SET title = '$title', content = '$content', article_date = '$article_date', tags = '$tags', image = '$imageName' WHERE id = $id";
                if ($conn->query($query) === TRUE) {
                    $response = ['status' => 'success', 'message' => 'Article updated successfully'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Database error: ' . $conn->error];
                }
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to upload image'];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid file type. Only JPG and PNG are allowed.'];
        }
    } else {
        // Update the article without changing the image
        $query = "UPDATE articles SET title = '$title', content = '$content', short_content='$short_content', article_date = '$article_date', tags = '$tags', category_id = '$category_id'  WHERE id = $id";
        if ($conn->query($query) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Article updated successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'Database error: ' . $conn->error];
        }
    }
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Edit Article</h2>
    <form id="editArticleForm" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $article['id'] ?>">
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="<?= htmlspecialchars($article['title']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="short_content" class="form-label">Short Content</label>
            <textarea class="form-control" name="short_content" id="short_content" rows="4" required><?= htmlspecialchars($article['short_content']) ?></textarea>
        </div>
        
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" name="content" id="content" rows="4" required><?= htmlspecialchars($article['content']) ?></textarea>
        </div>
        
        <div class="mb-3">
            <label for="article_date" class="form-label">Date</label>
            <input type="date" class="form-control" name="article_date" id="article_date" value="<?= htmlspecialchars($article['article_date']) ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <input type="text" class="form-control" name="tags" id="tags" value="<?= htmlspecialchars($article['tags']) ?>" placeholder="Enter tags separated by commas">
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <?php if (!empty($article['image'])): ?>
                <div>
                    <img src="../article_images/<?= $article['image'] ?>" width="150" alt="Current Image">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png">
            <small class="form-text text-muted">Upload a new image to replace the current one (JPG or PNG only).</small>
        </div>
        
        <?php 
        $categories_query = "SELECT id, name FROM categories ORDER BY name ASC";
        $categories_result = $conn->query($categories_query);
        ?>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" name="category_id" id="category_id" required>
                <option value="">Select Category</option>
                
                <?php while ($category = $categories_result->fetch_assoc()): ?>
                    <option value="<?= $category['id'] ?>" <?= $article['category_id'] == $category['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endwhile; ?>

            </select>
        </div>


        <button type="submit" class="btn btn-primary">Update Article</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#editArticleForm').on('submit', function(event) {
        event.preventDefault();

        const fileInput = document.getElementById('image');
        const file = fileInput.files[0];
        if (file && !['image/jpeg', 'image/png'].includes(file.type)) {
            Swal.fire('Error', 'Invalid file type. Only JPG and PNG are allowed.', 'error');
            return;
        }

        var formData = new FormData(this);

        $.ajax({
            url: 'article_edit.php?id=<?= $id ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Success', response.message, 'success').then(() => {
                        window.location.href = 'article_list.php';
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Something went wrong while submitting the form', 'error');
            }
        });
    });
</script>
</body>
</html>
