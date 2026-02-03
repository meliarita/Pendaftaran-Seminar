<?php 
include 'layout/header.php'; 
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-soft border-0 p-4 rounded-4">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle d-inline-block mb-2">
                            <i class="bi bi-person-plus-fill text-primary fs-1"></i>
                        </div>
                        <h3 class="fw-bold mt-2">Daftar Akun</h3>
                        <p class="text-muted small">Lengkapi data di bawah untuk akses event kampus.</p>
                    </div>

                    <form action="auth/proses_register.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" name="username" class="form-control bg-light border-0" placeholder="Username unik Anda" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0" placeholder="Buat password aman" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                                <input type="password" name="confirm_password" class="form-control bg-light border-0" placeholder="Ulangi password" required>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-primary">Pertanyaan Keamanan</label>
                            <p class="small text-muted mb-2">Siapa nama hewan peliharaan pertama Anda?</p>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-primary"><i class="bi bi-chat-heart"></i></span>
                                <input type="text" name="jawaban" class="form-control bg-light border-0" placeholder="Jawaban rahasia Anda" required>
                            </div>
                            <div class="form-text mt-2 small italic">
                                <i class="bi bi-info-circle me-1"></i> Jangan sampai lupa, ini digunakan jika Anda tidak bisa login.
                            </div>
                        </div>

                        <button type="submit" name="register" class="btn btn-primary w-100 btn-rounded shadow py-2 fw-bold">
                            Buat Akun Sekarang
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="small text-muted">Sudah punya akun? <a href="index.php" class="text-decoration-none fw-bold">Login di sini</a></p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted small text-decoration-none"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<?php 
include 'layout/footer.php'; 
?>