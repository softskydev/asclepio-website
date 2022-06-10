<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
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
    function check_data()
    {
        $check_voucher = $this->query->get_data_simple('voucher', ['code_voucher' => $this->input->post('code_voucher')])->num_rows();
        // if () {
        //     $this->session->set_flashdata('msg_type', 'error');
        //     $this->session->set_flashdata('msg', 'Code Voucher Sudah ada');
        // }
        if ($check_voucher > 0) {
            $response = [
                'status' => 200,
                'msg_type', 'error',
                'msg' => 'Code Voucher sudah ada',
            ];
        }

        echo json_encode($response);
    }
    function save()
    {
        $config['upload_path']   = './assets/uploads/voucher';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        // $id = $save->output;

        // $cpt = count($_FILES['gambar']['name']);

        $check_voucher = $this->query->get_data_simple('voucher', ['code_voucher' => $this->input->post('code_voucher')])->num_rows();
        if ($check_voucher > 0) {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Code Voucher Sudah ada');
            redirect('/Admin/voucher');

            exit;
        }

        $_FILES['images']['name'] = $_FILES['thumbnail']['name'];
        $_FILES['images']['type'] = $_FILES['thumbnail']['type'];
        $_FILES['images']['tmp_name'] = $_FILES['thumbnail']['tmp_name'];
        $_FILES['images']['error'] = $_FILES['thumbnail']['error'];
        $_FILES['images']['size'] = $_FILES['thumbnail']['size'];

        $this->upload->initialize($config);
        $this->upload->do_upload('images');
        $fileData = $this->upload->data();
        $uploadData = $fileData['file_name'];
        if ($this->input->post('kelas_spesifik')) {
            $status = '1';
        } else {
            $status = '0';
        }
        if ($this->input->post('discount')) {
            $discount = $this->input->post('discount');
        } else {
            $discount = 100;
        }

        if ($this->input->post('limit_status')) {
            $limit_status = $this->input->post('limit_status');
        } else {
            $limit_status = 'limited';
        }
        $data = [
            'code_voucher' => $this->input->post('code_voucher'),
            'jenis_voucher' => $this->input->post('jenis_voucher'),
            'discount' => $discount,
            'jenis_kelas' => $this->input->post('jenis_kelas'),
            'expired_date' => $this->input->post('expired_year') . '-' . $this->input->post('expired_month') . '-' . $this->input->post('expired_date'),
            'limit_status' => $limit_status,
            'limit_voucher' => $this->input->post('limit_voucher'),
            'deskripsi' => $this->input->post('deskripsi'),
            'thumbnail' => $uploadData,
            'is_spesifik' => $status,
        ];

        $save = $this->query->insert_for_id('voucher', null, $data);
        $id = $save->output;

        $spesifik = count($this->input->post('kelas_spesifik'));
        $spesifik_data = [];

        // cek 'SEMUA' di centang ato nggak
        if ($this->input->post('kelas_spesifik')[0] != '') {

            for ($i = 0; $i < $spesifik; $i++) {
                $spesifik_data[] = array(
                    'voucher_id' => $id,
                    'kelas_id' => $this->input->post('kelas_spesifik')[$i],
                );
            }
        } else {

            $get_kelas = $this->query->get_data_simple('kelas');
            foreach ($get_kelas->result() as $valz) {
                $spesifik_data[] = array(
                    'voucher_id' => $id,
                    'kelas_id' => $valz->id
                );
            }
        }




        if ($save) {
            if ($this->input->post('kelas_spesifik')) {
                $this->query->insert_batch('voucher_spesifik', $spesifik_data);
            }

            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil tambah data');
            redirect('/Admin/voucher');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal tambah data');
            redirect('/Admin/voucher');
        }
    }
    function get_voucher($page = 0)
    {
        $limit = $this->input->post('limit');
        $sort = $this->input->post('sort');
        $search = $this->input->post('search');
        $query = "SELECT * FROM voucher";
        $config['base_url'] = base_url() . 'Voucher/get_voucher/';
        $config['total_rows'] = $this->db->query($query)->num_rows();
        $config['per_page'] = $limit;
        if ($sort == 'terbaru') {
            if ($search) {
                $query .= " WHERE code_voucher LIKE '%$search%' OR jenis_voucher LIKE '%$search%' ORDER BY id DESC LIMIT $limit OFFSET $page";
            } else {
                $query .= " ORDER BY id DESC LIMIT $limit OFFSET $page";
            }
        } else {
            if ($search) {
                $query .= " WHERE code_voucher LIKE '%$search%' OR jenis_voucher LIKE '%$search%' ORDER BY id ASC LIMIT $limit OFFSET $page";
            } else {
                $query .= " ORDER BY id ASC LIMIT $limit OFFSET $page";
            }
        }
        $data = $this->query->get_query($query)->result();


        $this->pagination->initialize($config);


        $items = [];
        foreach ($data as $d) {
            $querys = $this->db->query("SELECT id FROM transaksi_detail WHERE code_voucher = '$d->code_voucher'")->num_rows();
            $pengguna = $this->query->get_query("SELECT u.nama_lengkap FROM transaksi t JOIN transaksi_detail d ON t.`id` = d.transaksi_id JOIN `user` u ON t.user_id = u.id WHERE d.code_voucher = '$d->code_voucher' AND t.`status` = 'paid'")->row()->nama_lengkap;
            if ($pengguna) {
                $item['pengguna_voucher'] = '<br><span class="badge badge-success">' . $pengguna . '</span>';
            } else {
                $item['pengguna_voucher'] = '';
            }

            $item['id'] = $d->id;
            $item['code_voucher'] = $d->code_voucher;
            $item['jenis_voucher'] = $d->jenis_voucher;
            $item['limit_voucher'] = $d->limit_voucher;
            $item['pemakaian_voucher'] = $querys;
            $item['expired_date'] = $d->expired_date;
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
    function detail_voucher($id)
    {
        $voucher = $this->query->get_data_simple('voucher', ['id' => $id])->row();
        $cek_transaksi = $this->query->get_query("SELECT * FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.code_voucher = '$voucher->code_voucher' AND t.user_id = " . $this->session->userdata('id') . "");
        $used = $cek_transaksi->num_rows();
        $sisa = $voucher->limit_voucher - $used;
        $item['thumbnail'] = $voucher->thumbnail;
        $item['code'] = $voucher->code_voucher;
        $item['expired'] = format_indo($voucher->expired_date);
        $item['limit'] = $voucher->limit_voucher;
        $item['deskripsi'] = $voucher->deskripsi;
        $item['sisa'] = $sisa;
        $item['limit_status'] = $voucher->limit_status;
        echo json_encode($item);
    }
    function get_kelas($jenis)
    {
        if ($jenis != 'all') {
            $kelas = $this->query->get_data('id,judul_kelas', 'kelas', ['jenis_kelas' => $jenis, 'is_delete' => 0])->result();
        } else {
            $kelas = $this->query->get_data('id,judul_kelas', 'kelas', ['is_delete' => 0])->result();
        }

        if ($kelas) {
            $response = [
                'status' => 200,
                'msg' => 'Success get kelas',
                'data' => $kelas,
                'jenis' => $jenis
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
    function delete($id)
    {
        $get = $this->query->get_data_simple('voucher', ['id' => $id])->row();
        $old_path = './assets/uploads/voucher/' . $get->thumbnail;
        if ($get->is_redeem == 1) {
            $response = [
                'msg_type' => 'error',
                'msg' => 'Gagal Hapus Data, karena voucher sudah diredeem',
            ];
        } else {
            if (file_exists($old_path)) {
                unlink($old_path);
            }
            $delete = $this->query->delete_data('voucher', ['id' => $id]);
            if ($delete) {
                $this->query->delete_data('voucher_spesifik', ['voucher_id' => $id]);
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
        }

        echo json_encode($response);
    }
}
