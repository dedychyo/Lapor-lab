<?php
/**
 * Proyek UTS Rekayasa Perangkat Lunak
 * Judul: Sistem Pengaduan Kerusakan Fasilitas Lab Komputer (LaporLab)
 * Pengembang: Dedy Nurcahya (D3 Teknik Komputer)
 */

// Contoh data dummy laporan yang sudah masuk
$laporan_list = [
    [
        'id' => 'LP-001',
        'nama_pelapor' => 'Ahmad Fajar',
        'lab' => 'Lab Komputer 3',
        'no_pc' => 'PC-12',
        'kategori' => 'Mati Total / PSU',
        'deskripsi' => 'Komputer tidak mau menyala sama sekali saat ditekan tombol power.',
        'status' => 'Sedang Diperbaiki'
    ],
    [
        'id' => 'LP-002',
        'nama_pelapor' => 'Siti Nurhaliza',
        'lab' => 'Lab Jaringan',
        'no_pc' => 'PC-05',
        'kategori' => 'Mouse / Keyboard',
        'deskripsi' => 'Klik kiri mouse sering double click sendiri.',
        'status' => 'Pending'
    ]
];

// Logika Sistem: Menentukan tingkat prioritas perbaikan berdasarkan jenis kerusakan
function tentukanPrioritas($kategori) {
    if (strpos($kategori, 'Mati Total') !== false || strpos($kategori, 'Jaringan') !== false) {
        return ['level' => 'Tinggi (Kritis)', 'badge' => 'danger'];
    } elseif (strpos($kategori, 'Layar') !== false || strpos($kategori, 'OS') !== false) {
        return ['level' => 'Sedang', 'badge' => 'warning'];
    } else {
        return ['level' => 'Rendah', 'badge' => 'secondary'];
    }
}

// Simulasi penanganan submit form
$notif_sukses = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = htmlspecialchars($_POST['nama'] ?? '');
    $lab = htmlspecialchars($_POST['lab'] ?? '');
    $no_pc = htmlspecialchars($_POST['no_pc'] ?? '');
    $kategori = htmlspecialchars($_POST['kategori'] ?? '');
    $deskripsi = htmlspecialchars($_POST['deskripsi'] ?? '');

    if (!empty($nama) && !empty($lab) && !empty($no_pc)) {
        $laporan_baru = [
            'id' => 'LP-' . str_pad(count($laporan_list) + 1, 3, '0', STR_PAD_LEFT),
            'nama_pelapor' => $nama,
            'lab' => $lab,
            'no_pc' => $no_pc,
            'kategori' => $kategori,
            'deskripsi' => $deskripsi,
            'status' => 'Pending'
        ];
        array_unshift($laporan_list, $laporan_baru);
        $notif_sukses = true;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaporLab - Pengaduan Kerusakan Lab Komputer</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', sans-serif; }
        .hero { background: linear-gradient(135deg, #1e293b, #0f172a); color: white; padding: 2.5rem 0; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <!-- Header / Informasi Proyek -->
    <div class="hero mb-4">
        <div class="container">
            <span class="badge bg-primary px-3 py-2 mb-2">TUGAS UTS REKAYASA PERANGKAT LUNAK</span>
            <h1 class="fw-bold">LaporLab</h1>
            <p class="mb-0 text-light opacity-75">Sistem Informasi Pengaduan Kerusakan Fasilitas Laboratorium Komputer</p>
            <small class="text-info">Pengembang: Dedy Nurcahya | Prodi: D3 Teknik Komputer</small>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row g-4">
            
            <!-- Kolom Form Pengaduan -->
            <div class="col-lg-5">
                <div class="card p-4">
                    <h5 class="fw-bold mb-3 text-primary">Form Lapor Kerusakan</h5>
                    
                    <?php if ($notif_sukses): ?>
                        <div class="alert alert-success py-2">Laporan berhasil dicatat ke antrean sistem!</div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pelapor (Mahasiswa/Dosen)</label>
                            <input type="text" name="nama" class="form-control" placeholder="Contoh: Dedy Nurcahya" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Laboratorium</label>
                            <select name="lab" class="form-select" required>
                                <option value="Lab Komputer 1">Lab Komputer 1 (Software)</option>
                                <option value="Lab Komputer 2">Lab Komputer 2 (Multimedia)</option>
                                <option value="Lab Jaringan">Lab Jaringan & Hardware</option>
                                <option value="Lab Mikrokontroler">Lab Mikrokontroler / IoT</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nomor PC / Perangkat</label>
                            <input type="text" name="no_pc" class="form-control" placeholder="Contoh: PC-07 atau Switch-1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kategori Kerusakan</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Mati Total / PSU">Mati Total / Daya Listrik</option>
                                <option value="Layar / Monitor Mati">Layar / Monitor Tidak Tampil</option>
                                <option value="Jaringan / Kabel LAN">Koneksi Internet / Kabel LAN Putus</option>
                                <option value="Mouse / Keyboard">Aksesoris (Mouse / Keyboard Rusak)</option>
                                <option value="Sistem Operasi / Bluescreen">Software / Windows Crash / Bluescreen</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi Kerusakan</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Jelaskan detail kendala yang dialami..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-semibold">Kirim Laporan Kerusakan</button>
                    </form>
                </div>
            </div>

            <!-- Kolom Logika Sistem & Monitoring Laporan -->
            <div class="col-lg-7">
                <div class="card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Antrean Laporan & Logika Prioritas</h5>
                        <span class="badge bg-success">Live Status</span>
                    </div>
                    <p class="text-muted small">
                        <strong>Logika Sistem:</strong> Sistem secara otomatis menentukan <em>Prioritas Penanganan</em> berdasarkan kategori komponen yang dilaporkan guna membantu efisiensi kerja teknisi lab.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Lokasi & PC</th>
                                    <th>Kategori & Kerusakan</th>
                                    <th>Prioritas AI/Sistem</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($laporan_list as $row): 
                                    $prioritas = tentukanPrioritas($row['kategori']);
                                ?>
                                <tr>
                                    <td><span class="badge bg-dark"><?= $row['id'] ?></span></td>
                                    <td>
                                        <div class="fw-bold"><?= $row['lab'] ?></div>
                                        <small class="text-muted"><?= $row['no_pc'] ?> (Pelapor: <?= $row['nama_pelapor'] ?>)</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-danger"><?= $row['kategori'] ?></div>
                                        <small class="text-secondary"><?= $row['deskripsi'] ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $prioritas['badge'] ?>">
                                            <?= $prioritas['level'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($row['status'] === 'Pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark"><?= $row['status'] ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
