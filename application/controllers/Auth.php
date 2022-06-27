<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'url'));
	}

	public function index()
	{
		$this->session->sess_destroy();
		$this->load->view('page_login');
	}

	// public function do_login()
	// {

	// 	$username 	=	$_POST['user_name'];
	// 	$password   =   $_POST['password'];
	// 	$select = "*";
	// 	$from   = "adms";
	// 	$where 	=	[
	// 		'username' => $username,
	// 		'password' =>  md5($password),
	// 	];
	// 	$result 	=	$this->query->get_data($select, $from, $where)->result();

	// 	if (count($result) > 0) {

	// 		foreach ($result as $val) {
	// 			$session['user_id']  = $val->user_id;
	// 			$session['username'] = $val->username;
	// 			$session['name']     = $val->name;
	// 			$this->session->set_userdata($session);
	// 			$this->session->set_flashdata('msg', 'Selamat datang ' . $val->username);
	// 			redirect('Dashboard');
	// 		}
	// 	}
	// }
	public function register()
	{
		$fullname      = $this->input->post('nama_lengkap');
		$gelar         = $this->input->post('gelar');
		$gender        = $this->input->post('gender');
		$email         = $this->input->post('email');
		$no_wa         = $this->input->post('no_wa');
		$provinsi_id   = $this->input->post('provinsi_id');
		$provinsi_name = $this->input->post('provinsi_name');
		$kota          = $this->input->post('kota');
		$univ          = $this->input->post('univ');
		$instansi      = $this->input->post('instansi');
		$password      = $this->input->post('password');
		$ig 		   = ($this->input->post('ig')) ? $this->input->post('ig') : '';
		$verif_link = base64_encode($fullname . 'verified');
		$insert_data = [
			'nama_lengkap'  => $fullname,
			'gelar'  		=> $gelar,
			'gender'  		=> $gender,
			'nama_lengkap'  => $fullname,
			'email'         => $email,
			'no_wa'         => $no_wa,
			'ig'            => $ig,
			'provinsi_id'   => $provinsi_id,
			'provinsi_name' => $provinsi_name,
			'kota'          => $kota,
			'universitas'   => $univ,
			'instansi'   	=> $instansi,
			'password'      => md5($password),
			'auth_token'    => $verif_link,
		];

		$cek_data = $this->query->get_query("SELECT * FROM user WHERE email = '$email'");
		if ($cek_data->num_rows() > 0) {
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Email kamu sudah terdaftar, silahkan gunakan email lain');
			redirect(base_url() . 'register');
		} else {
			$this->query->insert_for_id('user', NULL, $insert_data);
			$mail = $this->sent_mail_registration($email, $verif_link, $fullname);
			if ($mail != 'berhasil') {
				$this->session->set_flashdata('msg_type', 'error');
				$this->session->set_flashdata('msg', 'Registration Failed, unable to send email');
				redirect(base_url() . 'register');
			} else {
				$this->session->set_flashdata('msg_type', 'success');
				$this->session->set_flashdata('msg', 'Registrasi Berhasil, silahkan cek email Anda untuk verifikasi');
				redirect(base_url() . 'login');
			}
		}
	}
	function sent_mail_registration($email, $verif_link, $fullname)
	{
		$parsing           = ['fullname' => $fullname, 'link' => $verif_link, 'email' => $email];
		$this->load->library('phpmailer_lib');
		$mail              = $this->phpmailer_lib->load();

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth    = true; // enable SMTP authentication
		$mail->SMTPAutoTLS = true; // enable SMTP authentication
		$mail->SMTPSecure  = "tls"; // sets the prefix to the servier
		$mail->Host        = "smtp.gmail.com"; // sets GMAIL as the SMTP server
		$mail->Port        = 587; // set the SMTP port for the GMAIL server
		$mail->Username    = ACCESS_EMAIL; // GMAIL username
		// $mail->Password = 'websiteasclepiofamos'; // GMAIL password
		$mail->Password    = ACCESS_EMAIL_PASSWORD; // GMAIL App password
		$mail->AddAddress($email);
		$mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
		$mail->Subject     = 'Verify Your Asclepio Account';
		$mail->Body        = $this->load->view('front/mail_registration', $parsing, true);
		$mail->isHTML(true);
		try {
			$mail->Send();
			// echo "Success!";
			$resp['msg'] = 'Registration complete, please open your email for verify';
			return "berhasil";

		} catch (Exception $e) {
			// echo "Something went bad";
			echo "gagal :". $mail->ErrorInfo ;
			return 'fail';
		}
		// $config = [
		// 	'mailtype' => 'html', 'charset' => 'utf-8', 'crlf' => "\r\n", 'newline' => "\r\n"
		// ];
		// $this->load->library('email', $config);
		// $this->email->from('asclepio.website@gmail.com');
		// $this->email->to($email);
		// $this->email->subject('Verify Your Asclepio Account');
		// $body = $this->load->view('front/mail_registration', $parsing, true);
		// $this->email->message($body);
		// if ($this->email->send()) {
		// 	return "berhasil";
		// } else {
		// 	return "gagal";
		// }
	}
	function sent_mail_dummy2()
	{
		// $parsing           = ['fullname' => $fullname, 'link' => $verif_link, 'email' => $email];
		$this->load->library('phpmailer_lib');
		$mail              = $this->phpmailer_lib->load();

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth    = true; // enable SMTP authentication
		$mail->SMTPAutoTLS = true; // enable SMTP authentication
		$mail->SMTPSecure  = "tls"; // sets the prefix to the servier
		$mail->Host        = "smtp.gmail.com"; // sets GMAIL as the SMTP server
		$mail->Port        = 587; // set the SMTP port for the GMAIL server
		$mail->Username    = ACCESS_EMAIL; // GMAIL username
		// $mail->Password    = 'websiteasclepiofamos'; // GMAIL password
		$mail->Password    = ACCESS_EMAIL_PASSWORD; // GMAIL password
		$mail->AddAddress('mahmudrisna@gmail.com');
		$mail->SetFrom('asclepio.website@gmail.com', 'Asclepio');
		$mail->Subject     = 'Verify Your Asclepio Account';
		$mail->Body        = '<p>test</p>';
		// $mail->Body        = $this->load->view('front/mail_registration', $parsing, true);
		$mail->isHTML(true);
		try {
			$mail->Send();
			echo "Success!";
			// return "berhasil";
			// $resp['msg'] = 'Registration complete, please open your email for verify';

		} catch (Exception $e) {
			echo $mail->ErrorInfo;

			// return "gagal";
		}
	}
	function verify()
	{
		$verify = $_GET['url'];
		$where = ['auth_token' => $verify,];
		$update = ['is_verified' => 1];
		$this->query->get_query("UPDATE user set is_verified = '1' WHERE auth_token = '$verify'");
		$this->session->set_flashdata('msg_type', 'success');
		$this->session->set_flashdata('msg', 'Verification Success');
		redirect('login');
	}
	public function login()
	{	


		$email    =	$_POST['email'];
		$password = $_POST['password'];
		$url      = $_POST['url'];
		$token    = $_POST['token'];
		$remember = $_POST['remember'];
		
		// debug($_POST);


        if ($email == '' && $password != '') {
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Email tidak boleh kosong');
			redirect('login');
		}
		if ($email != '' && $password == '') {
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Password tidak boleh kosong');
			redirect('login');
		}
		if ($email == '' && $password == '') {
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Email & Password tidak boleh kosong');
			redirect('login');
		}
		$select = "*";
		$from   = "user";
		$where 	=	[
			'email' => $email,
			'password' =>  md5($password),
// 			'is_verified' => '1',
		];
		
		
		$result 	=	$this->query->get_data($select, $from, $where)->result();
        // echo (count($result));
        // echo md5($password);
        // exit;
		if (count($result) > 0) {

			foreach ($result as $val) {
				if ($val->is_verified != 1) {
					$this->session->set_flashdata('msg_type', 'error');
					$this->session->set_flashdata('msg', 'Email belum terverifikasi, silahkan Verifikasi terlebih dahulu');
					redirect('login');
				} else {
					$session['id']  = $val->id;
					$session['nama_lengkap'] = $val->nama_lengkap;
					$session['foto_profil'] = $val->foto_profil;
					$session['email']     = $val->email;
					// $session['customer_phone']     = $val->customer_phone;

					$this->session->set_userdata($session);
					$this->session->set_flashdata('msg_type', 'success');
					$this->session->set_flashdata('msg', 'Selamat datang ' . $val->nama_lengkap . ' di Asclepio ' . $token);
					
					if ($remember) {
						set_cookie('asclepio_email',$email,'604800'); 
						set_cookie('asclepio_password',$password,'604800'); 
					}
					if ($token) {
						$this->verif($token);
					}
                    // redirect(base_url());
					if ($url == 'redirect_to_ticket') {
						redirect('profile/tiket');
					} else {
						redirect(base_url());
					}
				}
			}
		} else {
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Username / Password salah , silahkan coba kembali');
			if ($url == 'redirect_to_ticket') {
				redirect('login?url=redirect_to_ticket');
			} else {
				redirect('login');
			}
		}
	}
	function verif($token)
	{
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
	function logout_cust()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}
	function do_logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('authadmin'));
	}
	function save_token()
	{
		$token = $this->input->post('token');
		$update = $this->query->update_data('admins', ['id' => $this->session->userdata('user_id')], ['token' => $token]);
		if ($token) {
			$response = [
				'status' => 200,
			];
		} else {
			$response = [
				'status' => 400,
			];
		}

		echo json_encode($response);
	}
	public function reset_password()
	{
		$mail = $_POST['email'];
		$newpassword = $mail . date('Y-m-d') . rand(1, 99);
		$new = strtoupper(substr(md5($newpassword), 0, 6));
		$password_to_db = md5($new);
		$update = ['password' => $password_to_db,];
		$where = ['email' => $mail];
		$this->query->insert_for_id('user', $where, $update);
		$sendmail = $this->sent_mail_forgot_password($mail, $new);
		if ($sendmail != 'berhasil') {
			$this->session->set_flashdata('msg_type', 'error');
			$this->session->set_flashdata('msg', 'Email tidak dapat terkirim');
		} else {
			$this->session->set_flashdata('msg_type', 'success');
			$this->session->set_flashdata('msg', 'Email telah terkirim, silahkan cek email anda.');
		}

		redirect(base_url('login'));
	}
	function sent_mail_forgot_password($email, $newpassword)
	{
		$fullname = $this->query->get_data_simple('user', ['email' => $email])->row()->nama_lengkap;
		$parsing = ['fullname' => $fullname, 'newpassword' => $newpassword,];
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
		$mail->Subject = 'Lupa Kata Sandi';
		$mail->Body = $this->load->view('front/mail_forgot', $parsing, true);
		$mail->isHTML(true);
		try {
			$mail->Send();
			// echo "Success!";
			return "berhasil";
			// $resp['msg'] = 'Registration complete, please open your email for verify';

		} catch (Exception $e) {
			// echo "Something went bad";
			return "gagal";
		}
	}
}
