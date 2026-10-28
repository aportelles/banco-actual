<?php
//set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/'); // Comentarea esta linea

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/simulador_paths.php';

$objPHPExcel2 = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('CREDITO-INVERSIONES.xls'));
$gotArray = $objPHPExcel2->getActiveSheet()->toArray(null, true, false, true);
$resInversiones = null;
$cont = 0;
for ($index = 2; $index <= 12; $index++) {
        $resInversiones[$cont] = Array($gotArray[$index]['A'], $gotArray[$index]['B']);
        $cont++;
}
$json = json_encode($resInversiones);
echo $json;
?>
