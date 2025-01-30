<?php
require_once('../TCPDF/tcpdf.php');
include '../koneksi.php';

// Ambil data dari database
$query = "SELECT pupuk_masuk.id_pupuk_masuk, pupuk.nama_pupuk, pupuk_masuk.jumlah_masuk, 
                 pupuk_masuk.tanggal_masuk, pupuk_masuk.tanggal_kadaluarsa, pupuk_masuk.dokumentasi 
          FROM pupuk_masuk
          JOIN pupuk ON pupuk_masuk.id_pupuk = pupuk.id_pupuk";

$result = $koneksi->query($query);
if (!$result) {
    die("Query error: " . $koneksi->error);
}

// Buat objek PDF (L = Landscape)
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dinas DKUKMP Kabupaten Tanah Datar');
$pdf->SetTitle('Laporan Pupuk Masuk');
$pdf->SetSubject('Laporan Pupuk Masuk');

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
<h3 style="text-align:center; margin-top:15px;">LAPORAN PUPUK MASUK</h3>
';

// Tambahkan tabel laporan
$html .= '
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th align="center"><b>No</b></th>
            <th align="center"><b>Nama Pupuk</b></th>
            <th align="center"><b>Jumlah Masuk</b></th>
            <th align="center"><b>Tanggal Masuk</b></th>
            <th align="center"><b>Tanggal Kadaluarsa</b></th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
$current_y = $pdf->GetY();

while ($row = $result->fetch_assoc()) {
    $dokumentasi_cell = '';
    if (!empty($row['dokumentasi'])) {
        $img_path = '../uploads/' . $row['dokumentasi'];
        if (file_exists($img_path)) {
            $dokumentasi_cell = '<img src="' . $img_path . '" width="60" height="60">';
        } else {
            $dokumentasi_cell = 'Gambar tidak ditemukan';
        }
    } else {
        $dokumentasi_cell = 'Tidak ada dokumentasi';
    }

    $html .= '
        <tr>
            <td align="center">' . $no . '</td>
            <td align="center">' . $row['nama_pupuk'] . '</td>
            <td align="center">' . $row['jumlah_masuk'] . '</td>
            <td align="center">' . $row['tanggal_masuk'] . '</td>
            <td align="center">' . $row['tanggal_kadaluarsa'] . '</td>
        </tr>';
    $no++;
}

$html .= '</tbody></table>';

// Tambahkan tanda tangan
$html .= '
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

// Masukkan HTML ke dalam PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF ke browser
$pdf->Output('Laporan_Pupuk_Masuk.pdf', 'I');

// Tutup koneksi database
$koneksi->close();
?>