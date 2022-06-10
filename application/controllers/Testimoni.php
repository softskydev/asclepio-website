<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testimoni extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->helper('string');
    }

    // private $tbl = 'categories';

    private function js_path()
    {
        return base_url() . 'assets/backend/js/';
    }
    function get_rating($page = 0)
    {
        $limit = $this->input->post('limit');
        $sort = $this->input->post('sort');
        $search = $this->input->post('search');
        $query = "SELECT u.*,k.judul_kelas FROM ulasan u JOIN kelas k ON u.kelas_id = k.id";
        $config['base_url'] = base_url() . 'Testimoni/get_rating/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;


        if ($sort == 'terbaru') {
            if ($search) {
                $query .= " WHERE k.is_delete = 0 AND k.judul_kelas LIKE '%$search%' GROUP BY u.kelas_id ORDER BY u.id DESC LIMIT $limit OFFSET $page";
            } else {
                $query .= " WHERE k.is_delete = 0 GROUP BY u.kelas_id ORDER BY u.id DESC LIMIT $limit OFFSET $page";
            }
        } else {
            if ($search) {
                $query .= " WHERE k.is_delete = 0 AND k.judul_kelas LIKE '%$search%' GROUP BY u.kelas_id ORDER BY u.id ASC LIMIT $limit OFFSET $page";
            } else {
                $query .= " WHERE k.is_delete = 0 GROUP BY u.kelas_id ORDER BY u.id ASC LIMIT $limit OFFSET $page";
            }
        }
        $data = $this->query->get_query($query)->result();

        $this->pagination->initialize($config);

        $items = [];
        foreach ($data as $d) {
            $rating = $this->query->get_query("SELECT FORMAT(FORMAT(AVG(rating),1),1) AS rating FROM ulasan WHERE kelas_id = $d->kelas_id")->row()->rating;
            $pengulas = $this->query->get_query("SELECT COUNT(id) AS total FROM ulasan WHERE kelas_id = $d->kelas_id")->row()->total;
            $item['id'] = $d->id;
            $item['judul_kelas'] = $d->judul_kelas;
            $item['rating'] = $rating;
            $item['pengulas'] = $pengulas;
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
        // $response['last_query'] = $query_before;



        echo json_encode($response);
    }

    function get_testi($pages = 0)
    {
        $limit = $this->input->post('limit_testi');
        $query = "SELECT k.judul_kelas,u.nama_lengkap,u.universitas,r.id,r.rating,r.ulasan FROM ulasan r JOIN kelas k ON r.kelas_id = k.id JOIN `user` u ON r.`user_id` = u.id ORDER BY r.id DESC";
        $config['base_url'] = base_url() . 'Testimoni/get_testi/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;


        $query .= " LIMIT $limit OFFSET $pages";
        $data = $this->query->get_query($query)->result();

        $this->pagination->initialize($config);

        $items = [];
        foreach ($data as $d) {
            $item['id'] = $d->id;
            $item['judul_kelas'] = $d->judul_kelas;
            $item['universitas'] = $d->universitas;
            $item['rating'] = start_created($d->rating);
            $item['ulasan'] = $d->ulasan;
            $item['nama_lengkap'] = $d->nama_lengkap;
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
        // $response['last_query'] = $query_before;




        echo json_encode($response);
    }

    function delete_testi($id)
    {
        $delete = $this->query->delete_data('ulasan', ['id' => $id]);
        if ($delete) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil hapus data');
            redirect('/Admin/testimoni');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal hapus data');
            redirect('/Admin/testimoni');
        }
    }
    public function export_rating()
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'libraries/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        // Settingan awal fil excel
        $excel->getProperties()->setCreator(' Asclepio Admin ')
            ->setLastModifiedBy(' Asclepio Admin ')
            ->setTitle("Asclepio - Data Rating")
            ->setSubject("Data Rating")
            ->setDescription("Data Rating")
            ->setKeywords("Data Rating");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Rating Asclepio Website"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:C1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "Judul Kelas"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Rating"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Pengulas"); // Set kolom B3 dengan tulisan "NIS"


        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data = $this->query->get_query("SELECT u.*,k.judul_kelas FROM ulasan u JOIN kelas k ON u.kelas_id = k.id WHERE k.is_delete = 0 GROUP BY u.kelas_id ORDER BY u.id DESC")->result();


        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        // $keseluruhan = 0;
        $total = 0;
        foreach ($data as $d) { // Lakukan looping pada variabel siswa
            // $total = $data->total * $data->pembeli;
            $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $d->kelas_id")->row()->rating;
            $pengulas = $this->query->get_query("SELECT COUNT(id) AS total FROM ulasan WHERE kelas_id = $d->kelas_id")->row()->total;
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $d->judul_kelas);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $rating);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $pengulas);
            // $keseluruhan  += $data->total;

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);


            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C

        // $footer_row = $numrow + 1;
        // $excel->setActiveSheetIndex(0)->setCellValue('D' . $footer_row, "Total Pemasukan Keseluruhan");
        // $excel->setActiveSheetIndex(0)->setCellValue('E' . $footer_row, 'Rp ' . number_format($keseluruhan));

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Data Rating");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rating Kelas Asclepio.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
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
            ->setTitle("Asclepio - Data Testimoni")
            ->setSubject("Data Testimoni")
            ->setDescription("Data Testimoni")
            ->setKeywords("Data Testimoni");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Testimoni Asclepio Website"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "Nama"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Universitas"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Kelas"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Rating"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Testimoni"); // Set kolom E3 dengan tulisan "ALAMAT"


        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data = $this->query->get_query("SELECT k.judul_kelas,u.nama_lengkap,u.universitas,r.id,r.rating,r.ulasan FROM ulasan r JOIN kelas k ON r.kelas_id = k.id JOIN `user` u ON r.`user_id` = u.id ORDER BY r.id DESC")->result();


        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        // $keseluruhan = 0;
        $total = 0;
        foreach ($data as $d) { // Lakukan looping pada variabel siswa
            // $total = $data->total * $data->pembeli;
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $d->nama_lengkap);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, $d->universitas);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $d->judul_kelas);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $d->rating . ' ★');
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $d->ulasan);
            // $keseluruhan  += $data->total;

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D' . $numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E' . $numrow)->applyFromArray($style_row);


            $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(35); // Set width kolom E

        // $footer_row = $numrow + 1;
        // $excel->setActiveSheetIndex(0)->setCellValue('D' . $footer_row, "Total Pemasukan Keseluruhan");
        // $excel->setActiveSheetIndex(0)->setCellValue('E' . $footer_row, 'Rp ' . number_format($keseluruhan));

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Data Testimoni");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Testimoni Asclepio.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
