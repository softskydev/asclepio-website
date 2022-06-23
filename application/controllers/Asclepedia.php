<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asclepedia extends CI_Controller
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
    function get_pemateri()
    {
        $data = $this->query->get_data_simple('pemateri', ['is_delete' => 0])->result();
        $response = [
            'data' => $data
        ];
        echo json_encode($response);
    }
    function get_topik()
    {
        $data = $this->query->get_data_simple('topik', ['is_delete' => 0])->result();
        $response = [
            'data' => $data
        ];
        echo json_encode($response);
    }
    function save_kelas()
    {

        // debug($_POST);
        $config['upload_path']   = './assets/uploads/kelas/asclepedia';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        $_FILES['images']['name']     = $_FILES['thumbnail']['name'];
        $_FILES['images']['type']     = $_FILES['thumbnail']['type'];
        $_FILES['images']['tmp_name'] = $_FILES['thumbnail']['tmp_name'];
        $_FILES['images']['error']    = $_FILES['thumbnail']['error'];
        $_FILES['images']['size']     = $_FILES['thumbnail']['size'];

        $gform                        = ($this->input->post('gform')) ? $this->input->post('gform') : '';
        $youtube                      = ($this->input->post('youtube')) ? $this->input->post('youtube') : '';

        $token = random_string('alnum', 16);

        $this->upload->initialize($config);
        $this->upload->do_upload('images');
        $fileData   = $this->upload->data();
        $uploadData = $fileData['file_name'];
        $tahun      = $this->input->post('year');
        $bulan      = $this->input->post('month');
        $tanggal    = $this->input->post('date');
        $date_kelas = ( $this->input->post('tipe_kelas_sekali_or_banyak') == 'sekali_pertemuan') ? $tahun.'-'.$bulan.'-'.$tanggal : $this->input->post('tanggal_materi')[0];

        $data = [
            'judul_kelas'     => $this->input->post('judul_kelas'),
            'topik_id'        => $this->input->post('topik'),
            'deskripsi_kelas' => $this->input->post('deskripsi_kelas'),
            'kategori_kelas'  => $this->input->post('kategori'),
            'tgl_kelas'       => $date_kelas,
            'waktu_mulai'     => $this->input->post('waktu_mulai'),
            'waktu_akhir'     => $this->input->post('waktu_akhir'),
            'tipe_kelas'      => $this->input->post('tipe_kelas_sekali_or_banyak'),
            'jenis_kelas'     => 'asclepedia',
            'early_price'     => str_replace(',', '', $this->input->post('early_price')),
            'late_price'      => str_replace(',', '', $this->input->post('late_price')),
            'early_daterange' => str_replace('/', '-', $this->input->post('date_early')),
            'late_daterange'  => str_replace('/', '-', $this->input->post('date_late')),
            'link_zoom'       => $this->input->post('link_zoom'),
            'slug'            => url_title($this->input->post('judul_kelas'), 'dash', true),
            'gform_url'       => $gform,
            'youtube'         => $youtube,
            'thumbnail'       => $uploadData,
            'token'           => $token,
            'limit'           => $this->input->post('limit'),
        ];
        $save = $this->query->insert_for_id('kelas', null, $data);
        $id = $save->output;

        $nama_pemateri = count($this->input->post('pemateri'));
        $judul_materi  = count($this->input->post('judul_materi'));



        if ($this->input->post('free_member')) {
            $free_member   = count($this->input->post('free_member'));

            for ($i = 0; $i < $free_member; $i++) {
                $member = array(
                    'user_id'           => $this->input->post('free_member')[$i],
                    'kode_transaksi'    => 'ASC' . date("YmdHis") . $i,
                    'total'             => 0,
                    'status'            => 'paid',
                    'metode_pembayaran' => 'free'
                );
                $save_trans = $this->query->insert_for_id('transaksi', null, $member);
                $trans_id = $save_trans->output;

                $detail[] = array(
                    'transaksi_id' => $trans_id,
                    'product_id'   => $id,
                    'harga'        => 0,
                    'diskon'       => 0,
                    'total_harga'  => 0,
                    'status'       => 'success',
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
                'kelas_id'         => $id,
                'judul_materi'     => $this->input->post('judul_materi')[$i],
                'deskripsi_materi' => $this->input->post('deskripsi_materi')[$i],
                'date_materi'      => $this->input->post('tanggal_materi')[$i],
                'hour_materi'      => $this->input->post('time_materi')[$i],
                'zoom_materi'      => $this->input->post('link_materi')[$i],
                'durasi_materi'    => $this->input->post('durasi_materi')[$i],
            );
        }

        $this->update_log($id, $this->input->post('link_zoom'));

        if ($save) {

            $this->query->insert_batch('kelas_pemateri', $pemateri);
            $this->query->insert_batch('kelas_materi', $materi);
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil tambah data');
            redirect('/Admin/asclepedia');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal tambah data');
            redirect('/Admin/asclepedia');
        }
    }

    function save_only_course(){

        // debug($_POST);route

        $materi = array(
            'kelas_id'         => $this->input->post('kelas_id'),
            'judul_materi'     => $this->input->post('judul_materi'),
            'deskripsi_materi' => $this->input->post('deskripsi_materi'),
            'date_materi'      => $this->input->post('tanggal_materi'),
            'hour_materi'      => $this->input->post('time_materi'),
            'zoom_materi'      => $this->input->post('link_materi'),
            'durasi_materi'    => $this->input->post('durasi_materi'),
        );

        $this->query->insert_for_id('kelas_materi' , null , $materi);

        $this->session->set_flashdata('msg_t' , MSG_SUCCESS);
        $this->session->set_flashdata('msg' , 'Materi berhasil di tambahkan!');
        redirect( base_url('admin/kelas_detail/'.$this->input->post('kelas_id')) );
    }

    function get_upcoming()
    {
        $type    = $_GET['type'];
        $datenow = date('Y-m-d');
        $query1 = "SELECT 
                    CASE 
                        WHEN a.tipe_kelas = 'banyak_pertemuan' THEN b.date_materi 
                        WHEN a.tipe_kelas = 'sekali_pertemuan' THEN a.tgl_kelas
                    END AS tanggal_mulai , a.* , b.date_materi
                    FROM kelas a JOIN kelas_materi b ON a.id = b.kelas_id WHERE a.jenis_kelas = 'asclepedia' ";
        if ($type != '' && $type != 'semua') {
            $query1 .= ' AND kategori_kelas = "' . $type . '"';
        }
        $query1 .= " GROUP BY a.id";
        $kelas = $this->query->get_query($query1)->result();
        // echo $this->db->last_query();


        $items = [];
        foreach ($kelas as $k) {
             if ($k->tanggal_mulai >= date('Y-m-d') ) {
                if ($k->early_daterange != '') {
                    $date_range_early = $k->early_daterange;
                    $date_early_start = explode(' - ', $date_range_early)[0];
                    $date_early_end   = explode(' - ', $date_range_early)[1];
                    $date_early_start = date("Y-m-d", strtotime($date_early_start));  
                    $date_early_end   = date("Y-m-d", strtotime($date_early_end));
                    
                    if (date('Y-m-d') <= $date_early_end) {
                        $new_price = $k->early_price;
                    } else {
                        $new_price = $k->late_price;
                    }

                } else {
                    $date = $k->created_date;
                    $new_date = date("Y-m-d", strtotime("+2 day", strtotime($date)));
                    if ($new_date > date('Y-m-d')) {
                        $new_price = $k->early_price;
                    } else {
                        $new_price = $k->late_price;
                    }
                }

                if ($new_price == 0) {
                    $harga = 'FREE';
                } else {
                    $harga = 'Rp.' . rupiah($new_price);
                }
                if ($k->kategori_kelas == 'good morning knowledge') {
                    $label = 'Good morning knowledge';
                } else if($k->kategori_kelas == 'drill the case'){
                     $label = 'Drill the Case';
                }

                else {
                    $label = 'Skill Labs';
                }
                $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();

                // debug($pemateri);

                $item['id'] = $k->id;
                $item['judul'] = $k->judul_kelas;
                $item['kategori'] = $label;
                $item['waktu_mulai'] = $k->waktu_mulai;
                $item['in_public'] = $k->in_public;
                $item['waktu_akhir'] = $k->waktu_akhir;
                $item['harga'] = $harga;
                $item['tgl_kelas'] = format_indo($k->tgl_kelas);
                $item['thumbnail'] = $k->thumbnail;
                $item['slug'] = $k->slug;
                $item['pemateri'] = $pemateri;
                $item['is_delete'] = $k->is_delete;
                array_push($items, $item); 
            }
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
        $query = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND link_rekaman IS NULL AND link_materi IS NULL AND is_delete = 0";
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
            if ($k->kategori_kelas == 'good morning knowledge') {
                $label = 'Good Morning Knowledge';
            } else {
                $label = 'Skill Lab';
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
    function get_with_benefit($page = 0)
    {
        $limit = $this->input->post('limit');
        $sort = $this->input->post('sort');
        $search = $this->input->post('search');
        $query = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND link_rekaman IS NOT NULL AND link_materi IS NOT NULL AND is_delete = 0";
        $config['base_url'] = base_url() . 'Asclepedia/get_with_benefit/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;

        if ($sort == 'terbaru') {
            if ($search) {
                $query .= " AND judul_kelas LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $page";
            } else {
                $query .= " ORDER BY id DESC LIMIT $limit OFFSET $page";
            }
        } else {
            if ($search) {
                $query .= " AND judul_kelas LIKE '%$search%' ORDER BY id ASC LIMIT $limit OFFSET $page";
            } else {
                $query .= " ORDER BY id ASC LIMIT $limit OFFSET $page";
            }
        }
        $data = $this->query->get_query($query)->result();


        $this->pagination->initialize($config);


        $items = [];
        foreach ($data as $d) {
            $item['id'] = $d->id;
            $item['judul_kelas'] = $d->judul_kelas;
            $item['kategori'] = $d->kategori_kelas;
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
    function get_finished()
    {
        $type = $_GET['type'];
        $search = $_GET['search'];
        $query = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND tgl_kelas < CURDATE() AND is_delete = 0";
        if ($type != 'semua') {
            if ($search) {
                $query .= " AND kategori_kelas = '" . $type . "' AND judul_kelas LIKE '%$search%' ";
            } else {
                $query .= " AND kategori_kelas = '" . $type . "' ";
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
            if ($k->kategori_kelas == 'good morning knowledge') {
                $label = 'Good morning knowledge';
            } else {
                $label = 'Skill Lab';
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

    function do_edit($id = null)
    {
        // debug($_FILES);
        // exit;   
        $errormsg = '';
        $gform    = ($this->input->post('gform_edit')) ? $this->input->post('gform_edit') : '';
        $youtube  = ($this->input->post('youtube_edit')) ? $this->input->post('youtube_edit') : '';

       
       
        $data = [
            'judul_kelas'     => $this->input->post('judul_kelas'),
            'kategori_kelas'  => $this->input->post('kategori_kelas'),
            'tipe_kelas'      => $this->input->post('tipe_kelas_sekali_or_banyak'),
            'topik_id'        => $this->input->post('topik_edit'),
            'deskripsi_kelas' => $this->input->post('deskripsi_kelas'),
            'link_zoom'       => $this->input->post('linkzoom'),
            'youtube'         => $this->input->post('linkyoutube'),
            'early_daterange' => $this->input->post('linkyoutube'),
            'late_daterange'  => $this->input->post('linkyoutube'),
            'limit'           => $this->input->post('limit'),
            'early_daterange' => str_replace('/', '-', $this->input->post('daterange_early')),
            'late_daterange'  => str_replace('/', '-', $this->input->post('daterange_late')),
            'jenis_kelas'     => 'asclepedia',
            'early_price'     => str_replace(',', '', $this->input->post('price_early')),
            'late_price'      => str_replace(',', '', $this->input->post('price_late')),
            'slug'            => $this->re_named_slug($this->input->post('judul_kelas')),
            // 'gform_url'       => $gform,
            // 'youtube'         => $youtube,
            'in_public'       => $this->input->post('status_publish'),
            'public_date'     => date("Y-m-d h:i:s"),

        ];

        if (isset($_FILES['foto_kelas']['name'])) {
            $config['upload_path']   = './assets/uploads/kelas/asclepedia/';
            $config['allowed_types'] = '*';
            $config['encrypt_name']  = true;
            $this->upload->initialize($config);

            $_FILES['images']['name']     = $_FILES['foto_kelas']['name'];
            $_FILES['images']['type']     = $_FILES['foto_kelas']['type'];
            $_FILES['images']['tmp_name'] = $_FILES['foto_kelas']['tmp_name'];
            $_FILES['images']['error']    = $_FILES['foto_kelas']['error'];
            $_FILES['images']['size']     = $_FILES['foto_kelas']['size'];

            if ($this->upload->do_upload('images')) {
                // Uploaded file data
                if ($id != null) {
                    $get = $this->query->get_data_simple('kelas', ['id' => $id])->row();
                    if ($get) {
                        $old_path = './assets/uploads/kelas/asclepedia/' . $get->thumbnail;
                        if (file_exists($old_path)) {
                            unlink($old_path);
                        }
                    }
                    $fileData   = $this->upload->data();
                    $uploadData = $fileData['file_name'];

                    $data['thumbnail'] = $uploadData;
                } else {
                    $errormsg =  $this->upload->display_errors();
                }
            }
        }
        

        $update = $this->query->insert_for_id('kelas', ['id' => $id], $data);

        // if ($this->input->post('free_member_edit')) {
        //     $free_member   = count($this->input->post('free_member_edit'));

        //     for ($i = 0; $i < $free_member; $i++) {
        //         $member = array(
        //             'user_id' => $this->input->post('free_member_edit')[$i],
        //             'kode_transaksi' => 'ASC' . date("YmdHis") . $i,
        //             'total' => 0,
        //             'status' => 'paid',
        //             'metode_pembayaran' => 'free'
        //         );
        //         $save_trans = $this->query->insert_for_id('transaksi', null, $member);
        //         $trans_id = $save_trans->output;

        //         $detail[] = array(
        //             'transaksi_id' => $trans_id,
        //             'product_id' => $id,
        //             'harga' => 0,
        //             'diskon' => 0,
        //             'total_harga' => 0,
        //             'status' => 'success',
        //         );
        //     }
        //     $this->query->insert_batch('transaksi_detail', $detail);
        // }

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

        $this->update_log($id, $this->input->post('link_zoom'));


        if ($update) {

            $response = [
                'status' => 200,
                'msg' => 'berhasil update kelas!'
            ];

        } else {
            // $this->session->set_flashdata('msg_type', 'error');
            // $this->session->set_flashdata('msg', 'Gagal edit data');
            // redirect('/Admin/asclepedia');

            $response = [
                'status' => 400,
                'msg' => 'gagal update kelas! :'.$errormsg
            ];
        }

        echo json_encode($response);
    }

    function course_detail($id){

        $json = $this->query->get_data_simple('kelas_materi' , ['id' => $id] )->row();
        echo json_encode(['status' => 200 , 'data' => $json]);
    }

    function save_course_link($id){

        $data = [
            'link_materi_rekaman' => $_POST['link_materi_rekaman'],
            'link_materi_youtube' => $_POST['link_materi_youtube'],
            'password_materi' => $_POST['password_materi'],
        ];

        $where = [
            'id' => $id
        ];

        $this->query->insert_for_id('kelas_materi' , $where , $data);

        $response['status'] = 200;
        $response['msg'] = 'Sukses mengupdate materi';

        echo json_encode($response);
    }

    function re_named_slug($title) {

        $slug_now = url_title($title, 'dash', true);
        $check = $this->query->get_data_simple('kelas' , ['slug' => $slug_now]);
        if ($check->num_rows()>0) {
            $slug_now = $slug_now .'-'.rand(1,999);
        }

        return $slug_now;

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
            redirect('/Admin/asclepedia');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal hapus data');
            redirect('/Admin/asclepedia');
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
            redirect('/Admin/asclepedia');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal update data');
            redirect('/Admin/asclepedia');
        }
    }
    function edit_benefit()
    {
        $kelas_id = $this->input->post('id_kelas');
        $rekaman = $this->input->post('link_rekaman');
        $materi = $this->input->post('link_materi');
        $sertifikat = $this->input->post('link_sertifikat');
        $password = $this->input->post('password_materi');
        $update = $this->query->update_data('kelas', ['id' => $kelas_id], ['link_rekaman' => $rekaman, 'link_materi' => $materi, 'link_sertifikat' => $sertifikat, 'password_materi' => $password]);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil update benefit');
            redirect('/Admin/asclepedia');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal update benefit');
            redirect('/Admin/asclepedia');
        }
    }
    function get_kelas_detail($id)
    {

        $data = $this->query->get_data_simple('kelas', ['id' => $id])->row();

        echo json_encode(['status' => 200, 'data' => $data]);
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
        if ($kelas->kategori_kelas == 'good morning knowledge') {
            $label = 'Good Morning Knowledge';
        } else {
            $label = 'Skill Lab';
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

    // function select_member($product_id)
    // {

    //     $transaksi = $this->query->get_query("SELECT t.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.product_id = $product_id")->result();
    //     $array = [];
    //     foreach ($transaksi as $key) {

    //         $array[] = 'u_' . $key->user_id;
    //     }
    //     $opt = '';
    //     $user = $this->query->get_query("SELECT * FROM `user`")->result();


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
        // $user = $this->query->get_query("SELECT id,
        // nama_lengkap
        // FROM   `user`
        // WHERE  id NOT IN(SELECT t.user_id
        //                 FROM   transaksi t
        //                         JOIN transaksi_detail d
        //                         ON t.id = d.`transaksi_id`
        //                 WHERE  d.`product_id` = $product_id)
        //         OR id IN(SELECT t.user_id
        //                 FROM   transaksi t
        //                         JOIN transaksi_detail d
        //                         ON t.id = d.`transaksi_id`
        //                 WHERE  d.`product_id` = $product_id
        //                         AND d.`status` != 'success')
        //         OR id IN(SELECT t.user_id
        //                 FROM   transaksi t
        //                         JOIN transaksi_detail d
        //                         ON t.id = d.`transaksi_id`
        //                 WHERE  d.`product_id` != $product_id)
        // GROUP  BY id ")->result();

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
        // echo $query;
        // exit;
        $non = $this->query->get_query($query)->result();

        // echo json_encode($user);
        foreach ($non as $keys) {
            $opt .= "<option value=" . $keys->id . ">" . $keys->nama_lengkap . "</option>";
        }

        echo $opt;
    }

    function update_log($id, $link)
    {
        $data = [
            'kelas_id'     => $id,
            'link_zoom'    => $link,
        ];
        $this->query->insert_for_id('log_update_link', null, $data);
    }

    function send_to_api()
    {

        $url = "https://graph.facebook.com/v13.0/1751101601916260/events?access_token=EAAGBBO0B4LYBALZA9u2lDuBpxGdyYyW2X6XA30ADWvOYE2xssedLcfVUzH4ncxWDpnWzxqEFrPZB3AwmlhPsWOMlXjnc1DZBiZC1wTLzBeeuuR0IDUxPC7mAi6getqhjkf6E9wOBxJyQA2ZBasoR15cZBsAWDt33Hd4YsVqNUbRFdaJqic61pxsibbQQZBhz58ZD";
        $data = [
            "data" => [
                [
                    "event_name" => "Tumbas",
                    "event_time" => 1648076718,
                    "event_id" => "event.id.123",
                    "event_source_url" => "http=>\/\/jaspers-market.com\/product\/123",
                    "action_source" => "website",
                    "user_data" => [
                        "client_ip_address" => $this->input->ip_address(),
                        "client_user_agent" => "hura",
                        "em" => [
                            "309a0a5c3e211326ae75ca18196d301a9bdbd1a882a4d2569511033da23f0abd"
                        ],
                        "ph" => [
                            "254aa248acb47dd654ca3ea53f48c2c26d641d23d7e2e93a1ec56258df7674c4",
                            "6f4fcb9deaeadc8f9746ae76d97ce1239e98b404efe5da3ee0b7149740f89ad6"
                        ],
                        "fbc" => "fb.1.1554763741205.AbCdEfGhIjKlMnOpQrStUvWxYz1234567890",
                        "fbp" => "fb.1.1558571054389.1098115397"
                    ],
                    "custom_data" => [
                        "value" => 100.2,
                        "currency" => "USD",
                        "content_ids" => [
                            "product.id.123"
                        ],
                        "content_type" => "product"
                    ],
                    "opt_out" => false
                ],
                [
                    "event_name" => "Tumbas",
                    "event_time" => 1648076718,
                    "user_data" => [
                        "client_ip_address" => $this->input->ip_address(),
                        "client_user_agent" => "hura2"
                    ],
                    "custom_data" => [
                        "value" => 50.5,
                        "currency" => "USD"
                    ],
                    "opt_out" => true
                ]
            ]
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        $response = curl_exec($curl);
        echo $response;
    }
}
