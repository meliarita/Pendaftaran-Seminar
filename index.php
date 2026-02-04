<?php 
include 'layout/header.php'; 
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
                    
                    <div class="mb-2">
                        <label class="form-label text-muted">Password</label>
                        <div class="input-group">
                            <input type="password" name="password" id="passwordInput" class="form-control rounded-start-3" required>
                            <span class="input-group-text rounded-end-3" onclick="togglePassword()" style="cursor: pointer;">
                                <i class="bi bi-eye-slash" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3 text-end">
                        <a href="auth/proses_lupa_password.php" class="text-decoration-none small text-primary">
                            Lupa Password?
                        </a>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100 btn-rounded shadow">login</button>
                </form>
                <p class="mt-3 text-center small text-muted">
                    Belum punya akun? <a href="register_page.php">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    }
</script>

<?php 
include 'layout/footer.php'; 
?>