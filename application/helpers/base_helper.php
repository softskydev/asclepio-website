<?php 

function create_slug($text){
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // trim
  $text = trim($text, '-');
  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);
  // lowercase
  $text = strtolower($text);
  return $text;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}



function unique_random_number($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}


function debug($data){

  echo "<pre>";
  print_r($data);
  exit;
}

function set_date($tanggal){


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
  $pecahkan = explode('-', $tanggal);
 
  return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function set_date_short($tanggal){
  $bulan = array (
    1  => 'Jan',
    2  => 'Feb',
    3  => 'Mar',
    4  => 'Apr',
    5  => 'May',
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

function terbilang($x){

    $abil = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");

    if ($x < 12)

      return " " . $abil[$x];

    elseif ($x < 20)

      return Terbilang($x - 10) . " Belas";

    elseif ($x < 100)

      return Terbilang($x / 10) . " Puluh" . Terbilang($x % 10);

    elseif ($x < 200)

      return " Seratus" . Terbilang($x - 100);

    elseif ($x < 1000)

      return Terbilang($x / 100) . " Ratus" . Terbilang($x % 100);

    elseif ($x < 2000)

      return " Seribu" . Terbilang($x - 1000);

    elseif ($x < 1000000)

      return Terbilang($x / 1000) . " Ribu" . Terbilang($x % 1000);

    elseif ($x < 1000000000)

      return Terbilang($x / 1000000) . " Juta" . Terbilang($x % 1000000);
  }

  function link_active($uri , $url){
      if ($uri == $url) {
        return 'class="active"';
      } else {
        return '';
      }
  }

  function group_active($uri , $array){
      $return = [];

      if (in_array($uri , $array)) {
          $return['li']     = 'class="active-page"';    
          $return['a_href'] = 'class="active"';
      } else {
          $return['li']     = '';    
          $return['a_href'] = '';
      }

      return $return;
  }

  function convertToK($num){
    if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('K', 'M', 'B', 'T');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

    }

    return $num;

  }
  
 

?>