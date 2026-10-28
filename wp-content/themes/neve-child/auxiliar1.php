<?php

//set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');// Comentarea esta linea

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/simulador_paths.php';

$objPHPExcel1 = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('CREDITO-AL-CONSUMO.xls'));
$gotArray = $objPHPExcel1->getActiveSheet()->toArray(null, true, false, true);
$resCredito = null;
$cont = 0;
for ($index = 2; $index <= 12; $index++) {
        $resCredito[$cont] = Array($gotArray[$index]['A'], $gotArray[$index]['B']);
        $cont++;
}
// El endpoint responde exclusivamente con las tasas que usa el cálculo de cuotas de crédito.
header('Content-Type: application/json; charset=utf-8');
echo json_encode($resCredito, JSON_THROW_ON_ERROR);

?>
