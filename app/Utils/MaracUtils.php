<?php

namespace App\Utils;

use App\ParametroSistema;
use Dompdf\Dompdf;
use Illuminate\Database\Eloquent\Model;

class MaracUtils
{
  public static function ActivarDescargaExcelSegunParametro(string $filename)
  {
    $descargarExcel = ParametroSistema::exportacionExcelActivada();
    if ($descargarExcel) {

      header('Pragma: public');
      header('Expires: 0');

      header('Content-type: application/vnd.ms-excel');
      header("Content-Disposition: attachment; filename=$filename");
      header('Pragma: no-cache');
    }
  }
  public static function FormatearMonto(float $monto)
  {
    return  number_format($monto, 2, '.', ' ');
  }

  public static function rellernarCerosIzq($numero, $nDigitos)
  {
    return str_pad($numero, $nDigitos, "0", STR_PAD_LEFT);
  }

  public static function BuildDompdf($html_rendered_view): Dompdf
  {
    $dompdf = new Dompdf();
    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled' => true));
    $dompdf->setOptions($options);
    $dompdf->setPaper('A4');

    $dompdf->loadHtml($html_rendered_view);
    $dompdf->render();

    return $dompdf;
  }
  public static function ResponsePdf($output, bool $download, string $filename)
  {
    if ($download) {
      $header = 'attachment;';
    } else {
      $header = 'inline;';
    }

    $header = $header . ' filename="' . $filename . '"';

    return response($output, 200)
      ->header('Content-Type', 'application/pdf')
      ->header('Content-Disposition', $header);
  }
}
