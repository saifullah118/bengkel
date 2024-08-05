<?php
// Sertakan file config.php untuk koneksi database
include 'config.php';

// Pastikan koneksi berhasil
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
// Ambil data tambahan dari formulir
$nama = isset($_POST['nama']) ? $_POST['nama'] : 'Tidak Diketahui';
$jenis_motor = isset($_POST['jenis_motor']) ? $_POST['jenis_motor'] : 'Tidak Diketahui';
$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : 'Tidak Diketahui';

// Ambil data gejala dari form
$gejala_terpilih = isset($_POST['gejala']) ? $_POST['gejala'] : [];
// Ambil basis pengetahuan dari database
$basis_pengetahuan_query = "SELECT * FROM basis_pengetahuan";
$basis_pengetahuan_result = $mysqli->query($basis_pengetahuan_query);

$basis_pengetahuan = [];
if ($basis_pengetahuan_result->num_rows > 0) {
    while ($row = $basis_pengetahuan_result->fetch_assoc()) {
        $basis_pengetahuan[] = $row;
    }}
// Ambil data kerusakan dan bobot dari basis pengetahuan
$kerusakan_bobot = [];
foreach ($basis_pengetahuan as $pengetahuan) {
    $kerusakan_bobot[$pengetahuan['Kode_Kerusakan']][$pengetahuan['Kode_Gejala']] = $pengetahuan['Bobot'];
}
// Hitung BPA untuk setiap kerusakan berdasarkan gejala terpilih
$bpa = [];
foreach ($kerusakan_bobot as $kode_kerusakan => $gejala_bobot) {
    $bpa[$kode_kerusakan] = 1.0;
    $relevant = false;
    foreach ($gejala_terpilih as $gejala) {
        if (isset($gejala_bobot[$gejala])) {
            $bpa[$kode_kerusakan] *= $gejala_bobot[$gejala];
            $relevant = true;
        }}
    // Set BPA ke 0 jika tidak relevan
    if (!$relevant) {
        $bpa[$kode_kerusakan] = 0;
    }}
// Normalisasi BPA
$total_bpa = array_sum($bpa);
if ($total_bpa == 0) {
    $total_bpa = 1; // Untuk menghindari pembagian dengan 0
}
$hasil = [];
foreach ($bpa as $kode_kerusakan => $nilai_bpa) {
    $hasil[$kode_kerusakan] = $nilai_bpa / $total_bpa;}
// Hitung Belief, Plausibility, dan Doubt
$belief = [];
$plausibility = [];
$doubt = [];

foreach ($hasil as $kode_kerusakan => $nilai) {
    $belief[$kode_kerusakan] = $nilai;
    $plausibility[$kode_kerusakan] = $nilai; // Menganggap hanya satu kerusakan relevan
    $doubt[$kode_kerusakan] = 1 - $plausibility[$kode_kerusakan];
}
// Ambil nama kerusakan untuk hasil akhir
$kerusakan_query = "SELECT kode_kerusakan, nama_kerusakan FROM kerusakan";
$kerusakan_result = $mysqli->query($kerusakan_query);

$kerusakan_nama = [];
if ($kerusakan_result->num_rows > 0) {
    while ($row = $kerusakan_result->fetch_assoc()) {
        $kerusakan_nama[$row['kode_kerusakan']] = $row['nama_kerusakan'];
    }}
// Ambil solusi untuk kerusakan
$solusi_query = "SELECT kode_kerusakan, solusi FROM kerusakan GROUP BY kode_kerusakan";
$solusi_result = $mysqli->query($solusi_query);

$solusi_nama = [];
if ($solusi_result->num_rows > 0) {
    while ($row = $solusi_result->fetch_assoc()) {
        $solusi_nama[$row['kode_kerusakan']] = $row['solusi'];
    }}
// Urutkan kerusakan berdasarkan belief tertinggi
arsort($belief);
// Ambil kerusakan dengan belief tertinggi dan solusi
$belief_tinggi = max($belief);
$kerusakan_tinggi = array_filter($belief, function($nilai) use ($belief_tinggi) {
    return $nilai == $belief_tinggi;
});

$kerusakan_terpilih = array_slice(array_keys($kerusakan_tinggi), 0, 2);

