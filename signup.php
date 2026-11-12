?php
require 'config.php';
$message = '';
$alert = 'danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($fullname === '' || $username === '' || $email === '' || $password === '') {
        $message = 'All fields are required.';
    } elseif (!preg_match('/^[A-Za-z0-9_]{3,30}$/', $username)) {
        $message = 'Username must be 3-30 letters, numbers or underscores.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $message = 'Password must be at least 8 characters.';
    } else {
        $check = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
        $check->bind_param('ss', $username, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = 'That username or email is already registered.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO users (fullname, username, email, password_hash) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $fullname, $username, $email, $hash);
            $stmt->execute();
            $message = 'Account created! You can now log in.';
            $alert = 'success';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
@@ -48,30 +11,26 @@
  <div class="container py-5" style="max-width:480px">
    <h2 class="text-center mb-4">Create your account</h2>
    
<?php if ($message): ?>
  <div class="alert alert-<?= $alert ?>"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
    
    <form method="POST" action="signup.php">
      <div class="mb-3">
        <label class="form-label">Full name</label>
        <input type="text" name="fullname" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" minlength="8" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Sign up</button>
      <p class="text-center mt-3">Already registered? <a href="login.php">Log in</a></p>
    </form>
  </div>
</body>
</html>
