<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemateri extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url_helper');
    }

    // private $tbl = 'categories';

    private function js_path()
    {
        return base_url() . 'assets/backend/js/';
    }

    function save_pemateri($id = null)
    {
        $config['upload_path']   = './assets/uploads/pemateri';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        $data = [
            'nama_pemateri' => $this->input->post('nama_pemateri'),
            'spesialis' => $this->input->post('spesialis'),
            
        ];

        if ($id == null) {

            $_FILES['images']['name']     = $_FILES['foto']['name'];
            $_FILES['images']['type']     = $_FILES['foto']['type'];
            $_FILES['images']['tmp_name'] = $_FILES['foto']['tmp_name'];
            $_FILES['images']['error']    = $_FILES['foto']['error'];
            $_FILES['images']['size']     = $_FILES['foto']['size'];

            $this->upload->initialize($config);
            $this->upload->do_upload('images');
            $fileData = $this->upload->data();
            $data['foto'] = $fileData['file_name'];

            $where = null;
        } else {
            $where = [
                'id' => $id
            ];
            if ($_FILES['foto']['tmp_name'] != '') {

                $this->upload->initialize($config);
                $this->upload->do_upload('foto');
                $fileData = $this->upload->data();
                $data['foto'] = $fileData['file_name'];
            }
        }

        // debug($_FILES);

        $save = $this->query->insert_for_id('pemateri', $where, $data);
        if ($save) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil tambah data');
            redirect('/Admin/pemateri');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal tambah data');
            redirect('/Admin/pemateri');
        }
    }
    function delete($id)
    {
        // $get = $this->query->get_data('foto', 'pemateri', ['id' => $id])->row();
        // $old_path = './assets/uploads/pemateri/' . $get->foto;
        // if (file_exists($old_path)) {
        //     unlink($old_path);
        // }
        $delete = $this->query->update_data('pemateri', ['id' => $id], ['is_delete' => 1]);
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

    function do_edit($id)
    {

        $row = $this->query->get_data_simple('pemateri', ['id' => $id])->row();

        echo json_encode(['status' => 200, 'row' => $row]);
    }
}
