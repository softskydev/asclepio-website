<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topik extends CI_Controller
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
    function save()
    {

        $data = [
            'nama_topik' => $this->input->post('nama_topik'),
        ];
        $save = $this->query->insert_for_id('topik', null, $data);
        if ($save) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Berhasil tambah data');
            redirect('/Admin/topik');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal tambah data');
            redirect('/Admin/topik');
        }
    }
    function detail($id)
    {
        $query = $this->query->get_data_simple("topik", ["id" => $id])->row();
        echo json_encode($query);
    }

    function get_kelas($topik_id)
    {
        $kelas = $this->query->get_query("SELECT * FROM kelas WHERE topik_id = $topik_id AND is_delete = 0")->result();
        $items = [];
        foreach ($kelas as $k) {
            $date = $k->public_date;
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
            if ($k->jenis_kelas == 'asclepedia') {
                if ($k->kategori_kelas == 'good morning knowledge') {
                    $label = 'Good morning knowledge';
                } else {
                    $label = 'Skill Lab';
                }
            } else {
                if ($k->kategori_go == 'open') {
                    $label = 'Open Class';
                } else if ($k->kategori_go == 'expert') {
                    $label = 'Expert Class';
                } else {
                    $label = 'Private Class';
                }
            }

            $pemateri = $this->query->get_query("SELECT p.foto,p.nama_pemateri FROM pemateri p JOIN kelas_pemateri kp ON p.id = kp.pemateri_id WHERE kp.kelas_id = $k->id")->result();
            $item['id'] = $k->id;
            $item['judul'] = $k->judul_kelas;
            $item['jenis'] = $k->jenis_kelas;
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
    function update()
    {
        $id = $this->input->post('id_topik_edit');
        $nama = $this->input->post('nama_topik_edit');

        $query = $this->query->update_data('topik', ['id' => $id], ['nama_topik' => $nama]);
        if ($query) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect(base_url('Admin/topik'));
    }
    function delete($id)
    {
        $query = $this->query->update_data('topik', ['id' => $id], ['is_delete' => 1]);
        if ($query) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Remove Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Remove Failed');
        }
        redirect(base_url('Admin/topik'));
    }
}