// Simpan hasil diagnosa ke tabel hasil_diagnosa
foreach ($kerusakan_terpilih as $kode_kerusakan) {
    $stmt = $mysqli->prepare("INSERT INTO hasil_diagnosa (nama, jenis_motor, alamat, kerusakan, belief) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $nama, $jenis_motor, $alamat, $kerusakan_nama[$kode_kerusakan], $belief[$kode_kerusakan]);
    $stmt->execute();
}

$stmt->close();
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- mobile metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- site metas -->
    <title>Hasil Diagnosa - Sistem Pakar Motor</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- site icon -->
    <link rel="icon" href="images/fevicon.png" type="image/png" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- site css -->
    <link rel="stylesheet" href="style.css" />
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css" />
    <!-- color css -->
    <link rel="stylesheet" href="css/colors.css" />
    <!-- select bootstrap -->
    <link rel="stylesheet" href="css/bootstrap-select.css" />
    <!-- scrollbar css -->
    <link rel="stylesheet" href="css/perfect-scrollbar.css" />
    <!-- custom css -->
    <link rel="stylesheet" href="css/custom.css" />
</head>
<body class="dashboard dashboard_1">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar_blog_1">
                    <div class="sidebar-header"></div>
                </div>
                <ul class="list-unstyled components">
                    <li class="active">
                        
                    </li>
                </ul>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="full">
                            <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
                            <div class="right_topbar">
                                <div class="icon_info"></div>
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Hasil Diagnosa</h2>
                                </div>
                            </div>
                        </div>
                         <!-- Info Tambahan -->
                         <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="table_section padding_infor_info">
                                        <h2>Informasi Pengguna:</h2>
                                        <p><strong>Nama:</strong> <?php echo htmlspecialchars($nama); ?></p>
                                        <p><strong>Jenis Motor:</strong> <?php echo htmlspecialchars($jenis_motor); ?></p>
                                        <p><strong>Alamat:</strong> <?php echo htmlspecialchars($alamat); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Info Tambahan -->
                        <!-- Tabel Hasil Diagnosa -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Daftar Hasil Diagnosa</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="table-responsive-sm">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Kode Kerusakan</th>
                                                        <th>Nama Kerusakan</th>
                                                        <th>BPA</th>
                                                        <th>Belief</th>
                                                        <th>Plausibility</th>
                                                        <th>Doubt</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($hasil as $kode_kerusakan => $nilai_bpa): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($kode_kerusakan); ?></td>
                                                        <td><?php echo htmlspecialchars($kerusakan_nama[$kode_kerusakan] ?? 'Tidak Diketahui'); ?></td>
                                                        <td><?php echo number_format($nilai_bpa , 2)  ; ?></td>
                                                        <td><?php echo number_format($belief[$kode_kerusakan] * 100, 2) . '%'; ?></td>
                                                        <td><?php echo number_format($plausibility[$kode_kerusakan] * 100, 2) . '%'; ?></td>
                                                        <td><?php echo number_format($doubt[$kode_kerusakan] * 100, 2) . '%'; ?></td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Tabel Hasil Diagnosa -->

                        <!-- Kesimpulan -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Kesimpulan</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <h2>Kerusakan dengan belief tertinggi:</h2>
                                        <?php foreach ($kerusakan_terpilih as $kode_kerusakan): ?>
                                            <p><strong><?php echo htmlspecialchars($kerusakan_nama[$kode_kerusakan] ?? 'Tidak Diketahui'); ?></strong></p>
                                        <?php endforeach; ?>

                                        <h2>Solusi:</h2>
                                        <?php foreach ($kerusakan_terpilih as $kode_kerusakan): ?>
                                            <p><strong><?php echo htmlspecialchars($solusi_nama[$kode_kerusakan] ?? 'Tidak Diketahui'); ?></strong></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Kesimpulan -->

                        <!-- Tombol Diagnosa Ulang dan Keluar -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="table_section padding_infor_info">
                                        <a href="gejala.php" class="btn btn-primary">Diagnosa Ulang</a>
                                        <a href="index.php" class="btn btn-secondary">Keluar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Tombol Diagnosa Ulang dan Keluar -->

                    </div>
                </div>
                <!-- end dashboard inner -->
            </div>
            <!-- end right content -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- Custom -->
    <script src="js/custom.js"></script>
    <!-- Select2 -->
    <script src="js/select2.min.js"></script>
    <!-- Perfect Scrollbar -->
    <script src="js/perfect-scrollbar.js"></script>
    <!-- Select Bootstrap -->
    <script src="js/bootstrap-select.js"></script>
    <!-- Nice Scroll -->
    <script src="js/jquery.nicescroll.min.js"></script>
    <!-- Script -->
    <script src="js/script.js"></script>
</body>
</html>
