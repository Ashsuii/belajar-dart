<!doctype html>
<?php 
    session_start();
    include "koneksi.php";
    $target_dir = "uploads/";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM pendaftar WHERE id = '$id'";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
    }

    if (isset($_POST['update'])) {
        $nama           = $_POST['nama'];
        $noKTP          = $_POST['noKTP'];
        $tanggal_lahir  = $_POST['tanggal_lahir'];
        $tempat_lahir   = $_POST['tempat_lahir'];
        $pekerjaan      = $_POST['pekerjaan'];
        $minat          = $_POST['minat'];

        $fileName = basename($_FILES["photoProfile"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $target_file = $target_dir . $nama . "." .$imageFileType;

        $check = getimagesize($_FILES["photoProfile"]["tmp_name"]);
        if ($check !== false) {
            $uploadOK = 1;
        }else{
            echo "file yang di upload bukan berupa gambar";
            $uploadOK = 0;
        }

      if ($_FILES["photoProfil"]["size"] > 500000) {
        echo "Maaf, File Terlalu Besar.";
        $uploadOK = 0;
        }
  
        if (!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
          echo "Maaf, Hanya jpg, jpeg, png & gif format yang diperbolehkan.";
          $uploadOK = 0;
        }
  
        if  ($uploadOK == 1) {
          if (move_uploaded_file($_FILES["photoProfil"]["tmp_name"], $target_file)) {
              $photoProfile = $nama.".".$imageFileType;
              $sql = "UPDATE pendaftar SET nama='$nama', ktp='$noKTP', tanggalLahir='$tanggal_lahir', tempatLahir='$tempat_lahir', pekerjaan='$pekerjaan', minat='$minat', photoProfil='$photoProfile' WHERE id='$id'";
          }else{
              echo "Maaf, Terjadi kesalahan ketika upload Photo Anda";
          }
        } 


        $sql = "UPDATE pendaftar SET nama='$nama', ktp='$noKTP', tanggalLahir='$tanggal_lahir', tempatLahir='$tempat_lahir', pekerjaan='$pekerjaan', minat='$minat' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['alert'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    Data berhasil Di ubah!
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
        <h4>Ubah Data</h4>
    </div>

    <div class="content" style=" margin-top: 70px;">
        <form method="POST" class="border p-4 rounded shadow" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="" class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">No KTP</label>
                <input type="text" name="noKTP" class="form-control" maxlength="16" value="<?php echo $row['ktp']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="<?php echo $row['tanggalLahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="<?php echo $row['tempatLahir']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Pekerjaan</label>
                <input type="text" name="pekerjaan" class="form-control" value="<?php echo $row['pekerjaan']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Minat</label>
                <textarea name="minat" class="form-control" required><?php echo $row['minat']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="" class="form-label">Photo Profile</label>
                <img id="imagePreview" src="uploads/<?php echo $row['photoProfil']; ?>" alt="Profile Preview" style="width: 150px; height:
                150px; object-fit: cover; display: block; margin-bottom: 10px;">
                <input name="photoProfile" type="file" required> 
            </div>
            <button type="submit" class="btn btn-warning" name="update">Update Data</button>
        </form>
    </div>

   <?php include "footer.php"; ?>