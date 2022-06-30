<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asclepiogo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->library('pagination');
        $this->load->helper('string');
        // ini_set('display_erros' , 0);
    }

    // private $tbl = 'categories';

    private function js_path()
    {
        return base_url() . 'assets/backend/js/';
    }
    function get_pemateri()
    {
        $data = $this->query->get_data_simple('pemateri', ['is_delete' => 0])->result();
        $response = [
            'data' => $data
        ];
        echo json_encode($response);
    }
    function save_kelas()
    {
        $config['upload_path']   = './assets/uploads/kelas/asclepio_go';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        $_FILES['images']['name'] = $_FILES['thumbnail']['name'];
        $_FILES['images']['type'] = $_FILES['thumbnail']['type'];
        $_FILES['images']['tmp_name'] = $_FILES['thumbnail']['tmp_name'];
        $_FILES['images']['error'] = $_FILES['thumbnail']['error'];
        $_FILES['images']['size'] = $_FILES['thumbnail']['size'];

        $gform = ($this->input->post('gform')) ? $this->input->post('gform') : '';
        $youtube = ($this->input->post('youtube')) ? $this->input->post('youtube') : '';
        $token = random_string('alnum', 16);

        $this->upload->initialize($config);
        $this->upload->do_upload('images');
        $fileData = $this->upload->data();
        $uploadData = $fileData['file_name'];
        $data = [
            'judul_kelas' => $this->input->post('judul_kelas'),
            'topik_id' => $this->input->post('topik'),
            'deskripsi_kelas' => $this->input->post('deskripsi_kelas'),
            'kategori_go' => $this->input->post('kategori'),
            'tgl_kelas' => $this->input->post('year') . '-' . $this->input->post('month') . '-' . $this->input->post('date'),
            'waktu_mulai' => $this->input->post('waktu_mulai'),
            'waktu_akhir' => $this->input->post('waktu_akhir'),
            'jenis_kelas' => 'asclepio_go',
            'early_price'     => str_replace(',', '', $this->input->post('early_price')),
            'late_price'      => str_replace(',', '', $this->input->post('late_price')),
            'link_zoom' => $this->input->post('link_zoom'),
            'slug' => url_title($this->input->post('judul_kelas'), 'dash', true),
            'gform_url'       => $gform,
            'youtube'       => $youtube,
            'token'       => $token,
            'thumbnail' => $uploadData,
            'limit' => $this->input->post('limit'),
        ];
        $save = $this->query->insert_for_id('kelas', null, $data);
        $id = $save->output;

        $nama_pemateri = count($this->input->post('pemateri'));
        $judul_materi = count($this->input->post('judul_materi'));
        // $free_member = count($this->input->post('free_member'));

        if ($this->input->post('free_member')) {
            $free_member   = count($this->input->post('free_member'));

            for ($i = 0; $i < $free_member; $i++) {
                $member = array(
                    'user_id' => $this->input->post('free_member')[$i],
                    'kode_transaksi' => 'ASC' . date("YmdHis") . $i,
                    'total' => 0,
                    'status' => 'paid',
                    'metode_pembayaran' => 'free'
                );
                $save_trans = $this->query->insert_for_id('transaksi', null, $member);
                $trans_id = $save_trans->output;

                $detail[] = array(
                    'transaksi_id' => $trans_id,
                    'product_id' => $id,
                    'harga' => 0,
                    'diskon' => 0,
                    'total_harga' => 0,
                    'status' => 'success',
                );
            }
            $this->query->insert_batch('transaksi_detail', $detail);
        }

        for ($i = 0; $i < $nama_pemateri; $i++) {
            $pemateri[] = array(
                'kelas_id' => $id,
                'pemateri_id' => $this->input->post('pemateri')[$i],
            );
        }
        for ($i = 0; $i < $judul_materi; $i++) {
            $materi[] = array(
                'kelas_id' => $id,
                'judul_materi' => $this->input->post('judul_materi')[$i],
                'deskripsi_materi' => $this->input->post('deskripsi_materi')[$i],
                'durasi_materi' => $this->input->post('durasi_materi')[$i],
            );
        }
        for ($i = 0; $i < $free_member; $i++) {
            $member[] = array(
                'product_id' => $id,
                'user_id' => $this->input->post('free_member')[$i],
                'kode_transaksi' => 'ASC' . date("YmdHis") . $i,
                'harga' => 0,
                'diskon' => 0,
                'total' => 0,
                'status' => 'paid',
                'metode_pembayaran' => 'free'
            );
        }

        $this->update_log($id, $this->input->post('link_zoom'));

        if ($save) {

            $this->query->insert_batch('kelas_pemateri', $pemateri);
            $this->query->insert_batch('kelas_materi', $materi);

            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil tambah data');
            redirect('/Admin/asclepio_go');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal tambah data');
            redirect('/Admin/asclepio_go');
        }
    }
    function do_edit($publish = null)
    {
        $id = $this->input->post('kelas_id');
        $config['upload_path']   = './assets/uploads/kelas/asclepio_go';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        $_FILES['images']['name'] = $_FILES['thumbnail_edit']['name'];
        $_FILES['images']['type'] = $_FILES['thumbnail_edit']['type'];
        $_FILES['images']['tmp_name'] = $_FILES['thumbnail_edit']['tmp_name'];
        $_FILES['images']['error'] = $_FILES['thumbnail_edit']['error'];
        $_FILES['images']['size'] = $_FILES['thumbnail_edit']['size'];

        $gform = ($this->input->post('gform_edit')) ? $this->input->post('gform_edit') : '';
        $youtube = ($this->input->post('youtube_edit')) ? $this->input->post('youtube_edit') : '';

        $this->upload->initialize($config);
        if ($publish == null) {
            $in_public = 0;
        } else {
            $in_public = 1;
        }
        $data = [
            'judul_kelas'     => $this->input->post('judul_kelas_edit'),
            'topik_id'        => $this->input->post('topik_edit'),
            'deskripsi_kelas' => $this->input->post('deskripsi_kelas_edit'),
            'kategori_go'     => $this->input->post('kategori_edit'),
            'tgl_kelas'       => $this->input->post('year_edit') . '-' . $this->input->post('month_edit') . '-' . $this->input->post('date_edit'),
            'waktu_mulai'     => $this->input->post('waktu_mulai_edit'),
            'waktu_akhir'     => $this->input->post('waktu_akhir_edit'),
            'jenis_kelas'     => 'asclepio_go',
            'early_price'     => str_replace(',', '', $this->input->post('early_price_edit')),
            'late_price'      => str_replace(',', '', $this->input->post('late_price_edit')),
            'link_zoom'       => $this->input->post('link_zoom_edit'),
            'slug'            => url_title($this->input->post('judul_kelas_edit'), 'dash', true),
            'gform_url'       => $gform,
            'youtube'         => $youtube,
            'limit'           => $this->input->post('limit_edit'),
            'in_public'       => $in_public,
            'public_date'     => date("Y-m-d h:i:s"),
        ];

        if ($this->upload->do_upload('images')) {
            // Uploaded file data
            if ($id != null) {
                $get = $this->query->get_data_simple('kelas', ['id' => $id])->row();
                if ($get) {
                    $old_path = './assets/uploads/kelas/asclepio_go/' . $get->thumbnail;
                    if (file_exists($old_path)) {
                        unlink($old_path);
                    }
                }
                $fileData   = $this->upload->data();
                $uploadData = $fileData['file_name'];

                $data['thumbnail'] = $uploadData;
            } else {
                echo $this->upload->display_errors();
            }
        }
        $update = $this->query->insert_for_id('kelas', ['id' => $id], $data);


        if ($this->input->post('free_member_edit')) {
            $free_member   = count($this->input->post('free_member_edit'));

            for ($i = 0; $i < $free_member; $i++) {
                $member = array(
                    'user_id' => $this->input->post('free_member_edit')[$i],
                    'kode_transaksi' => 'ASC' . date("YmdHis") . $i,
                    'total' => 0,
                    'status' => 'paid',
                    'metode_pembayaran' => 'free'
                );
                $save_trans = $this->query->insert_for_id('transaksi', null, $member);
                $trans_id = $save_trans->output;

                $detail[] = array(
                    'transaksi_id' => $trans_id,
                    'product_id' => $id,
                    'harga' => 0,
                    'diskon' => 0,
                    'total_harga' => 0,
                    'status' => 'success',
                );
            }
            $this->query->insert_batch('transaksi_detail', $detail);
        }
        if ($this->input->post('pemateri_edit')) {
            $this->query->delete_data('kelas_pemateri', ['kelas_id' => $id]);
            $nama_pemateri = count($this->input->post('pemateri_edit'));
            for ($i = 0; $i < $nama_pemateri; $i++) {
                $pemateri[] = array(
                    'kelas_id' => $id,
                    'pemateri_id' => $this->input->post('pemateri_edit')[$i],
                );
            }
            $this->query->insert_batch('kelas_pemateri', $pemateri);
        }

        $this->update_log($id, $this->input->post('link_zoom_edit'));

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil edit data');
            redirect('/Admin/asclepio_go');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal edit data');
            redirect('/Admin/asclepio_go');
        }
    }
    function get_topik()
    {
        $data = $this->query->get_data_simple('topik', ['is_delete' => 0])->result();
        $response = [
            'data' => $data
        ];
        echo json_encode($response);
    }
    // function select_member($product_id)
    // {

    //     $transaksi = $this->query->get_query("SELECT t.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $product_id")->result();
    //     $array = [];
    //     foreach ($transaksi as $key) {

    //         $array[] = 'u_' . $key->user_id;
    //     }
    //     $opt = '';

    //     $user = $this->query->get_query("SELECT * FROM `user`")->result();


    //     $transaksi = $this->query->get_query("SELECT t.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $product_id")->result();
    //     $kelas_id = [];
    //     foreach ($transaksi as $t) {
    //         $kelas_id[] = $t->user_id;
    //     }
    //     foreach ($user as $keys) {

    //         if (in_array($keys->id, $kelas_id)) {
    //         } else {
    //             $opt .= "<option value=" . $keys->id . ">" . $keys->nama_lengkap . "</option>";
    //         }


    //     }

    //     echo $opt;
    // }
    function select_member($product_id)
    {

        $opt = '';
        //
        $pembeli = $this->query->get_query("SELECT u.id, u.nama_lengkap FROM transaksi t JOIN transaksi_detail d ON d.`transaksi_id` = t.id JOIN `user` u ON t.`user_id` = u.`id` WHERE t.status = 'paid' AND d.status = 'success' AND d.`product_id` = $product_id")->result();
        $query = "SELECT * FROM `user` WHERE";
        $i = 0;
        $len = count($pembeli);
        foreach ($pembeli as $p) {
            if ($i >= 0 && $i <= $len - 2) {
                $query .= " id != " . $p->id . " AND ";
            } else if ($i == $len - 1) {
                $query .= " id != " . $p->id;
            }
            $i++;
        }
        $non = $this->query->get_query($query)->result();

        foreach ($non as $keys) {
            $opt .= "<option value=" . $keys->id . ">" . $keys->nama_lengkap . "</option>";
        }

        echo $opt;
    }
    function load_khusus_pemateri($kelas_id)
    {

        // $get = 'SELECT a.* , b.nama_pemateri as nama FROM `kelas_pemateri` a inner join pemateri b on a.pemateri_id = b.id where a.kelas_id = '.$kelas_id;

        $kelas_pemateri = $this->query->get_data_simple('kelas_pemateri', ['kelas_id' => $kelas_id])->result();
        $array_check    = [];
        foreach ($kelas_pemateri as $d) {
            $array_check[] = $d->pemateri_id;
        }

        $kelas = $this->query->get_data_simple('pemateri', ['is_delete' => 0])->result();

        $option = '';
        foreach ($kelas as $data) {

            if (in_array($data->id, $array_check)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }

            $option .= '
            <option value="' . $data->id . '" ' . $selected . '>' . $data->nama_pemateri . '</option>
            ';
        }

        echo $option;
    }

    function load_materi($kelas_id)
    {
        $data = $this->query->get_data_simple('kelas_materi', ['kelas_id' => $kelas_id])->result();
        echo json_encode($data);
    }
    function get_kelas_detail($id)
    {

        $data = $this->query->get_data_simple('kelas', ['id' => $id])->row();

        echo json_encode(['status' => 200, 'data' => $data]);
    }
    function get_upcoming()
    {
        $type   = $_GET['type'];
        $search = $_GET['search'];
        $query1 = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND tgl_kelas >= CURDATE() AND is_delete = 0";
        if ($type != 'semua') {
            if ($search) {
                $query1 .= " AND kategori_go = '" . $type . "' AND judul_kelas LIKE '%$search%' ";
            } else {
                $query1 .= " AND kategori_go = '" . $type . "'";
            }
        } else {
            if ($search) {
                $query1 .= " AND judul_kelas LIKE '%$search%' ";
            } else {
                $query1 .= "";
            }
        }
        $kelas = $this->query->get_query($query1)->result();
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
                $harga = 'Rp.' . rupiah($new_price);
            }
            if ($k->kategori_go == 'open') {
                if ($new_price == 0) {
                    $tag = 'FREE';
                } else {
                    $tag = 'PREMIUM';
                }
                $label = 'Open Class';
            } else if ($k->kategori_go == 'private') {
                $label = 'Private Class';
                $tag   = '';
            } else {
                $label = 'Expert Class';
                $tag   = '';
            }
            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();
            $item['id'] = $k->id;
            $item['judul'] = $k->judul_kelas;
            $item['kategori'] = $label;
            $item['waktu_mulai'] = $k->waktu_mulai;
            $item['waktu_akhir'] = $k->waktu_akhir;
            $item['harga'] = $harga;
            $item['tgl_kelas'] = format_indo($k->tgl_kelas);
            $item['thumbnail'] = $k->thumbnail;
            $item['slug'] = $k->slug;
            $item['token'] = $k->token;
            $item['tag'] = $tag;
            $item['pemateri'] = $pemateri;
            $item['in_public'] = $k->in_public;
            $item['is_delete'] = $k->is_delete;
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
    function get_finished()
    {
        $type = $_GET['type'];
        $search = $_GET['search'];
        $query = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND tgl_kelas < CURDATE() AND is_delete = 0";
        if ($type != 'semua') {
            if ($search) {
                $query .= " AND kategori_go = '" . $type . "' AND judul_kelas LIKE '%$search%' ";
            } else {
                $query .= " AND kategori_go = '" . $type . "' ";
            }
        } else {
            if ($search) {
                $query .= " AND judul_kelas LIKE '%$search%' ";
            } else {
                $query .= "";
            }
        }
        $kelas = $this->query->get_query($query)->result();
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
                $harga = 'Rp.' . rupiah($new_price);
            }
            if ($k->kategori_go == 'open') {
                if ($new_price == 0) {
                    $tag = 'FREE';
                } else {
                    $tag = 'PREMIUM';
                }
                $label = 'Open Class';
            } else if ($k->kategori_go == 'private') {
                $label = 'Private Class';
                $tag = '';
            } else {
                $label = 'Expert Class';
                $tag = '';
            }
            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();
            $item['id'] = $k->id;
            $item['judul'] = $k->judul_kelas;
            $item['kategori'] = $label;
            $item['waktu_mulai'] = $k->waktu_mulai;
            $item['waktu_akhir'] = $k->waktu_akhir;
            $item['harga'] = $harga;
            $item['tgl_kelas'] = format_indo($k->tgl_kelas);
            $item['token'] = $k->token;
            $item['thumbnail'] = $k->thumbnail;
            $item['slug'] = $k->slug;
            $item['pemateri'] = $pemateri;
            $item['tag'] = $tag;
            $item['in_public'] = $k->in_public;
            $item['is_delete'] = $k->is_delete;
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
    function get_unbenefit()
    {
        $sort = $_GET['sort'];
        $search = $_GET['search'];
        $query = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND link_rekaman IS NULL AND link_materi IS NULL AND is_delete = 0";
        if ($sort == 'terbaru') {
            if ($search) {
                $query .= " AND judul_kelas LIKE '%$search%' ORDER BY id DESC";
            } else {
                $query .= " ORDER BY id DESC";
            }
        } else {
            if ($search) {
                $query .= " AND judul_kelas LIKE '%$search%' ORDER BY id ASC";
            } else {
                $query .= " ORDER BY id ASC";
            }
        }
        $kelas = $this->query->get_query($query)->result();
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
                $harga = 'Rp.' . rupiah($new_price);
            }
            if ($k->kategori_go == 'open') {
                if ($new_price == 0) {
                    $tag = 'FREE';
                } else {
                    $tag = 'PREMIUM';
                }
                $label = 'Open Class';
            } else if ($k->kategori_go == 'private') {
                $label = 'Private Class';
                $tag = '';
            } else {
                $label = 'Expert Class';
                $tag = '';
            }
                  $pemateri      = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();
            $item['id']          = $k->id;
            $item['judul']       = $k->judul_kelas;
            $item['kategori']    = $label;
            $item['waktu_mulai'] = $k->waktu_mulai;
            $item['waktu_akhir'] = $k->waktu_akhir;
            $item['harga']       = $harga;
            $item['tgl_kelas']   = format_indo($k->tgl_kelas);
            $item['thumbnail']   = $k->thumbnail;
            $item['slug']        = $k->slug;
            $item['pemateri']    = $pemateri;
            $item['tag']         = $tag;
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

    function detail($id)
    {
        $kelas = $this->query->get_query("SELECT * FROM kelas WHERE id = $id")->row();
        $items = [];
        $date = $kelas->created_date;
        $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));

        if ($new_date > date('Y-m-d')) {
            $new_price = $kelas->early_price;
        } else {
            $new_price = $kelas->late_price;
        }
        if ($new_price == 0) {
            $harga = 'FREE';
        } else {
            $harga = 'Rp.' . rupiah($new_price);
        }
        if ($kelas->kategori_go == 'open') {
            if ($new_price == 0) {
                $tag = 'FREE';
            } else {
                $tag = 'PREMIUM';
            }
            $label = 'Open Class';
        } else if ($kelas->kategori_go == 'private') {
            $label = 'Private Class';
            $tag = '';
        } else {
            $label = 'Expert Class';
            $tag = '';
        }
        $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $kelas->id")->result();
        $item['id'] = $kelas->id;
        $item['judul'] = $kelas->judul_kelas;
        $item['kategori'] = $label;
        $item['waktu_mulai'] = $kelas->waktu_mulai;
        $item['waktu_akhir'] = $kelas->waktu_akhir;
        $item['harga'] = $harga;
        $item['tgl_kelas'] = format_indo($kelas->tgl_kelas);
        $item['thumbnail'] = $kelas->thumbnail;
        $item['slug'] = $kelas->slug;
        $item['pemateri'] = $pemateri;
        $item['link_rekaman'] = $kelas->link_rekaman;
        $item['link_materi'] = $kelas->link_materi;
        $item['link_sertifikat'] = $kelas->link_sertifikat;
        $item['password_materi'] = $kelas->password_materi;
        $item['tag'] = $tag;
        array_push($items, $item);

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
    function edit_benefit()
    {
        $kelas_id = $this->input->post('kelas_id');
        $rekaman = $this->input->post('link_rekaman');
        $materi = $this->input->post('link_materi');
        $sertifikat = $this->input->post('link_sertifikat');
        $password = $this->input->post('password_materi');
        $update = $this->query->update_data('kelas', ['id' => $kelas_id], ['link_rekaman' => $rekaman, 'link_materi' => $materi, 'link_sertifikat' => $sertifikat,  'password_materi' => $password]);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil update benefit');
            redirect('/Admin/asclepio_go');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal update benefit');
            redirect('/Admin/asclepio_go');
        }
    }
    function get_with_benefit($page = 0)
    {
        $limit  = $this->input->post('limit');
        $sort   = $this->input->post('sort');
        $search = $this->input->post('search');
        $query  = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepio_go' AND link_rekaman IS NOT NULL AND link_materi IS NOT NULL AND is_delete = 0";
        $config['base_url'] = base_url() . 'Asclepiogo/get_with_benefit/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;

        if ($sort == 'terbaru') {
            if ($search) {
                $query .= " AND judul_kelas LIKE '%$search%' ORDER BY id DESC LIMIT $limit , $page";
            } else {
                $query .= " ORDER BY id DESC LIMIT $limit , $page";
            }
        } else {
            if ($search) {
                $query .= " AND judul_kelas LIKE '%$search%' ORDER BY id ASC LIMIT $limit , $page";
            } else {
                $query .= " ORDER BY id ASC LIMIT $limit , $page";
            }
        }
        $data = $this->query->get_query($query)->result();
        $this->pagination->initialize($config);

        $items = [];
        foreach ($data as $d) {
            $item['id'] = $d->id;
            $item['judul_kelas'] = $d->judul_kelas;
            $item['kategori'] = $d->kategori_go;
            $item['tgl_kelas'] = format_indo($d->tgl_kelas);
            $item['link_rekaman'] = $d->link_rekaman;
            $item['link_materi'] = $d->link_materi;
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
    function delete_kelas($id)
    {
        $is_delete = $this->query->get_data('is_delete', 'kelas', ['id' => $id])->row()->is_delete;
        if ($is_delete == 1) {
            $data_hapus = 0;
        } else {
            $data_hapus = 1;
        }
        $delete = $this->query->update_data('kelas', ['id' => $id], ['is_delete' => $data_hapus]);
        if ($delete) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil hapus data');
            redirect('/Admin/asclepio_go');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal hapus data');
            redirect('/Admin/asclepio_go');
        }
    }
    function publish_kelas($id)
    {
        $in_public = $this->query->get_data('in_public', 'kelas', ['id' => $id])->row()->in_public;
        if ($in_public == 1) {
            $data_public = 0;
        } else {
            $data_public = 1;
        }
        $update = $this->query->update_data('kelas', ['id' => $id], ['in_public' => $data_public, 'public_date' => date("Y-m-d h:i:s")]);
        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil update data');
            redirect('/Admin/asclepio_go');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal update data');
            redirect('/Admin/asclepio_go');
        }
    }

    function update_log($id, $link)
    {
        $data = [
            'kelas_id'     => $id,
            'link_zoom'    => $link,
        ];
        $this->query->insert_for_id('log_update_link', null, $data);
    }
}
