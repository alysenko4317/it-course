<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Book Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Optional: you can customize the max width of the form here */
        .form-container {
            max-width: 400px; /* Sets a fixed max width for the form */
            margin: 0 auto; /* Centers the form horizontally */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2 class="text-center mb-4">Sign In</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/login" method="POST">
                <div class="mb-3">
                    <label for="ticket" class="form-label">Ticket ID</label>
                    <input type="text" class="form-control" id="ticket" name="ticket" placeholder="Enter your ticket" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
            <div class="text-center mt-3">
                <p>Don't have an account? <a href="/register">Sign Up</a></p>
                <p><a href="/forgot-password">Forgot Password?</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

