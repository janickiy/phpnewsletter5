<?php

/********************************************
 * PHP Newsletter 5.3.1
 * Copyright (c) 2006-2018 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

// authorization
Auth::authorization();

session_write_close();

$autInfo = Auth::getAutInfo(Auth::getAutId());

if (Pnl::CheckAccess($autInfo['role'], 'admin,moderator')) throw new Exception403(core::getLanguage('str', 'dont_have_permission_to_access'));

core::requireEx('libs', "PHPExcel/PHPExcel.php");

$pExcel = new PHPExcel();
$pExcel->setActiveSheetIndex(0);
$aSheet = $pExcel->getActiveSheet();
$aSheet->setTitle(core::getLanguage('str', 'referral_report'));

$arrs = $data->getLogList($_GET['url']);

$aSheet->setCellValue('A1',core::getLanguage('str', 'url'));
$aSheet->setCellValue('B1',core::getLanguage('str', 'email'));
$aSheet->setCellValue('C1',core::getLanguage('str', 'time'));

$aSheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$aSheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EE7171');
$aSheet->getStyle('B1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$aSheet->getStyle('B1')->getFill()->getStartColor()->setRGB('EE7171');
$aSheet->getStyle('C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$aSheet->getStyle('C1')->getFill()->getStartColor()->setRGB('EE7171');

$aSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$aSheet->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$aSheet->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

if (is_array($arrs)){
    $i=1;

    foreach($arrs as $row){
        $i++;

        $aSheet->setCellValue('A'.$i, $row['url']);
        $aSheet->setCellValue('B'.$i, $row['email']);
        $aSheet->setCellValue('C'.$i, $status);

        $aSheet->getStyle('D'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $aSheet->getStyle('E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $aSheet->setCellValue('A'.$i, $row['url']);
        $aSheet->setCellValue('B'.$i, $row['email']);
        $aSheet->setCellValue('C'.$i, $row['time']);
    }
}

$aSheet->getColumnDimension('A')->setWidth(30);
$aSheet->getColumnDimension('B')->setWidth(25);
$aSheet->getColumnDimension('C')->setWidth(15);

core::requireEx('libs', 'PHPExcel/PHPExcel/Writer/Excel5.php');

$objWriter = new PHPExcel_Writer_Excel5($pExcel);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="redirectlogstat_' . $timelog . '.xls"');
header('Cache-Control: max-age=0');
$objWriter->save('php://output');