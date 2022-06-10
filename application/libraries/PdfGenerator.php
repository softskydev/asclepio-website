<?php
use Dompdf\Dompdf;
class PdfGenerator
{
  public function generate($html,$filename,$paper,$orientation)
  {
    define('DOMPDF_ENABLE_AUTOLOAD', false);
    define('DOMPDF_ENABLE_REMOTE', true);
    define('DOMPDF_ENABLE_JAVASCRIPT', true);
    ini_set('memory_limit', '-1');
    require_once("./vendor/dompdf/dompdf/autoload.inc.php");
 
    $dompdf = new Dompdf();
    $dompdf->set_paper($paper,$orientation);
    $dompdf->load_html($html);
    $dompdf->render();
    $dompdf->stream($filename.'.pdf',array("Attachment"=>0));
  }
}

?>