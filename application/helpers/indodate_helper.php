<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function set_date($i){


	$bulan = array (
		1  => 'Januari',
		2  => 'Februari',
		3  => 'Maret',
		4  => 'April',
		5  => 'Mei',
		6  => 'Juni',
		7  => 'Juli',
		8  => 'Agustus',
		9  => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember'
	);
	// $pecahkan = explode('-', $tanggal);
	return $bulan[(int)$i];
 
	// return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function set_date_short($tanggal){
	$bulan = array (
		1  => 'Jan',
		2  => 'Feb',
		3  => 'Mar',
		4  => 'Apr',
		5  => 'Mei',
		6  => 'Jun',
		7  => 'Jul',
		8  => 'Aug',
		9  => 'Sep',
		10 => 'Okt',
		11 => 'Nov',
		12 => 'Des'
	);
	$pecahkan = explode('-', $tanggal);
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>