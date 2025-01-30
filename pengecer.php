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
                            <h3 class="mb-0">Pengecer</h3>
                        </div>

                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPengecer">Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <?php
                            include 'koneksi.php';

                            $query = "SELECT * FROM pengecer";
                            $result = $koneksi->query($query);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>";
                                echo "<thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th>No HP</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                      </thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td>{$row['nama_pengecer']}</td>
                                            <td>{$row['jenis_kelamin']}</td>
                                            <td>{$row['tanggal_lahir']}</td>
                                            <td>{$row['no_hp']}</td>
                                            <td>{$row['alamat']}</td>
                                            <td>
                                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditPengecer{$row['id_pengecer']}'>Edit</button>
                                                <a href='crud/hapus_pengecer.php?id={$row['id_pengecer']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                                            </td>
                                          </tr>";

                                    echo "<div class='modal fade' id='modalEditPengecer{$row['id_pengecer']}' tabindex='-1' aria-labelledby='modalEditPengecerLabel' aria-hidden='true'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header'>
                                                        <h5 class='modal-title'>Edit Pengecer</h5>
                                                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <form action='crud/edit_pengecer.php' method='post'>
                                                            <input type='hidden' name='id_pengecer' value='{$row['id_pengecer']}'>
                                                            <div class='mb-3'>
                                                                <label for='nama_pengecer' class='form-label'>Nama</label>
                                                                <input type='text' class='form-control' name='nama_pengecer' value='{$row['nama_pengecer']}' required>
                                                            </div>
                                                            <div class='mb-3'>
                                                                <label for='jenis_kelamin' class='form-label'>Jenis Kelamin</label>
                                                                <select class='form-control' name='jenis_kelamin' required>
                                                                    <option value='Laki-laki' " . ($row['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '') . ">Laki-laki</option>
                                                                    <option value='Perempuan' " . ($row['jenis_kelamin'] == 'Perempuan' ? 'selected' : '') . ">Perempuan</option>
                                                                </select>
                                                            </div>
                                                            <div class='mb-3'>
                                                                <label for='tanggal_lahir' class='form-label'>Tanggal Lahir</label>
                                                                <input type='date' class='form-control' name='tanggal_lahir' value='{$row['tanggal_lahir']}' required>
                                                            </div>
                                                            <div class='mb-3'>
                                                                <label for='no_hp' class='form-label'>No HP</label>
                                                                <input type='text' class='form-control' name='no_hp' value='{$row['no_hp']}' required>
                                                            </div>
                                                            <div class='mb-3'>
                                                                <label for='alamat' class='form-label'>Alamat</label>
                                                                <textarea class='form-control' name='alamat' required>{$row['alamat']}</textarea>
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
                                echo "<p class='text-center'>Tidak ada data pengecer.</p>";
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

    <div class="modal fade" id="modalTambahPengecer" tabindex="-1" aria-labelledby="modalTambahPengecerLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengecer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah_pengecer.php" method="post">
                        <div class="mb-3">
                            <label for="nama_pengecer" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama_pengecer" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" name="jenis_kelamin" required>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" name="tanggal_lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" name="alamat" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>