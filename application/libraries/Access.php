<?php 

class Access
{
	
	
	function get_data_user_admin($id)
	{
		$ci = & get_instance();
		$sql = "select a.*, b.user_type_name from users a 
				join user_types b on b.user_type_id = a.user_type_id
				where a.user_id = $id
				";
		
		$query = $ci->db->query($sql);
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = ($row); // render dulu dunk!
		return $result; 
	}
	
	function get_data_user($id)
	{
		$ci = & get_instance();
		$sql = "select a.*, b.creative_id from users a 
				left join creatives b on b.user_id = a.user_id 
				where a.user_id = $id
				";
		
		$query = $ci->db->query($sql);
		
		$result = null;
		foreach ($query->result_array() as $row) $result = ($row);
		return array(
					'user_name' => $result['user_first_name']." ".$result['user_last_name'],
					'creative_id' => $result['creative_id']
		);
	}
	
	function get_user_acces($id,$menu_id) {
		$ci = & get_instance();
		$query = "select a.*,b.permit_acces,c.side_menu_type_parent from users a
				  join permits b on b.user_type_id = a.user_type_id
				  join side_menus c on c.side_menu_id = b.side_menu_id
				  where a.user_id = $id and b.side_menu_id = $menu_id
				  ";
        $query = $ci->db->query($query);
       	$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = ($row); // render dulu dunk!
		return $result; 
	}
	
	function list_menu_lv1($id) {
		$ci = & get_instance();
		$query = "select a.* from side_menus a where a.side_menu_level = $id 
				  ";
        $query = $ci->db->query($query);
        //query();
        if ($query->num_rows() == 0)
            return array();
        $data = $query->result_array();
        foreach ($data as $index => $row) {}
        return $data;
	}
	
	function parent_menu($id,$parent_id) {
		$ci = & get_instance();
		$query = "select b.permit_acces,c.* from users a
				  join permits b on b.user_type_id = a.user_type_id
				  join side_menus c on c.side_menu_id = b.side_menu_id
				  where a.user_id = $id and c.side_menu_parent = $parent_id and b.permit_acces != '' 
				  ";
				  
		$query = $ci->db->query($query);
        
        //query();
        if ($query->num_rows() == 0)
            return array();
        $data = $query->result_array();
        foreach ($data as $index => $row) {}
        return $data;
	}
	
	function notification() {
		$ci = & get_instance();
		$query = "select * from approvals a ";
				  
		$query = $ci->db->query($query);
        
        //query();
        $count = $query->num_rows();
        return $count;
	}
	
	function notification_list($id) {
		$ci = & get_instance();
		$query = "select a.*,b.* from notifications a 
				  join notification_types b on b.notification_type_id = a.notification_type_id
				  where user_type_id = $id and notification_approve = 0
				  ";
				  
		$query = $ci->db->query($query);
        
        //query();
        if ($query->num_rows() == 0)
            return array();
        $data = $query->result_array();
        foreach ($data as $index => $row) {}
        return $data;
	}

	function read_employee_id($id) {
		$ci = & get_instance();
		$query = "select a.employee_id from employees a 
				  join users b on b.employee_id = a.employee_id
				  where user_id = $id 
				  ";
				  
		$query = $ci->db->query($query);
        
        //query();
        $result = null;
        foreach ($query->result_array() as $row) $result = ($row);
        return $result['employee_id'];
	}
	
	public function format_date($date){
		$phpdate = strtotime( $date );
		$new_date = date( 'd M Y', $phpdate );
		
		return $new_date;
	}
	
	public function get_valid_img($img){
		$data_image = getimagesize($img);
		
		$width = $data_image[0];
		$height = $data_image[1];
		
		if($height == 0){
			$height = 1;
		}
		
		$ratio = $width / $height;
		//if($ratio > 1.43){
		if($ratio > 1.5){
			$class = "img_class2";
		}else{
			$class = "img_class";
		}
		return $class;
	}
	
	public function get_valid_profile_img($img){
		$data_image = getimagesize($img);
		
		$width = $data_image[0];
		$height = $data_image[1];
		
		
		if($height == 0){
			$height = 1;
		}
		
		
		$ratio = $width / $height;
		if($ratio > 1){
			$class = "img_class2";
		}else{
			$class = "img_class";
		}
		return $class;
	}
	
