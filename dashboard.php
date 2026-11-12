<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CAT2 Portal | Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5" style="max-width:600px">
    <div class="alert alert-success">
      Login successful. Welcome, <strong><?= htmlspecialchars($_SESSION['fullname']) ?></strong>
      (<?= htmlspecialchars($_SESSION['username']) ?>).
    </div>
    <a href="feedback.php" class="btn btn-primary">Course feedback form</a>
    <a href="logout.php" class="btn btn-outline-secondary">Log out</a>
  </div>
</body>
</html>
