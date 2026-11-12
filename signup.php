?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CAT2 Portal | Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5" style="max-width:480px">
    <h2 class="text-center mb-4">Create your account</h2>
    
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
