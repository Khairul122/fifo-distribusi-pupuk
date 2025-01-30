<?php
require_once('../TCPDF/tcpdf.php');
include '../koneksi.php';

// Ambil data dari database
$query = "SELECT id_pengecer, nama_pengecer, jenis_kelamin, tanggal_lahir, no_hp, alamat FROM pengecer";
$result = $koneksi->query($query);
if (!$result) {
    die("Query error: " . $koneksi->error);
}

// Buat objek PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dinas DKUKMP Kabupaten Tanah Datar');
$pdf->SetTitle('Laporan Pengecer');
$pdf->SetSubject('Laporan Pengecer');

// Hilangkan header dan footer default
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Tambahkan halaman baru
$pdf->AddPage();
$image_file = '../img/logo.jpg';
$pdf->Image($image_file, 5, 10, 30); 

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
<h3 style="text-align:center; margin-top:15px;">LAPORAN PENGECER</h3>
';

// Tambahkan tabel laporan
$html .= '
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th align="center"><b>No</b></th>
            <th align="center"><b>ID Pengecer</b></th>
            <th align="center"><b>Nama Pengecer</b></th>
            <th align="center"><b>Jenis Kelamin</b></th>
            <th align="center"><b>Tanggal Lahir</b></th>
            <th align="center"><b>No HP</b></th>
            <th align="center"><b>Alamat</b></th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
while ($row = $result->fetch_assoc()) {
    $html .= '
        <tr>
            <td align="center">' . $no . '</td>
            <td align="center">' . $row['id_pengecer'] . '</td>
            <td align="center">' . $row['nama_pengecer'] . '</td>
            <td align="center">' . $row['jenis_kelamin'] . '</td>
            <td align="center">' . $row['tanggal_lahir'] . '</td>
            <td align="center">' . $row['no_hp'] . '</td>
            <td align="center">' . $row['alamat'] . '</td>
        </tr>';
    $no++;
}

$html .= '</tbody></table>';

// Tambahkan tanda tangan
$html .= '
<br><br>
<table border="0" cellspacing="0" cellpadding="5">
    <tr>
        <td width="64%"></td>
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
$pdf->Output('Laporan_Pengecer.pdf', 'I');

// Tutup koneksi database
$koneksi->close();
