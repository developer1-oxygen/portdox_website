<?php
include_once("admin/db.php");

// Get the category ID
$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch category details
$category_query = "SELECT * FROM categories WHERE id = $category_id";
$category_result = $conn->query($category_query);
$category = $category_result->fetch_assoc();

if (!$category) {
    echo "<h2>Category not found!</h2>";
    exit;
}

// Fetch articles for the category
$articles_query = "SELECT * FROM articles WHERE category_id = $category_id ORDER BY article_date DESC";
$articles_result = $conn->query($articles_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category['name']) ?> - Articles</title>
</head>
<body>
    <h1>Category: <?= htmlspecialchars($category['name']) ?></h1>
    <p><?= htmlspecialchars($category['description']) ?></p>

    <?php while ($article = $articles_result->fetch_assoc()): ?>
        <div>
            <h2><a href="blog-details.php?id=<?= $article['id'] ?>"><?= htmlspecialchars($article['title']) ?></a></h2>
            <p><?= htmlspecialchars(substr($article['short_content'], 0, 100)) ?>...</p>
        </div>
        <hr>
    <?php endwhile; ?>
</body>
</html>
