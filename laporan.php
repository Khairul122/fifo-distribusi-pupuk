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
                            <h3 class="mb-0">Laporan Pupuk</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">

                        <!-- Laporan Pupuk -->
                        <div class="card mt-3">
                            <div class="card-header d-flex flex-column align-items-start">
                                <h5 class="mb-2">Laporan Pupuk</h5>
                            </div>
                            <div class="card-body">
                                <div class="col-md-2 mt-2 d-flex align-items-start" style="margin-bottom: 15px;">
                                    <button type="button" class="btn btn-success" onclick="window.open('cetak/laporan_pupuk.php?<?php echo http_build_query($_GET); ?>', '_blank')">Cetak Laporan Pupuk</button>
                                </div>
                                <?php
                                include 'koneksi.php';

                                $query = "SELECT * FROM pupuk";
                                $result = $koneksi->query($query);

                                if ($result === false) {
                                    echo "<p class='text-center text-danger'>Terjadi kesalahan: " . $koneksi->error . "</p>";
                                } elseif ($result->num_rows > 0) {
                                    echo "<table class='table table-bordered table-striped'>";
                                    echo "<thead class='bg-primary text-white'>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pupuk</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                            </tr>
                                          </thead>";
                                    echo "<tbody>";
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$no}</td>
                                                <td>{$row['nama_pupuk']}</td>
                                                <td>{$row['satuan']}</td>
                                                <td>Rp " . number_format($row['harga'], 2, ',', '.') . "</td>
                                              </tr>";
                                        $no++;
                                    }
                                    echo "</tbody></table>";
                                } else {
                                    echo "<p class='text-center'>Tidak ada data pupuk.</p>";
                                }

                                $koneksi->close();
                                ?>
                            </div>
                        </div>

                        <!-- Laporan Stok -->
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Laporan Stok Pupuk</h5>
                            </div>
                            <div class="card-body">
                                <div class="col-md-2 mt-2 d-flex align-items-start" style="margin-bottom: 15px;">
                                    <button type="button" class="btn btn-success" onclick="window.open('cetak/laporan_stok.php?<?php echo http_build_query($_GET); ?>', '_blank')">Cetak Laporan Stok</button>
                                </div>
                                <?php
                                include 'koneksi.php';

                                $query = "SELECT stok.id_stok, pupuk.nama_pupuk, stok.stok, stok.harga_total
                                          FROM stok
                                          JOIN pupuk ON stok.id_pupuk = pupuk.id_pupuk";
                                $result = $koneksi->query($query);

                                if ($result === false) {
                                    echo "<p class='text-center text-danger'>Terjadi kesalahan: " . $koneksi->error . "</p>";
                                } elseif ($result->num_rows > 0) {
                                    echo "<table class='table table-bordered table-striped'>";
                                    echo "<thead class='bg-primary text-white'>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pupuk</th>
                                                <th>Stok</th>
                                                <th>Harga Total</th>
                                            </tr>
                                          </thead>";
                                    echo "<tbody>";
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>{$no}</td>
                                                <td>{$row['nama_pupuk']}</td>
                                                <td>{$row['stok']}</td>
                                                <td>Rp " . number_format($row['harga_total'], 2, ',', '.') . "</td>
                                              </tr>";
                                        $no++;
                                    }
                                    echo "</tbody></table>";
                                } else {
                                    echo "<p class='text-center'>Tidak ada data stok.</p>";
                                }

                                $koneksi->close();
                                ?>
                            </div>
                        </div>

                        <!-- Laporan Pengecer -->
                        <div class="card mt-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Laporan Pengecer</h5>
                            </div>
                            <div class="card-body">
                                <div class="col-md-2 mt-2 d-flex align-items-start" style="margin-bottom: 15px;">
                                    <button type="button" class="btn btn-success" onclick="window.open('cetak/laporan_pengecer.php?<?php echo http_build_query($_GET); ?>', '_blank')">Cetak Laporan Pengecer</button>
                                </div>
                                <?php
                                include 'koneksi.php';

                                $query = "SELECT id_pengecer, nama_pengecer, jenis_kelamin, tanggal_lahir, no_hp, alamat FROM pengecer";
                                $result = $koneksi->query($query);

                                if ($result === false) {
                                    echo "<p class='text-center text-danger'>Terjadi kesalahan: " . $koneksi->error . "</p>";
                                } elseif ($result->num_rows > 0) {
                                    echo "<table class='table table-bordered table-striped'>";
                                    echo "<thead class='bg-primary text-white'>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengecer</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                    </tr>
                  </thead>";
                                    echo "<tbody>";
                                    $no = 1;
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_pengecer']}</td>
                        <td>{$row['jenis_kelamin']}</td>
                        <td>{$row['tanggal_lahir']}</td>
                        <td>{$row['no_hp']}</td>
                        <td>{$row['alamat']}</td>
                      </tr>";
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

                <!-- Laporan Pupuk Masuk -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Laporan Pupuk Masuk</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-2 mt-2 d-flex align-items-start" style="margin-bottom: 15px;">
                            <button type="button" class="btn btn-success" onclick="window.open('cetak/laporan_pupuk_masuk.php?<?php echo http_build_query($_GET); ?>', '_blank')">Cetak Laporan Pupuk Masuk</button>
                        </div>
                        <?php
                        include 'koneksi.php';

                        $query = "SELECT pupuk_masuk.id_pupuk_masuk, pupuk.nama_pupuk, pupuk_masuk.jumlah_masuk, 
                         pupuk_masuk.tanggal_masuk, pupuk_masuk.tanggal_kadaluarsa, pupuk_masuk.dokumentasi 
                  FROM pupuk_masuk
                  JOIN pupuk ON pupuk_masuk.id_pupuk = pupuk.id_pupuk";

                        $result = $koneksi->query($query);

                        if ($result === false) {
                            echo "<p class='text-center text-danger'>Terjadi kesalahan: " . $koneksi->error . "</p>";
                        } elseif ($result->num_rows > 0) {
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead class='bg-primary text-white'>
                    <tr>
                        <th>No</th>
                        <th>Nama Pupuk</th>
                        <th>Jumlah Masuk</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>Dokumentasi</th>
                    </tr>
                  </thead>";
                            echo "<tbody>";
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_pupuk']}</td>
                        <td>{$row['jumlah_masuk']}</td>
                        <td>{$row['tanggal_masuk']}</td>
                        <td>{$row['tanggal_kadaluarsa']}</td>
                        <td><img src='uploads/{$row['dokumentasi']}' width='100' height='100' alt='Dokumentasi'></td>
                      </tr>";
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

                <!-- Laporan Distribusi -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Laporan Distribusi Pupuk</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-2 mt-2 d-flex align-items-start" style="margin-bottom: 15px;">
                            <button type="button" class="btn btn-success" onclick="window.open('cetak/laporan_distribusi.php?<?php echo http_build_query($_GET); ?>', '_blank')">Cetak Laporan Distribusi</button>
                        </div>
                        <?php
                        include 'koneksi.php';

                        $query = "SELECT distribusi.id_distribusi, pupuk.nama_pupuk, pengecer.nama_pengecer, distribusi.satuan, 
                         distribusi.jumlah_keluar, distribusi.harga_distribusi, distribusi.harga_total, 
                         distribusi.tujuan, distribusi.tanggal_distribusi, distribusi.dokumentasi
                  FROM distribusi
                  JOIN pupuk ON distribusi.id_pupuk = pupuk.id_pupuk
                  JOIN pengecer ON distribusi.id_pengecer = pengecer.id_pengecer";

                        $result = $koneksi->query($query);

                        if ($result === false) {
                            echo "<p class='text-center text-danger'>Terjadi kesalahan: " . $koneksi->error . "</p>";
                        } elseif ($result->num_rows > 0) {
                            echo "<table class='table table-bordered table-striped'>";
                            echo "<thead class='bg-primary text-white'>
                    <tr>
                        <th>No</th>
                        <th>Nama Pupuk</th>
                        <th>Nama Pengecer</th>
                        <th>Satuan</th>
                        <th>Jumlah Keluar</th>
                        <th>Harga Distribusi</th>
                        <th>Harga Total</th>
                        <th>Tujuan</th>
                        <th>Tanggal Distribusi</th>
                        <th>Dokumentasi</th>
                    </tr>
                  </thead>";
                            echo "<tbody>";
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama_pupuk']}</td>
                        <td>{$row['nama_pengecer']}</td>
                        <td>{$row['satuan']}</td>
                        <td>{$row['jumlah_keluar']}</td>
                        <td>Rp " . number_format($row['harga_distribusi'], 2, ',', '.') . "</td>
                        <td>Rp " . number_format($row['harga_total'], 2, ',', '.') . "</td>
                        <td>{$row['tujuan']}</td>
                        <td>{$row['tanggal_distribusi']}</td>
                        <td>";
                                if (!empty($row['dokumentasi']) && file_exists('uploads/' . $row['dokumentasi'])) {
                                    echo "<img src='uploads/{$row['dokumentasi']}' width='100' height='100' alt='Dokumentasi'>";
                                } else {
                                    echo "Tidak ada dokumentasi";
                                }
                                echo "</td></tr>";
                                $no++;
                            }
                            echo "</tbody></table>";
                        } else {
                            echo "<p class='text-center'>Tidak ada data distribusi.</p>";
                        }

                        $koneksi->close();
                        ?>
                    </div>
                </div>


                <!-- Laporan Permintaan -->
                <div class="card mt-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Laporan Permintaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-md-2 mt-2 d-flex align-items-start" style="margin-bottom: 15px;">
                            <button type="button" class="btn btn-success" onclick="window.open('cetak/laporan_permintaan.php?<?php echo http_build_query($_GET); ?>', '_blank')">Cetak Laporan Permintaan</button>
                        </div>
                        <?php
                        include 'koneksi.php';
                        $query = "SELECT permintaan.*, pengecer.nama_pengecer, pupuk.nama_pupuk 
                  FROM permintaan 
                  JOIN pengecer ON permintaan.id_pengecer = pengecer.id_pengecer
                  JOIN pupuk ON permintaan.id_pupuk = pupuk.id_pupuk";
                        $result = $koneksi->query($query);
                        $no = 1;

                        if ($result->num_rows > 0) {
                            echo "<table class='table table-bordered'>";
                            echo "<thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Permintaan</th>
                    <th>Nama Distributor</th>
                    <th>Nama Pengecer</th>
                    <th>Nama Pupuk</th>
                    <th>Jumlah</th>
                    <th>Kecamatan</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                </tr>
            </thead>";
                            echo "<tbody>";

                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['tanggal_permintaan']}</td>
                    <td>{$row['nama_distributor']}</td>
                    <td>{$row['nama_pengecer']}</td>
                    <td>{$row['nama_pupuk']}</td>
                    <td>{$row['jumlah']}</td>
                    <td>{$row['kecamatan']}</td>
                    <td>{$row['keterangan']}</td>
                    <td>{$row['status']}</td>
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
        </main>
        <footer class="app-footer">
        </footer>
    </div>
</body>

</html>