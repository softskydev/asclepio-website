<?php

require_once 'source/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

function generate_pdf($view, $data = [], $filename = 'Laporan', $paper = 'F4', $orientation = 'potrait') {
	$ci =& get_instance();

	$dompdf = new Dompdf();
	$html   = $ci->load->view($view, $data, TRUE);
	$dompdf->load_html($html);
	$dompdf->setPaper($paper, $orientation);
	$dompdf->render();
	$dompdf->stream($filename.'.pdf', array('Attachment' => FALSE));
}