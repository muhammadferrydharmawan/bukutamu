<?php
// Tambahkan di bagian atas index.php
session_start();

// Tampilkan notifikasi sukses
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">Data tamu berhasil disimpan!</div>';
    unset($_SESSION['success']);
}

// Tampilkan notifikasi error
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

require_once 'includes/config.php';
require_once 'includes/functions.php';

$result = get_last_guests($conn);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buku Tamu | Butterfly Incubator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">
                <i class="fas fa-book-open"></i>
            </div>
            <h1>Buku Tamu</h1>
            <h3>Butterfly Incubator (UPU)</h3>
            <p class="lead">Silakan isi data diri Anda untuk registrasi kunjungan</p>
        </div>

        <div class="card">
            <div class="form-card-header">
                <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Form Registrasi Kunjungan</h4>
            </div>
            <div class="form-card-body">
                <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>Data tamu berhasil disimpan!
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($_GET['error']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="post" action="process.php" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama" name="nama" required>
                                <label for="nama" class="required-field">Nama Lengkap</label>
                                <div class="invalid-feedback">
                                    Nama lengkap harus diisi
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="tel" class="form-control" id="telepon" name="telepon" required>
                                <label for="telepon" class="required-field">No. Telepon</label>
                                <div class="invalid-feedback">
                                    Nomor telepon harus diisi
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="kategori" name="kategori" required>
                                    <option value="">-</option>
                                    <option value="Instansi">Instansi</option>
                                    <option value="Akademisi">Akademisi</option>
                                    <option value="Mahasiswa">Mahasiswa</option>
                                    <option value="Umum">Umum</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <label for="kategori" class="required-field">Kategori Tamu</label>
                                <div class="invalid-feedback">
                                    Harap pilih kategori tamu
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="instansi" name="instansi">
                                <label for="instansi">Keterangan Tamu</label>
                                <div class="form-text text-muted">
                                    <small>Contoh: Nama perusahaan, asal universitas, dll.</small>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="janji_temu" name="janji_temu" required>
                                    <option value="">-</option>
                                    <option value="Dr. Hj. Kartika Sari Lubis, S.E, M.Sc">Dr. Hj. Kartika Sari Lubis, S.E., M.Sc</option>
                                    <option value="Ina Liswanty, S.E., M.Ak">Ina Liswanty, S.E., M.Ak</option>
                                    <option value="Muhammad Ferry Dharmawan, S.Kom">Muhammad Ferry Dharmawan, S.Kom</option>
                                </select>
                                <label for="janji_temu" class="required-field">Janji Temu Dengan</label>
                                <div class="invalid-feedback">
                                    Harap pilih staff untuk janji temu
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="keperluan" name="keperluan" style="height: 100px" required></textarea>
                                <label for="keperluan" class="required-field">Keperluan</label>
                                <div class="invalid-feedback">
                                    Keperluan kunjungan harus diisi
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid col-md-6 mx-auto mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Daftar Kunjungan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h4 class="mb-0"><i class="fas fa-users me-2"></i>Daftar Tamu Terakhir</h4>
            </div>
            <div class="table-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Nama</th>
                                <th width="12%">Kategori</th>
                                <th width="15%">Keterangan</th>
                                <th width="20%">Janji Temu</th>
                                <th width="15%">Keperluan</th>
                                <th width="13%">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php $no = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <?php $initialLetter = strtoupper(substr($row['nama'], 0, 1)); ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <div class="guest-info">
                                                <div class="guest-photo"><?= $initialLetter ?></div>
                                                <?= htmlspecialchars($row['nama']) ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="guest-category <?= get_category_class($row['kategori']) ?>">
                                                <?= htmlspecialchars($row['kategori']) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($row['instansi']) ?></td>
                                        <td><?= htmlspecialchars($row['janji_temu']) ?></td>
                                        <td><?= htmlspecialchars($row['keperluan']) ?></td>
                                        <td>
                                            <span class="time-badge">
                                                <i class="far fa-clock"></i> 
                                                <?= date('d-m-Y H:i', strtotime($row['tanggal_kunjungan'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4">Belum ada data tamu</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
<?php $conn->close(); ?>