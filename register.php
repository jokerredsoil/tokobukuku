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
                <h3 class="card-title text-center mb-4 fw-bold text-primary">Daftar</h3>

                <form action="register_aksi.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" required>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat</label>
                        <textarea class="form-control" name="alamat" id="alamat" required placeholder="Masukan Alamat"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_telp" class="form-label fw-semibold">No Telepon</label>
                        <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No Telepon" required>
                    </div>

                    <div class="mb-3">
                        
                        <label class="form-label fw-semibold">Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_l" value="L" required>
                            <label class="form-check-label" for="jenis_kelamin_l">
                                Laki-Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin_p" value="P" required>
                            <label class="form-check-label" for="jenis_kelamin_p">
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary fw-semibold">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </main>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>