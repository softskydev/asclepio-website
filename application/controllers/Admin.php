<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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

    private function check_session()
    {

        if (!$this->session->userdata('name')) {
            $this->session->set_flashdata('mgs', 'Sesi login anda telah habis , Silahkan login kembali');
            $this->session->set_flashdata('msg_type', 'danger');
            redirect('Admin');
        }
    }

    function index()
    {


        if ($this->session->userdata('name')) {
            $this->session->set_flashdata('msg', 'Anda sudah login');
            $this->session->set_flashdata('msg_type', 'success');
            redirect('Admin/dashboard');
        }

        $data['title']    = 'Dashboard';

        $data['script'][] = $this->js_path() . 'dashboard.js';

        $this->load->view('admin/login', '');
    }

    function do_logout()
    {

        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('username');

        $this->session->set_flashdata('msg', 'Sesi login anda telah habis , Silahkan login kembali');
        $this->session->set_flashdata('msg_type', 'danger');
        redirect('Admin');
    }

    function do_login()
    {

        $username   =   $_POST['username'];
        $password   =   $_POST['userpassword'];
        $select   = "admins";
        $where  =   [
            'username' => $username,
            'password' =>  md5($password),
        ];
        $result     =   $this->query->get_data_simple($select, $where)->result();

        if (count($result) > 0) {

            foreach ($result as $val) {
                $session['user_id']  = $val->id;
                $session['name']     = $val->name;
                $session['username'] = $val->username;
                $session['access'] = $val->access;
                $this->session->set_userdata($session);
                $this->session->set_flashdata('msg', 'Selamat datang ' . $val->name);
                $this->session->set_flashdata('msg_type', 'success');

                if ($val->access == 'direksi' || $val->access == 'finance' || $val->access == 'marketing') {
                    redirect('Admin/dashboard');
                } else if ($val->access == 'cs') {
                    redirect('Admin/user');
                } else {
                    redirect('Admin/asclepedia');
                }
            }
        } else {
            $this->session->set_flashdata('msg', 'Akun tidak ditemukan');
            $this->session->set_flashdata('msg_type', 'error');
            redirect('Admin');
        }
    }


    /* ======  LAYOUT PAGE ====== */
    function dashboard()
    {

        $this->check_session();

        $data['title']       = 'Dashboard';
        $data['script'][] = 'https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js';
        $data['script'][] = $this->js_path() . 'dashboard.js';
        $page['content']  = $this->load->view('admin/dashboard', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function asclepedia()
    {
        $this->check_session();

        $data['title']       = 'Asclepedia Class';
        $data_kelas_terusan = [];
        $kelas_terusan   = $this->query->get_query("SELECT 
        CASE 
            WHEN a.tipe_kelas = 'banyak_pertemuan' THEN b.date_materi 
            WHEN a.tipe_kelas = 'sekali_pertemuan' THEN a.tgl_kelas
        END AS tanggal_mulai , a.* , b.date_materi
        FROM kelas a JOIN kelas_materi b ON a.id = b.kelas_id WHERE a.jenis_kelas = 'asclepedia' group by a.id ")->result();
        $i = 0;
        foreach($kelas_terusan as $kelas){
            if($kelas->tanggal_mulai >= date('Y-m-d')){
                $data_kelas_terusan[$i]['id']  = $kelas->id;
                $data_kelas_terusan[$i]['judul'] = $kelas->judul_kelas;
                $i++;
            }
        }
        $data['kelas_terusan'] = $data_kelas_terusan;       
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = $this->js_path() . 'asclepedia.js';

        $page['content']  = $this->load->view('admin/asclepedia', $data, true);
        $this->load->view('admin/layout', $page);
    }

    function kelas_detail($kelas_id){
        $this->check_session();

        $data['data']  = $this->query->get_data_simple('kelas' , ['id' => $kelas_id] )->row();
        $data['topik'] = $this->query->get_data_simple('topik' , ['is_delete' => 0] )->result();
        $pemateri      = $this->query->get_data_simple('kelas_pemateri' , ['kelas_id' => $kelas_id] )->result();
        $array = [];
        foreach ($pemateri as $v) {
            $array[] = $v->pemateri_id;
        }
        $data['data_pemateri']  = $array;
        $data['list_pemateri']  = $this->query->get_data_simple('pemateri' , ['is_delete' => 0] )->result();
        $data['materi']         = $this->query->get_data_simple('kelas_materi' , ['kelas_id' => $kelas_id] )->result();


        $data['title']       = $data['data']->judul_kelas;
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = 'https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js';
        $data['script'][] = 'https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js';
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js';
        $data['script'][] = $this->js_path() . 'asclepedia_edit.js';

        $page['content']  = $this->load->view('admin/asclepedia_edit_kelas', $data, true);
        $this->load->view('admin/layout', $page);

    }
    function asclepio_go()
    {

        $this->check_session();

        $data['title']       = 'Asclepio Go';
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = $this->js_path() . 'asclepio_go.js';

        $page['content']  = $this->load->view('admin/asclepio_go', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function pemateri()
    {
        $this->check_session();

        $data['title']       = 'Pemateri';
        $data['script'][] = $this->js_path() . 'pemateri.js';
        $data['data'] = $this->query->get_data_simple('pemateri', ['is_delete' => 0])->result();
        $page['content']  = $this->load->view('admin/pemateri', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function user()
    {
        $this->check_session();

        $data['title']       = 'User';
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = $this->js_path() . 'user.js';
        $page['content']  = $this->load->view('admin/user', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function testimoni()
    {
        $this->check_session();

        $data['title']       = 'Testimoni';
        $data['testimoni'] = $this->query->get_query("SELECT k.judul_kelas,u.nama_lengkap,u.universitas,r.id,r.rating,r.ulasan FROM ulasan r JOIN kelas k ON r.kelas_id = k.id JOIN `user` u ON r.`user_id` = u.id ORDER BY r.id DESC")->result();
        $data['script'][] = $this->js_path() . 'testimoni.js';
        $page['content']  = $this->load->view('admin/testimoni', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function user_analytics()
    {
        $this->check_session();

        $data['title']       = 'Analisa Peserta';
        $data['script'][] = 'https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js';
        $data['script'][] = $this->js_path() . 'user_analytics.js';
        $page['content']  = $this->load->view('admin/user_analytics', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function income_analytics()
    {
        $this->check_session();

        $data['title']       = 'Analisa Keuangan';
        $data['script'][] = 'https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js';
        $data['script'][] = $this->js_path() . 'income_analytics.js';
        $page['content']  = $this->load->view('admin/income_analytics', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function voucher()
    {
        $this->check_session();

        $data['title']       = 'Voucher';
        $data['script'][] = $this->js_path() . 'voucher.js';
        $page['content']  = $this->load->view('admin/voucher', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function transaksi()
    {
        $this->check_session();

        $data['title']       = 'Transaksi';
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = $this->js_path() . 'transaksi.js';
        $page['content']  = $this->load->view('admin/transaksi', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function laporan_keuangan()
    {
        $this->check_session();

        $data['title']       = 'Laporan Keuangan';
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = $this->js_path() . 'keuangan.js';
        $page['content']  = $this->load->view('admin/laporan_keuangan', $data, true);
        $this->load->view('admin/layout', $page);
    }
    public function ringkasan_peserta($id, $periode)
    {
        $this->check_session();
        $query = "SELECT k.*,SUM(d.total_harga) AS total, t.status FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.status = 'paid' AND d.status = 'success' AND k.id = $id ";
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
            $query .= "AND date(t.tgl_pembelian) between'" . $finalDate1 . "' and '" . $finalDate2 . "'";
        }
        $data['data'] = $this->query->get_query($query)->row();

        $this->load->view('admin/ringkasan_peserta', $data);
    }
    function log_history($id)
    {
        $data['judul_kelas'] = $this->query->get_data_simple('kelas', ['id' => $id])->row()->judul_kelas;
        $data['log'] = $this->query->get_query("SELECT * FROM log_update_link WHERE kelas_id = $id ORDER BY updated_at DESC")->result();

        $this->load->view('admin/log_history', $data);
    }
    function topik()
    {
        $this->check_session();

        $data['title']       = 'Topik';
        $data['script'][] = $this->js_path() . 'topik.js';
        $page['content']  = $this->load->view('admin/topik', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function setting_auth()
    {
        $this->check_session();

        $data['title']       = 'Setting Auth';
        // $data['script'][] = $this->js_path() . 'topik.js';
        $data['login'] = $this->query->get_data_simple('image_auth', ['page' => 'login'])->row();
        $data['register'] = $this->query->get_data_simple('image_auth', ['page' => 'register'])->row();
        $page['content']  = $this->load->view('admin/setting_auth', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function setting_caption()
    {
        $this->check_session();

        $data['title']       = 'Setting Caption';
        // $data['script'][] = $this->js_path() . 'topik.js';
        $data['data'] = $this->query->get_data_simple('caption', ['id' => 1])->row();
        $page['content']  = $this->load->view('admin/setting_caption', $data, true);
        $this->load->view('admin/layout', $page);
    }
    function setting_seo()
    {
        $this->check_session();

        $data['title']       = 'Setting SEO';
        // $data['script'][] = $this->js_path() . 'topik.js';
        $data['home'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row();
        $data['asclepedia'] = $this->query->get_data_simple('seo', ['page' => 'asclepedia'])->row();
        $data['asclepio_go'] = $this->query->get_data_simple('seo', ['page' => 'asclepio_go'])->row();
        $data['about'] = $this->query->get_data_simple('seo', ['page' => 'about'])->row();
        $page['content']  = $this->load->view('admin/setting_seo', $data, true);
        $this->load->view('admin/layout', $page);
    }

    function cek_tgl_kelas()
    {
        $kelas = $this->query->get_query("SELECT id,judul_kelas,tgl_kelas, waktu_mulai FROM kelas")->result();

        $today = strtotime(date("Y-m-d H:i:s"));
        // echo $today . '<br>';
        foreach ($kelas as $k) {
            $tgl_kelas = strtotime($k->tgl_kelas . '' . $k->waktu_mulai . ':00');

            $diff = $tgl_kelas - $today;
            $menit    = floor($diff / (60));
            // echo $menit . $k->judul_kelas . '<br>';
            // print_r($jam . ' ' . $k->judul_kelas . ' ' . $tgl_kelas . '<br>');

            if ($menit == 60 || $menit == 59 || $menit == 1440 || $menit == 1439) {
                $this->reminder($k->id);
            }
        }
    }

    function do_reminder($kelas_id){
         $this->reminder($kelas_id);

         $this->session->set_flashdata('msg_type' , 'success');
         $this->session->set_flashdata('msg' , 'Reminder sudah di kirim ke para Asclepian');
         redirect( base_url('Admin/asclepedia/') );

    }

    function reminder($id)
    {

        $cek_trans = $this->query->get_query("SELECT u.email,u.nama_lengkap,k.judul_kelas,k.waktu_mulai,k.jenis_kelas,k.slug, k.tgl_kelas FROM transaksi t JOIN `user` u ON t.user_id = u.id JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.id = $id")->result();
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPAutoTLS = true; // enable SMTP authentication
        $mail->SMTPSecure = "tls"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 587; // set the SMTP port for the GMAIL server
        $mail->Username = ACCESS_EMAIL; // GMAIL username
        $mail->Password = ACCESS_EMAIL_PASSWORD; // GMAIL password
        foreach ($cek_trans as $ct) {
            // print_r($ct);
            if ($ct->jenis_kelas == 'asclepedia') {
                $jenis_kelas = 'asclepedia';
            } else {
                $jenis_kelas = 'asclepiogo';
            }

            $parsing = ['judul_kelas' => $ct->judul_kelas, 'fullname' => $ct->nama_lengkap, 'waktu_mulai' => $ct->waktu_mulai, 'jenis_kelas' => $jenis_kelas, 'tgl_kelas' => $ct->tgl_kelas, 'slug' => $ct->slug];
            $mail->ClearAllRecipients();
            $mail->AddAddress($ct->email);
            $mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
            $mail->Subject = 'Reminder';
            $mail->Body = $this->load->view('front/mail_reminder', $parsing, true);
            $mail->isHTML(true);


            try {
                $mail->Send();
                print_r($mail->ErrorInfo);
            } catch (Exception $e) {
                print_r($mail->ErrorInfo);
            }
        }
    }

    function get_chart()
    {

        $data['items'] = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = sprintf("%02s", $i);
            $year = date('Y');
            $result = $month . '-' . $year;
            $query_pedia = $this->query->get_query("SELECT COUNT(t.`user_id`) AS total_pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.jenis_kelas = 'asclepedia' AND DATE_FORMAT(t.tgl_pembelian, '%m-%Y') = '$result' AND t.`status`='paid'")->row();
            $query_piogo = $this->query->get_query("SELECT COUNT(t.`user_id`) AS total_pembeli FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.jenis_kelas = 'asclepio_go' AND DATE_FORMAT(t.tgl_pembelian, '%m-%Y') = '$result' AND t.`status`='paid'")->row();
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
            $total['asclepedia'] = $query_pedia->total_pembeli;
            $total['asclepiogo'] = $query_piogo->total_pembeli;

            array_push($data['items'], $total);
        }

        echo json_encode($data);
    }
}
