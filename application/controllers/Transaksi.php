<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
    }

    // private $tbl = 'categories';

    private function js_path()
    {
        return base_url() . 'assets/backend/js/';
    }

    function delete($id = 0){
        $this->query->delete_data('transaksi_detail', array('transaksi_id' => $id));
        $this->query->delete_data('transaksi', array('id' => $id));
        redirect(site_url('Admin/transaksi'));
    }

    function get_transaksi($page = 0)
    {
        $limit                = $this->input->post('limit');

        $sort                 = $this->input->post('sort');
        $order                = $this->input->post('order');
        $search               = $this->input->post('search');
        // $batas = 10;
        // $halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
        // $halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;    

        // $previous = $halaman - 1;
        // $next = $halaman + 1;
        
        // $data = mysqli_query($koneksi,"select * from pegawai");
        // $jumlah_data = mysqli_num_rows($data);
        // $total_halaman = ceil($jumlah_data / $batas);
        $query                = "SELECT u.foto_profil,u.nama_lengkap,u.no_wa,k.jenis_kelas,k.judul_kelas,k.kategori_kelas,k.kategori_go,k.tgl_kelas,d.total_harga,t.id,t.status,t.tgl_pembelian,t.payment_method FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id JOIN `user` u ON t.`user_id` = u.id";
        // $query2            = "SELECT u.foto_profil,u.nama_lengkap,k.jenis_kelas,k.judul_kelas,k.kategori_kelas,k.kategori_go,k.tgl_kelas,t.total,t.id,t.status,t.tgl_pembelian FROM transaksi t JOIN kelas k ON t.`product_id` = k.id JOIN `user` u ON t.`user_id` = u.id LIMIT $limit OFFSET $page";
        $config['base_url']   = base_url() . 'Transaksi/get_transaksi/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page']   = $limit;
        if ($sort == 'terbaru') {
            if ($order == 'today') {
                if ($search) {
                    $query .= " WHERE date(t.tgl_pembelian) = CURDATE() AND u.nama_lengkap LIKE '%$search%' OR k.judul_kelas LIKE '%$search%' OR t.status LIKE '%$search%'";
                }
                $query .= " WHERE date(t.tgl_pembelian) = CURDATE() ORDER BY t.tgl_pembelian DESC LIMIT $limit OFFSET $page";
            } else if ($order == 'month') {
                if ($search) {
                    $query .= " WHERE MONTH(t.tgl_pembelian)=MONTH(now()) AND u.nama_lengkap LIKE '%$search%' OR k.judul_kelas LIKE '%$search%' OR t.status LIKE '%$search%'";
                }
                $query .= " WHERE MONTH(t.tgl_pembelian)=MONTH(now()) ORDER BY t.tgl_pembelian DESC LIMIT $limit OFFSET $page";
            } else {
                if ($search) {
                    $query .= " WHERE YEAR(t.tgl_pembelian)=YEAR(now()) AND u.nama_lengkap LIKE '%$search%' OR k.judul_kelas LIKE '%$search%' OR t.status LIKE '%$search%'";
                }
                $query .= " WHERE YEAR(t.tgl_pembelian)=YEAR(now()) ORDER BY t.tgl_pembelian DESC LIMIT $limit OFFSET $page";
            }
        } else {
            if ($order == 'today') {
                if ($search) {
                    $query .= " WHERE date(t.tgl_pembelian) = CURDATE() AND u.nama_lengkap LIKE '%$search%' OR k.judul_kelas LIKE '%$search%' OR t.status LIKE '%$search%'";
                }
                $query .= " WHERE date(t.tgl_pembelian) = CURDATE() ORDER BY t.tgl_pembelian ASC LIMIT $limit OFFSET $page";
            } else if ($order == 'month') {
                if ($search) {
                    $query .= " WHERE MONTH(t.tgl_pembelian)=MONTH(now()) AND u.nama_lengkap LIKE '%$search%' OR k.judul_kelas LIKE '%$search%' OR t.status LIKE '%$search%'";
                }
                $query .= " WHERE MONTH(t.tgl_pembelian)=MONTH(now()) ORDER BY t.tgl_pembelian ASC LIMIT $limit OFFSET $page";
            } else {
                if ($search) {
                    $query .= " WHERE YEAR(t.tgl_pembelian)=YEAR(now()) AND u.nama_lengkap LIKE '%$search%' OR k.judul_kelas LIKE '%$search%' OR t.status LIKE '%$search%'";
                }
                $query .= " WHERE YEAR(t.tgl_pembelian)=YEAR(now()) ORDER BY t.tgl_pembelian ASC LIMIT $limit OFFSET $page";
            }
        }
        $data = $this->query->get_query($query)->result();
        // echo $this->db->last_query();
        // debug($data);

        $this->pagination->initialize($config);


        $items = [];
        foreach ($data as $d) {
            if ($d->total_harga == 0) {
                $harga = 'FREE';
            } else {
                $harga = 'Rp.' . rupiah($d->total_harga);
            }
            if ($d->jenis_kelas == 'asclepedia') {
                $kategori = $d->kategori_kelas;
            } else {
                $kategori = $d->kategori_go;
            }
            if ($d->status == 'pending' || $d->status == 'wait_for_payment') {
                $status = 'unpaid';
            } else if ($d->status == 'expired') {
                $status = 'expired';
            } else {
                $status = 'paid';
            }
            $item['id'] = $d->id;
            $item['nama_lengkap'] = $d->nama_lengkap;
            $item['no_wa'] = $d->no_wa;
            $item['foto_profil'] = base_url() . 'assets/uploads/member/' . $d->foto_profil;
            $item['img_error'] = base_url() . 'assets/uploads/member/profile_default.png';
            $item['judul_kelas'] = $d->judul_kelas;
            $item['kategori'] = $kategori;
            $item['tgl_kelas'] = format_indo($d->tgl_kelas);
            $item['status'] = $status;
            $item['tgl_pembelian'] = format_indo($d->tgl_pembelian);
            $item['payment_method'] = $d->payment_method;
            array_push($items, $item);
        }

        if ($data) {
            $response = [
                'data' => $items
            ];
        } else {
            $response = [
                'data' => null
            ];
        }
        $response['pagination'] = $this->pagination->create_links();

        echo json_encode($response);
    }
    function detail($id)
    {
        $transaksi = $this->query->get_query("SELECT t.*, k.*, u.* FROM transaksi t JOIN kelas k ON t.product_id = k.id JOIN `user` u ON t.user_id = u.id WHERE t.id = $id")->row();
        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $transaksi->id")->result();
        if ($transaksi->total == 0) {
            $harga = 'FREE';
        } else {
            $harga = 'Rp.' . rupiah($transaksi->total);
        }
        if ($transaksi->jenis_kelas == 'asclepedia') {
            $kategori = $transaksi->kategori_kelas;
        } else {
            $kategori = $transaksi->kategori_go;
        }
        if ($transaksi->status == 'pending' || $transaksi->status == 'wait_for_payment') {
            $status = 'unpaid';
        } else if ($transaksi->status == 'expired') {
            $status = 'expired';
        } else {
            $status = 'paid';
        }
        $item['nama_lengkap'] = $transaksi->nama_lengkap;
        $item['foto_profil'] = base_url() . 'assets/uploads/member/' . $transaksi->foto_profil;
        $item['judul_kelas'] = $transaksi->judul_kelas;
        $item['kategori'] = $kategori;
        $item['tgl_kelas'] = format_indo($transaksi->tgl_kelas);
        $item['status'] = $status;
        $item['tgl_pembelian'] = format_indo(date("Y-m-d", strtotime($transaksi->tgl_pembelian)));
        $item['harga'] = $harga;
        $item['pemateri'] = $pemateri;

        echo json_encode($item);
    }
    function summary($order)
    {
        if ($order == 'today') {
            $pemasukan =  $this->query->get_query("SELECT SUM(d.total_harga) AS pemasukan FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND t.status = 'paid' AND d.status = 'success' AND date(t.tgl_pembelian) = CURDATE()")->row()->pemasukan;
            $orderan =  $this->query->get_query("SELECT COUNT(id) as `orderan` FROM transaksi WHERE date(tgl_pembelian) = CURDATE()")->row()->orderan;
            $unpaid =  $this->query->get_query("SELECT COUNT(`user_id`) as unpaid FROM transaksi WHERE `status` = 'pending' OR `status` = 'wait_for_payment' AND date(tgl_pembelian) = CURDATE()")->row()->unpaid;
        } else if ($order == 'month') {
            $pemasukan =  $this->query->get_query("SELECT SUM(d.total_harga) AS pemasukan FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND t.status = 'paid' AND d.status = 'success' AND MONTH(t.tgl_pembelian)=MONTH(now())")->row()->pemasukan;
            $orderan =  $this->query->get_query("SELECT COUNT(id) as `orderan` FROM transaksi WHERE MONTH(tgl_pembelian)=MONTH(now())")->row()->orderan;
            $unpaid =  $this->query->get_query("SELECT COUNT(`user_id`) as unpaid FROM transaksi WHERE `status` = 'pending' OR `status` = 'wait_for_payment' AND MONTH(tgl_pembelian)=MONTH(now())")->row()->unpaid;
        } else {
            $pemasukan =  $this->query->get_query("SELECT SUM(d.total_harga) AS pemasukan FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND t.status = 'paid' AND d.status = 'success' AND YEAR(t.tgl_pembelian)=YEAR(now())")->row()->pemasukan;
            $orderan =  $this->query->get_query("SELECT COUNT(id) as `orderan` FROM transaksi WHERE YEAR(tgl_pembelian)=YEAR(now())")->row()->orderan;
            $unpaid =  $this->query->get_query("SELECT COUNT(`user_id`) as unpaid FROM transaksi WHERE `status` = 'pending' OR `status` = 'wait_for_payment' AND YEAR(tgl_pembelian)=YEAR(now())")->row()->unpaid;
        }
        if ($order != '') {
            $response = [
                'pemasukan' => $pemasukan,
                'order' => $orderan,
                'unpaid' => $unpaid,
                'order_by' => $order
            ];
        } else {
            $response = [
                'pemasukan' => null,
                'order' => null,
                'unpaid' => null,
                'order_by' => $order
            ];
        }

        echo json_encode($response);
    }

    public function export()
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'libraries/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan awal fil excel
        $excel->getProperties()->setCreator(' Asclepio Admin ')
            ->setLastModifiedBy(' Asclepio Admin ')
            ->setTitle("Asclepio - Data Transaksi")
            ->setSubject("Data Transaksi")
            ->setDescription("Data Transaksi")
            ->setKeywords("Data Transaksi");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Transaksi Asclepio Website"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "Judul Kelas"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Pembeli"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Harga Beli"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Tanggal Order"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Status Order"); // Set kolom B3 dengan tulisan "NIS"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data = $this->query->get_query("SELECT k.id,k.judul_kelas, u.nama_lengkap,t.tgl_pembelian,d.total_harga, t.status FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id JOIN `user` u ON t.`user_id` = u.`id` ORDER BY t.tgl_pembelian DESC")->result();


        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        // $keseluruhan = 0;
        $total = 0;
        foreach ($data as $d) { // Lakukan looping pada variabel siswa


            if ($d->status == 'wait_for_payment' || $d->status == 'pending') {
                $status = 'Menunggu pembayaran';
            } else if ($d->status == 'paid') {
                $status = 'Sudah Bayar';
            } else {
                $status = 'Pembayaran Expired';
            }
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $d->judul_kelas);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $d->nama_lengkap);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, 'Rp ' . rupiah($d->total_harga));
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, format_indo($d->tgl_pembelian));
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $status);

            $numrow++;

            // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom B

        // $footer_row = $numrow + 1;
        // $excel->setActiveSheetIndex(0)->setCellValue('D' . $footer_row, "Total Pemasukan Keseluruhan");
        // $excel->setActiveSheetIndex(0)->setCellValue('E' . $footer_row, 'Rp ' . number_format($keseluruhan));

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Data Transaksi");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Transaksi Asclepio.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
