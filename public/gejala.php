<?php
// Sertakan file config.php untuk koneksi database
include 'config.php';

// Pastikan koneksi berhasil
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

// Ambil data gejala dari database
$gejala_query = "SELECT Kode_Gejala, Nama_Gejala FROM gejala";
$gejala_result = $mysqli->query($gejala_query);

if (!$gejala_result) {
    die("Query gagal: " . $mysqli->error);
}

$gejala_options = [];

if ($gejala_result->num_rows > 0) {
    while ($row = $gejala_result->fetch_assoc()) {
        $gejala_options[] = $row;
    }
}
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
   <title>Diagnosa</title>
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
                  <a href="#additional_page" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-clone yellow_color"></i> <span>Additional Pages</span></a>
                  <ul class="collapse list-unstyled" id="additional_page">
                     <li><a href="login.html">> <span>Login Admin</span></a></li>
                  </ul>
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
                           <h2>Form Identitas dan Gejala</h2>
                        </div>
                     </div>
                  </div>
                  <!-- Form Identitas dan Gejala -->
                  <div class="row">
                     <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                           <div class="full graph_head">
                              <div class="heading1 margin_0">
                                 <h2>Form Identitas dan Gejala</h2>
                              </div>
                           </div>
                           <div class="table_section padding_infor_info">
                              <div class="table-responsive-sm">
                                 <form method="post" action="hasil_diagnosa.php">
                                    <!-- Form Identitas Pengguna -->
                                    <div class="form-group">
                                       <label for="nama">Nama</label>
                                       <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="jenis_motor">Jenis Motor</label>
                                       <input type="text" class="form-control" id="jenis_motor" name="jenis_motor" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="alamat">Alamat</label>
                                       <input type="text" class="form-control" id="alamat" name="alamat" required>
                                    </div>
                                    <!-- Daftar Gejala -->
                                    <table class="table table-striped">
                                       <thead>
                                          <tr>
                                             <th>Kode Gejala</th>
                                             <th>Nama Gejala</th>
                                             <th>Pilih</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($gejala_options as $option): ?>
                                              <tr>
                                                 <td><?php echo htmlspecialchars($option['Kode_Gejala']); ?></td>
                                                 <td><?php echo htmlspecialchars($option['Nama_Gejala']); ?></td>
                                                 <td><input type='checkbox' name='gejala[]' value='<?php echo htmlspecialchars($option['Kode_Gejala']); ?>'></td>
                                              </tr>
                                          <?php endforeach; ?>
                                       </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- footer -->
               <div class="container-fluid">
                  <div class="footer">
                     <p>Hak Cipta © 2024 Saifullah Habibi. Hak cipta dilindungi undang-undang.<br><br></p>
                  </div>
               </div>
            </div>
            <!-- end dashboard inner -->
         </div>
      </div>
   </div>
   
   <!-- jQuery -->
   <script src="js/jquery.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <!-- wow animation -->
   <script src="js/animate.js"></script>
   <!-- select country -->
   <script src="js/bootstrap-select.js"></script>
   <!-- owl carousel -->
   <script src="js/owl.carousel.js"></script> 
   <!-- chart js -->
   <script src="js/Chart.min.js"></script>
   <script src="js/Chart.bundle.min.js"></script>
   <script src="js/utils.js"></script>
   <script src="js/analyser.js"></script>
   <!-- nice scrollbar -->
   <script src="js/perfect-scrollbar.min.js"></script>
   <script>
      var ps = new PerfectScrollbar('#sidebar');
   </script>
   <!-- custom js -->
   <script src="js/custom.js"></script>
   <script src="js/chart_custom_style1.js"></script>
</body>
</html>
