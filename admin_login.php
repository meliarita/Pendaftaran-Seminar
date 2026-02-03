<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Login</title>
</head>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">Admin Login</h3>
                        <form action="auth/admin_auth.php" method="POST">
                            <div class="mb-3">
                                <label>Username Admin</label>
                                <input type="text" name="username" class="form-control" placeholder="admin" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="admin123" required>
                            </div>
                            <button type="submit" name="login_admin" class="btn btn-danger w-100">Login Sebagai Admin</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>