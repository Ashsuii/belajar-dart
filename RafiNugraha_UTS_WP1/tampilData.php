<?php 
    include "header.php"; 
    session_start();
    ?>

    <div class="header">
        <h4>Kelola Registrasi</h4>
    </div>

    <div class="content" style="margin-top: 70px;">
        <?php
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
        }
        ?>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Minat</th>
                    <th>Pekerjaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    include "koneksi.php";
                    $sql = "SELECT id, nama, minat, pekerjaan FROM pendaftar";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $i = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<th scope='row'>".$i++."</th>"; 
                            echo "<td>".$row['nama']."</td>";
                            echo "<td>".$row['minat']."</td>";
                            echo "<td>".$row['pekerjaan']."</td>";
                            echo "<td>
                                    <a href='ubahData.php?id=".$row['id']."'>
                                        <button class='btn btn-primary'>Ubah</button></a> | 
                                    <a href='prosesHapus.php?id=".$row['id']."'>
                                        <button class='btn btn-danger'>Hapus</button></a>
                                </td>";
                            echo "</tr>";
                        }
                    }    
                ?>
            </tbody>
        </table>
        <a href="tambahData.php"><button type="button" class="form-control btn btn-success mb-3" name="submit">Tambah Data</button></a>
    </div>

<?php include "footer.php"; ?>