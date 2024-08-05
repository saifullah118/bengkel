<?php
include 'config.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Ambil data untuk ID tertentu
if ($id > 0) {
    $query = "SELECT * FROM diagnosa WHERE id = $id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        die('Data tidak ditemukan');
    }
} else {
    die('ID tidak valid');
}

// Proses form jika data dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jenis_motor = $_POST['jenis_motor'];
    $alamat = $_POST['alamat'];
    
    $update_query = "UPDATE diagnosa SET nama='$nama', jenis_motor='$jenis_motor', alamat='$alamat' WHERE id=$id";
    
    if ($conn->query($update_query) === TRUE) {
        header("Location: admin.php");
        exit();
    } else {
        $error = $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>Edit Data Diagnosa</title>
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
   <body>
      <div class="container mt-5">
         <h2>Edit Data Diagnosa</h2>
         <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
         <?php endif; ?>
         <form method="post">
            <div class="form-group">
               <label for="nama">Nama:</label>
               <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="form-group">
               <label for="jenis_motor">Jenis Motor:</label>
               <input type="text" class="form-control" id="jenis_motor" name="jenis_motor" value="<?php echo htmlspecialchars($data['jenis_motor']); ?>" required>
            </div>
            <div class="form-group">
               <label for="alamat">Alamat:</label>
               <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo htmlspecialchars($data['alamat']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
         </form>
      </div>
   </body>
</html>
