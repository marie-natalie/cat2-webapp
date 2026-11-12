<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
require 'config.php';

$message = '';
$alert = 'danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course   = trim($_POST['course'] ?? '');
    $rating   = (int)($_POST['rating'] ?? 0);
    $comments = trim($_POST['comments'] ?? '');

    if ($course === '' || $comments === '') {
        $message = 'Course and comments are required.';
    } elseif ($rating < 1 || $rating > 5) {
        $message = 'Rating must be between 1 and 5.';
    } elseif (strlen($comments) > 1000) {
        $message = 'Comments must be under 1000 characters.';
    } else {
        $stmt = $conn->prepare('INSERT INTO feedback (username, course, rating, comments) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssis', $_SESSION['username'], $course, $rating, $comments);
        $stmt->execute();
        $message = 'Thank you! Your feedback was saved.';
        $alert = 'success';
    }
}

$rows = $conn->query('SELECT username, course, rating, comments, submitted_at FROM feedback ORDER BY submitted_at DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CAT2 Portal | Course Feedback</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5" style="max-width:800px">
    <h2 class="mb-4">Course feedback</h2>
    <?php if ($message): ?>
      <div class="alert alert-<?= $alert ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="feedback.php" class="mb-5">
      <div class="mb-3">
        <label class="form-label">Course</label>
        <input type="text" name="course" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Rating (1-5)</label>
        <select name="rating" class="form-select" required>
          <option value="">Choose...</option>
          <?php for ($i = 1; $i <= 5; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Comments</label>
        <textarea name="comments" class="form-control" rows="3" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit feedback</button>
      <a href="dashboard.php" class="btn btn-outline-secondary">Back</a>
    </form>

    <h4>Submitted feedback</h4>
    <table class="table table-striped">
      <thead><tr><th>User</th><th>Course</th><th>Rating</th><th>Comments</th><th>Date</th></tr></thead>
      <tbody>
      <?php while ($r = $rows->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($r['username']) ?></td>
          <td><?= htmlspecialchars($r['course']) ?></td>
          <td><?= (int)$r['rating'] ?></td>
          <td><?= htmlspecialchars($r['comments']) ?></td>
          <td><?= htmlspecialchars($r['submitted_at']) ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
