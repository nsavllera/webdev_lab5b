<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'lab_5b');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $sql = "UPDATE users SET matric='$matric', name='$name', role='$role' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: view_users.php");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Update User</h2>
    <form method="POST" class="mt-4">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <div class="mb-3">
            <label for="matric" class="form-label">Matric</label>
            <input type="text" name="matric" class="form-control" value="<?= $user['matric'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?= $user['name'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="Admin" <?= $user['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                <option value="User" <?= $user['role'] == 'User' ? 'selected' : '' ?>>User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="view_users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
