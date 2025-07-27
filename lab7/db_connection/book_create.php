<?php
require_once '../db_connection/db.php';
// Fetch authors for dropdown
$authors = [];
$res = $conn->query('SELECT id, name FROM author ORDER BY name');
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $authors[] = $row;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author_id = intval($_POST['author_id'] ?? 0);
    $desc = trim($_POST['description'] ?? '');
    if ($title === '' || $author_id === 0) {
        $msg = 'Title and author are required!';
    } else {
        $stmt = $conn->prepare('INSERT INTO book (title, author_id, description) VALUES (?, ?, ?)');
        $stmt->bind_param('sis', $title, $author_id, $desc);
        if ($stmt->execute()) {
            $msg = 'Book added successfully!';
        } else {
            $msg = 'Error: ' . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Book</title>
</head>
<body>
    <h2>Add Book</h2>
    <form method="post">
        <input type="text" name="title" placeholder="Book Title" required><br>
        <select name="author_id" required>
            <option value="">Select Author</option>
            <?php foreach ($authors as $a): ?>
                <option value="<?= $a['id'] ?>"><?= htmlspecialchars($a['name']) ?></option>
            <?php endforeach; ?>
        </select><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <button type="submit">Add Book</button>
    </form>
    <?php if (isset($msg)) echo '<p>' . htmlspecialchars($msg) . '</p>'; ?>
</body>
</html>
