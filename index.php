<?php 
include 'layout/header.php'; // Ini otomatis memanggil semua link CSS & tag <head>
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-soft p-4">
                <h3 class="text-center mb-4 fw-bold">Login Peserta</h3>
                <form action="auth/login.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 btn-rounded shadow">Masuk</button>
                </form>
                <p class="mt-3 text-center small text-muted">
                    Belum punya akun? <a href="register_page.php">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<?php 
include 'layout/footer.php'; // Ini otomatis memanggil link JavaScript & tag </html>
?>