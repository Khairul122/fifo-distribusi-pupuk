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
                            <h3 class="mb-0">Stok Pupuk</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahStok">Tambah Stok</button>
                        </div>
                        <div class="card-body">
                            <?php
                            include 'koneksi.php';

                            $query = "SELECT s.id_stok, s.id_pupuk, s.stok, s.harga_total, p.nama_pupuk, p.harga
              FROM stok s
              JOIN pupuk p ON s.id_pupuk = p.id_pupuk";

                            $result = $koneksi->query($query);
                            $no = 1;

                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>";
                                echo "<thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pupuk</th>
                    <th>Jumlah Stok</th>
                    <th>Harga Total</th>
                    <th>Aksi</th>
                </tr>
              </thead>";
                                echo "<tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nama_pupuk']}</td>
                    <td>{$row['stok']}</td>
                    <td>Rp " . number_format($row['harga_total'], 2, ',', '.') . "</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditStok{$row['id_stok']}'>Edit</button>
                        <a href='crud/hapus_stok.php?id={$row['id_stok']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")' class='btn btn-danger btn-sm'>Hapus</a>
                    </td>
                  </tr>";

                                    echo "<div class='modal fade' id='modalEditStok{$row['id_stok']}' tabindex='-1' aria-labelledby='modalEditStokLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='modalEditStokLabel'>Edit Data Stok</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-body'>
                                <form action='crud/edit_stok.php' method='post'>
                                    <input type='hidden' name='id_stok' value='{$row['id_stok']}'>
                                    <input type='hidden' id='harga_pupuk_{$row['id_stok']}' value='{$row['harga']}'> 
                                    
                                    <div class='mb-3'>
                                        <label for='stok' class='form-label'>Jumlah Stok</label>
                                        <input type='number' class='form-control' id='stok_{$row['id_stok']}' name='stok' value='{$row['stok']}' required oninput='hitungHargaTotal({$row['id_stok']})'>
                                    </div>
                                    
                                    <div class='mb-3'>
                                        <label for='harga_total' class='form-label'>Harga Total</label>
                                        <input type='text' class='form-control' id='harga_total_format_{$row['id_stok']}' readonly>
                                        <input type='hidden' class='form-control' id='harga_total_{$row['id_stok']}' name='harga_total' value='{$row['harga_total']}' readonly>
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
                                echo "<p class='text-center'>Tidak ada data stok.</p>";
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

    <!-- Modal Tambah -->
    <div class="modal fade" id="modalTambahStok" tabindex="-1" aria-labelledby="modalTambahStokLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahStokLabel">Tambah Data Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="crud/tambah_stok.php" method="post">
                        <div class="mb-3">
                            <label for="id_pupuk" class="form-label">Nama Pupuk</label>
                            <select class="form-control" id="id_pupuk" name="id_pupuk" required>
                                <option value="">Pilih Pupuk</option>
                                <?php
                                include 'koneksi.php';
                                $query_pupuk = "SELECT * FROM pupuk";
                                $result_pupuk = $koneksi->query($query_pupuk);
                                while ($row_pupuk = $result_pupuk->fetch_assoc()) {
                                    echo "<option value='{$row_pupuk['id_pupuk']}' data-harga='{$row_pupuk['harga']}'>{$row_pupuk['nama_pupuk']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Jumlah Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga Satuan</label>
                            <input type="text" class="form-control" id="harga_format" readonly>
                            <input type="hidden" id="harga" name="harga">
                        </div>
                        <div class="mb-3">
                            <label for="harga_total" class="form-label">Harga Total</label>
                            <input type="text" class="form-control" id="harga_total_format" readonly>
                            <input type="hidden" id="harga_total" name="harga_total">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pupukSelect = document.getElementById("id_pupuk");
            const stokInput = document.getElementById("stok");
            const hargaInput = document.getElementById("harga");
            const hargaFormatInput = document.getElementById("harga_format");
            const hargaTotalInput = document.getElementById("harga_total");
            const hargaTotalFormatInput = document.getElementById("harga_total_format");

            pupukSelect.addEventListener("change", function() {
                let selectedOption = pupukSelect.options[pupukSelect.selectedIndex];
                let harga = selectedOption.getAttribute("data-harga");

                if (harga) {
                    hargaInput.value = parseFloat(harga);
                    hargaFormatInput.value = formatRupiah(hargaInput.value);
                    hitungHargaTotal();
                } else {
                    hargaInput.value = "";
                    hargaFormatInput.value = "";
                    hargaTotalInput.value = "";
                    hargaTotalFormatInput.value = "";
                }
            });

            stokInput.addEventListener("input", function() {
                hitungHargaTotal();
            });

            function hitungHargaTotal() {
                let harga = parseFloat(hargaInput.value);
                let jumlah = parseInt(stokInput.value);

                if (!isNaN(harga) && !isNaN(jumlah)) {
                    let total = harga * jumlah;
                    hargaTotalInput.value = total;
                    hargaTotalFormatInput.value = formatRupiah(total);
                } else {
                    hargaTotalInput.value = "";
                    hargaTotalFormatInput.value = "";
                }
            }

            function formatRupiah(angka) {
                return "Rp " + angka.toLocaleString('id-ID', {
                    minimumFractionDigits: 2
                });
            }
        });
    </script>

    <script>
        function hitungHargaTotal(id) {
            let stokInput = document.getElementById("stok_" + id);
            let hargaPupuk = document.getElementById("harga_pupuk_" + id).value;
            let hargaTotalInput = document.getElementById("harga_total_" + id);
            let hargaTotalFormatInput = document.getElementById("harga_total_format_" + id);

            let jumlah = parseInt(stokInput.value);
            let harga = parseFloat(hargaPupuk);

            if (!isNaN(jumlah) && !isNaN(harga)) {
                let total = jumlah * harga;
                hargaTotalInput.value = total;
                hargaTotalFormatInput.value = formatRupiah(total);
            } else {
                hargaTotalInput.value = "";
                hargaTotalFormatInput.value = "";
            }
        }

        function formatRupiah(angka) {
            return "Rp " + angka.toLocaleString('id-ID', {
                minimumFractionDigits: 2
            });
        }
    </script>

</body>

</html>