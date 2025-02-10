<?php include 'template/header.php'; 

?>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <?php include 'template/navbar.php'; ?>
        <?php include 'template/sidebar.php'; ?>
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Permintaan</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPermintaan">
                    Tambah Data
                </button>
            </div>
            <div class="card-body">
                            <?php
                            include 'koneksi.php';
                            $query = "SELECT * FROM permintaan";
                            $result = $koneksi->query($query);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>";
                                echo "<thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Permintaan</th>
                                        <th>Nama Distributor</th>
                                        <th>ID Pupuk</th>
                                        <th>Jumlah</th>
                                        <th>Kecamatan</th>
                                        <th>Dokumentasi</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$no}</td>
                                        <td>";
                                            $bulanIndo = [
                                                1 => 'Januari',
                                                2 => 'Februari',
                                                3 => 'Maret',
                                                4 => 'April',
                                                5 => 'Mei',
                                                6 => 'Juni',
                                                7 => 'Juli',
                                                8 => 'Agustus',
                                                9 => 'September',
                                                10 => 'Oktober',
                                                11 => 'November',
                                                12 => 'Desember'
                                            ];
                                            $tanggal = $row['tanggal_permintaan'];
                                            $timestamp = strtotime($tanggal);
                                            $day = date('j', $timestamp);
                                            $month = $bulanIndo[(int)date('m', $timestamp)];
                                            $year = date('Y', $timestamp);
                                            echo "$day $month $year";
                                    echo "</td>
                                        <td>{$row['nama_distributor']}</td>
                                        <td>{$row['id_pupuk']}</td>
                                        <td>{$row['jumlah']}</td>
                                        <td>{$row['kecamatan']}</td>
                                        <td>";
                                            $file_path = "uploads/{$row['dokumentasi']}";
                                            if (file_exists($file_path) && !empty($row['dokumentasi'])) {
                                                echo "<a href='$file_path' target='_blank'>Lihat</a>";
                                            } else {
                                                echo "Tidak ada";
                                            }
                                    echo "</td>
                                        <td>{$row['keterangan']}</td>
                                        <td>{$row['status']}</td>
                                        <td>
                                            <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditPermintaan{$row['id_permintaan']}'>Edit</button>
                                            <a href='crud/hapus_permintaan.php?id={$row['id_permintaan']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                                        </td>
                                    </tr>";
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
        <footer class="app-footer"></footer>
    </div>

    <!-- Modal Tambah Data Permintaan -->
    <div class="modal fade" id="modalTambahPermintaan" tabindex="-1" aria-labelledby="modalTambahPermintaanLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahPermintaanLabel">Tambah Data Permintaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah_permintaan.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="tanggal_permintaan" class="form-label">Tanggal Permintaan</label>
                            <input type="date" class="form-control" id="tanggal_permintaan" name="tanggal_permintaan" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama_distributor" class="form-label">Nama Distributor</label>
                            <input type="text" class="form-control" id="nama_distributor" name="nama_distributor" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_pupuk" class="form-label">Nama Pupuk</label>
                            <select class="form-control" id="id_pupuk" name="id_pupuk" required>
                                <option value="">-- Pilih Pupuk --</option>
                                <?php
                                include 'koneksi.php';
                                $query_pupuk = "SELECT id_pupuk, nama_pupuk FROM pupuk";
                                $result_pupuk = $koneksi->query($query_pupuk);
                                while ($row_pupuk = $result_pupuk->fetch_assoc()) {
                                    echo "<option value='{$row_pupuk['id_pupuk']}'>{$row_pupuk['nama_pupuk']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>

                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                        </div>

                        <div class="mb-3">
                            <label for="dokumentasi" class="form-label">Dokumentasi</label>
                            <input type="file" class="form-control" id="dokumentasi" name="dokumentasi">
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>