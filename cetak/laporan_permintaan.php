<?php
require_once('../TCPDF/tcpdf.php');
include '../koneksi.php';

$query = "SELECT permintaan.*, pengecer.nama_pengecer, pupuk.nama_pupuk 
          FROM permintaan 
          JOIN pengecer ON permintaan.id_pengecer = pengecer.id_pengecer
          JOIN pupuk ON permintaan.id_pupuk = pupuk.id_pupuk";
$result = $koneksi->query($query);
if (!$result) {
    die("Query error: " . $koneksi->error);
}

$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dinas DKUKMP Kabupaten Tanah Datar');
$pdf->SetTitle('Laporan Permintaan');
$pdf->SetSubject('Laporan Permintaan');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->AddPage();
$image_file = '../img/logo.jpg';
$pdf->Image($image_file, 5, 10, 30);

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
<h3 style="text-align:center; margin-top:15px;">LAPORAN PERMINTAAN PUPUK</h3>
';

$html .= '
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th align="center"><b>No</b></th>
            <th align="center"><b>Tanggal Permintaan</b></th>
            <th align="center"><b>Nama Distributor</b></th>
            <th align="center"><b>Nama Pengecer</b></th>
            <th align="center"><b>Nama Pupuk</b></th>
            <th align="center"><b>Jumlah</b></th>
            <th align="center"><b>Kecamatan</b></th>
            <th align="center"><b>Keterangan</b></th>
            <th align="center"><b>Status</b></th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
while ($row = $result->fetch_assoc()) {
    $html .= '
        <tr>
            <td align="center">' . $no . '</td>
            <td align="center">' . date("d-m-Y", strtotime($row['tanggal_permintaan'])) . '</td>
            <td align="center">' . $row['nama_distributor'] . '</td>
            <td align="center">' . $row['nama_pengecer'] . '</td>
            <td align="center">' . $row['nama_pupuk'] . '</td>
            <td align="center">' . $row['jumlah'] . '</td>
            <td align="center">' . $row['kecamatan'] . '</td>
            <td align="center">' . $row['keterangan'] . '</td>
            <td align="center">' . $row['status'] . '</td>
        </tr>';
    $no++;
}

$html .= '</tbody></table>';

$html .= '
<br><br>
<table border="0" cellspacing="0" cellpadding="5">
    <tr>
        <td width="74%"></td>
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

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('Laporan_Permintaan.pdf', 'I');

$koneksi->close();
?>
