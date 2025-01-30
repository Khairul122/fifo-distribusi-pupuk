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
                            <h3 class="mb-0">Pupuk</h3>
                        </div>
                        <div class="col-sm-6">
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPupuk">
                                Tambah Data
                            </button>
                        </div>
                        <div class="card-body">
                            <?php
                            include 'koneksi.php';
                            $query = "SELECT * FROM pupuk";
                            $result = $koneksi->query($query);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>";
                                echo "<thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pupuk</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
              </thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_pupuk']}</td>
                    <td>{$row['satuan']}</td>
                    <td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditPupuk{$row['id_pupuk']}'>Edit</button>
                        <a href='crud/hapus_pupuk.php?id={$row['id_pupuk']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                  </tr>";

                                    echo "<div class='modal fade' id='modalEditPupuk{$row['id_pupuk']}' tabindex='-1' aria-labelledby='modalEditPupukLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='modalEditPupukLabel'>Edit Data Pupuk</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <form action='crud/edit_pupuk.php' method='post'>
                                    <input type='hidden' name='id_pupuk' value='{$row['id_pupuk']}'>
                                    <div class='mb-3'>
                                        <label for='nama_pupuk' class='form-label'>Nama Pupuk</label>
                                        <input type='text' class='form-control' name='nama_pupuk' value='{$row['nama_pupuk']}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='satuan' class='form-label'>Satuan</label>
                                        <input type='text' class='form-control' name='satuan' value='{$row['satuan']}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label for='harga' class='form-label'>Harga</label>
                                        <input type='number' class='form-control' name='harga' value='{$row['harga']}' required>
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
                                echo "<p class='text-center'>Tidak ada data.</p>";
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

    <!-- Modal Form Tambah Data Pupuk -->
    <div class="modal fade" id="modalTambahPupuk" tabindex="-1" aria-labelledby="modalTambahPupukLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPupukLabel">Tambah Data Pupuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah_pupuk.php" method="post">
                        <div class="mb-3">
                            <label for="nama_pupuk" class="form-label">Nama Pupuk</label>
                            <input type="text" class="form-control" id="nama_pupuk" name="nama_pupuk" required>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>