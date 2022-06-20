<?php
 if ($data->early_price == 0 && $data->late_price == 0) {
    $query = "SELECT u.nama_lengkap,u.email,u.no_wa,t.`total`,d.total_harga, DATE(t.`tgl_pembelian`) AS tgl_order, t.status FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.`product_id` = $data->id ";
    $query_pembeli ="SELECT COUNT(t.user_id) as pembeli FROM transaksi t JOIN transaksi_detail d ON d.transaksi_id = t.id WHERE d.product_id = $data->id";
}else{
    $query = "SELECT u.nama_lengkap,u.email,u.no_wa,t.`total`,d.total_harga, DATE(t.`tgl_pembelian`) AS tgl_order, t.status FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.status = 'success' AND d.`product_id` = $data->id ";
    $query_pembeli ="SELECT COUNT(t.user_id) as pembeli FROM transaksi t JOIN transaksi_detail d ON d.transaksi_id = t.id WHERE d.product_id = $data->id AND d.`status` = 'success'";
}

if ($this->uri->segment(4) == 'semua') {
    $query .= "";
    $query_pembeli .= "";
} else if ($this->uri->segment(4) == 'today') {
    $query .= "AND date(t.tgl_pembelian) = CURDATE()";
    $query_pembeli .= " AND date(t.tgl_pembelian) = CURDATE()";
} else if ($this->uri->segment(4) == 'this_week') {
    $query .= "AND WEEK(t.tgl_pembelian)=WEEK(now())";
    $query_pembeli .= " AND WEEK(t.tgl_pembelian)=WEEK(now())";
} else if ($this->uri->segment(4) == 'this_month') {
    $query .= "AND MONTH(t.tgl_pembelian)=MONTH(now())";
    $query_pembeli .= " AND MONTH(t.tgl_pembelian)=MONTH(now())";
} else {
    $string = explode('%', $this->uri->segment(4));

    $date1 = explode('-', $string[0]);
    $date2 = explode('-', $string[1]);

    $finalDate1 = $date1[0] . '-' . $date1[1] . '-' . $date1[2];
    $finalDate2 = $date2[0] . '-' . $date2[1] . '-' . $date2[2];
    $query .= "AND date(t.tgl_pembelian) between '" . $finalDate1 . "' and '" . $finalDate2 . "'";
    $query_pembeli .= " AND date(t.tgl_pembelian) between '" . $finalDate1 . "' and '" . $finalDate2 . "' ";
}
$detail                 = $this->query->get_query($query)->result();
$pembeli                = $this->query->get_query($query_pembeli)->row()->pembeli;
$is_asclepio_asclepedia = $this->query->get_query('SELECT a.* , b.product_id FROM transaksi a JOIN transaksi_detail b ON a.id = b.transaksi_id WHERE b.product_id = '.$data->id.' AND a.user_id = 22')->num_rows();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Peserta</title>
    <style>
        table tr td {
            padding: 5px 10px;
        }

        table tr th {
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <h1 style="text-align: center;">
        <?= $data->judul_kelas ?>
    </h1>

    <!-- Report -->
    <table style="width: 100%;border-collapse:collapse" border="1">
        <thead>
            <tr>
                <th>Jenis Peserta</th>
                <th>Jumlah Peserta</th>
                <th>Nominal Pembayaran Peserta</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Grand Total Peserta</td>
                <td><?= $pembeli ?></td>
                <td><?= number_format(100000) ?></td>

            </tr>
            <tr>
                <td>Total Peserta Early </td>
                <td><?= $pembeli ?></td>
                <td><?= number_format(100000) ?></td>

            </tr>
            <tr>
                <td>Total Peserta Late</td>
                <td><?= $pembeli ?></td>
                <td><?= number_format(100000) ?></td>                
            </tr>
            <tr>
                <td>Total Peserta Voucher </td>
                <td><?= $pembeli ?></td>
                <td><?= number_format(100000) ?></td>
            </tr>
            <tr>
                <td>Total Peserta Bayar </td>
                <td><?= $pembeli ?></td>
                <td><?= number_format(100000) ?></td>
            </tr>
            <tr>
                <td>Total Peserta Free </td>
                <td><?= $pembeli ?></td>
                <td><?= number_format(100000) ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <!-- <h3>Total Peserta : <?= $pembeli ?></h3> -->
    <!-- <h3>Total Pemasukan :Rp <?= rupiah($data->total) ?></h3> -->
    <table style="width: 100%;border-collapse:collapse" border="1">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal Order</th>
                <th>
                    Pembeli
                </th>
                <th>No WA</th>
                <th>Email</th>
                <th>Harga Beli</th>
                <th>Status Order</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            $no = 1;
            foreach ($detail as $d) { 
                ?>
                <tr>
                    <td>
                        <?= $no++ ?>
                    </td>
                    <td>
                        <?= set_date($d->tgl_order) ?>
                    </td>
                    <td>
                        <?= $d->nama_lengkap ?>
                    </td>
                    <td>
                        <?= $d->no_wa ?>
                    </td>
                    <td>
                        <?= $d->email ?>
                    </td>
                    <td>
                        <?= $d->total_harga ?>
                    </td>
                    <td>
                        Sudah bayar
                    </td>
                </tr>
                <?php $total += $d->total_harga; ?>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align:right;"> Total Pemasukan </th>
                <th colspan="2" style="text-align: left;">Rp <?= number_format($total); ?></th>
            </tr>
        </tfoot>
    </table>

    
</body>

</html>