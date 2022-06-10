<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Income_analytics extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('base');
    }


    private function js_path()
    {
        return base_url() . 'assets/admin/scripts/';
    }



    /* ======  LAYOUT PAGE ====== */

    function chart_asclepedia($year)
    {

        $data['items'] = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = sprintf("%02s", $i);
            // $year = date('Y');
            $result = $month . '-' . $year;
            $query_gmk = $this->query->get_query("SELECT SUM(t.total) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.kategori_kelas = 'good morning knowledge' AND DATE_FORMAT(t.tgl_pembelian, '%m-%Y') = '$result' AND t.`status`='paid'")->row();
            $query_skill = $this->query->get_query("SELECT SUM(t.total) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.kategori_kelas = 'skill labs' AND DATE_FORMAT(t.tgl_pembelian, '%m-%Y') = '$result' AND t.`status`='paid'")->row();
            // print_r($query);
            switch ($i) {
                case '1':
                    $bulan = 'Januari';
                    break;
                case '2':
                    $bulan = 'Februari';
                    break;
                case '3':
                    $bulan = 'Maret';
                    break;
                case '4':
                    $bulan = 'April';
                    break;
                case '5':
                    $bulan = 'Mei';
                    break;
                case '6':
                    $bulan = 'Juni';
                    break;
                case '7':
                    $bulan = 'Juli';
                    break;
                case '8':
                    $bulan = 'Agustus';
                    break;
                case '9':
                    $bulan = 'September';
                    break;
                case '10':
                    $bulan = 'Oktober';
                    break;
                case '11':
                    $bulan = 'November';
                    break;
                case '12':
                    $bulan = 'Desember';
                    break;
            }
            $total['label'] = $bulan;
            $total['gmk'] = (int)$query_gmk->total_income;
            $total['skills_lab'] = (int)$query_skill->total_income;

            array_push($data['items'], $total);
        }

        echo json_encode($data);
    }
    function chart_asclepiogo($year)
    {

        $data['items'] = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = sprintf("%02s", $i);
            // $year = date('Y');
            $result = $month . '-' . $year;
            $query_open = $this->query->get_query("SELECT SUM(t.total) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.kategori_go = 'open' AND DATE_FORMAT(t.tgl_pembelian, '%m-%Y') = '$result' AND t.`status`='paid'")->row();
            $query_expert = $this->query->get_query("SELECT SUM(t.total) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.kategori_go = 'expert' AND DATE_FORMAT(t.tgl_pembelian, '%m-%Y') = '$result' AND t.`status`='paid'")->row();
            // print_r($query);
            switch ($i) {
                case '1':
                    $bulan = 'Januari';
                    break;
                case '2':
                    $bulan = 'Februari';
                    break;
                case '3':
                    $bulan = 'Maret';
                    break;
                case '4':
                    $bulan = 'April';
                    break;
                case '5':
                    $bulan = 'Mei';
                    break;
                case '6':
                    $bulan = 'Juni';
                    break;
                case '7':
                    $bulan = 'Juli';
                    break;
                case '8':
                    $bulan = 'Agustus';
                    break;
                case '9':
                    $bulan = 'September';
                    break;
                case '10':
                    $bulan = 'Oktober';
                    break;
                case '11':
                    $bulan = 'November';
                    break;
                case '12':
                    $bulan = 'Desember';
                    break;
            }
            $total['label'] = $bulan;
            $total['open'] = (int)$query_open->total_income;
            $total['expert'] = (int)$query_expert->total_income;

            array_push($data['items'], $total);
        }

        echo json_encode($data);
    }



    function chart_tahunan()
    {
        $data['items'] = [];


        // $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepedia', 'is_delete' => 0])->result();
        $list = array();
        $datas = [];
        // $month = date('m');
        $year = date('Y');

        for ($d = $year - 1; $d <= $year + 2; $d++) {


            $list[] = $d;
            $querys = $this->query->get_query("SELECT SUM(total) AS total_income FROM transaksi WHERE DATE_FORMAT(tgl_pembelian, '%Y') = '$d' AND `status` = 'paid'")->row()->total_income;
            array_push($datas, (int)$querys);
            // $item['data'] = $datas;
        }

        $item['label'] = 'Pemasukan';
        $item['data'] = $datas;
        $item['backgroundColor'] = 'rgb(255, 99, 132)';
        $item['borderColor'] = 'rgb(255, 99, 132)';
        $data['labels'] = $list;
        array_push($data['items'], $item);

        echo json_encode($data);
    }
    function chart_bulanan()
    {

        $data['items'] = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = sprintf("%02s", $i);
            $year = date('Y');
            $result = $month . '-' . $year;
            $query = $this->query->get_query("SELECT SUM(total) AS total_income FROM transaksi  WHERE DATE_FORMAT(tgl_pembelian, '%m-%Y') = '$result' AND `status`='paid'")->row();
            // echo $this->db->last_query();
            // $query_skill = $this->query->get_query("SELECT COUNT(t.`user_id`) AS total_pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.kategori_kelas = 'skill labs' AND DATE_FORMAT(t.tgl_pembelian, '%m-%Y') = '$result' AND t.`status`='paid'")->row();
            // print_r($query);
            switch ($i) {
                case '1':
                    $bulan = 'Januari';
                    break;
                case '2':
                    $bulan = 'Februari';
                    break;
                case '3':
                    $bulan = 'Maret';
                    break;
                case '4':
                    $bulan = 'April';
                    break;
                case '5':
                    $bulan = 'Mei';
                    break;
                case '6':
                    $bulan = 'Juni';
                    break;
                case '7':
                    $bulan = 'Juli';
                    break;
                case '8':
                    $bulan = 'Agustus';
                    break;
                case '9':
                    $bulan = 'September';
                    break;
                case '10':
                    $bulan = 'Oktober';
                    break;
                case '11':
                    $bulan = 'November';
                    break;
                case '12':
                    $bulan = 'Desember';
                    break;
            }
            $total['label'] = $bulan;
            $total['data'] = (int)$query->total_income;

            array_push($data['items'], $total);
        }

        echo json_encode($data);
    }
    function chart_mingguan()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepedia', 'is_delete' => 0])->result();
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 4; $d++) {
            $list[] = 'Minggu ' . $d;
        }

        $week_1 = $this->query->get_query("SELECT SUM(total) AS total_income FROM transaksi WHERE (DATE(`tgl_pembelian`) BETWEEN '$year-$month-1' AND '$year-$month-7') AND `status` = 'paid'")->row()->total_income;
        $week_2 = $this->query->get_query("SELECT SUM(total) AS total_income FROM transaksi WHERE (DATE(`tgl_pembelian`) BETWEEN '$year-$month-8' AND '$year-$month-14') AND `status` = 'paid'")->row()->total_income;
        $week_3 = $this->query->get_query("SELECT SUM(total) AS total_income FROM transaksi WHERE (DATE(`tgl_pembelian`) BETWEEN '$year-$month-15' AND '$year-$month-21') AND `status` = 'paid'")->row()->total_income;
        $week_4 = $this->query->get_query("SELECT SUM(total) AS total_income FROM transaksi WHERE (DATE(`tgl_pembelian`) BETWEEN '$year-$month-22' AND '$year-$month-31') AND `status` = 'paid'")->row()->total_income;
        $datas = [
            (int)$week_1,
            (int)$week_2,
            (int)$week_3,
            (int)$week_4,
        ];



        $item['label'] = 'Pemasukan';
        $data['labels'] = $list;
        $item['data'] = $datas;
        $item['backgroundColor'] = 'rgb(255, 99, 132)';
        $item['borderColor'] = 'rgb(255, 99, 132)';
        array_push($data['items'], $item);

        echo json_encode($data);
    }
    function chart_harian()
    {
        $data['items'] = [];


        $list = array();
        $month = date('m');
        $year = date('Y');
        $datas = [];
        for ($d = 1; $d <= 31; $d++) {

            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {

                $list[] = format_indo(date('Y-m-d', $time));
                $tgl_beli = date('Y-m-d', $time);
                $query = $this->query->get_query("SELECT SUM(total) AS total_income FROM transaksi  WHERE DATE(tgl_pembelian) = '$tgl_beli' AND `status`='paid'")->row()->total_income;
                array_push($datas, (int)$query);
            }
        }



        $item['label'] = 'Pemasukan';
        $item['data'] = $datas;
        $item['backgroundColor'] = 'rgb(255, 99, 132)';
        $item['borderColor'] = 'rgb(255, 99, 132)';
        array_push($data['items'], $item);

        $data['labels'] = $list;

        echo json_encode($data);
    }

    // Asclepedia
    function chart_asclepedia_year()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepedia', 'is_delete' => 0])->result();
        $list = array();
        // $month = date('m');
        $year = date('Y');

        for ($d = $year - 1; $d <= $year + 2; $d++) {
            $list[] = $d;
        }

        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $datas = [];
                for ($d = $year - 1; $d <= $year + 2; $d++) {
                    // $tgl_beli = date('Y-m-d', $time);
                    $querys = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND DATE_FORMAT(tgl_pembelian, '%Y') = '$d' AND t.`status` = 'paid'")->row()->total_income;
                    array_push($datas, (int)$querys);
                }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }



        echo json_encode($data);
    }
    function chart_asclepedia_month()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepedia', 'is_delete' => 0])->result();
        $list = array();
        // $month = date('m');
        // $year = date('Y');

        for ($d = 1; $d <= 12; $d++) {
            switch ($d) {
                case '1':
                    $bulan = 'Januari';
                    break;
                case '2':
                    $bulan = 'Februari';
                    break;
                case '3':
                    $bulan = 'Maret';
                    break;
                case '4':
                    $bulan = 'April';
                    break;
                case '5':
                    $bulan = 'Mei';
                    break;
                case '6':
                    $bulan = 'Juni';
                    break;
                case '7':
                    $bulan = 'Juli';
                    break;
                case '8':
                    $bulan = 'Agustus';
                    break;
                case '9':
                    $bulan = 'September';
                    break;
                case '10':
                    $bulan = 'Oktober';
                    break;
                case '11':
                    $bulan = 'November';
                    break;
                case '12':
                    $bulan = 'Desember';
                    break;
            }
            $list[] = $bulan . ' ' . date('Y');
        }

        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $datas = [];
                for ($d = 1; $d <= 12; $d++) {
                    $month = sprintf("%02s", $d);
                    $year = date('Y');
                    $result = $month . '-' . $year;
                    // $tgl_beli = date('Y-m-d', $time);
                    $querys = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND DATE_FORMAT(tgl_pembelian, '%m-%Y') = '$result' AND t.`status` = 'paid'")->row()->total_income;
                    array_push($datas, (int)$querys);
                }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }


        echo json_encode($data);
    }
    function chart_asclepedia_week()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepedia', 'is_delete' => 0])->result();
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 4; $d++) {
            $list[] = 'Minggu ' . $d;
        }
        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $week_1 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-1' AND '$year-$month-7') AND t.`status` = 'paid'")->row()->total_income;
                $week_2 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-8' AND '$year-$month-14') AND t.`status` = 'paid'")->row()->total_income;
                $week_3 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-15' AND '$year-$month-21') AND t.`status` = 'paid'")->row()->total_income;
                $week_4 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-22' AND '$year-$month-31') AND t.`status` = 'paid'")->row()->total_income;
                $datas = [
                    (int)$week_1,
                    (int)$week_2,
                    (int)$week_3,
                    (int)$week_4,
                ];
                // for ($d = 1; $d <= 4; $d++) {
                //     // $tgl_beli = date('Y-m-d', $time);

                //     array_push($datas, (int)$querys);
                // }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }



        echo json_encode($data);
    }
    function chart_asclepedia_day()
    {
        $data['items'] = [];

        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepedia', 'is_delete' => 0])->result();
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {

            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {

                $list[] = format_indo(date('Y-m-d', $time));
            }
        }

        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $datas = [];
                for ($d = 1; $d <= 31; $d++) {

                    $time = mktime(12, 0, 0, $month, $d, $year);
                    if (date('m', $time) == $month) {
                        $tgl_beli = date('Y-m-d', $time);
                        $querys = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND DATE(t.`tgl_pembelian`) = '$tgl_beli' AND t.`status` = 'paid'")->row()->total_income;
                        array_push($datas, (int)$querys);
                    }
                }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }


        echo json_encode($data);
    }
    // END Asclepedia

    function chart_asclepiogo_year()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepio_go', 'is_delete' => 0])->result();
        $list = array();
        // $month = date('m');
        $year = date('Y');

        for ($d = $year - 1; $d <= $year + 2; $d++) {
            $list[] = $d;
        }
        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $datas = [];
                for ($d = $year - 1; $d <= $year + 2; $d++) {
                    // $tgl_beli = date('Y-m-d', $time);
                    $querys = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND DATE_FORMAT(tgl_pembelian, '%Y') = '$d' AND t.`status` = 'paid'")->row()->total_income;
                    array_push($datas, (int)$querys);
                }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }


        echo json_encode($data);
    }
    function chart_asclepiogo_month()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepio_go', 'is_delete' => 0])->result();
        $list = array();
        // $month = date('m');
        // $year = date('Y');

        for ($d = 1; $d <= 12; $d++) {
            switch ($d) {
                case '1':
                    $bulan = 'Januari';
                    break;
                case '2':
                    $bulan = 'Februari';
                    break;
                case '3':
                    $bulan = 'Maret';
                    break;
                case '4':
                    $bulan = 'April';
                    break;
                case '5':
                    $bulan = 'Mei';
                    break;
                case '6':
                    $bulan = 'Juni';
                    break;
                case '7':
                    $bulan = 'Juli';
                    break;
                case '8':
                    $bulan = 'Agustus';
                    break;
                case '9':
                    $bulan = 'September';
                    break;
                case '10':
                    $bulan = 'Oktober';
                    break;
                case '11':
                    $bulan = 'November';
                    break;
                case '12':
                    $bulan = 'Desember';
                    break;
            }
            $list[] = $bulan . ' ' . date('Y');
            // $time = mktime(12, 0, 0, $month, $d, $year);
            // if (date('m', $time) == $month) {

            //     $list[] = format_indo(date('Y-m-d', $time));
            // }
        }
        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $datas = [];
                for ($d = 1; $d <= 12; $d++) {
                    $month = sprintf("%02s", $d);
                    $year = date('Y');
                    $result = $month . '-' . $year;
                    // $tgl_beli = date('Y-m-d', $time);
                    $querys = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND DATE_FORMAT(tgl_pembelian, '%m-%Y') = '$result' AND t.`status` = 'paid'")->row()->total_income;
                    array_push($datas, (int)$querys);
                }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }


        echo json_encode($data);
    }
    function chart_asclepiogo_week()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepio_go', 'is_delete' => 0])->result();
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 4; $d++) {
            $list[] = 'Minggu ' . $d;
        }

        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $week_1 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-1' AND '$year-$month-7') AND t.`status` = 'paid'")->row()->total_income;
                $week_2 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-8' AND '$year-$month-14') AND t.`status` = 'paid'")->row()->total_income;
                $week_3 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-15' AND '$year-$month-21') AND t.`status` = 'paid'")->row()->total_income;
                $week_4 = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND (DATE(t.`tgl_pembelian`) BETWEEN '$year-$month-22' AND '$year-$month-31') AND t.`status` = 'paid'")->row()->total_income;
                $datas = [
                    (int)$week_1,
                    (int)$week_2,
                    (int)$week_3,
                    (int)$week_4,
                ];
                // for ($d = 1; $d <= 4; $d++) {
                //     // $tgl_beli = date('Y-m-d', $time);

                //     array_push($datas, (int)$querys);
                // }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }


        echo json_encode($data);
    }
    function chart_asclepiogo_day()
    {
        $data['items'] = [];


        $query = $this->query->get_data_simple('kelas', ['jenis_kelas' => 'asclepio_go', 'is_delete' => 0])->result();
        $list = array();
        $month = date('m');
        $year = date('Y');

        for ($d = 1; $d <= 31; $d++) {

            $time = mktime(12, 0, 0, $month, $d, $year);
            if (date('m', $time) == $month) {

                $list[] = format_indo(date('Y-m-d', $time));

                // $get_date[] = "OR DATE(t.`tgl_pembelian`) = '" . date('Y-m-d', $time) . "'";
                // $querys[] = $this->query->get_query("SELECT COUNT('t.user_id') AS total_pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND DATE(t.`tgl_pembelian`) = '$tgl_beli' AND t.`status` = 'paid'")->row()->total_pembeli;
            }
        }

        if ($query) {
            foreach ($query as $q) {
                $rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
                $color = '#' . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)] . $rand[rand(0, 15)];

                $datas = [];
                for ($d = 1; $d <= 31; $d++) {

                    $time = mktime(12, 0, 0, $month, $d, $year);
                    if (date('m', $time) == $month) {
                        $tgl_beli = date('Y-m-d', $time);
                        $querys = $this->query->get_query("SELECT SUM(d.total_harga) AS total_income FROM transaksi t JOIN transaksi_detail d ON t.id = d.`transaksi_id` JOIN kelas k ON d.`product_id`=k.`id` WHERE d.`product_id` = $q->id AND DATE(t.`tgl_pembelian`) = '$tgl_beli' AND t.`status` = 'paid'")->row()->total_income;
                        array_push($datas, (int)$querys);
                    }
                }

                $item['label'] = $q->judul_kelas;
                $item['data'] = $datas;
                $item['backgroundColor'] = $color;
                $item['borderColor'] = $color;
                array_push($data['items'], $item);
            }

            $data['labels'] = $list;
        } else {
            $item['label'] = 'Tidak ada kelas';
            $item['data'] = 0;
            $item['backgroundColor'] = 'grey';
            $item['borderColor'] = 'grey';
            $data['labels'] = $list;
            array_push($data['items'], $item);
        }


        echo json_encode($data);
    }
}
