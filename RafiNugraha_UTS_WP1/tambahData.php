<!doctype html>
<?php 
    session_start();
    include "koneksi.php";
    $target_dir = "uploads/";

    if (isset($_POST['submit'])) {
      $nama           = $_POST['nama'];
      $noKTP          = $_POST['noKTP'];
      $tanggal_lahir  = $_POST['tanggal_lahir'];
      $tempat_lahir   = $_POST['tempat_lahir'];
      $pekerjaan      = $_POST['pekerjaan'];
      $minat          = $_POST['minat'];

      $fileName = basename($_FILES["photoProfile"]["name"]);
      $uploadOK = 1;
      $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      $target_file = $target_dir . $nama . "." .$imageFileType;

      $check = getimagesize($_FILES["photoProfile"]["tmp_name"]);
      if ($check !== false) {
        $uploadOK = 1;
      }else{
        echo "file yang di upload bukan berupa gambar";
        $uploadOK = 0;
      }

      if ($_FILES["photoProfile"]["size"] > 500000) {
      echo "Maaf, File Terlalu Besar.";
      $uploadOK = 0;
      }

      if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
        echo "Maaf, Hanya jpg, jpeg, png & gif format yang diperbolehkan.";
        $uploadOK = 0;
      }

      if  ($uploadOK == 1) {
        if (move_uploaded_file($_FILES["photoProfile"]["tmp_name"], $target_file)) {
            $photoProfile = $nama.".".$imageFileType;
            $sql = "INSERT INTO pendaftar (nama, ktp, tanggalLahir, tempatLahir, pekerjaan, minat, photoProfil) VALUES ('$nama','$noKTP','$tanggal_lahir','$tempat_lahir','$pekerjaan'.'$minat','$photoProfile')";
        }else{
            echo "Maaf, Terjadi kesalahan ketika upload Photo Anda";
        }
      } 


      if ($conn->query($sql) === TRUE) {
          $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                  Data berhasil di Tambah!
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
          $conn->close();
          header("Location: tampilData.php");
          exit();
      } else {
          $_SESSION['alert'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                  Error: ".$sql." - " . $conn->error . "
                                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                </div>";
          $conn->close();
          header("Location: tampilData.php");
          exit();
      }
    }
?>
    <?php include "header.php"; ?>

      <div class="header">
        <h4>Tambah Data Pendaftar</h4>
      </div>

        <div class="content" style="margin-top: 70px;">
            <form action="" method="POST" class="border p-4 rounded shadow" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="" class="form-label">Nama</label>
                <input type="text" for="" name="nama" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">No KTP</label>
                <input type="text" for="" name="noKTP" class="form-control" maxlength="16" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Tanggal Lahir</label>
                <input type="date" for="" name="tanggal_lahir" class="form-control" max="2006-12-31" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Tempat Lahir</label>
                <input type="text" for="" name="tempat_lahir" class="form-control" required>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Pekerjaan</label>
                
                <select name="pekerjaan" id="pekerjaan" class="form-control" required>
                    <option value=""></option>
                    <option value="PNS">PNS</option>
                    <option value="Wiraswasta">Wiraswasta</option>
                    <option value="Karyawan">Karyawan</option>
                    <option value="BUMN">BUMN</option>
                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                    <option value="Pelajar">Pelajar</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Minat</label>
                <textarea name="minat" id="" col="3" class="form-control" required></textarea>
              </div>

              <div class="mb-3">
                <label for="" class="form-label">Photo Profile</label>
                <input type="file" for="" name="photoProfile" class="form-control" required>
              </div>
              <div class="row">
                <div class="col-8"></div> 
                <div class="col-4 text-end"> 
                    <button type="submit" class="btn btn-primary mb-3" name="submit">Tambah Data</button>
                    <button type="button" class="btn btn-secondary mb-3" onclick="window.history.back()">Kembali</button>
                </div>
              </div>
            </form>
        </div>

    <?php include "footer.php"; ?>
