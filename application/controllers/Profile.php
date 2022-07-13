<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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

    function edit($user_id)
    {
        $email = $this->input->post('email');
        $nama_lengkap = $this->input->post('nama_lengkap');
        $gender = $this->input->post('gender');
        $provinsi_id = $this->input->post('provinsi_id');
        $provinsi_name = $this->input->post('provinsi_name');
        $kota = $this->input->post('kota');
        $univ = $this->input->post('univ');
        $instansi = $this->input->post('instansi');
        $tentang = $this->input->post('tentang');
        $no_wa = $this->input->post('no_wa');
        $ig = $this->input->post('ig');
        $pass = ($this->input->post('password')) ? $this->input->post('password') : '';
        $config['upload_path']   = './assets/uploads/member';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        $where = ['id' => $user_id];

        if ($this->input->post('topik')) {
            $this->query->delete_data('user_topik', ['user_id' => $user_id]);
            $topik = count($this->input->post('topik'));
            for ($i = 0; $i < $topik; $i++) {
                $data_topik[] = array(
                    'user_id' => $user_id,
                    'topik_id' => $this->input->post('topik')[$i],
                );
            }
            $this->query->insert_batch('user_topik', $data_topik);
        }
        if ($pass == '') {
            $data = [
                'email' => $email,
                'nama_lengkap' => $nama_lengkap,
                'gender' => $gender,
                'provinsi_id' => $provinsi_id,
                'provinsi_name' => $provinsi_name,
                'kota' => $kota,
                'universitas' => $univ,
                'instansi' => $instansi,
                'tentang' => $tentang,
                'no_wa' => $no_wa,
                'ig' => $ig,

            ];
        } else {
            $data = [
                'email' => $email,
                'nama_lengkap' => $nama_lengkap,
                'provinsi_id' => $provinsi_id,
                'provinsi_name' => $provinsi_name,
                'kota' => $kota,
                'universitas' => $univ,
                'tentang' => $tentang,
                'no_wa' => $no_wa,
                'ig' => $ig,
                'password' => md5($pass),

            ];
        }

        if ($this->upload->do_upload('foto_profil')) {
            // Uploaded file data
            if ($user_id != null) {
                $get = $this->query->get_data_simple('user', $where)->row();
                if ($get) {
                    $old_path = './assets/uploads/member/' . $get->foto_profil;
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];

                $data['foto_profil'] = $uploadData;

                $this->session->unset_userdata('foto_profil');
                $this->session->set_userdata('foto_profil', $uploadData);
            } else {
                echo $this->upload->display_errors();
            }
        }
        $query = $this->query->insert_for_id('user', $where, $data);
        if ($query) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect(base_url('profile'));
    }
    function get_following($user_id, $page = 0)
    {
        $limit = $this->input->post('limit');
        $query = "SELECT k.*,t.id as trans_id,t.total FROM transaksi t JOIN kelas k ON t.product_id = k.id WHERE t.user_id = $user_id AND k.tgl_kelas <= CURDATE() GROUP BY t.product_id";
        $query2 = "SELECT k.*,t.id as trans_id,t.total FROM transaksi t JOIN kelas k ON t.product_id = k.id WHERE t.user_id = $user_id AND k.tgl_kelas <= CURDATE() GROUP BY t.product_id LIMIT $limit OFFSET $page";
        $data = $this->query->get_query($query2)->result();


        $config['base_url'] = base_url() . 'Profile/get_following/' . $user_id . '/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;

        $this->pagination->initialize($config);



        $items = [];
        foreach ($data as $d) {
            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $d->id")->result();
            $is_rated = $this->query->get_query("SELECT COUNT(*) AS is_rated FROM ulasan WHERE `user_id` = $user_id AND kelas_id = $d->id")->row()->is_rated;
            $rating = $this->query->get_query("SELECT rating FROM ulasan WHERE `user_id` = $user_id AND kelas_id = $d->id")->row();
            if ($is_rated == 0) {
                $rating = 0;
            } else {
                $rating = $this->query->get_query("SELECT rating FROM ulasan WHERE `user_id` = $user_id AND kelas_id = $d->id")->row()->rating;
            }
            if ($d->jenis_kelas == 'asclepedia') {
                $kategori = $d->kategori_kelas;
            } else {
                $kategori = $d->kategori_go;
            }
            $item['id'] = $d->trans_id;
            $item['kelas_id'] = $d->id;
            $item['thumbnail'] = $d->thumbnail;
            $item['judul_kelas'] = $d->judul_kelas;
            $item['jenis_kelas'] = $d->jenis_kelas;
            $item['kategori'] = $kategori;
            $item['tgl_kelas'] = format_indo($d->tgl_kelas);
            $item['total'] = rupiah($d->total);
            $item['waktu_mulai'] = $d->waktu_mulai;
            $item['waktu_akhir'] = $d->waktu_akhir;
            $item['pemateri'] = $pemateri;
            $item['is_rated'] = $is_rated;
            $item['rating'] = start_created($rating);
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
        $response['pagination'] = $this->pagination->create_links();

        echo json_encode($response);
    }

    function kelas_detail($id)
    {
        $kelas = $this->query->get_data_simple('kelas', ['id' => $id])->row();
        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $id")->result();
        if ($kelas->jenis_kelas == 'asclepedia') {
            $kategori = $kelas->kategori_kelas;
        } else {
            $kategori = $kelas->kategori_go;
        }
        $item['id'] = $kelas->id;
        $item['judul'] = $kelas->judul_kelas;
        $item['kategori'] = $kategori;
        $item['pemateri'] = $pemateri;

        if ($kelas) {
            $response = [
                'data' => $item
            ];
        } else {
            $response = [
                'data' => null
            ];
        }
        echo json_encode($response);
    }

    function download_certificate(){
     
        $data = [];
        // $this->load->view('front/certificate_user');
       
        $this->load->library('pdf');

        
        $this->pdf->setPaper('A4', 'landscape');
        $this->pdf->set_option('isRemoteEnabled', true);
        $this->pdf->filename = "certificate.pdf";
        $this->pdf->load_view('front/certificate_user', $data);
            
    }

    function add_review()
    {
        $user_id  = $this->input->post('user_id');
        $kelas_id = $this->input->post('kelas_id');
        $rating   = $this->input->post('rating');
        $ulasan   = $this->input->post('ulasan');

        $check = $this->query->get_data_simple('kelas' , ['id' => $kelas_id])->row();
        

        $data = [
            'user_id'         => $user_id,
            'kelas_id'        => $check->id,
            'actual_kelas_id' => $check->actual_kelas_id,
            'rating'          => $rating,
            'ulasan'          => $ulasan,
        ];
        $save = $this->query->save_data('ulasan', $data);

        if ($save) {
            $response = [
                'status' => 200
            ];
        } else {
            $response = [
                'status' => 400
            ];
        }

        echo json_encode($response);
    }

    function get_voucher($code = null)
    {

        // echo $this->db->last_query();
        if ($code) {
            $query = $this->query->get_query("SELECT * FROM voucher WHERE code_voucher = '$code'")->result();
            // $cek = $this->query->get_query("SELECT * FROM voucher WHERE code_voucher LIKE '%" . $code . "%'")->row();
            if ($query) {
                $response = [
                    'status' => 200,
                    'data' => $query
                ];
            } else {
                $response = [
                    'status' => 404,
                    'data' => null
                ];
            }
        } else {
            $response = [
                'status' => 404,
                'data' => null
            ];
        }

        echo json_encode($response);
    }

    function redeem()
    {
        $user = $this->input->post('user');
        $id = $this->input->post('id');

        $update = $this->query->get_query("UPDATE voucher SET is_redeem = 1 , redeem_by = $user WHERE id = $id");
        if ($update) {
            $response = [
                'status' => 200,
                'msg_type' => 'success',
                'msg' => 'Voucher berhasil di redeem',
            ];
        } else {
            $response = [
                'status' => 400,
                'msg_type' => 'error',
                'msg' => 'Voucher gagal di redeem',
            ];
        }

        echo json_encode($response);
    }
}
