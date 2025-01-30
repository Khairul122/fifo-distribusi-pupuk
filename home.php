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
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        include 'koneksi.php';

                        $query_pupuk_masuk = "SELECT COUNT(*) AS total_pupuk_masuk FROM pupuk_masuk";
                        $result_pupuk_masuk = $koneksi->query($query_pupuk_masuk);
                        $total_pupuk_masuk = $result_pupuk_masuk->fetch_assoc()['total_pupuk_masuk'];

                        $query_distribusi = "SELECT COUNT(*) AS total_distribusi FROM distribusi";
                        $result_distribusi = $koneksi->query($query_distribusi);
                        $total_distribusi = $result_distribusi->fetch_assoc()['total_distribusi'];
                        ?>

                        <div class="col-md-6">
                            <div class="card text-white bg-primary mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pupuk Masuk : <?php echo $total_pupuk_masuk; ?></h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Total Distribusi : <?php echo $total_distribusi; ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0">Pupuk Kurang Stok</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pupuk</th>
                                                <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query_stok = "SELECT pupuk.nama_pupuk, stok.stok 
                                                           FROM stok 
                                                           JOIN pupuk ON stok.id_pupuk = pupuk.id_pupuk
                                                           WHERE stok.stok < 5";
                                            $result_stok = $koneksi->query($query_stok);
                                            $no = 1;
                                            if ($result_stok->num_rows > 0) {
                                                while ($row = $result_stok->fetch_assoc()) {
                                                    echo "<tr>
                                                            <td>{$no}</td>
                                                            <td>{$row['nama_pupuk']}</td>
                                                            <td>{$row['stok']}</td>
                                                          </tr>";
                                                    $no++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='3' class='text-center'>Tidak ada data</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="mb-0">Pupuk Kadaluarsa</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pupuk</th>
                                                <th>Tanggal Kadaluarsa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query_kadaluarsa = "SELECT pupuk.nama_pupuk, pupuk_masuk.tanggal_kadaluarsa 
                                                                 FROM pupuk_masuk
                                                                 JOIN pupuk ON pupuk_masuk.id_pupuk = pupuk.id_pupuk
                                                                 WHERE DATEDIFF(pupuk_masuk.tanggal_kadaluarsa, CURDATE()) <= 5";
                                            $result_kadaluarsa = $koneksi->query($query_kadaluarsa);
                                            $no = 1;
                                            if ($result_kadaluarsa->num_rows > 0) {
                                                while ($row = $result_kadaluarsa->fetch_assoc()) {
                                                    echo "<tr>
                                                            <td>{$no}</td>
                                                            <td>{$row['nama_pupuk']}</td>
                                                            <td>{$row['tanggal_kadaluarsa']}</td>
                                                          </tr>";
                                                    $no++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='3' class='text-center'>Tidak ada data</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="app-footer">
        </footer>
    </div>
</body>
</html>
