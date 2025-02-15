<?php include 'template/header.php'; ?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <?php include 'template/navbar.php'; ?>
        <?php include 'template/sidebar.php'; ?>
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Pupuk Masuk</h3>
                        </div>

                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPupukMasuk">Tambah Pupuk Masuk</button>
                        </div>
                        <div class="card-body">
                            <?php
                            include 'koneksi.php';

                            $query = "SELECT pm.id_pupuk_masuk, p.nama_pupuk, pm.jumlah_masuk, pm.tanggal_masuk, pm.tanggal_kadaluarsa, pm.dokumentasi 
              FROM pupuk_masuk pm 
              JOIN pupuk p ON pm.id_pupuk = p.id_pupuk";

                            $result = $koneksi->query($query);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>";
                                echo "<thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pupuk</th>
                    <th>Jumlah Masuk</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Kadaluarsa</th>
                    <th>Dokumentasi</th>
                    <th>Aksi</th>
                </tr>
              </thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_pupuk']}</td>
                    <td>{$row['jumlah_masuk']}</td>
                    <td>{$row['tanggal_masuk']}</td>
                    <td>{$row['tanggal_kadaluarsa']}</td>
                    <td><a href='uploads/{$row['dokumentasi']}' target='_blank'>Lihat</a></td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditPupukMasuk{$row['id_pupuk_masuk']}'>Edit</button>
                        <a href='crud/hapus_pupuk_masuk.php?id={$row['id_pupuk_masuk']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                  </tr>";

                  echo "<div class='modal fade' id='modalEditPupukMasuk{$row['id_pupuk_masuk']}' tabindex='-1' aria-labelledby='modalEditPupukMasukLabel' aria-hidden='true'>
                  <div class='modal-dialog'>
                      <div class='modal-content'>
                          <div class='modal-header'>
                              <h5 class='modal-title'>Edit Pupuk Masuk</h5>
                              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                          </div>
                          <div class='modal-body'>
                              <form action='crud/edit_pupuk_masuk.php' method='post' enctype='multipart/form-data'>
                                  <input type='hidden' name='id_pupuk_masuk' value='{$row['id_pupuk_masuk']}'>
          
                                  <div class='mb-3'>
                                      <label for='id_pupuk' class='form-label'>Jenis Pupuk</label>
                                      <select class='form-control' name='id_pupuk' required>
                                          <option value=''>-- Pilih Pupuk --</option>";
                                          
                                          $query_pupuk = "SELECT id_pupuk, nama_pupuk FROM pupuk";
                                          $result_pupuk = $koneksi->query($query_pupuk);
                                          
                                          while ($pupuk = $result_pupuk->fetch_assoc()) {
                                              $selected = ($pupuk['id_pupuk'] == $row['id_pupuk']) ? "selected" : "";
                                              echo "<option value='{$pupuk['id_pupuk']}' $selected>{$pupuk['nama_pupuk']}</option>";
                                          }
                                          
                                      echo "</select>
                                  </div>
          
                                  <div class='mb-3'>
                                      <label for='jumlah_masuk' class='form-label'>Jumlah Masuk</label>
                                      <input type='number' class='form-control' name='jumlah_masuk' value='{$row['jumlah_masuk']}' required>
                                  </div>
                                  <div class='mb-3'>
                                      <label for='tanggal_masuk' class='form-label'>Tanggal Masuk</label>
                                      <input type='date' class='form-control' name='tanggal_masuk' value='{$row['tanggal_masuk']}' required>
                                  </div>
                                  <div class='mb-3'>
                                      <label for='tanggal_kadaluarsa' class='form-label'>Tanggal Kadaluarsa</label>
                                      <input type='date' class='form-control' name='tanggal_kadaluarsa' value='{$row['tanggal_kadaluarsa']}' required>
                                  </div>
                                  <div class='mb-3'>
                                      <label for='dokumentasi' class='form-label'>Dokumentasi (Opsional)</label>
                                      <input type='file' class='form-control' name='dokumentasi'>
                                      <small>File sebelumnya: <a href='../uploads/{$row['dokumentasi']}' target='_blank'>{$row['dokumentasi']}</a></small>
                                  </div>
                                  <button type='submit' class='btn btn-primary'>Simpan</button>
                              </form>
                          </div>
                      </div>
                  </div>
                </div>";
          
                                    $no++;
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "<p class='text-center'>Tidak ada data pupuk masuk.</p>";
                            }
                            $koneksi->close();
                            ?>
                        </div>

                    </div>
                </div>
            </div>
        </main>
        <footer class="app-footer">
        </footer>
    </div>

    <div class="modal fade" id="modalTambahPupukMasuk" tabindex="-1" aria-labelledby="modalTambahPupukMasukLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pupuk Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah_pupuk_masuk.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="id_pupuk" class="form-label">Nama Pupuk</label>
                            <select class="form-control" name="id_pupuk" required>
                                <?php
                                include 'koneksi.php';
                                $query_pupuk = "SELECT * FROM pupuk";
                                $result_pupuk = $koneksi->query($query_pupuk);
                                while ($row_pupuk = $result_pupuk->fetch_assoc()) {
                                    echo "<option value='{$row_pupuk['id_pupuk']}'>{$row_pupuk['nama_pupuk']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_masuk" class="form-label">Jumlah Masuk</label>
                            <input type="number" class="form-control" name="jumlah_masuk" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_kadaluarsa" class="form-label">Tanggal Kadaluarsa</label>
                            <input type="date" class="form-control" name="tanggal_kadaluarsa" required>
                        </div>
                        <div class="mb-3">
                            <label for="dokumentasi" class="form-label">Dokumentasi</label>
                            <input type="file" class="form-control" name="dokumentasi">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>