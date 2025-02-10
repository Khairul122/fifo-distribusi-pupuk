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
                            <h3 class="mb-0">Distribusi</h3>
                        </div>

                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahDistribusi">Tambah Data</button>
                        </div>
                        <div class="card-body">
                            <?php
                            include 'koneksi.php';

                            $query = "SELECT d.id_distribusi, p.id_pupuk, p.nama_pupuk, pe.id_pengecer, pe.nama_pengecer, 
                            d.satuan, d.tujuan, d.kecamatan, d.tanggal_distribusi, d.harga_distribusi, 
                            d.jumlah_keluar, d.harga_total, d.dokumentasi 
                     FROM distribusi d
                     JOIN pupuk p ON d.id_pupuk = p.id_pupuk
                     JOIN pengecer pe ON d.id_pengecer = pe.id_pengecer";


                            $result = $koneksi->query($query);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>";
                                echo "<thead>
                            <tr>
                <th>No</th>
                <th>Nama Pupuk</th>
                <th>Pengecer</th>
                <th>Satuan</th>
                <th>Tujuan</th>
                <th>Kecamatan</th>
                <th>Tanggal Distribusi</th>
                <th>Harga Distribusi</th>
                <th>Jumlah Keluar</th>
                <th>Harga Total</th>
                <th>Dokumentasi</th>
                <th>Aksi</th>
            </tr>
                          </thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    $tanggal_distribusi = date("j F Y", strtotime($row['tanggal_distribusi']));
                                    echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama_pupuk']}</td>
                                    <td>{$row['nama_pengecer']}</td>
                                    <td>{$row['satuan']}</td>
                                    <td>{$row['tujuan']}</td>
                                     <td>{$row['kecamatan']}</td>
                                    <td>{$tanggal_distribusi}</td>
                                    <td>Rp " . number_format($row['harga_distribusi'], 2, ',', '.') . "</td>
                                    <td>{$row['jumlah_keluar']}</td>
                                    <td>Rp " . number_format($row['harga_total'], 2, ',', '.') . "</td>
                                    <td><a href='uploads/{$row['dokumentasi']}' target='_blank'>Lihat</a></td>
                                    <td>
                                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditDistribusi{$row['id_distribusi']}'>Edit</button>
                                        <a href='crud/hapus_distribusi.php?id={$row['id_distribusi']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                                    </td>
                                  </tr>";

                                    echo "<div class='modal fade' id='modalEditDistribusi{$row['id_distribusi']}' tabindex='-1' aria-labelledby='modalEditDistribusiLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title'>Edit Distribusi</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form action='crud/edit_distribusi.php' method='post' enctype='multipart/form-data'>
                                                <input type='hidden' name='id_distribusi' value='{$row['id_distribusi']}'>
                                                <div class='mb-3'>
                                                    <label for='id_pupuk' class='form-label'>Nama Pupuk</label>
                                                    <select class='form-control' name='id_pupuk' required>";
                                    $query_pupuk = "SELECT id_pupuk, nama_pupuk FROM pupuk";
                                    $result_pupuk = $koneksi->query($query_pupuk);
                                    while ($row_pupuk = $result_pupuk->fetch_assoc()) {
                                        $selected = ($row_pupuk['id_pupuk'] == $row['id_pupuk']) ? "selected" : "";
                                        echo "<option value='{$row_pupuk['id_pupuk']}' $selected>{$row_pupuk['nama_pupuk']}</option>";
                                    }
                                    echo "<div class='modal fade' id='modalEditDistribusi{$row['id_distribusi']}' tabindex='-1' aria-labelledby='modalEditDistribusiLabel' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title'>Edit Distribusi</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                               <form action='crud/edit_distribusi.php' method='post' enctype='multipart/form-data'>
    <input type='hidden' name='id_distribusi' value='{$row['id_distribusi']}'>
    
    <div class='mb-3'>
        <label for='id_pupuk' class='form-label'>Nama Pupuk</label>
        <select class='form-control' name='id_pupuk' required>";
                                    $query_pupuk = "SELECT id_pupuk, nama_pupuk FROM pupuk";
                                    $result_pupuk = $koneksi->query($query_pupuk);
                                    while ($row_pupuk = $result_pupuk->fetch_assoc()) {
                                        $selected = ($row_pupuk['id_pupuk'] == $row['id_pupuk']) ? "selected" : "";
                                        echo "<option value='{$row_pupuk['id_pupuk']}' $selected>{$row_pupuk['nama_pupuk']}</option>";
                                    }
                                    echo "</select>
    </div>

    <div class='mb-3'>
        <label for='id_pengecer' class='form-label'>Pengecer</label>
        <select class='form-control' name='id_pengecer' required>";
                                    $query_pengecer = "SELECT id_pengecer, nama_pengecer FROM pengecer";
                                    $result_pengecer = $koneksi->query($query_pengecer);
                                    while ($row_pengecer = $result_pengecer->fetch_assoc()) {
                                        $selected = ($row_pengecer['id_pengecer'] == $row['id_pengecer']) ? "selected" : "";
                                        echo "<option value='{$row_pengecer['id_pengecer']}' $selected>{$row_pengecer['nama_pengecer']}</option>";
                                    }
                                    echo "</select>
    </div>

    <div class='mb-3'>
        <label for='satuan' class='form-label'>Satuan</label>
        <input type='text' class='form-control' name='satuan' value='{$row['satuan']}' required>
    </div>

    <div class='mb-3'>
        <label for='tujuan' class='form-label'>Tujuan</label>
        <input type='text' class='form-control' name='tujuan' value='{$row['tujuan']}' required>
    </div>

    <div class='mb-3'>
        <label for='kecamatan' class='form-label'>Kecamatan</label>
        <input type='text' class='form-control' name='kecamatan' value='{$row['kecamatan']}' required>
    </div>

    <div class='mb-3'>
        <label for='tanggal_distribusi' class='form-label'>Tanggal Distribusi</label>
        <input type='date' class='form-control' name='tanggal_distribusi' value='{$row['tanggal_distribusi']}' required>
    </div>

    <div class='mb-3'>
        <label for='harga_distribusi' class='form-label'>Harga Distribusi</label>
        <input type='number' class='form-control' id='harga_distribusi_{$row['id_distribusi']}' name='harga_distribusi' value='{$row['harga_distribusi']}' required oninput='hitungHargaTotal({$row['id_distribusi']})'>
    </div>

    <div class='mb-3'>
        <label for='jumlah_keluar' class='form-label'>Jumlah Keluar</label>
        <input type='number' class='form-control' id='jumlah_keluar_{$row['id_distribusi']}' name='jumlah_keluar' value='{$row['jumlah_keluar']}' required oninput='hitungHargaTotal({$row['id_distribusi']})'>
    </div>

    <div class='mb-3'>
        <label for='harga_total' class='form-label'>Harga Total</label>
        <input type='text' class='form-control' id='harga_total_format_{$row['id_distribusi']}' readonly>
        <input type='hidden' class='form-control' id='harga_total_{$row['id_distribusi']}' name='harga_total' value='{$row['harga_total']}'>
    </div>

    <div class='mb-3'>
        <label for='dokumentasi' class='form-label'>Dokumentasi</label>
        <input type='file' class='form-control' name='dokumentasi'>
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
                                echo "<p class='text-center'>Tidak ada data distribusi.</p>";
                            }

                            $koneksi->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>


            <script>
                function hitungHargaTotal(id) {
                    let jumlahKeluar = document.getElementById(`jumlah_keluar_${id}`).value || 0;
                    let hargaDistribusi = document.getElementById(`harga_distribusi_${id}`).value || 0;
                    let total = jumlahKeluar * hargaDistribusi;

                    document.getElementById(`harga_total_${id}`).value = total;
                    document.getElementById(`harga_total_format_${id}`).value = total.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    });
                }
            </script>


        </main>
        <footer class="app-footer">
        </footer>
    </div>

    <div class="modal fade" id="modalTambahDistribusi" tabindex="-1" aria-labelledby="modalTambahDistribusiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Distribusi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah_distribusi.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="id_pupuk" class="form-label">Nama Pupuk</label>
                            <select class="form-control" id="id_pupuk" name="id_pupuk" required>
                                <option value="">Pilih Pupuk</option>
                                <?php
                                include 'koneksi.php';
                                $query_pupuk = "SELECT id_pupuk, nama_pupuk, harga FROM pupuk";
                                $result_pupuk = $koneksi->query($query_pupuk);
                                while ($row_pupuk = $result_pupuk->fetch_assoc()) {
                                    echo "<option value='{$row_pupuk['id_pupuk']}' data-harga='{$row_pupuk['harga']}'>{$row_pupuk['nama_pupuk']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_pengecer" class="form-label">Pengecer</label>
                            <select class="form-control" id="id_pengecer" name="id_pengecer" required>
                                <option value="">Pilih Pengecer</option>
                                <?php
                                $query_pengecer = "SELECT id_pengecer, nama_pengecer FROM pengecer";
                                $result_pengecer = $koneksi->query($query_pengecer);
                                while ($row_pengecer = $result_pengecer->fetch_assoc()) {
                                    echo "<option value='{$row_pengecer['id_pengecer']}'>{$row_pengecer['nama_pengecer']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" name="satuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <input type="text" class="form-control" name="tujuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                            <input type="number" class="form-control" id="jumlah_keluar" name="jumlah_keluar" required oninput="hitungHargaTotal()">
                        </div>
                        <div class="mb-3">
                            <label for="harga_distribusi" class="form-label">Harga Distribusi</label>
                            <input type="number" class="form-control" id="harga_distribusi" name="harga_distribusi" required oninput="hitungHargaTotal()">
                        </div>
                        <div class="mb-3">
                            <label for="harga_total" class="form-label">Harga Total</label>
                            <input type="text" class="form-control" id="harga_total_format" readonly>
                            <input type="hidden" class="form-control" id="harga_total" name="harga_total">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_distribusi" class="form-label">Tanggal Distribusi</label>
                            <input type="date" class="form-control" id="tanggal_distribusi" name="tanggal_distribusi" required>
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


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const jumlahKeluarInput = document.getElementById("jumlah_keluar");
            const hargaDistribusiInput = document.getElementById("harga_distribusi");
            const hargaTotalInput = document.getElementById("harga_total");
            const hargaTotalFormatInput = document.getElementById("harga_total_format");

            function hitungHargaTotal() {
                let jumlahKeluar = parseInt(jumlahKeluarInput.value) || 0;
                let hargaDistribusi = parseFloat(hargaDistribusiInput.value) || 0;
                let total = jumlahKeluar * hargaDistribusi;

                hargaTotalInput.value = total;
                hargaTotalFormatInput.value = total.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }

            jumlahKeluarInput.addEventListener("input", hitungHargaTotal);
            hargaDistribusiInput.addEventListener("input", hitungHargaTotal);
        });
    </script>
    <script>
        function hitungHargaTotal(id) {
            let jumlahKeluar = document.getElementById(`jumlah_keluar_${id}`).value || 0;
            let hargaDistribusi = document.getElementById(`harga_distribusi_${id}`).value || 0;
            let total = jumlahKeluar * hargaDistribusi;

            document.getElementById(`harga_total_${id}`).value = total;
            document.getElementById(`harga_total_format_${id}`).value = total.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
        }
    </script>

</body>

</html>