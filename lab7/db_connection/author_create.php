<?php
require_once '../db_connection/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        $msg = 'Author name is required!';
    } else {
        $stmt = $conn->prepare('INSERT INTO author (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        if ($stmt->execute()) {
            $msg = 'Author added successfully!';
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
    <title>Add Author</title>
</head>
<body>
    <h2>Add Author</h2>
    <form method="post">
        <input type="text" name="name" placeholder="Author Name" required>
        <button type="submit">Add Author</button>
    </form>
    <?php if (isset($msg)) echo '<p>' . htmlspecialchars($msg) . '</p>'; ?>
</body>
</html>
