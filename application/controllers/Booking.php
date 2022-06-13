<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('base');
    }

    private function js_path()
    {
        return base_url() . 'assets/front/scripts/';
    }

    function addtocart()
    {

        $user_id = $this->input->post('user_id');
        $product_id = $this->input->post('product_id');

        if ($user_id == '') {
            $response = [
                'status' => 402,
                'msg' => 'Silahkan Login terlebih dahulu',
            ];
        } else {

            $cek_kelas = $this->query->get_query("SELECT * FROM kelas WHERE id = $product_id")->row();
            $cek_transaksi = $this->query->get_query("SELECT t.* FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE t.user_id = " . $this->session->userdata('id') . " AND d.product_id = $product_id AND t.status = 'paid'");
            // $cek_data =
            // $count_kelas = count($cek_data);
            $cek_status = $this->query->get_query("SELECT product_id FROM cart WHERE user_id = " . $this->session->userdata('id') . " AND product_id = $product_id");
            $cek_cart = $this->query->get_query("SELECT c.product_id,k.late_price FROM cart c JOIN kelas k ON c.product_id = k.id WHERE c.user_id = " . $this->session->userdata('id') . "");
            $data = [
                'user_id' => $user_id,
                'product_id' => $product_id
            ];

            $today_time = strtotime(date("Y-m-d H:i"));
            // $expire_time = strtotime("-1 day", strtotime($cek_kelas->tgl_kelas));
            $expire_time = strtotime($cek_kelas->tgl_kelas . ' ' . $cek_kelas->waktu_mulai);

            if ($expire_time <= $today_time) {
                $response = [
                    'status' => 403,
                    'msg' => 'Kelas sudah expired,silahkan cari kelas lain',
                ];
            } else if ($cek_status->num_rows() > 0) {
                $response = [
                    'status' => 401,
                    'msg' => 'Kelas ini sudah ada dikeranjang',
                ];
            } else if ($cek_transaksi->num_rows() > 0) {
                $response = [
                    'status' => 405,
                    'msg' => 'Anda sudah terdaftar dalam kelas ini',
                ];
            } else if ($cek_cart->num_rows() > 0) {
                if ($cek_cart->row()->late_price == 0) {
                    $status = 'Free';
                } else {
                    $status = 'Berbayar';
                }
                if ($cek_kelas->late_price == 0 && $cek_cart->row()->late_price == 0) {
                    $save = $this->query->save_data('cart', $data);
                    if ($save) {
                        $response = [
                            'status' => 200,
                            'msg' => 'Success add to cart',
                        ];
                    } else {
                        $response = [
                            'status' => 400,
                            'msg' => 'Failed add to cart',
                        ];
                    }
                } else if ($cek_kelas->late_price != 0 && $cek_cart->row()->late_price != 0) {
                    $save = $this->query->save_data('cart', $data);
                    if ($save) {
                        $response = [
                            'status' => 200,
                            'msg' => 'Success add to cart',
                        ];
                    } else {
                        $response = [
                            'status' => 400,
                            'msg' => 'Failed add to cart',
                        ];
                    }
                } else {
                    $response = [
                        'status' => 406,
                        'msg' => 'Dikeranjangmu sudah ada kelas dengan tipe ' . $status . ', Anda hanya dapat menggabungkan pembelian dengan kelas ' . $status . '',
                    ];
                }
            } else {
                $save = $this->query->save_data('cart', $data);
                if ($save) {
                    $response = [
                        'status' => 200,
                        'msg' => 'Success add to cart',
                    ];
                } else {
                    $response = [
                        'status' => 400,
                        'msg' => 'Failed add to cart',
                    ];
                }
            }
        }




        echo json_encode($response);
    }

    function delete_cart($user_id, $id)
    {
        $delete = $this->query->delete_data('cart', ['user_id' => $user_id, 'product_id' => $id]);

        if ($delete) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Tiket Anda berhasil dihapus');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Tiket gagal dihapus');
        }
        redirect('/cart');
    }

    function makeTransaction()
    {
        $user_id = $this->input->post('user_id');
        $total = $this->input->post('total');

        $email = $this->query->get_data('email', 'user', ['id' => $user_id])->row()->email;



        $data = [
            'kode_transaksi' => 'ASC' . date("YmdHis"),
            'user_id' => $user_id,
            'total' => $total,
            'status' => 'wait_for_payment',
        ];

        $save = $this->query->insert_for_id('transaksi', null, $data);
        $id = $save->output;
        $code_transaction = $this->query->get_data('kode_transaksi', 'transaksi', ['id' => $id])->row()->kode_transaksi;

        $harga   = count($this->input->post('harga'));
        for ($i = 0; $i < $harga; $i++) {
            if ($this->input->post('code_voucher')[$i]) {
                $voucher = $this->input->post('code_voucher')[$i];
            } else {
                $voucher = '';
            }
            $detail[] = array(
                'transaksi_id' => $id,
                'product_id' => $this->input->post('product_id')[$i],
                'harga' => $this->input->post('harga')[$i],
                'diskon' => $this->input->post('diskon')[$i],
                'total_harga' => $this->input->post('harga_total')[$i],
                'code_voucher' => $voucher,
                'status' => 'pending',
            );
        }
        $this->query->insert_batch('transaksi_detail', $detail);

        // $judul = $this->query->get_query("SELECT k.judul_kelas FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.id = $id")->row()->judul_kelas;
        if ($save) {
            $this->query->delete_data('cart', ['user_id' => $user_id]);
            $this->notifToAdmin();
            $this->sent_mail_invoice($email, $code_transaction);
            $response = [
                'status' => 200,
                'msg' => 'Success',
                'code_transaction' => $code_transaction,
            ];
        } else {
            $response = [
                'status' => 400,
                'msg' => 'Failed',
                'code_transaction' => null,
            ];
        }

        echo json_encode($response);
    }
    function quickBuy()
    {
        $user_id = $this->input->post('user_id');
        $total = $this->input->post('total');


        $data = [
            'kode_transaksi' => 'ASC' . date("YmdHis"),
            'user_id' => $user_id,
            'total' => $total,
            'status' => 'paid',
            'metode_pembayaran' => 'free',
        ];

        $save = $this->query->insert_for_id('transaksi', null, $data);
        $id = $save->output;
        $code_transaction = $this->query->get_data('kode_transaksi', 'transaksi', ['id' => $id])->row()->kode_transaksi;
        $detail = array();

        $harga   = count($this->input->post('harga'));
        for ($i = 0; $i < $harga; $i++) {
            if ($this->input->post('code_voucher')[$i]) {
                $voucher = $this->input->post('code_voucher')[$i];
            } else {
                $voucher = '';
            }
            $cek = $this->query->get_query("SELECT id,judul_kelas,jenis_kelas,kategori_kelas,kategori_go,`limit` FROM kelas WHERE id = " . $this->input->post('product_id')[$i] . " ")->row();
            if ($cek->jenis_kelas == 'asclepedia') {
                $kategori = $cek->kategori_kelas;
                if ($kategori == 'good morning knowledge') {
                    $count_limit = $this->query->get_query("SELECT COUNT(id) as `limit` FROM transaksi_detail WHERE product_id = $cek->id")->row()->limit;
                    if ($count_limit < $cek->limit) {
                        $status_link = 'zoom';
                    } else {
                        $status_link = 'youtube';
                    };
                    $status = 'pending';
                } else {
                    $status = 'success';
                    $status_link = '';
                }
            } else {
                $kategori = $cek->kategori_go;
                if ($kategori == 'open') {
                    $status = 'success';
                    $status_link = '';
                }
            }


            $detail[] = array(
                'transaksi_id' => $id,
                'product_id' => $this->input->post('product_id')[$i],
                'harga' => 0,
                'diskon' => 0,
                'total_harga' => 0,
                'code_voucher' => $voucher,
                'status' => $status,
                'status_link' => $status_link
            );
        }
        $this->query->insert_batch('transaksi_detail', $detail);

        // $judul = $this->query->get_query("SELECT k.judul_kelas FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.id = $id")->row()->judul_kelas;
        if ($save) {
            $this->query->delete_data('cart', ['user_id' => $user_id]);
            $this->notifToAdmin();
            $response = [
                'status' => 200,
                'msg' => 'Success',
                'code_transaction' => $code_transaction,
            ];
        } else {
            $response = [
                'status' => 400,
                'msg' => 'Failed',
                'code_transaction' => null,
            ];
        }

        echo json_encode($response);
    }
    function manualPayment($code)
    {
        $update = $this->query->update_data('transaksi', ['kode_transaksi' => $code], ['metode_pembayaran' => 'manual', 'payment_method' => 'manual']);
        if ($update) {
            $this->session->set_flashdata('msg_type', 'success');
            $this->session->set_flashdata('msg', 'Anda berhasil melakukan pemesanan, pesanan Anda akan terkonfirmasi setelah mengirim bukti pembayaran melalui Whatsapp');
        } else {
            $this->session->set_flashdata('msg_type', 'error');
            $this->session->set_flashdata('msg', 'Gagal melakukan pemesanan');
        }
        redirect('/profile/pemesanan/wait_for_payment');
    }
    function makePayment()
    {

        $code_transaction = $this->input->post('code_transaction');
        // $payment = $this->input->post('payment');
        $total = $this->query->get_data('total', 'transaksi', ['kode_transaksi' => $code_transaction])->row()->total;
        $get_data = $this->query->get_query("SELECT d.id,d.diskon,t.user_id,d.total_harga,t.tgl_pembelian,k.id as kelas_id,k.judul_kelas FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id JOIN kelas k ON d.product_id = k.id WHERE t.kode_transaksi = '$code_transaction'")->result();
        $items = [];
        foreach ($get_data as $d) {
            $item = array(
                'id' => $d->id,
                'price' => $d->total_harga,
                'quantity' => 1,
                'name' => $d->judul_kelas
            );
            array_push($items, $item);
        }
        $get_cust = $this->query->get_data_simple('user', ['id' => $this->session->userdata('id')])->row();

        $name = explode(' ', $get_cust->nama_lengkap);
        $first_name = $name[0];
        if (count($name) == 1) {
            $last_name = '';
        } else {
            $last_name = $name[count($name) - 1];
        }


        $server_key = 'Mid-server-1Xd5iajkcLSzFTtyymFARow8';
        $token = base64_encode($server_key);
        /* Endpoint */
        $url = 'https://app.midtrans.com/snap/v1/transactions';

        /* eCurl */
        $curl = curl_init($url);

        /* Data */
        $data = [
            'transaction_details' => [
                'order_id' => $code_transaction,
                'gross_amount' => $total
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $get_cust->email,
                'phone' => $get_cust->no_wa,
            ]
        ];

        /* Set JSON data to POST */
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

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
        echo $result;
    }
    function handler()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $order_id = $data['order_id'];
        $status = $data['transaction_status'];
        if ($data['payment_type'] == 'bank_transfer') {
            $payment = $data['payment_type'] . ' ' . $data['va_numbers'][0]['bank'];
        } else if ($data['payment_type'] == 'credit_card') {
            $payment = $data['payment_type'] . ' ' . $data['bank'];
        } else if ($data['payment_type'] == 'cstore') {
            $payment = $data['store'];
        } else {
            $payment = $data['payment_type'];
        }


        if ($status == 'settlement' || $status == 'capture') {
            $get_transaksi = $this->query->get_query("SELECT t.id,u.email FROM transaksi t JOIN user u ON t.user_id = u.id WHERE t.kode_transaksi = '$order_id'")->row();
            $this->query->update_data('transaksi', ['kode_transaksi' => $order_id], ['status' => 'paid', 'metode_pembayaran' => $payment]);
            $this->query->update_data('transaksi_detail', ['transaksi_id' => $get_transaksi->id], ['status' => 'success']);
            $email = $get_transaksi->email;
            $this->sent_mail_link($email, $order_id);
            $this->notifToAdmin();
            redirect(base_url('Booking/finish?order_id=' . $order_id . '&status_code=201&transaction_status=pending'));
        } else if ($status == 'expire') {
            $this->query->update_data('transaksi', ['kode_transaksi' => $order_id], ['status' => 'expired', 'metode_pembayaran' => $payment]);
        }
        // $this->finish();
    }
    function accPayment($id)
    {
        $get_transaksi = $this->query->get_query("SELECT t.id,u.email,t.kode_transaksi FROM transaksi t JOIN user u ON t.user_id = u.id WHERE t.id = '$id'")->row();
        $update = $this->query->update_data('transaksi', ['kode_transaksi' => $get_transaksi->kode_transaksi], ['status' => 'paid']);

        if ($update) {
            $this->query->update_data('transaksi_detail', ['transaksi_id' => $id], ['status' => 'success']);
            $email = $get_transaksi->email;
            $this->sent_mail_link($email, $get_transaksi->kode_transaksi);
            $response = [
                'status' => 200,
                'msg_type' => 'success',
                'msg' => 'Pembayaran berhasil di acc',
            ];
        } else {
            $response = [
                'status' => 400,
                'msg_type' => 'error',
                'msg' => 'Pembayaran gagall di acc',
            ];
        }
        echo json_encode($response);
    }
    function notifToAdmin()
    {
        $token = $this->query->get_data('token', 'admins', null)->result();
        $tokens = [];
        foreach ($token as $data) {
            $tokens[] = $data->token;
        }

        $data = [
            "registration_ids" => $tokens,
            "notification" =>
            [
                "title" => 'Asclepio | Transaksi Masuk',
                "body" => '',
                "icon" => 'https://iswam.intivestudio.com/assets/images/logo.png',
            ],
        ];
        $dataString = json_encode($data);
        $headers = [
            'Authorization: key=AAAARBVa1X4:APA91bHusIfrOSmtun-Fgn4Zh2fuXLmhTBDing1jTtsnIYdKssNxf0MY7AvwRRS88STHdVAy2dA8Tt-DZHrwdo_81BiAJDV18MfJo1pkQRlTQ2t83bqAw5kT41tl2dJ1kKu4sHUgNEJz',
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $result = curl_exec($ch);
        curl_close($ch);

        // echo json_encode($result);
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
        print_r(json_decode($result));
    }
    function finish()
    {
        if ($this->session->userdata('id') == '') {
            redirect(base_url('login'));
        }

        $order_id = $_GET['order_id'];
        $user = $this->query->get_data('user_id', 'transaksi', ['kode_transaksi' => $order_id])->row()->user_id;
        if ($this->session->userdata('id') != $user) {
            redirect(base_url('login'));
        }
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
        // print_r(json_decode($result));
        // exit;
        $data['meta_title'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_title;
        $data['meta_desc'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_desc;
        $data['meta_keyword'] = $this->query->get_data_simple('seo', ['page' => 'home'])->row()->meta_keyword;
        $data['meta_url'] = base_url();
        $data['meta_img'] = '';

        $data['script'][] = $this->js_path() . 'wait_payment.js';
        $data['data'] = json_decode($result);
        // if ($data['data']->metode_pembayaran == null) {
        //     redirect('/payment/' . $order_id);
        // } else {


        // }
        if ($data['data']->transaction_status == 'settlement' || $data['data']->transaction_status == 'capture') {
            $data['title']       = 'Transaksi Sukses';
            $page['content']  = $this->load->view('front/transaction_success', $data, true);
        } else if ($data['data']->transaction_status == 'pending' || $data['data']->transaction_status == 'wait_for_payment') {
            $data['title']       = 'Menunggu Pembayaran';
            $page['content']  = $this->load->view('front/wait_payment', $data, true);
            if ($data['data']->payment_type == 'bank_transfer' || $data['data']->payment_type == 'cstore' || $data['data']->payment_type == 'echannel' || $data['data']->payment_type == 'gopay' || $data['data']->payment_type == 'qris') {
                $page['content']  = $this->load->view('front/wait_payment', $data, true);
            } else {
                redirect('profile');
            }
        } else {
            redirect('profile');
        }

        $this->load->view('front/layout', $page);
    }
    function get_status()
    {
        $order_id = $_GET['order_id'];
        // $user = $this->query->get_data('user_id', 'transaksi', ['kode_transaksi' => $order_id])->row()->user_id;
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
        print_r(json_decode($result));
        // exit;

        // echo json_decode($result);
        // if ($data['data']->metode_pembayaran == null) {
        //     redirect('/payment/' . $order_id);
        // } else {



    }
    function test_mail()
    {
        $this->sent_mail_link('ttoonnii321@gmail.com', 'ASC20211103131724');
    }

    function sent_mail_link($email, $order_id)
    {
        $fullname = $this->query->get_data_simple('user', ['email' => $email])->row()->nama_lengkap;
        $parsing = ['fullname' => $fullname, 'order_id' => $order_id];
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPAutoTLS = true; // enable SMTP authentication
        $mail->SMTPSecure = "tls"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 587; // set the SMTP port for the GMAIL server
        $mail->Username = 'asclepio.website@gmail.com'; // GMAIL username
        $mail->Password = 'websiteasclepiofamos'; // GMAIL password
        $mail->AddAddress($email);
        $mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
        $mail->Subject = 'Transaksi Berhasil #' . $order_id;
        $mail->Body = $this->load->view('front/mail_zoom', $parsing, true);
        $mail->isHTML(true);


        try {
            $mail->Send();
            // echo "Success!";
            return $mail->ErrorInfo;
            // $resp['msg'] = 'Registration complete, please open your email for verify';

        } catch (Exception $e) {
            // echo "Something went bad";
            return $mail->ErrorInfo;
        }

        // $parsing = ['judul' => $judul, 'link' => $link, 'email' => $email];
        // $config = [
        //     'mailtype' => 'html', 'charset' => 'utf-8', 'crlf' => "\r\n", 'newline' => "\r\n"
        // ];
        // $this->load->library('email', $config);
        // $this->email->from('asclepio.website@gmail.com');
        // $this->email->to($email);
        // $this->email->subject('Link Zoom');
        // $body = $this->load->view('front/mail_zoom', $parsing, true);
        // $this->email->message($body);
        // if ($this->email->send()) {
        //     return "berhasil";
        // } else {
        //     return "gagal";
        // }
    }
    function sent_mail_invoice($email, $order_id)
    {
        $fullname = $this->query->get_data_simple('user', ['email' => $email])->row()->nama_lengkap;
        $parsing = ['fullname' => $fullname, 'order_id' => $order_id];
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPAutoTLS = true; // enable SMTP authentication
        $mail->SMTPSecure = "tls"; // sets the prefix to the servier
        $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
        $mail->Port = 587; // set the SMTP port for the GMAIL server
        $mail->Username = 'asclepio.website@gmail.com'; // GMAIL username
        $mail->Password = 'websiteasclepiofamos'; // GMAIL password
        $mail->AddAddress($email);
        $mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
        $mail->Subject = 'INVOICE #' . $order_id;
        $mail->Body = $this->load->view('front/mail_invoice', $parsing, true);
        $mail->isHTML(true);


        try {
            $mail->Send();
            // echo "Success!";
            return $mail->ErrorInfo;
            // $resp['msg'] = 'Registration complete, please open your email for verify';

        } catch (Exception $e) {
            // echo "Something went bad";
            return $mail->ErrorInfo;
        }

        // $parsing = ['judul' => $judul, 'link' => $link, 'email' => $email];
        // $config = [
        //     'mailtype' => 'html', 'charset' => 'utf-8', 'crlf' => "\r\n", 'newline' => "\r\n"
        // ];
        // $this->load->library('email', $config);
        // $this->email->from('asclepio.website@gmail.com');
        // $this->email->to($email);
        // $this->email->subject('Link Zoom');
        // $body = $this->load->view('front/mail_zoom', $parsing, true);
        // $this->email->message($body);
        // if ($this->email->send()) {
        //     return "berhasil";
        // } else {
        //     return "gagal";
        // }
    }

    function sent_mail_cadbury()
    {
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();

        $email = $this->input->post('email');
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth = true; // enable SMTP authentication
        $mail->SMTPAutoTLS = true; // enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
        $mail->Host = "cadburyungkapanhati.com"; // sets GMAIL as the SMTP server
        $mail->Port = 465; // set the SMTP port for the GMAIL server
        $mail->Username = 'no-reply@cadburyungkapanhati.com'; // GMAIL username
        $mail->Password = 'cadburydm26'; // GMAIL password
        $mail->AddAddress($email);
        $mail->SetFrom('no-reply@cadburyungkapanhati.com', 'Asclepio');
        $mail->Subject = 'tes';
        $mail->Body = $this->load->view('front/mail_invoice', null, true);
        $mail->isHTML(true);


        try {
            $mail->Send();
            echo "Success!";
            print($mail->ErrorInfo);
            // $resp['msg'] = 'Registration complete, please open your email for verify';

        } catch (Exception $e) {
            echo "Something went bad";
            print($mail->ErrorInfo);
        }

        // $parsing = ['judul' => $judul, 'link' => $link, 'email' => $email];
        // $config = [
        //     'mailtype' => 'html', 'charset' => 'utf-8', 'crlf' => "\r\n", 'newline' => "\r\n"
        // ];
        // $this->load->library('email', $config);
        // $this->email->from('asclepio.website@gmail.com');
        // $this->email->to($email);
        // $this->email->subject('Link Zoom');
        // $body = $this->load->view('front/mail_zoom', $parsing, true);
        // $this->email->message($body);
        // if ($this->email->send()) {
        //     return "berhasil";
        // } else {
        //     return "gagal";
        // }
    }

    function resend_email()
    {
        $email = $this->input->post('email');
        $order_id = $this->input->post('order_id');
        $fullname = $this->query->get_data_simple('user', ['email' => $email])->row()->nama_lengkap;
        $parsing = ['fullname' => $fullname, 'order_id' => $order_id];
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
        $mail->AddAddress($email);
        $mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
        $mail->Subject = 'Transaksi Berhasil #' . $order_id;
        $mail->Body = $this->load->view('front/mail_zoom', $parsing, true);
        $mail->isHTML(true);


        if ($mail->Send()) {
            $response = [
                'status' => 200,
                'msg_type' => 'success',
                'msg' => 'Email telah terkirim, silahkan cek email Anda',
            ];
        } else {
            $response = [
                'status' => 400,
                'msg_type' => 'error',
                'msg' => 'Email gagal terkirim',
            ];
        }
        echo json_encode($response);
    }
    function resend_invoice()
    {
        $email = $this->input->post('email');
        $order_id = $this->input->post('order_id');
        $fullname = $this->query->get_data_simple('user', ['email' => $email])->row()->nama_lengkap;
        $parsing = ['fullname' => $fullname, 'order_id' => $order_id];
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
        $mail->AddAddress($email);
        $mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
        $mail->Subject = 'INVOICE #' . $order_id;
        $mail->Body = $this->load->view('front/mail_invoice', $parsing, true);
        $mail->isHTML(true);


        if ($mail->Send()) {
            $response = [
                'status' => 200,
                'msg_type' => 'success',
                'msg' => 'Email telah terkirim, silahkan cek email Anda',
            ];
        } else {
            $response = [
                'status' => 400,
                'msg_type' => 'error',
                'msg' => 'Email gagal terkirim',
            ];
        }
        echo json_encode($response);
    }
    function sent_mail_dummy()
    {
        $judul = 'nama kelas';
        $link = 'link.zoom';
        $email = 'ttoonnii321@gmail.com';
        $parsing = ['judul' => $judul, 'link' => $link, 'email' => $email, 'order_id' => 'ASC20220114140331'];
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
        // $mail->SMTPOptions = array(
        //     'ssl' => array(
        //         'verify_peer' => false,
        //         'verify_peer_name' => false,
        //         'allow_self_signed' => true
        //     )
        // );
        $mail->AddAddress($email);
        $mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
        $mail->Subject = 'Link Zoom';
        $mail->Body = $this->load->view('front/mail_zoom', $parsing, true);
        $mail->isHTML(true);
        $mail->SMTPDebug = 4;

        if ($mail->Send()) {
            $response = [
                'status' => 200,
                'msg_type' => 'success',
                'msg' => 'Email telah terkirim, silahkan cek email Anda',
            ];
        } else {
            $response = [
                'status' => 400,
                'msg_type' => 'error',
                'msg' => 'Email gagal terkirim',
            ];
        }
        echo json_encode($response);
        // try {
        //     $mail->Send();
        //     echo "Success!";
        //     echo $mail->ErrorInfo;

        // } catch (Exception $e) {
        //     echo "Something went bad";
        //     echo $mail->ErrorInfo;
        // }
    }

    function cek_voucher($code = '')
    {
        $cek = $this->query->get_data_simple('voucher', ['code_voucher' => $code, 'redeem_by' => $this->session->userdata('id')])->row();
        // print_r($cek);
        // exit;
        // $cek_transaksi = $this->query->get_query('transaksi', ['code_voucher' => $code, 'user_id' => $this->session->userdata('id')]);
        $cek_transaksi = $this->query->get_query("SELECT * FROM transaksi t JOIN transaksi_detail d ON t.id = d.transaksi_id WHERE d.code_voucher = '$code' AND t.user_id = " . $this->session->userdata('id') . " AND d.status = 'success'");
        $used = $cek_transaksi->num_rows();

        if (!$cek) {
            $response = [
                'status' => 404,
                'msg' => 'Voucher tidak ditemukan',
            ];
            echo json_encode($response);
            exit;
        }
        $sisa = $cek->limit_voucher - $used;
        // $cek_cart = $this->query->get_query("SELECT k.jenis_kelas FROM cart c JOIN kelas k ON c.product_id = k.id WHERE c.user_id =" . $this->session->userdata('id') . " ")->row();

        if (!$cek) {
            $response = [
                'status' => 404,
                'msg' => 'Voucher tidak ditemukan',
            ];
            echo json_encode($response);
            exit;
        }

        if ($cek->expired_date < date("Y-m-d")) {
            $response = [
                'status' => 400,
                'msg' => 'Voucher telah expired',
            ];
            echo json_encode($response);
            exit;
        }
        if ($cek->limit_status == 'limited') {
            if ($used >= $cek->limit_voucher || $cek->limit_voucher == 0) {
                $response = [
                    'status' => 400,
                    'msg' => 'Maksimal penggunaan ' . $cek->limit_voucher . ' kali ',
                ];
                echo json_encode($response);
                exit;
            }
        }


        if ($cek->is_spesifik == 0) {
            $response = [
                'status' => 200,
                'voucher_type' => $cek->jenis_voucher,
                'discount' => $cek->discount,
                'jenis_kelas' => $cek->jenis_kelas,
                'jenis_voucher' => $cek->jenis_voucher,
                'msg' => 'Voucher berhasil digunakan',
                'kode_voucher' => $code,
                'is_spesifik' => 0,
                'spesifik' => null,
                'sisa_voucher' => $sisa
            ];
            echo json_encode($response);
            exit;
        }
        if ($cek->is_spesifik == 1) {
            $cek_spesifik = $this->query->get_query("SELECT * FROM voucher_spesifik WHERE voucher_id = $cek->id")->result();
            if ($cek_spesifik) {
                $response = [
                    'status' => 200,
                    'voucher_type' => $cek->jenis_voucher,
                    'discount' => $cek->discount,
                    'jenis_kelas' => $cek->jenis_kelas,
                    'jenis_voucher' => $cek->jenis_voucher,
                    'msg' => 'Voucher berhasil digunakan',
                    'kode_voucher' => $code,
                    'is_spesifik' => 1,
                    'spesifik' => $cek_spesifik,
                    'sisa_voucher' => $sisa
                ];
                echo json_encode($response);
                exit;
            }
        }


        $response = [
            'status' => 404,
            'msg' => 'Voucher tidak ditemukan',
        ];
        echo json_encode($response);
    }
}
