<?php
require 'data/connection.php';
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>

    <main class="d-flex align-items-center justify-content-center" style="min-height: 75vh;">
        <div class="card shadow border-0 p-4" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4 fw-bold text-primary">Silahkan Masuk</h3>

                <form action="login_aksi.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label text-muted small" for="rememberMe">Ingatkan saya di perangkat ini</label>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary fw-semibold">Login</button>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="register.php" class="btn btn-danger fw-semibold">Register</a>
                    </div>
                </form>

            </div>
        </div>
    </main>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>