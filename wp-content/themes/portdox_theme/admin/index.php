<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Welcome to the Admin Panel</h2>
   
    <a href="comment_list.php">Comment List</a>
     | <a href="article_list.php">Article List</a>
     | <a href="logout.php" class="btn btn-danger">Logout</a>
    
    
</div>
</body>
</html>