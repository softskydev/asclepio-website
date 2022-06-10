<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
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

    function capt_home()
    {
        $data = [
            'title_home' => $this->input->post('title_home'),
            'desc_home' => $this->input->post('desc_home'),
        ];
        $update = $this->query->update_data('caption', ['id' => 1], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_caption');
    }
    function capt_asclepedia()
    {
        $data = [
            'title_asclepedia' => $this->input->post('title_asclepedia'),
            'desc_asclepedia' => $this->input->post('desc_asclepedia'),
        ];
        $update = $this->query->update_data('caption', ['id' => 1], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_caption');
    }
    function capt_asclepiogo()
    {
        $data = [
            'title_asclepiogo' => $this->input->post('title_asclepiogo'),
            'desc_asclepiogo' => $this->input->post('desc_asclepiogo'),
        ];
        $update = $this->query->update_data('caption', ['id' => 1], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_caption');
    }
    function capt_about()
    {
        $data = [
            'title_about' => $this->input->post('title_about'),
            'desc_about' => $this->input->post('desc_about'),
        ];
        $update = $this->query->update_data('caption', ['id' => 1], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_caption');
    }
    function seo_home()
    {
        $data = [
            'meta_title' => $this->input->post('meta_title_home'),
            'meta_keyword' => $this->input->post('meta_keyword_home'),
            'meta_desc' => $this->input->post('meta_desc_home'),
        ];
        $update = $this->query->update_data('seo', ['page' => 'home'], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_seo');
    }
    function seo_asclepedia()
    {
        $data = [
            'meta_title' => $this->input->post('meta_title_asclepedia'),
            'meta_keyword' => $this->input->post('meta_keyword_asclepedia'),
            'meta_desc' => $this->input->post('meta_desc_asclepedia'),
        ];
        $update = $this->query->update_data('seo', ['page' => 'asclepedia'], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_seo');
    }
    function seo_asclepio_go()
    {
        $data = [
            'meta_title' => $this->input->post('meta_title_asclepio_go'),
            'meta_keyword' => $this->input->post('meta_keyword_asclepio_go'),
            'meta_desc' => $this->input->post('meta_desc_asclepio_go'),
        ];
        $update = $this->query->update_data('seo', ['page' => 'asclepio_go'], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_seo');
    }
    function seo_about()
    {
        $data = [
            'meta_title' => $this->input->post('meta_title_about'),
            'meta_keyword' => $this->input->post('meta_keyword_about'),
            'meta_desc' => $this->input->post('meta_desc_about'),
        ];
        $update = $this->query->update_data('seo', ['page' => 'about'], $data);

        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect('Admin/setting_seo');
    }

    function auth()
    {
        $config['upload_path']   = './assets/front/images';
        $config['allowed_types'] = '*';
        $config['encrypt_name']  = true;
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('register')) {
            $get = $this->query->get_data_simple('image_auth', ['page' => 'register'])->row();
            if ($get) {
                $old_path = './assets/front/images/' . $get->image;
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
            $fileData   = $this->upload->data();
            $uploadData = $fileData['file_name'];

            $data['image'] = $uploadData;
            $query = $this->query->update_data('image_auth', ['page' => 'register'], $data);
        }
        if ($this->upload->do_upload('login')) {
            $get = $this->query->get_data_simple('image_auth', ['page' => 'login'])->row();
            if ($get) {
                $old_path = './assets/front/images/' . $get->image;
                if (file_exists($old_path)) {
                    unlink($old_path);
                }
            }
            $fileData   = $this->upload->data();
            $uploadData = $fileData['file_name'];

            $data['image'] = $uploadData;
            $query = $this->query->update_data('image_auth', ['page' => 'login'], $data);
        }

        if ($query) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Update Success');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Update Failed');
        }
        redirect(base_url('Admin/setting_auth'));
    }
}
