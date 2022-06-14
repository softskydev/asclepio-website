<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Asclepedia extends CI_Controller
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
        $data = $this->query->get_data_simple('topik', null)->result();
        $response = [
            'data' => $data
        ];
        echo json_encode($response);
    }
    function save_kelas()
    {

        $config['upload_path']   = './assets/uploads/kelas/asclepedia';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        $_FILES['images']['name'] = $_FILES['thumbnail']['name'];
        $_FILES['images']['type'] = $_FILES['thumbnail']['type'];
        $_FILES['images']['tmp_name'] = $_FILES['thumbnail']['tmp_name'];
        $_FILES['images']['error'] = $_FILES['thumbnail']['error'];
        $_FILES['images']['size'] = $_FILES['thumbnail']['size'];

        $gform = ($this->input->post('gform')) ? $this->input->post('gform') : '';

        $this->upload->initialize($config);
        $this->upload->do_upload('images');
        $fileData = $this->upload->data();
        $uploadData = $fileData['file_name'];
        $data = [
            'judul_kelas'     => $this->input->post('judul_kelas'),
            'topik_id'        => $this->input->post('topik'),
            'deskripsi_kelas' => $this->input->post('deskripsi_kelas'),
            'kategori_kelas'  => $this->input->post('kategori'),
            'tgl_kelas'       => $this->input->post('year') . '-' . $this->input->post('month') . '-' . $this->input->post('date'),
            'waktu_mulai'     => $this->input->post('waktu_mulai'),
            'waktu_akhir'     => $this->input->post('waktu_akhir'),
            'jenis_kelas'     => 'asclepedia',
            'early_price'     => str_replace(',', '', $this->input->post('early_price')),
            'late_price'      => str_replace(',', '', $this->input->post('late_price')),
            'link_zoom'       => $this->input->post('link_zoom'),
            'slug'            => url_title($this->input->post('judul_kelas'), 'dash', true),
            'gform_url'       => $gform,
            'thumbnail'       => $uploadData,
        ];
        $save = $this->query->insert_for_id('kelas', null, $data);
        $id = $save->output;

        $nama_pemateri = count($this->input->post('pemateri'));
        $judul_materi  = count($this->input->post('judul_materi'));



        if ($this->input->post('free_member')) {
            $free_member   = count($this->input->post('free_member'));

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
                $this->query->insert_batch('transaksi', $member);
            }
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
    function get_upcoming()
    {
        $type = $_GET['type'];

        $query1 = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND tgl_kelas >= CURDATE()";
        if ($type != '') {
            $query1 .= ' AND kategori_kelas = "' . $type . '"';
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
            if ($k->kategori_kelas == 'good morning knowledge') {
                $label = 'Good morning knowledge';
            } else {
                $label = 'Skill Labs';
            }
            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();

            // debug($pemateri);

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

    function load_data_kelas_on_benefit()
    {


        $query1 = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND ";

        if ($_GET['filter'] == 'past') {
            $query1 .= ' tgl_kelas < CURDATE() ';
        } else {

            $query1 .= ' tgl_kelas > CURDATE() ';
        }

        if ($_GET['keys'] != '') {
            $query1 .= ' AND judul_kelas LIKE "%' . $_GET['keys'] . '%"';
        }


        $kelas = $this->query->get_query($query1)->result();
        $items = [];

        $echo = '';
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
                $label = 'Skill Labs';
            }
            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();
            $pemateri_ppl = '';

            foreach ($pemateri as $z) {
                $pemateri_ppl .= '<div class="pp">
                                            <img src="' . base_url() . 'assets/uploads/pemateri/' . $z->foto . '" />
                                        </div>
                                        <span>' . $z->nama_pemateri . '</span>';
            }




            $echo .= '<div class="box-card">
                        <a class="box-card__link" href="javascript:void(0)" onclick="select_benefit(' . $k->id . ')">
                            <div class="box-card__img"><img src="' . base_url() . 'assets/uploads/kelas/asclepedia/' . $k->thumbnail . '" /></div>
                            <div class="box-card__content">
                                <div class="box-card__text"><span class="tag tag-open">' . $label . '</span>
                                    <h4>' . $k->judul_kelas . '</h4>
                                    <ul class="schedule">
                                        <ul>
                                            <li>
                                                <div class="ic"><img src="' . base_url() . 'assets/admin/images/ic-date.svg" /></div><span>16 Aug 2020</span>
                                            </li>
                                            <li>
                                                <div class="ic"><img src="' . base_url() . 'assets/admin/images/ic-time.svg" /></div><span>' . $k->waktu_mulai . ' - ' . $k->waktu_akhir . ' WIB</span>
                                            </li>
                                        </ul>
                                    </ul>
                                </div>
                                <div class="box-card__footer">
                                    <div class="author">
                                        ' . $pemateri_ppl . '
                                    </div>
                                    <div class="price">' . $harga . '</div>
                                </div>
                            </div>
                        </a>
                    </div>';
        }

        echo $echo;
    }
    function get_with_benefit($page = 0)
    {
        $limit = $this->input->post('limit');
        $query = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND link_rekaman IS NOT NULL AND link_materi IS NOT NULL";
        $query2 = "SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND link_rekaman IS NOT NULL AND link_materi IS NOT NULL LIMIT $limit OFFSET $page";
        $data = $this->query->get_query($query2)->result();
        $config['base_url'] = base_url() . 'Asclepedia/get_with_benefit/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;

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
        $kelas = $this->query->get_query("SELECT * FROM kelas WHERE jenis_kelas = 'asclepedia' AND tgl_kelas < CURDATE()")->result();
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
                $label = 'Skill Labs';
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

    function do_edit()
    {
        $id = $this->input->post('kelas_id');
        $config['upload_path']   = './assets/uploads/kelas/asclepedia';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        $_FILES['images']['name'] = $_FILES['thumbnail_edit']['name'];
        $_FILES['images']['type'] = $_FILES['thumbnail_edit']['type'];
        $_FILES['images']['tmp_name'] = $_FILES['thumbnail_edit']['tmp_name'];
        $_FILES['images']['error'] = $_FILES['thumbnail_edit']['error'];
        $_FILES['images']['size'] = $_FILES['thumbnail_edit']['size'];

        $gform = ($this->input->post('gform_edit')) ? $this->input->post('gform_edit') : '';

        $this->upload->initialize($config);
        $data = [
            'judul_kelas'     => $this->input->post('judul_kelas_edit'),
            'topik_id'        => $this->input->post('topik_edit'),
            'deskripsi_kelas' => $this->input->post('deskripsi_kelas_edit'),
            'kategori_kelas'  => $this->input->post('kategori_edit'),
            'tgl_kelas'       => $this->input->post('year_edit') . '-' . $this->input->post('month_edit') . '-' . $this->input->post('date_edit'),
            'waktu_mulai'     => $this->input->post('waktu_mulai_edit'),
            'waktu_akhir'     => $this->input->post('waktu_akhir_edit'),
            'jenis_kelas'     => 'asclepedia',
            'early_price'     => str_replace(',', '', $this->input->post('early_price_edit')),
            'late_price'      => str_replace(',', '', $this->input->post('late_price_edit')),
            'link_zoom'       => $this->input->post('link_zoom_edit'),
            'slug'            => url_title($this->input->post('judul_kelas_edit'), 'dash', true),
            'gform_url'       => $gform,
        ];

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
                echo $this->upload->display_errors();
            }
        }
        $update = $this->query->update_data('kelas', ['id' => $id], $data);


        if ($this->input->post('free_member_edit')) {
            $free_member   = count($this->input->post('free_member_edit'));

            for ($i = 0; $i < $free_member; $i++) {
                $member[] = array(
                    'product_id' => $id,
                    'user_id' => $this->input->post('free_member_edit')[$i],
                    'kode_transaksi' => 'ASC' . date("YmdHis") . $i,
                    'harga' => 0,
                    'diskon' => 0,
                    'total' => 0,
                    'status' => 'paid',
                    'metode_pembayaran' => 'free'
                );
                $this->query->insert_batch('transaksi', $member);
            }
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


        if ($update) {

            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil edit data');
            redirect('/Admin/asclepedia');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal edit data');
            redirect('/Admin/asclepedia');
        }
    }
    function delete($id)
    {
        $get = $this->query->get_data('foto', 'pemateri', ['id' => $id])->row();
        $old_path = './assets/uploads/pemateri/' . $get->foto;
        if (file_exists($old_path)) {
            unlink($old_path);
        }
        $delete = $this->query->delete_data('pemateri', ['id' => $id]);
        if ($delete) {
            $response = [
                'msg_type' => 'success',
                'msg' => 'Berhasil Hapus Data',
            ];
        } else {
            $response = [
                'msg_type' => 'error',
                'msg' => 'Gagal Hapus Data',
            ];
        }
        echo json_encode($response);
    }

    function get_kelas_detail($id)
    {

        $data = $this->query->get_data_simple('kelas', ['id' => $id])->row();

        echo json_encode(['status' => 200, 'data' => $data]);
    }
    function load_khusus_pemateri($kelas_id)
    {

        // $get = 'SELECT a.* , b.nama_pemateri as nama FROM `kelas_pemateri` a inner join pemateri b on a.pemateri_id = b.id where a.kelas_id = '.$kelas_id;

        $kelas_pemateri = $this->query->get_data_simple('kelas_pemateri', ['kelas_id' => $kelas_id])->result();
        $array_check    = [];
        foreach ($kelas_pemateri as $d) {
            $array_check[] = $d->pemateri_id;
        }

        $kelas = $this->query->get_data_simple('pemateri')->result();

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

    function select_member($transaksi_id)
    {

        $data = $this->query->get_data_simple('transaksi', ['product_id' => $transaksi_id])->result();
        $array = [];
        foreach ($data as $key) {

            $array[] = 'u_' . $key->user_id;
        }
        $opt = '';

        // $user = $this->query->get_query("SELECT u.id,u.nama_lengkap FROM transaksi t JOIN `user` u ON t.`user_id` != u.`id` WHERE t.product_id != $transaksi_id GROUP BY u.`nama_lengkap`")->result();
        $user = $this->query->get_query("SELECT * FROM `user`")->result();


        $transaksi = $this->query->get_data_simple('transaksi', ['product_id' => $transaksi_id])->result();
        $kelas_id = [];
        foreach ($transaksi as $t) {
            $kelas_id[] = $t->user_id;
        }
        foreach ($user as $keys) {

            if (in_array($keys->id, $kelas_id)) {
            } else {
                $opt .= "<option value=" . $keys->id . ">" . $keys->nama_lengkap . "</option>";
            }

            // $data_content = "";

        }

        echo $opt;
    }
}
