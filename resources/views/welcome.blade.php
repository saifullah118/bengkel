<!DOCTYPE html>
<html lang="en">
<head>
   <!-- basic -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- mobile metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- site metas -->
   <title>Beranda</title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <!-- site icon -->
   <link rel="icon" href="images/.png" type="image/png" />
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
         <!-- Sidebar -->
         <nav id="sidebar">
            <ul class="list-unstyled components">
            <ul class="navbar-nav mr-auto">
                           <li class="nav-item">
                              <a class="nav-link" href="faq.html">FAQ</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="bantuan.html">Bantuan</a>
                           </li>
                        </ul>   
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
         <a class="navbar-brand" href="#">Sistem Pakar kerusakan Sepeda Motor</a> <!-- Tambahkan judul sistem di sini -->
         <div class="right_topbar">
            <div class="dropdown">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <div class="watermark-container">
                     <img src="images/v75.jpg" alt="Logo" style="width: 90px; height: auto;">
                  </div>
               </a>
               <ul class="dropdown-menu">
                  <li><a href="login.html">Login Admin</a></li>
               </ul>
            </div>
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
                     </div>
                  </div>
                  <!-- Form Identitas -->
                  <h1>Lebih Baik Mencegah Daripada Memperbaiki</h1>
                  <p>Selamat datang di Sistem Pakar Pendiagnosa Kerusakan Sepeda Motor!</p>
                  <p>Ingatlah, menjaga sepeda motor Anda dalam kondisi baik lebih mudah daripada memperbaiki kerusakan yang sudah terjadi. Dengan sistem kami, Anda dapat mendiagnosa potensi masalah lebih awal dan mencegah kerusakan yang lebih parah.</p>
                  
                  <form action="gejala.php" method="get">
                     <button type="submit" class="btn btn-primary">Mulai Diagnosa</button>
                  </form>
               </div>
            </div>
            <!-- footer -->
            <div class="container-fluid">
               <div class="footer">
                  <p>Copyright © 2024 Saifullah Habibi. All rights reserved.<br><br></p>
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
