<?php
// admin.php
include 'config.php';

// Koneksi ke database
$mysqli = new mysqli("localhost", "root", "", "bengkel");

// Periksa koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Handle aksi Hapus
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete_query = "DELETE FROM hasil_diagnosa WHERE id = ?";
    $stmt = $mysqli->prepare($delete_query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Data berhasil dihapus!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan: ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

// Handle aksi Ubah
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nama = $_POST['nama'];
    $jenis_motor = $_POST['jenis_motor'];
    $alamat = $_POST['alamat'];

    $update_query = "UPDATE hasil_diagnosa SET nama = ?, jenis_motor = ?, alamat = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param("sssi", $nama, $jenis_motor, $alamat, $id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success" role="alert">Data berhasil diupdate!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Terjadi kesalahan: ' . $stmt->error . '</div>';
    }
    $stmt->close();
}

// Handle form edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $edit_query = "SELECT id, nama, jenis_motor, alamat, kerusakan, belief, tanggal FROM hasil_diagnosa WHERE id = ?";
    $stmt = $mysqli->prepare($edit_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_data = $result->fetch_assoc();
    $stmt->close();
}

// Ambil data dari tabel hasil_diagnosa
$query = "SELECT id, nama, jenis_motor, alamat, kerusakan, belief, tanggal FROM hasil_diagnosa ORDER BY tanggal DESC";
$result = $mysqli->query($query);
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
   <title>Halaman Admin - Sistem Pakar Motor</title>
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
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
   <![endif]-->
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
                  <li><a href="index.php">> <span>logout</span></a></li>
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
                                          <th>ID</th>
                                          <th>Nama</th>
                                          <th>Jenis Motor</th>
                                          <th>Alamat</th>
                                          <th>Kerusakan</th>
                                          <th>Belief</th>
                                          <th>Tanggal</th>
                                          <th>Actions</th>
                                       </tr>
                                    </thead>
                                    <tbody>
                                       <?php while ($row = $result->fetch_assoc()): ?>
                                       <tr>
                                          <td><?php echo htmlspecialchars($row['id']); ?></td>
                                          <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                          <td><?php echo htmlspecialchars($row['jenis_motor']); ?></td>
                                          <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                          <td><?php echo htmlspecialchars($row['kerusakan']); ?></td>
                                          <td><?php echo htmlspecialchars($row['belief']); ?></td>
                                          <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                                          <td>
                                             <a href="admin.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning">Ubah</a>
                                             <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                          </td>
                                       </tr>
                                       <?php endwhile; ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                           <!-- Button untuk kembali ke halaman utama -->
                           <div class="container">
                              <a href="index.php" class="btn btn-secondary">Logout</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- End Tabel Hasil Diagnosa -->

                  <!-- Form Ubah Diagnosa -->
                  <?php if ($edit_data): ?>
                  <div class="row">
                     <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                           <div class="full graph_head">
                              <div class="heading1 margin_0">
                                 <h2>Ubah Diagnosa</h2>
                              </div>
                           </div>
                           <div class="table_section padding_infor_info">
                              <div class="container">
                                 <form action="admin.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                                    <div class="form-group">
                                       <label for="nama">Nama:</label>
                                       <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($edit_data['nama']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="jenis_motor">Jenis Motor:</label>
                                       <input type="text" class="form-control" id="jenis_motor" name="jenis_motor" value="<?php echo htmlspecialchars($edit_data['jenis_motor']); ?>" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="alamat">Alamat:</label>
                                       <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($edit_data['alamat']); ?>" required>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                                    <a href="admin.php" class="btn btn-secondary">Batal</a>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php endif; ?>
                  <!-- End Form Ubah Diagnosa -->

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
