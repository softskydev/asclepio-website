<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Front extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('base');
        $this->load->library('pagination');
    }


    private function js_path()
    {
        return base_url() . 'assets/front/scripts/';
    }
    function email()
    {
        $this->load->view('front/mail_registration');
    }
    /* ======  LAYOUT PAGE ====== */
    function index()
    {
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Asclepio';
        // $data['script'][] = $this->js_path() . 'asclepedia.js';

        $data['script'][] = $this->js_path() . 'booking.js';
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';
        $data['caption'] = $this->query->get_data_simple('caption', ['id' => 1])->row();
        $data['asclepedia'] = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND is_delete = 0 AND in_public = 1 ORDER BY public_date DESC")->result();
        $data['asclepio_go'] = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND is_delete = 0 AND in_public = 1 ORDER BY public_date DESC")->result();
        $data['onrating'] = $this->query->get_query("SELECT k.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND k.in_public = 1 GROUP BY k.`judul_kelas` ORDER BY COUNT(d.`product_id`) DESC LIMIT 3")->result();
        $data['testimoni'] = $this->query->get_query("SELECT k.judul_kelas,k.slug,k.jenis_kelas,u.nama_lengkap,u.universitas,r.rating,r.ulasan FROM ulasan r JOIN kelas k ON r.kelas_id = k.id JOIN `user` u ON r.`user_id` = u.id ORDER BY r.id DESC")->result();
        $page['content']  = $this->load->view('front/index', $data, true);
        $this->load->view('front/layout', $page);
    }
    function login()
    {
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Asclepio Login';
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';
        // $data['script'][] = $this->js_path() . 'asclepedia.js';
        $page['content']  = $this->load->view('front/login', $data, true);
        $this->load->view('front/layout', $page);
    }
    function register()
    {
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Asclepio Register';
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';
        $data['script'][] = $this->js_path() . 'register.js';
        $page['content']  = $this->load->view('front/register', $data, true);
        $this->load->view('front/layout', $page);
    }
    function univ()
    {
        $data['data'] = $this->query->get_data_simple('univ', null)->result();
        echo json_encode($data);
    }
    function asclepedia($slug = null)
    {

        $data['caption'] = $this->query->get_data_simple('caption', ['id' => 1])->row();
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = $this->js_path() . 'booking.js';
        
        if ($slug == null) {
            $data['meta_title']   = $this->query->get_data_simple('seo', ['page' => 'asclepedia'])->row()->meta_title;
            $data['meta_desc']    = $this->query->get_data_simple('seo', ['page' => 'asclepedia'])->row()->meta_desc;
            $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'asclepedia'])->row()->meta_keyword;
            $data['meta_url']     = base_url('asclepedia');
            $data['meta_img']     = '';
            $data['title']        = ' Kelas Online Kedokteran #1 di Indonesia | Asclepedia Class';
            $data['onrating']     = $this->query->get_query("SELECT k.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND k.in_public = 1 AND k.jenis_kelas = 'asclepedia' GROUP BY k.`judul_kelas` ORDER BY COUNT(d.`product_id`) DESC LIMIT 3")->result();
            $data['morning']      = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND kategori_kelas = 'good morning knowledge' AND is_delete = 0 AND in_public = 1 ORDER BY public_date ASC")->result();
            $data['skill']        = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND kategori_kelas = 'skill labs' AND is_delete = 0 AND in_public = 1 ORDER BY public_date ASC")->result();
            $data['drill']        = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND kategori_kelas = 'drill the case' AND is_delete = 0 AND in_public = 1 ORDER BY public_date ASC")->result();
            $data['terusan']      = $this->query->get_query("SELECT * FROM kelas_terusan")->result();
            $page['content']      = $this->load->view('front/asclepedia', $data, true);
        } else {
            $data['title']        = ' Kelas Online Kedokteran #1 di Indonesia | Asclepedia Class';
            $data['data']         = $this->query->get_query("SELECT * FROM kelas WHERE slug = '$slug'")->row();
            $data['meta_title']   = $data['data']->judul_kelas;
            $data['meta_desc']    = $data['data']->deskripsi_kelas;
            $data['meta_keyword'] = $data['data']->deskripsi_kelas;
            $data['meta_url']     = base_url('asclepedia/' . $data['data']->slug);
            $data['meta_img']     = base_url() . 'assets/uploads/kelas/asclepedia/' . $data['data']->thumbnail;
            $page['content']      = $this->load->view('front/class_detail', $data, true);
        }

        $this->load->view('front/layout', $page);
    }

    function tiket_terusan_detail($slug){
        $data['data']         = $this->query->get_data_simple('kelas_terusan' , ['md5(code_kelas)' => $slug])->row();
        if(($data['data'])){
            $data['title']        = $data['data']->judul_kelas_terusan;
            $data['meta_title']   = $data['data']->judul_kelas_terusan;
            $data['meta_desc']    = $data['data']->judul_kelas_terusan;
            $data['meta_keyword'] = $data['data']->judul_kelas_terusan .','. $data['data']->code_kelas;
            $data['meta_url']     = base_url('kelas-terusan');
            $data['meta_img']     = '';
            $data['script'][]     = $this->js_path() . 'tiket-terusan.js';
            $page['content']      = $this->load->view('front/class_detail_terusan', $data, true);
            $this->load->view('front/layout', $page);
        } else {

            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Tiket Terusan tidak ditemukan');
            redirect(base_url('asclepedia'));
            
        }
        
    }


    function asclepiogo($slug = null)
    {

        $data['caption'] = $this->query->get_data_simple('caption', ['id' => 1])->row();
        $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
        $data['script'][] = $this->js_path() . 'booking.js';
        if ($slug == null) {
            $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'asclepio_go'])->row()->meta_title;
            $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'asclepio_go'])->row()->meta_desc;
            $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'asclepio_go'])->row()->meta_keyword;
            $data['meta_url'] = base_url('asclepio_go');
            $data['meta_img'] = '';
            $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Asclepio Go';
            $data['onrating'] = $this->query->get_query("SELECT k.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE k.is_delete = 0 AND k.in_public = 1 AND k.jenis_kelas = 'asclepio_go' GROUP BY k.`judul_kelas` ORDER BY COUNT(d.`product_id`) DESC LIMIT 3")->result();
            $data['open'] = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND kategori_go = 'open' AND is_delete = 0 AND in_public = 1 ORDER BY public_date ASC")->result();
            $data['expert'] = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND kategori_go = 'expert' AND is_delete = 0 AND in_public = 1 ORDER BY public_date ASC")->result();
            $data['private'] = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND kategori_go = 'private' AND is_delete = 0 AND in_public = 1 ORDER BY public_date ASC")->result();
            $page['content']  = $this->load->view('front/asclepio_go', $data, true);
        } else {
            $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Asclepio Go';
            $data['data'] = $this->query->get_query("SELECT * FROM kelas WHERE slug = '$slug'")->row();
            $data['meta_title'] = $data['data']->judul_kelas;
            $data['meta_desc'] = $data['data']->deskripsi_kelas;
            $data['meta_keyword'] = $data['data']->deskripsi_kelas;
            $data['meta_url'] = base_url('asclepio_go/' . $data['data']->slug);
            $data['meta_img'] = base_url() . 'assets/uploads/kelas/asclepio_go/' . $data['data']->thumbnail;
            $page['content']  = $this->load->view('front/class_detail', $data, true);
        }

        $this->load->view('front/layout', $page);
    }
    function change_jadwal()
    {
        $jenis_kelas = $this->input->post('jenis_kelas');
        $tgl_kelas   = $this->input->post('tgl_kelas');
        $kategori    = $this->input->post('kategori');
        $query1      = "SELECT * FROM kelas WHERE jenis_kelas = '$jenis_kelas' AND tgl_kelas = '$tgl_kelas' AND is_delete = 0 AND in_public = 1";

        if ($kategori != 'all') {
            if ($jenis_kelas == 'asclepedia') {
                if ($kategori == 'morning') {
                    $query1 .= ' AND kategori_kelas = "good morning knowledge"';
                } else {
                    $query1 .= ' AND kategori_kelas = "skill labs"';
                }
            } else {
                if ($kategori == 'open') {
                    $query1 .= ' AND kategori_go = "open"';
                } else if ($kategori == 'expert') {
                    $query1 .= ' AND kategori_go = "expert"';
                } else {
                    $query1 .= ' AND kategori_go = "private"';
                }
            }
        }


        $kelas = $this->query->get_query($query1)->result();
        // echo $this->db->last_query();
        $items = [];
        foreach ($kelas as $k) {
            $date = $k->created_date;
            $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

            if ($new_date > date('Y-m-d')) {
                $new_price = $k->early_price;
            } else {
                $new_price = $k->late_price;
            }
            if ($new_price == 0) {
                $harga = 'FREE';
            } else {
                $harga = 'Rp' . rupiah($new_price);
            }

            if ($k->jenis_kelas == 'asclepedia') {
                if ($k->kategori_kelas == 'good morning knowledge') {
                    $label = 'good morning knowledge';
                } else {
                    $label = 'skill labs';
                }
            } else {
                if ($k->kategori_go == 'open') {
                    $label = 'open';
                } else if ($k->kategori_go == 'expert') {
                    $label = 'expert';
                } else {
                    $label = 'private';
                }
            }

            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();
            $rating = $this->query->get_query("SELECT FORMAT(AVG(rating),1) AS rating FROM ulasan WHERE kelas_id = $k->id")->row()->rating;
            if ($rating == '') {
                $rating = 0;
            } else {
                $rating = $rating;
            }
            // debug($pemateri);

            $item['id'] = $k->id;
            $item['judul'] = $k->judul_kelas;
            $item['rating'] = $rating;
            $item['kategori'] = $label;
            $item['jenis_kelas'] = $k->jenis_kelas;
            $item['waktu_mulai'] = $k->waktu_mulai;
            $item['waktu_akhir'] = $k->waktu_akhir;
            $item['harga'] = $harga;
            $item['tgl_kelas'] = format_indo($k->tgl_kelas);
            $item['thumbnail'] = $k->thumbnail;
            $item['slug'] = $k->slug;
            $item['pemateri'] = $pemateri;
            array_push($items, $item);
        }
        if ($kelas) {
            $response = [
                'status' => 200,
                'msg' => 'Success get kelas',
                'data' => $items
            ];
        } else {
            $response = [
                'status' => 404,
                'msg' => 'Not found',
                'data' => null
            ];
        }

        echo json_encode($response);
    }
    function faq()
    {
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url('faq');
        $data['meta_img'] = '';
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | FAQ';
        // $data['script'][] = $this->js_path() . 'asclepio_go.js';
        $page['content']  = $this->load->view('front/faq', $data, true);
        $this->load->view('front/layout', $page);
    }
    function cart()
    {
        $data['meta_title']   = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc']    = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url']     = base_url();
        $data['meta_img']     = '';
              $user_id        = $this->session->userdata('id');
        $data['title']        = 'Kelas Online Kedokteran #1 di Indonesia | Cart';

        if ($user_id == '') {
            redirect(base_url('login'));
        } else {
            $data['script'][] = '//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js';
            $data['script'][] = $this->js_path() . 'booking.js';
            $data['data']     = $this->query->get_query("SELECT k.* FROM cart c JOIN kelas k ON c.`product_id` = k.`id` WHERE c.user_id = $user_id")->result();
            $page['content']  = $this->load->view('front/cart', $data, true);
        }

        $this->load->view('front/layout', $page);
    }
    function payment($code)
    {
        $data['meta_title']   = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc']    = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url']     = base_url();
        $data['meta_img']     = '';
        $user_id = $this->session->userdata('id');
        $data['title']        = ' Kelas Online Kedokteran #1 di Indonesia | Payment';
        $data['script'][] = $this->js_path() . 'booking.js';
        $transaksi_detail = $this->query->get_data_simple('transaksi' , ['kode_transaksi' => $code])->row();
        if($transaksi_detail->metode_pembayaran == 'manual'){

            $data['detail']   = $transaksi_detail;
            $page['content']  = $this->load->view('front/manual', $data, true);

        } else {

            if ($user_id == '') {
                redirect(base_url('login'));
            } else {
                $data['transaction'] = $this->query->get_data_simple('transaksi', ['kode_transaksi' => $code])->row();
                if ($data['transaction']->total == 0) {
                    redirect(base_url('profile'));
                }
                $cek = $this->cek_status($code);
                // print_r($cek->payment_code);
                if ($cek->status_code != 404) {
                    if ($cek->transaction_status == 'settlement' || $cek->transaction_status == 'pending' || $cek->transaction_status == 'capture') {
                        redirect('Booking/finish/?order_id=' . $code . '&status_code=201&transaction_status=pending');
                    } else if ($cek->transaction_status == 'expired' || $cek->transaction_status == 'deny' || $cek->transaction_status == 'cancel') {
                        redirect('profile');
                    }
                }
            }
    
            $page['content']  = $this->load->view('front/payment', $data, true);

        }
        

        // $data['data'] = $this->query->get_query("SELECT k.* FROM cart c JOIN kelas k ON c.`product_id` = k.`id` WHERE c.user_id = $user_id")->row();

        $this->load->view('front/layout', $page);
    }
    function cek_status($order_id)
    {
        $server_key = 'Mid-server-1Xd5iajkcLSzFTtyymFARow8';
        $token = base64_encode($server_key);
        /* Endpoint */
        $url = 'https://api.midtrans.com/v2/' . $order_id . '/status';

        /* eCurl */
        $curl = curl_init($url);

        /* Define content type */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization:Basic ' . $token,
        ));

        /* Return json */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        /* make request */
        $result = curl_exec($curl);
        return json_decode($result);
    }
    function verif_kelas($token)
    {
        if ($this->session->userdata('id') == '') {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Harap login terlebih dahulu untuk verifikasi kelas gratis Anda');
            redirect('/login?token=' . $token);
        }

        $cek_kelas = $this->query->get_data_simple('kelas', ['token' => $token])->row();
        $trans_detail_id = $this->query->get_query("SELECT b.id AS transaksi_detail_id FROM transaksi a JOIN transaksi_detail b ON a.id = b.`transaksi_id` WHERE a.`user_id` = " . $this->session->userdata('id') . " AND b.`product_id` = $cek_kelas->id ")->row()->transaksi_detail_id;
        $update = $this->query->get_query("UPDATE transaksi_detail SET `status`= 'success' WHERE id = $trans_detail_id");
        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil verifikasi kelas');
            redirect('/profile');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal verifikasi kelas');
            redirect(base_url());
        }
    }
    function profile($cat = null, $status = null)
    {
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';
        $user_id = $this->session->userdata('id');
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Profile';
        $data['script'][] = $this->js_path() . 'profile.js';
        $data['script'][] = $this->js_path() . 'booking.js';
        // $data['script'][] = $this->js_path() . 'following_class.js';
        $data['script'][] = $this->js_path() . 'rating.js';
        $data['profile'] = $this->query->get_data_simple('user', ['id' => $this->session->userdata('id')])->row();
        if ($cat == '') {
            if ($user_id == '') {
                redirect(base_url('login'));
            } else {
                $page['content']  = $this->load->view('front/profile', $data, true);
            }
        } else if ($cat ==  'pemesanan') {
            if ($user_id == '') {
                redirect(base_url('login'));
            } else {
                $data['status'] = $status;
                $page['content']  = $this->load->view('front/profile_pemesanan', $data, true);
            }
        } else if ($cat ==  'kelas') {
            if ($user_id == '') {
                redirect(base_url('login'));
            } else {
                $data['script'][] = $this->js_path() . 'following_class.js';
                $page['content']  = $this->load->view('front/profile_following_class', $data, true);
            }
        } else if ($cat ==  'voucher') {
            if ($user_id == '') {
                redirect(base_url('login'));
            } else {
                $page['content']  = $this->load->view('front/profile_voucher', $data, true);
            }
        } else if ($cat ==  'tiket') {
            if ($user_id == '') {
                redirect('/login?url=redirect_to_ticket');
            } else {
                $page['content']  = $this->load->view('front/profile_tiket', $data, true);
            }
        }
        // if ($user_id == '') {
        //     redirect(base_url('login'));
        // } else {

        // }

        $this->load->view('front/layout', $page);
    }
    function about()
    {
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'about'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'about'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'about'])->row()->meta_keyword;
        $data['meta_url'] = base_url('about');
        $data['meta_img'] = '';
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | About';
        $data['caption'] = $this->query->get_data_simple('caption', ['id' => 1])->row();
        $data['testimoni'] = $this->query->get_query("SELECT k.judul_kelas,u.nama_lengkap,u.universitas,r.rating,r.ulasan FROM ulasan r JOIN kelas k ON r.kelas_id = k.id JOIN `user` u ON r.`user_id` = u.id ORDER BY r.id DESC")->result();
        // $data['script'][] = $this->js_path() . 'asclepio_go.js';
        $page['content']  = $this->load->view('front/about', $data, true);
        $this->load->view('front/layout', $page);
    }
    function following_class()
    {
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';
        $user_id = $this->session->userdata('id');
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Kelas yang sudah diikuti';
        $data['script'][] = $this->js_path() . 'following_class.js';
        $data['script'][] = $this->js_path() . 'rating.js';
        if ($user_id == '') {
            redirect(base_url('login'));
        } else {
            $page['content']  = $this->load->view('front/following_class', $data, true);
        }

        $this->load->view('front/layout', $page);
    }
    function benefit($id)
    {   

        $kelas                = $this->query->get_data_simple('kelas', ['id' => $id])->row();

        $data['meta_title']   = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc']    = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url']     = base_url();
        $data['meta_img']     = '';
        $user_id              = $this->session->userdata('id');
        $data['title']        =  ' Kelas Online Kedokteran #1 di Indonesia | Benefit';
        $data['data']         = $this->query->get_data_simple('kelas', ['id' => $id])->row();
        $data['script'][]     = $this->js_path() . 'profile.js';   
        if ($user_id == '') {
            redirect(base_url('login'));
        } else {

            if ($kelas->tipe_kelas == 'banyak_pertemuan') {
                $count = $this->query->get_query("SELECT COUNT(link_materi_rekaman) AS jumlah_materi FROM  kelas_materi WHERE kelas_id = $id AND link_materi_rekaman != '' ")->row();
                if ($count->jumlah_materi == 0) {
                    $data['script'][]     = $this->js_path() . 'profile.js';
                    $page['content']  = $this->load->view('front/benefit', $data, true);
                } else {
                    $data['data']    = $kelas;
                    $data['materi']   = $this->query->get_data_simple('kelas_materi' , ['kelas_id' => $id])->result();
                    $page['content']  = $this->load->view('front/benefit_multiple_class', $data, true);
                }

            } else {
                 
                 $page['content']  = $this->load->view('front/benefit', $data, true);
            }
           
        }




        $this->load->view('front/layout', $page);
    }
    function setting()
    {
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';
        $user_id = $this->session->userdata('id');
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Setting';
        if ($user_id == '') {
            redirect(base_url('login'));
        } else {
            $page['content']  = $this->load->view('front/setting', $data, true);
        }
        // $data['script'][] = $this->js_path() . 'asclepio_go.js';

        $this->load->view('front/layout', $page);
    }
    function payment_status($code)
    {
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';

        $server_key = 'Mid-server-1Xd5iajkcLSzFTtyymFARow8';
        $token = base64_encode($server_key);
        /* Endpoint */
        $url = 'https://api.midtrans.com/v2/' . $code . '/status';

        /* eCurl */
        $curl = curl_init($url);

        /* Define content type */
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Accept:application/json',
            'Content-Type:application/json',
            'Authorization:Basic ' . $token,
        ));

        /* Return json */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        /* make request */
        $result = curl_exec($curl);
        // print_r(json_decode($result));
        // exit;
        $data['title']       =  ' Kelas Online Kedokteran #1 di Indonesia | Pembayaran';
        $data['script'][] = $this->js_path() . 'booking.js';
        $data['script'][] = $this->js_path() . 'wait_payment.js';
        $data['data'] = json_decode($result);
        if (json_decode($result)->transaction_status == 'pending') {
            $page['content']  = $this->load->view('front/wait_payment', $data, true);
        } else if (json_decode($result)->transaction_status == 'settlement') {
            $page['content']  = $this->load->view('front/transaction_success', $data, true);
        } else if (json_decode($result)->transaction_status == 'expire') {
            $page['content']  = $this->load->view('front/transaction_expired', $data, true);
        }
        $this->load->view('front/layout', $page);
    }

    function save_topik()
    {
        if ($this->input->post('topik')) {
            $topik = count($this->input->post('topik'));
            for ($i = 0; $i < $topik; $i++) {
                $data_topik[] = array(
                    'user_id' => $this->session->userdata('id'),
                    'topik_id' => $this->input->post('topik')[$i],
                );
            }
            $this->query->insert_batch('user_topik', $data_topik);
        }
        redirect(base_url());
    }

    function subscribe()
    {
        $email = $this->input->post('email');

        $cek = $this->query->get_data_simple('subscribe', ['email' => $email])->row();
        if ($cek) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Oops, Kamu sudah pernah subscribe menggunakan email ini');
            redirect($_SERVER['HTTP_REFERER']);
        } else {
            $save = $this->query->save_data('subscribe', ['email' => $email]);
            if ($save) {
                $this->session->set_flashdata('msg_type', 'success');
                $this->session->set_flashdata('msg', 'Berhasil, Kamu akan mendapat notifikasi jika website ini sudah launching');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('msg_type', 'error');
                $this->session->set_flashdata('msg', 'Gagal');
                redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }

    function reminder()
    {
        $today_time = strtotime(date("Y-m-d"));
        $launch_time = strtotime(date("2022-02-02"));

        if ($today_time == $launch_time) {
            $cek_trans = $this->query->get_data_simple("subscribe", null)->result();
            $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();

            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPAuth = true; // enable SMTP authentication
            $mail->SMTPAutoTLS = true; // enable SMTP authentication
            $mail->SMTPSecure = "tls"; // sets the prefix to the servier
            $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
            $mail->Port = 587; // set the SMTP port for the GMAIL server
            $mail->Username = 'asclepio.management@gmail.com'; // GMAIL username
            $mail->Password = 'Asclepio1Milyar!'; // GMAIL password
            foreach ($cek_trans as $ct) {
                // print_r($ct);
                $parsing = ['email' => $ct->email];
                $mail->ClearAllRecipients();
                $mail->AddAddress($ct->email);
                $mail->SetFrom('asclepio.management@gmail.com', 'Asclepio');
                $mail->Subject = 'Reminder';
                $mail->Body = $this->load->view('front/mail_launch', $parsing, true);
                $mail->isHTML(true);


                try {
                    $mail->Send();
                    print_r($mail->ErrorInfo);
                } catch (Exception $e) {
                    print_r($mail->ErrorInfo);
                }
            }
        }
    }

    function manual($transaction_code){

        $transaction        = $this->query->get_data_simple('transaksi' , ['kode_transaksi' => $transaction_code])->row();
        $transaction_detail = $this->query->get_data_simple('transaksi_detail' , ['transaksi_id' => $transaction->id] )->result();
        $response           = [
            'transaksi'     => $transaction,
            'transaksi_det' => $transaction_detail
        ];

        $user = 'select manual_no_rekening,manual_nama_rekening,manual_nama_bank from user where id = '.$this->session->userdata('id');
        $data['user']   = $this->query->get_query($user)->row();

        $data['response']     = $response;
        $data['title']        = ' Kelas Online Kedokteran #1 di Indonesia | Asclepio Login';
        $data['meta_title']   = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc']    = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url']     = base_url();
        $data['meta_img']     = '';
        $data['script'][] = $this->js_path() . 'manual.js';
        $page['content']  = $this->load->view('front/manual', $data, true);
        $this->load->view('front/layout', $page);
    }

    function bundling($class_id = null){
            $class_detail = $this->query->get_data_simple('kelas' , ['md5(id)' => $class_id]);
            if($class_detail->num_rows() == 0){
                $this->session->set_flashdata('msg_type', 'warning');
                $this->session->set_flashdata('msg', 'Kelas tidak ditemukan');
                redirect( base_url('asclepedia') );
            } else {

                if($class_detail->row()->tools_price > 0){
                    if( $this->session->userdata('id') !== null ){
    
                        $data['title']        = 'Asclepedia Bundling';
                        $data['meta_title']   = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
                        $data['meta_desc']    = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
                        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
                        $data['meta_url']     = base_url();
                        $data['meta_img']     = '';
                        $data['detail']       = $this->query->get_data_simple('user' , ['id' => $this->session->userdata('id')])->row();
                        $data['kelas_id']     = $class_detail->row()->id;
                        $data['script'][]     = $this->js_path() . 'bundling.js';
                        $page['content']      = $this->load->view('front/bundling', $data, true);
                        $this->load->view('front/layout', $page);
                        
            
                    } else {
                        
                        redirect( base_url('register') );
                    }
                } else {
                    $this->session->set_flashdata('msg_type', 'warning');
                    $this->session->set_flashdata('msg', 'Tidak ada bundling untuk kelas ini');
                    redirect( base_url('asclepedia') );
                }

            }
    }
}
