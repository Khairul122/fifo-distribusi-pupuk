<?php
require_once('../TCPDF/tcpdf.php');
include '../koneksi.php';

// Ambil data dari database
$query = "SELECT distribusi.id_distribusi, pupuk.nama_pupuk, pengecer.nama_pengecer, distribusi.satuan, 
                 distribusi.jumlah_keluar, distribusi.harga_distribusi, distribusi.harga_total, 
                 distribusi.tujuan, distribusi.tanggal_distribusi, distribusi.dokumentasi
          FROM distribusi
          JOIN pupuk ON distribusi.id_pupuk = pupuk.id_pupuk
          JOIN pengecer ON distribusi.id_pengecer = pengecer.id_pengecer";

$result = $koneksi->query($query);
if (!$result) {
    die("Query error: " . $koneksi->error);
}

// Buat objek PDF (L = Landscape)
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dinas DKUKMP Kabupaten Tanah Datar');
$pdf->SetTitle('Laporan Distribusi Pupuk');
$pdf->SetSubject('Laporan Distribusi Pupuk');

// Hilangkan header dan footer default
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Tambahkan halaman baru
$pdf->AddPage();
$image_file = '../img/logo.jpg';
$pdf->Image($image_file, 10, 10, 30); 

// Kop Surat
$html = '
<table cellpadding="0">
    <tr>
        <td>
            <h3 style="font-size:14pt; text-align:center;">PEMERINTAH KABUPATEN TANAH DATAR</h3>
            <h4 style="font-size:12pt; text-align:center;">DINAS KOPERASI, USAHA KECIL, MENEGAH, DAN PERDAGANGAN</h4>
            <p style="font-size:8pt; text-align:center;">Jalan Prof Muhammad Yamin, SH Telp(0752)71039 - Fax (0752) 71147 Batusangkar 27261</p>
        </td>
    </tr>
</table>
 <hr style="height: 2px; background-color: black; border: none; margin-top: 20px;">
<h3 style="text-align:center; margin-top:15px;">LAPORAN DISTRIBUSI PUPUK</h3>
';

// Tambahkan tabel laporan
$html .= '
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th align="center"><b>No</b></th>
            <th align="center"><b>Nama Pupuk</b></th>
            <th align="center"><b>Nama Pengecer</b></th>
            <th align="center"><b>Satuan</b></th>
            <th align="center"><b>Jumlah Keluar</b></th>
            <th align="center"><b>Harga Distribusi</b></th>
            <th align="center"><b>Harga Total</b></th>
            <th align="center"><b>Tujuan</b></th>
            <th align="center"><b>Tanggal Distribusi</b></th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
$image_positions = [];
while ($row = $result->fetch_assoc()) {
    // Simpan posisi gambar agar dapat ditambahkan setelah tabel
    // if (!empty($row['dokumentasi'])) {
    //     $img_path = '../uploads/' . $row['dokumentasi'];
    //     if (file_exists($img_path)) {
    //         $image_positions[] = ['path' => $img_path, 'y' => $pdf->GetY()];
    //     }
    // }

    $html .= '
        <tr>
            <td align="center">' . $no . '</td>
            <td align="center">' . $row['nama_pupuk'] . '</td>
            <td align="center">' . $row['nama_pengecer'] . '</td>
            <td align="center">' . $row['satuan'] . '</td>
            <td align="center">' . $row['jumlah_keluar'] . '</td>
            <td align="center">Rp ' . number_format($row['harga_distribusi'], 2, ',', '.') . '</td>
            <td align="center">Rp ' . number_format($row['harga_total'], 2, ',', '.') . '</td>
            <td align="center">' . $row['tujuan'] . '</td>
            <td align="center">' . $row['tanggal_distribusi'] . '</td>
        </tr>';
    $no++;
}

$html .= '</tbody></table>';

// Masukkan tabel HTML ke dalam PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Tambahkan gambar ke dalam PDF setelah tabel dibuat
foreach ($image_positions as $img) {
    $pdf->Image($img['path'], 250, $img['y'], 25, 25); // Posisi X 250 agar pas di kolom dokumentasi
}

// Tambahkan tanda tangan
$html = '
<br><br>
<table border="0" cellspacing="0" cellpadding="5">
    <tr>
        <td width="70%"></td>
        <td>
            Batusangkar, ' . date("d F Y") . '<br>
            Kepala Dinas KUKMP<br>
            Kabupaten Tanah Datar<br>
            <br><br><br><br>
            <b>Drs. HENDRA SETYAWAN, M.Si</b><br>
            NIP. 1972071019920301007
        </td>
    </tr>
</table>';

// Masukkan tanda tangan ke dalam PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF ke browser
$pdf->Output('Laporan_Distribusi.pdf', 'I');

// Tutup koneksi database
$koneksi->close();
?>
