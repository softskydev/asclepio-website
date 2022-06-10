<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan extends CI_Controller
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
    function get_summary()
    {
        $periode = $this->input->post('periode');
        $kategori = $this->input->post('kategori');
        $date_1 = ($this->input->post('date_1')) ? $this->input->post('date_1') : '';
        $date_2 = ($this->input->post('date_2')) ? $this->input->post('date_2') : '';
        $query = "SELECT k.`kategori_kelas`,k.`kategori_go`,k.`tgl_kelas`,SUM(d.total_harga) AS total, COUNT(t.user_id) AS pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND t.status = 'paid' AND d.status = 'success'";
        $terlaris = "SELECT k.`judul_kelas`,k.`jenis_kelas`,k.`kategori_kelas`,k.`kategori_go`,k.`tgl_kelas`,SUM(d.total_harga) AS total, COUNT(t.user_id) AS pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.status = 'paid' AND d.status = 'success'";
        if ($periode == 'semua') {
            if ($kategori == 'semua') {
                $query .= "";
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                $query .= " AND k.kategori_kelas = '" . $kategori . "' ";
            } else {
                $query .= " AND k.kategori_go = '" . $kategori . "' ";
            }
            $terlaris .= "";
            $time = 'Semua';
        } else if ($periode == 'today') {
            if ($kategori == 'semua') {
                $query .= " AND DATE(t.tgl_pembelian) = CURDATE()";
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                $query .= " AND k.kategori_kelas = '" . $kategori . "' AND date(t.tgl_pembelian) = CURDATE()";
            } else {
                $query .= " AND k.kategori_go = '" . $kategori . "' AND date(t.tgl_pembelian) = CURDATE()";
            }
            $terlaris .= " AND DATE(t.tgl_pembelian) = CURDATE()";
            $time = 'Hari ini';
        } else if ($periode == 'this_month') {
            if ($kategori == 'semua') {
                $query .= " AND MONTH(t.tgl_pembelian)=MONTH(now())";
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                $query .= " AND k.kategori_kelas = '" . $kategori . "' AND MONTH(t.tgl_pembelian)=MONTH(now())";
            } else {
                $query .= " AND k.kategori_go = '" . $kategori . "' AND MONTH(t.tgl_pembelian)=MONTH(now())";
            }
            $terlaris .= " AND MONTH(t.tgl_pembelian)=MONTH(now())";
            $time = 'Bulan ini';
        } else if ($periode == 'this_week') {
            if ($kategori == 'semua') {
                $query .= " AND WEEK(t.tgl_pembelian)=WEEK(now())";
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                $query .= " AND k.kategori_kelas = '" . $kategori . "' AND WEEK(t.tgl_pembelian)=WEEK(now())";
            } else {
                $query .= " AND k.kategori_go = '" . $kategori . "' AND WEEK(t.tgl_pembelian)=WEEK(now())";
            }
            $terlaris .= " AND WEEK(t.tgl_pembelian)=WEEK(now())";
            $time = 'Minggu ini';
        } else {
            if ($kategori == 'semua') {
                $query .= " AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'";
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                $query .= " AND k.kategori_kelas = '" . $kategori . "' AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'";
            } else {
                $query .= " AND k.kategori_go = '" . $kategori . "' AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'";
            }
            $terlaris .= " AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'";
            $time = $date_1 . ' s/d ' . $date_2;
        }
        $terlaris .= "  GROUP BY d.product_id ORDER BY pembeli DESC";


        $data = $this->query->get_query($query)->row();
        $data_terlaris = $this->query->get_query($terlaris)->row();

        // echo $this->db->last_query();
        // exit;

        if ($data_terlaris->jenis_kelas == 'asclepedia') {
            $terlaris_kategori = $data_terlaris->kategori_kelas;
        } else {
            $terlaris_kategori = $data_terlaris->kategori_go;
        }
        $item['peserta'] = rupiah($data->pembeli);
        $item['income']  = rupiah($data->total);
        $item['terlaris_judul']  = $data_terlaris->judul_kelas;
        $item['terlaris_kategori']  = $terlaris_kategori;
        $item['terlaris_tgl_kelas']  = format_indo($data_terlaris->tgl_kelas);
        $item['periode'] = $time;


        if ($data) {
            $response = [
                'status' => 200,
                'data' => $item
            ];
        } else {
            $response = [
                'status' => 404,
                'data' => null
            ];
        }
        $response['q'] = $this->db->last_query();

        echo json_encode($response);
    }
    function get_list($page = 0)
    {
        $limit = $this->input->post('limit');
        $search = $this->input->post('search');
        $periode = $this->input->post('periode');
        $kategori = $this->input->post('kategori');
        $date_1 = ($this->input->post('date_1')) ? $this->input->post('date_1') : '';
        $date_2 = ($this->input->post('date_2')) ? $this->input->post('date_2') : '';
        $query = "SELECT k.*,SUM(d.total_harga) AS total, DATE(t.tgl_pembelian) AS tgl_beli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND t.status = 'paid' AND d.status = 'success'";
        $query1 = "SELECT k.*,SUM(d.total_harga) AS total, DATE(t.tgl_pembelian) AS tgl_beli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND t.status = 'paid' AND d.status = 'success' GROUP BY d.product_id";
        $config['base_url'] = base_url() . 'Keuangan/get_list/';
        $config['total_rows'] = $this->db->query($query1)->num_rows();
        $config['per_page'] = $limit;
        // $query2 = "SELECT k.judul_kelas,k.jenis_kelas,k.kategori_kelas,k.`kategori_go`,k.`tgl_kelas`,SUM(t.total) AS total, COUNT(t.user_id) AS pembeli, DATE(t.tgl_pembelian) AS tgl_beli FROM transaksi t JOIN kelas k ON t.`product_id` = k.`id` GROUP BY t.product_id LIMIT $limit OFFSET $page";
        if ($periode == 'semua') {
            $param_export = $periode;
            if ($kategori == 'semua') {
                if ($search) {
                    $query .= " AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  GROUP BY d.product_id";
                }
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = '" . $kategori . "' AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = '" . $kategori . "' GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_free') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_premium') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 GROUP BY d.product_id";
                }
            } else {
                if ($search) {
                    $query .= " AND k.kategori_go = '" . $kategori . "' AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_go = '" . $kategori . "' GROUP BY d.product_id";
                }
            }
        } else if ($periode == 'today') {
            $param_export = $periode;
            if ($kategori == 'semua') {
                if ($search) {
                    $query .= " AND date(t.tgl_pembelian) = CURDATE() AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND date(t.tgl_pembelian) = CURDATE() GROUP BY d.product_id";
                }
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = '" . $kategori . "' AND date(t.tgl_pembelian) = CURDATE() AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND k.kategori_kelas = '" . $kategori . "' AND date(t.tgl_pembelian) = CURDATE() GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_free') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND date(t.tgl_pembelian) = CURDATE() AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND date(t.tgl_pembelian) = CURDATE() GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_premium') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND date(t.tgl_pembelian) = CURDATE() AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND date(t.tgl_pembelian) = CURDATE() GROUP BY d.product_id";
                }
            } else {
                if ($search) {
                    $query .= " AND k.kategori_go = '" . $kategori . "' AND date(t.tgl_pembelian) = CURDATE() AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND k.kategori_go = '" . $kategori . "' AND date(t.tgl_pembelian) = CURDATE() GROUP BY d.product_id";
                }
            }
        } else if ($periode == 'this_month') {
            $param_export = $periode;
            if ($kategori == 'semua') {
                if ($search) {
                    $query .= " AND MONTH(t.tgl_pembelian)=MONTH(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND MONTH(t.tgl_pembelian)=MONTH(now()) GROUP BY d.product_id";
                }
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = '" . $kategori . "' AND MONTH(t.tgl_pembelian)=MONTH(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND k.kategori_kelas = '" . $kategori . "' AND MONTH(t.tgl_pembelian)=MONTH(now()) GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_free') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND MONTH(t.tgl_pembelian)=MONTH(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND MONTH(t.tgl_pembelian)=MONTH(now()) GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_premium') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND MONTH(t.tgl_pembelian)=MONTH(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND MONTH(t.tgl_pembelian)=MONTH(now()) GROUP BY d.product_id";
                }
            } else {
                if ($search) {
                    $query .= " AND k.kategori_go = '" . $kategori . "' AND MONTH(t.tgl_pembelian)=MONTH(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND k.kategori_go = '" . $kategori . "' AND MONTH(t.tgl_pembelian)=MONTH(now()) GROUP BY d.product_id";
                }
            }
        } else if ($periode == 'this_week') {
            $param_export = $periode;
            if ($kategori == 'semua') {
                if ($search) {
                    $query .= " AND WEEK(t.tgl_pembelian)=WEEK(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND WEEK(t.tgl_pembelian)=WEEK(now()) GROUP BY d.product_id";
                }
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = '" . $kategori . "' AND WEEK(t.tgl_pembelian)=WEEK(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND k.kategori_kelas = '" . $kategori . "' AND WEEK(t.tgl_pembelian)=WEEK(now()) GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_free') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND WEEK(t.tgl_pembelian)=WEEK(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND WEEK(t.tgl_pembelian)=WEEK(now()) GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_premium') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND WEEK(t.tgl_pembelian)=WEEK(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND WEEK(t.tgl_pembelian)=WEEK(now()) GROUP BY d.product_id";
                }
            } else {
                if ($search) {
                    $query .= " AND k.kategori_go = '" . $kategori . "' AND WEEK(t.tgl_pembelian)=WEEK(now()) AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= "  AND k.kategori_go = '" . $kategori . "' AND WEEK(t.tgl_pembelian)=WEEK(now()) GROUP BY d.product_id";
                }
            }
        } else {
            $param_export = $date_1 . '%' . $date_2;
            if ($kategori == 'semua') {
                if ($search) {
                    $query .= " AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'  AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'  GROUP BY d.product_id";
                }
            } else if ($kategori == 'good morning knowledge' || $kategori == 'skill labs') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = '" . $kategori . "' AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'  AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = '" . $kategori . "' AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'  GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_free') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "' AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price = 0 AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "' GROUP BY d.product_id";
                }
            } else if ($kategori == 'open_premium') {
                if ($search) {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "' AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_kelas = 'open' AND k.late_price != 0 AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "' GROUP BY d.product_id";
                }
            } else {
                if ($search) {
                    $query .= " AND k.kategori_go = '" . $kategori . "' AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'  AND k.judul_kelas LIKE '%$search%' GROUP BY d.product_id";
                } else {
                    $query .= " AND k.kategori_go = '" . $kategori . "' AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'  GROUP BY d.product_id";
                }
            }
        }

        $query_before = $query;

        // exit;

        $query .= " ORDER BY t.tgl_pembelian DESC LIMIT $limit OFFSET $page";
        $data = $this->query->get_query($query)->result();
        // echo $this->db->last_query();
        // exit;

        $this->pagination->initialize($config);


        $items = [];
        foreach ($data as $d) {
            if ($d->early_price == 0 && $d->late_price == 0) {
                $query_pembeli = "SELECT COUNT(t.user_id) as pembeli FROM transaksi t JOIN transaksi_detail d ON d.transaksi_id = t.id WHERE d.product_id = $d->id";
            }else{
                $query_pembeli = "SELECT COUNT(t.user_id) as pembeli FROM transaksi t JOIN transaksi_detail d ON d.transaksi_id = t.id WHERE d.product_id = $d->id AND d.`status` = 'success'";
            }
            if ($periode == 'semua') {
                $query_pembeli .= "";
            } else if ($periode == 'today') {
                $query_pembeli .= " AND date(t.tgl_pembelian) = CURDATE()";
            } else if ($periode == 'this_week') {
                $query_pembeli .= " AND WEEK(t.tgl_pembelian)=WEEK(now())";
            } else if ($periode == 'this_month') {
                $query_pembeli .= " AND MONTH(t.tgl_pembelian)=MONTH(now())";
            } else {
               
                $query_pembeli .= " AND date(t.tgl_pembelian) between '" . $date_1 . "' and '" . $date_2 . "'";
            }
            $pembeli = $this->query->get_query($query_pembeli)->row()->pembeli;
            // echo $this->db->last_query();
            // exit;
            if ($d->jenis_kelas == 'asclepedia') {
                $kategori = $d->kategori_kelas;
            } else {
                $kategori = $d->kategori_go;
            }
            $item['kelas_id'] = $d->id;
            $item['judul_kelas'] = $d->judul_kelas;
            $item['tgl_kelas'] = $d->tgl_kelas;
            $item['kategori'] = $kategori;
            $item['peserta'] = $pembeli;
            $item['income'] = $d->total;
            $item['param_export'] = $param_export;
            array_push($items, $item);
        }
       
        if ($data) {
            $response = [
                'status' => 200,
                'data' => $items
            ];
        } else {
            $response = [
                'status' => 404,
                'data' => null
            ];
        }
        $response['q'] = $query_before;
        $response['pagination'] = $this->pagination->create_links();

        // echo  $this->db->query($query1)->num_rows();


        //
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
            ->setTitle("Asclepio - Laporan Keuangan")
            ->setSubject("Laporan Keuangan")
            ->setDescription("Laporan Keuangan")
            ->setKeywords("Laporan Keuangan");

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Keuangan Asclepio Website"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "Nama Kelas"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "Kategori Kelas"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Tanggal Kelas Dimulai"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Jumlah Pembeli"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Total Income"); // Set kolom E3 dengan tulisan "ALAMAT"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $keuangan = $this->query->get_query($q);


        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        $keseluruhan = 0;
        $total = 0;
        foreach ($keuangan->result() as $data) { // Lakukan looping pada variabel siswa
            // $total = $data->total * $data->pembeli;
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $numrow, $data->judul_kelas);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $numrow, ($data->jenis_kelas == 'asclepedia') ? $data->kategori_kelas : $data->kategori_go);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $numrow, $data->tgl_kelas);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $numrow, $data->pembeli);
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, 'Rp ' . number_format($data->total)); // if used RP
            // $excel->setActiveSheetIndex(0)->setCellValue('E' . $numrow, $data->total); // if no
            $keseluruhan  += $data->total;

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
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E

        $footer_row = $numrow + 1;
        $excel->setActiveSheetIndex(0)->setCellValue('D' . $footer_row, "Total Pemasukan Keseluruhan");
        $excel->setActiveSheetIndex(0)->setCellValue('E' . $footer_row, 'Rp ' . number_format($keseluruhan));

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Keuangan");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Keuangan Asclepio.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function export_item($id, $periode)
    {
        // Load plugin PHPExcel nya
        include APPPATH . 'libraries/PHPExcel.php';

        // Panggil class PHPExcel nya
        $excel = new PHPExcel();

        $query = "SELECT k.*, COUNT(t.user_id) AS pembeli, t.status FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.status = 'paid' AND d.status = 'success' AND k.id = $id ";
        $query_detail = "SELECT u.nama_lengkap,u.email,u.no_wa,u.kota,t.`total`,d.total_harga, DATE(t.`tgl_pembelian`) AS tgl_order, t.status FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.status = 'success' ";


        if ($periode == 'semua') {
            $query .= "";
        } else if ($periode == 'today') {
            $query .= "AND date(t.tgl_pembelian) = CURDATE()";
        } else if ($periode == 'this_week') {
            $query .= "AND WEEK(t.tgl_pembelian)=WEEK(now())";
        } else if ($periode == 'this_month') {
            $query .= "AND MONTH(t.tgl_pembelian)=MONTH(now())";
        } else {
            $string = explode('%', $periode);

            $date1 = explode('-', $string[0]);
            $date2 = explode('-', $string[1]);

            $finalDate1 = $date1[0] . '-' . $date1[1] . '-' . $date1[2];
            $finalDate2 = $date2[0] . '-' . $date2[1] . '-' . $date2[2];
            $query .= "AND date(t.tgl_pembelian) between '" . $finalDate1 . "' and '" . $finalDate2 . "'";
        }
        $query .= " GROUP BY d.product_id";

        $data = $this->query->get_query($query)->row();
        if ($data->early_price == 0 && $data->late_price == 0) {
            $query_detail = "SELECT u.nama_lengkap,u.email,u.no_wa,t.`total`,d.total_harga, DATE(t.`tgl_pembelian`) AS tgl_order, t.status FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.`product_id` = $data->id ";
        }else{
            $query_detail = "SELECT u.nama_lengkap,u.email,u.no_wa,t.`total`,d.total_harga, DATE(t.`tgl_pembelian`) AS tgl_order, t.status FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.status = 'success' AND d.`product_id` = $data->id ";
        }
        if ($periode == 'semua') {
            $query_detail .= "";
        } else if ($periode == 'today') {
            $query_detail .= "AND date(t.tgl_pembelian) = CURDATE()";
        } else if ($periode == 'this_week') {
            $query_detail .= "AND WEEK(t.tgl_pembelian)=WEEK(now())";
        } else if ($periode == 'this_month') {
            $query_detail .= "AND MONTH(t.tgl_pembelian)=MONTH(now())";
        } else {
            $string = explode('%', $periode);

            $date1 = explode('-', $string[0]);
            $date2 = explode('-', $string[1]);

            $finalDate1 = $date1[0] . '-' . $date1[1] . '-' . $date1[2];
            $finalDate2 = $date2[0] . '-' . $date2[1] . '-' . $date2[2];
            $query_detail .= "AND date(t.tgl_pembelian) between '" . $finalDate1 . "' and '" . $finalDate2 . "'";
        }
        $detail = $this->query->get_query($query_detail)->result();
      

        // Settingan awal fil excel
        $excel->getProperties()->setCreator(' Asclepio Admin ')
            ->setLastModifiedBy(' Asclepio Admin ')
            ->setTitle("Asclepio - Data Laporan Kelas")
            ->setSubject("Data Laporan Kelas " . $data->judul_kelas)
            ->setDescription("Data Laporan Kelas " . $data->judul_kelas)
            ->setKeywords("Data Laporan Kelas " . $data->judul_kelas);

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

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "Data Laporan Kelas " . $data->judul_kelas); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "Pembeli"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "No WA"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "Email"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "Asal Kota"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "Harga Beli"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "Tanggal Order"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "Status Order"); // Set kolom B3 dengan tulisan "NIS"

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya



        $numrow = 7; // Set baris pertama untuk isi tabel adalah baris ke 4
        $rows = 4;



        foreach ($detail as $dt) {
            if ($data->early_price == 0 && $data->late_price == 0) {
                $query = "SELECT u.nama_lengkap,u.email,u.no_wa,t.`total`,d.total_harga, DATE(t.`tgl_pembelian`) AS tgl_order, t.status FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.`product_id` = $data->id ";
                $query_pembeli ="SELECT COUNT(t.user_id) as pembeli FROM transaksi t JOIN transaksi_detail d ON d.transaksi_id = t.id WHERE d.product_id = $data->id";
            }else{
                $query = "SELECT u.nama_lengkap,u.email,u.no_wa,t.`total`,d.total_harga, DATE(t.`tgl_pembelian`) AS tgl_order, t.status FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.status = 'success' AND d.`product_id` = $data->id ";
                $query_pembeli ="SELECT COUNT(t.user_id) as pembeli FROM transaksi t JOIN transaksi_detail d ON d.transaksi_id = t.id WHERE d.product_id = $data->id AND d.`status` = 'success'";
            }
            // if ($dt->status == 'wait_for_payment' || $dt->status == 'pending') {
            //     $status = 'Menunggu pembayaran';
            // } else if ($dt->status == 'paid') {
            //     $status = 'Sudah Bayar';
            // } else {
            //     $status = 'Pembayaran Expired';
            // }
            if (!preg_match('/[^+0-9]/', trim($dt->no_wa))) {
                // cek apakah no hp karakter 1-3 adalah +62
                if (substr(trim($dt->no_wa), 0, 3) == '+62') {
                    $wa = '0' . substr(trim($dt->no_wa), 1);
                }
                else if (substr(trim($dt->no_wa), 0, 2) == '62') {
                    $wa = '0' . substr(trim($dt->no_wa), 1);
                }else{
                    $wa = $dt->no_wa;
                }
            }
            $excel->getActiveSheet()->getStyle('A' . $rows)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('A' . $rows, $dt->nama_lengkap);
            $excel->getActiveSheet()->getStyle('B' . $rows)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('B' . $rows,  substr_replace($wa, '0', 0, 3));
            $excel->getActiveSheet()->getStyle('C' . $rows)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('C' . $rows, $dt->email);
            $excel->getActiveSheet()->getStyle('D' . $rows)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('D' . $rows, $dt->kota);
            $excel->getActiveSheet()->getStyle('E' . $rows)->applyFromArray($style_row);
            // $excel->setActiveSheetIndex(0)->setCellValue('E' . $rows, 'Rp ' . rupiah($dt->total_harga));
            $excel->setActiveSheetIndex(0)->setCellValue('E' . $rows, $dt->total_harga);
            $excel->getActiveSheet()->getStyle('F' . $rows)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('F' . $rows, format_indo($dt->tgl_order));
            $excel->getActiveSheet()->getStyle('G' . $rows)->applyFromArray($style_row);
            $excel->setActiveSheetIndex(0)->setCellValue('G' . $rows, 'Sudah Bayar');
            $rows++;
        }


        // $keseluruhan  += $data->total;

        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)



        // Tambah 1 setiap kali looping

        // $keseluruhan = 0;
        $total = 0;

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(30); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom B

        // $footer_row = $numrow + 1;
        // $excel->setActiveSheetIndex(0)->setCellValue('D' . $footer_row, "Total Pemasukan Keseluruhan");
        // $excel->setActiveSheetIndex(0)->setCellValue('E' . $footer_row, 'Rp ' . number_format($keseluruhan));

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Data Laporan Kelas");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Laporan Kelas ' . $data->judul_kelas . '.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }
}
