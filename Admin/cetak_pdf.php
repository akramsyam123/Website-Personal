<?php
require 'D:/xampp/htdocs/toko pakaian muslim azzahra/tcpdf/tcpdf.php';

// Koneksi ke database
$con = mysqli_connect("localhost", "root", "", "toko pakaian muslim azzahra");
if (mysqli_connect_error()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil data
$sql = "SELECT 
           user_registration.CustomerId, 
           user_registration.CustomerName, 
           shopping_cart_final.ItemName, 
           shopping_cart_final.Quantity, 
           shopping_cart_final.Price, 
           shopping_cart_final.Total 
       FROM user_registration 
       INNER JOIN shopping_cart_final 
       ON user_registration.CustomerId = shopping_cart_final.CustomerId";

$result = mysqli_query($con, $sql);
if (!$result) {
    die("Query gagal: " . mysqli_error($con));
}

// Inisialisasi TCPDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Toko Pakaian Muslim Azzahra');
$pdf->SetTitle('Laporan Data Penjualan');
$pdf->SetHeaderData('', 0, 'Laporan Data Penjualan', 'Toko Pakaian Muslim Azzahra');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 10));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();

// Konten PDF
$html = '<h2 align="center">Laporan Data Penjualan</h2><br>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; text-align: left;">
            <thead>
                <tr>
                    <th style="width: 10%;"><strong>ID</strong></th>
                    <th style="width: 25%;"><strong>Customer Name</strong></th>
                    <th style="width: 25%;"><strong>Item Name</strong></th>
                    <th style="width: 10%;"><strong>Quantity</strong></th>
                    <th style="width: 15%;"><strong>Price</strong></th>
                    <th style="width: 15%;"><strong>Total</strong></th>
                </tr>
            </thead>
            <tbody>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $html .= "<tr>
                    <td>{$row['CustomerId']}</td>
                    <td>{$row['CustomerName']}</td>
                    <td>{$row['ItemName']}</td>
                    <td>{$row['Quantity']}</td>
                    <td>Rp " . number_format($row['Price'], 2, ',', '.') . "</td>
                    <td>Rp " . number_format($row['Total'], 2, ',', '.') . "</td>
                  </tr>";
    }
} else {
    $html .= '<tr><td colspan="6" align="center">Data tidak tersedia</td></tr>';
}

$html .= '</tbody></table>';

// Output ke PDF
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Laporan_Data_Penjualan.pdf', 'I');
?>
