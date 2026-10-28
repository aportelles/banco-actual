<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
        require_once __DIR__ . '/vendor/autoload.php';
        require_once __DIR__ . '/simulador_paths.php';
         
        $objPHPExcel3 = \PhpOffice\PhpSpreadsheet\IOFactory::load(simulador_upload_path('FIJO-CERTIFICADO.xls'));
         
        $sheetDataFijoCertificado = $objPHPExcel3->getActiveSheet()->toArray(null, true, false, true);
        
        $result[0] = Array($sheetDataFijoCertificado[2]['B'],$sheetDataFijoCertificado[2]['C'],$sheetDataFijoCertificado[2]['D']);
        $result[1] = Array($sheetDataFijoCertificado[3]['B'],$sheetDataFijoCertificado[3]['C'],$sheetDataFijoCertificado[3]['D']);
        $result[2] = Array($sheetDataFijoCertificado[4]['B'],$sheetDataFijoCertificado[4]['C'],$sheetDataFijoCertificado[4]['D']);
        $result[3] = Array($sheetDataFijoCertificado[5]['B'],$sheetDataFijoCertificado[5]['C'],$sheetDataFijoCertificado[5]['D']);
        $result[4] = Array($sheetDataFijoCertificado[6]['B'],$sheetDataFijoCertificado[6]['C'],$sheetDataFijoCertificado[6]['D']);
        $result[5] = Array($sheetDataFijoCertificado[7]['B'],$sheetDataFijoCertificado[7]['C'],$sheetDataFijoCertificado[7]['D']);
        $result[6] = Array($sheetDataFijoCertificado[8]['B'],$sheetDataFijoCertificado[8]['C'],$sheetDataFijoCertificado[8]['D']);
//        print_r($result, false);
        // Este endpoint consume la matriz desde el simulador de depósitos y certificados.
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result, JSON_THROW_ON_ERROR);
 ?>