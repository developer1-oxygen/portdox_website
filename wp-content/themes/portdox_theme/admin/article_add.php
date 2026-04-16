<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Handle AJAX form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $short_content = $_POST['short_content'];

    $article_date = $_POST['article_date'];
    $tags = $_POST['tags'];
    $response = [];

    // Directory outside admin to store images
    $uploadDir = __DIR__ . '/../article_images/';
    
    // Ensure the directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create directory with write permissions
    }

    // Handle image upload if an image is provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $fileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($fileType, ['jpg', 'jpeg', 'png'])) {
            $imageName = uniqid('img_', true) . '.' . $fileType;
            $targetFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $query = "INSERT INTO articles (title, short_content, content, article_date, tags, image) VALUES ('$title','$short_content', '$content', '$article_date', '$tags', '$imageName')";
                if ($conn->query($query) === TRUE) {
                    $response = ['status' => 'success', 'message' => 'Article added successfully'];
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
        $query = "INSERT INTO articles (title, content, article_date, tags) VALUES ('$title', '$content', '$article_date', '$tags')";
        if ($conn->query($query) === TRUE) {
            $response = ['status' => 'success', 'message' => 'Article added successfully'];
        } else {
            $response = ['status' => 'error', 'message' => 'Database error: ' . $conn->error];
        }
    }
    
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
    <title>Add Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <h2>Add New Article</h2>

    <!--ya mera edit artical ka code ha is ma short description add karni ha ya column ma nay add kar daya short_content-->
    <form id="articleForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <div class="mb-3">
            <label for="short_content" class="form-label">Short Content</label>
            <textarea class="form-control" name="short_content" id="short_content" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" name="content" id="content" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="article_date" class="form-label">Date</label>
            <input type="date" class="form-control" name="article_date" id="article_date" required>
        </div>
        <div class="mb-3">
            <label for="tags" class="form-label">Tags</label>
            <input type="text" class="form-control" name="tags" id="tags" placeholder="Enter tags separated by commas">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" name="image" id="image" accept=".jpg, .jpeg, .png">
        </div>
        <button type="submit" class="btn btn-primary">Add Article</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#articleForm').on('submit', function(event) {
        event.preventDefault();

        const fileInput = document.getElementById('image');
        const file = fileInput.files[0];
        if (file && !['image/jpeg', 'image/png'].includes(file.type)) {
            Swal.fire('Error', 'Invalid file type. Only JPG and PNG are allowed.', 'error');
            return;
        }

        var formData = new FormData(this);

        $.ajax({
            url: 'article_add.php',
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