	public function get_alert_success($message){
		$result = '<div class="alert-message">
						<div class="alert-message-item">
							<i class="fa fa-check"></i>&nbsp';
		$result .= $message;
		$result .= '</div></div>';
		
		return $result;
	}
	
	public function get_late(){
		$nowtime = date('Y-m-d h:i:s');
		$endtime = strtotime('+ 10 minutes', strtotime($nowtime));
		$endtime = date('Y-m-d H:i:s', $endtime);
		
		$ci = & get_instance();
		$sql = "select count(*) as total from reservations a
				join transaction_tmp b on b.reservation_id = a.reservation_id
				where a.reservation_checkin_real <= '$endtime'"; // ambil seluruh data
		$query = $ci->db->query($sql);
		$result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
		foreach($query->result_array() as $row)	$result = ($row);
		return $result['total']; 
	}

	public function late_booking() {
		$nowtime = date('Y-m-d h:i:s');
		$endtime = strtotime('+ 10 minutes', strtotime($nowtime));
		$endtime = date('Y-m-d H:i:s', $endtime);
		
		$ci = & get_instance();
		$query = "select a.*,c.*,d.room_name  from reservations a
				join transaction_tmp b on b.reservation_id = a.reservation_id
				join customers c on c.customer_id = a.customer_id
				join rooms d on d.room_id = a.room_id
				where a.reservation_checkin_real <= '$endtime'";
        $query = $ci->db->query($query);
        //query();
        if ($query->num_rows() == 0)
            return array();
        $data = $query->result_array();
        foreach ($data as $index => $row) {}
        return $data;
	}
	
	public function month($date){
		$month = substr($date,5,2);
		
		switch($month){
			case '01' : $month_name = 'Januari'; break;
			case '02' : $month_name = 'Februari'; break;
			case '03' : $month_name = 'Maret'; break;
			case '04' : $month_name = 'April'; break;
			case '05' : $month_name = 'Mei'; break;
			case '06' : $month_name = 'Juni'; break;
			case '07' : $month_name = 'Juli'; break;
			case '08' : $month_name = 'Agustus'; break;
			case '09' : $month_name = 'September'; break;
			case '10' : $month_name = 'Oktober'; break;
			case '11' : $month_name = 'November'; break;
			case '12' : $month_name = 'Desember'; break;
		}
		return $month_name;
	}

	public function format_date_indo($date){
		$month = substr($date,5,2);
		$tgl = substr($date,8,2);
		$year = substr($date,0,4);
		
		switch($month){
			case '01' : $month_name = 'Januari'; break;
			case '02' : $month_name = 'Februari'; break;
			case '03' : $month_name = 'Maret'; break;
			case '04' : $month_name = 'April'; break;
			case '05' : $month_name = 'Mei'; break;
			case '06' : $month_name = 'Juni'; break;
			case '07' : $month_name = 'Juli'; break;
			case '08' : $month_name = 'Agustus'; break;
			case '09' : $month_name = 'September'; break;
			case '10' : $month_name = 'Oktober'; break;
			case '11' : $month_name = 'November'; break;
			case '12' : $month_name = 'Desember'; break;
		}

		$date_update = $tgl." ".$month_name." ".$year;

		return $date_update;
	}
	
	public function set_barcode($code)
	{
		//load library
		$this->load->library('zend');
		//load in folder Zend
		$this->zend->load('Zend/Barcode');
		//generate barcode
		Zend_Barcode::render('code128', 'image', array('text'=>$code), array());
	}

	function pembulatan($uang)
	{
		 $ratusan = substr($uang, -3);
		 if($ratusan<500){
		 	$akhir = $uang - $ratusan;
		 }else{
		 	$akhir = $uang + (1000-$ratusan);
		 }
		 return $akhir;
	}

	function pembulatan_kebawah($uang)
	{
		 $ratusan = substr($uang, -3);

		 $akhir = $uang - $ratusan;
		 
		 return $akhir;
	}

	function call_view($nm_view,$param) 
    {
    	$ci = & get_instance();

		$ci->load->view('layout/header',$param);
        $ci->load->view($nm_view,$param);
        $ci->load->view('layout/footer');
    }	

    
	
}

# -- end file -- #
