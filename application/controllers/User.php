<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
    function str_replace_first($from, $to, $content)
    {
        $from = '/' . preg_quote($from, '/') . '/';

        return preg_replace($from, $to, $content, 1);
    }

    function get_user($page = 0)
    {
        $limit = $this->input->post('limit');
        $sort = $this->input->post('sort');
        $search = $this->input->post('search');
        $query_before = "SELECT * FROM user";
        $query = "SELECT * FROM user";
        $config['base_url'] = base_url() . 'User/get_user/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;



        if ($sort == 'terbaru') {

            if ($search) {
                $query .= " WHERE nama_lengkap LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $page";
            } else {
                $query .= " ORDER BY id DESC LIMIT $limit OFFSET $page";
            }
        } else {
            if ($search) {
                $query .= " WHERE nama_lengkap LIKE '%$search%' ORDER BY id ASC LIMIT $limit OFFSET $page";
            } else {
                $query .= " ORDER BY id ASC LIMIT $limit OFFSET $page";
            }
        }
        $data = $this->query->get_query($query)->result();


        $this->pagination->initialize($config);


        $items = [];
        foreach ($data as $d) {
            $total = $this->query->get_query("SELECT COUNT(d.id) AS total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE t.`user_id` = $d->id AND t.`status` = 'paid'")->row()->total;
            $total_asclepedia = $this->query->get_query("SELECT COUNT(d.id) AS total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $d->id AND k.jenis_kelas = 'asclepedia' AND t.`status` = 'paid'")->row()->total;
            $total_asclepiogo = $this->query->get_query("SELECT COUNT(d.id) AS total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $d->id AND k.jenis_kelas = 'asclepio_go' AND t.`status` = 'paid'")->row()->total;
            $item['id'] = $d->id;
            $item['nama_lengkap'] = $d->nama_lengkap;
            $item['email'] = $d->email;
            $item['universitas'] = $d->universitas;
            $item['instansi'] = $d->instansi;
            $item['no_wa'] = $this->str_replace_first('0', '62', $d->no_wa);
            $item['instagram'] = $d->ig;
            $item['kota'] = $d->kota . ', ' . $d->provinsi_name;
            $item['asclepedia'] = $total_asclepedia;
            $item['asclepio_go'] = $total_asclepiogo;
            $item['total'] = $total;
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
        $response['last_query'] = $query_before;



        echo json_encode($response);
    }
    public function getClass($user_id)
    {
        $ascped = $this->query->get_query("SELECT COUNT(t.id) as total FROM transaksi t JOIN transaksi_detail d ON t.`id` = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $user_id AND k.jenis_kelas = 'asclepedia' AND t.`status` = 'paid'")->row()->total;
        $ascgo = $this->query->get_query("SELECT COUNT(t.id) as total FROM transaksi t JOIN transaksi_detail d ON t.`id` = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $user_id AND k.jenis_kelas = 'asclepio_go' AND t.`status` = 'paid'")->row()->total;
        $total = $this->query->get_query("SELECT COUNT(t.id) as total FROM transaksi t JOIN transaksi_detail d ON t.`id` = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $user_id AND t.`status` = 'paid'")->row()->total;
        $total_out = $this->query->get_query("SELECT SUM(t.total) as total FROM transaksi t JOIN transaksi_detail d ON t.`id` = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $user_id AND t.`status` = 'paid'")->row()->total;
        $query = $this->query->get_query("SELECT k.judul_kelas,d.code_voucher,d.total_harga FROM transaksi t JOIN transaksi_detail d ON t.`id` = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $user_id AND t.`status` = 'paid'")->result();
        if ($query) {
            $response = [
                'code' => 200,
                'data' => $query,
                'ascped' => $ascped,
                'ascgo' => $ascgo,
                'total' => $total,
                'total_out' => $total_out,
            ];
        } else {
            $response = [
                'code' => 404,
                'data' => null,
                'ascped' => 0,
                'ascgo' => 0,
                'total' => 0,
                'total_out' => 0,
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
        $q = $_POST['q'];

        // Settingan awal fil excel
        $excel->getProperties()->setCreator(' Asclepio Admin ')
            ->setLastModifiedBy(' Asclepio Admin ')
            ->setTitle("Asclepio - Data User")
            ->setSubject("Data User")
            ->setDescription("Data User")
            ->setKeywords("Data User");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data User Asclepio Website"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:K1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "Nama Peserta"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Email Peserta"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Universitas"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Instansi"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "No Wa"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Instagram"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Asal Kota"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "Asclepedia"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('I3', "Asclepio Go"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('J3', "Total class purchased"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('K3', "Total Pembelian"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data = $this->query->get_query($q);

        
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        // $keseluruhan = 0;
        $total = 0;
        foreach ($data->result() as $d) { // Lakukan looping pada variabel siswa
            // $total = $data->total * $data->pembeli;
            if (!preg_match('/[^+0-9]/', trim($d->no_wa))) {
                // cek apakah no hp karakter 1-3 adalah +62
                if (substr(trim($d->no_wa), 0, 3) == '+62') {
                    $wa = '0' . substr(trim($d->no_wa), 1);
                }
                else if (substr(trim($d->no_wa), 0, 2) == '62') {
                    $wa = '0' . substr(trim($d->no_wa), 1);
                }else{
                    $wa = $d->no_wa;
                }
            }
            $total = $this->query->get_query("SELECT COUNT(d.id) AS total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE t.`user_id` = $d->id AND t.`status` = 'paid'")->row()->total;
            $total_asclepedia = $this->query->get_query("SELECT COUNT(d.id) AS total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $d->id AND k.jenis_kelas = 'asclepedia' AND t.`status` = 'paid'")->row()->total;
            $total_asclepiogo = $this->query->get_query("SELECT COUNT(d.id) AS total FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $d->id AND k.jenis_kelas = 'asclepio_go' AND t.`status` = 'paid'")->row()->total;
            $total_out = $this->query->get_query("SELECT SUM(t.total) as total FROM transaksi t JOIN transaksi_detail d ON t.`id` = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.`user_id` = $d->id AND t.`status` = 'paid'")->row()->total;
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $d->nama_lengkap);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $d->email);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $d->universitas);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $d->instansi);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $wa);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $numrow, $d->ig);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $numrow, $d->kota . ', ' . $d->provinsi_name);
            $excel->setActiveSheetIndex(0)->setCellValue('H' . $numrow, $total_asclepedia . ' kelas');
            $excel->setActiveSheetIndex(0)->setCellValue('I' . $numrow, $total_asclepiogo . ' kelas');
            $excel->setActiveSheetIndex(0)->setCellValue('J' . $numrow, $total);
            $excel->setActiveSheetIndex(0)->setCellValue('K' . $numrow, $total_out);
            // $keseluruhan  += $data->total;

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('I' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('J' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('K' . $numrow)->applyFromArray($style_row);


            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(30); // Set width kolom E

        // $footer_row = $numrow + 1;
        // $excel->setActiveSheetIndex(0)->setCellValue('D' . $footer_row, "Total Pemasukan Keseluruhan");
        // $excel->setActiveSheetIndex(0)->setCellValue('E' . $footer_row, 'Rp ' . number_format($keseluruhan));

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Data User");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data User Asclepio.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
