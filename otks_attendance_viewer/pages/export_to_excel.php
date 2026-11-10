<?php
	require('../../../media/PHPExcel.php'); //call the parent class
	require_once('../class/otks.php');
	
	// Add a get or post function here
	// Note: All php functions will work here except for codes that will display something like echo
	
	$start_date = $_GET['start_date'];
	$end_date 	= $_GET['end_date'];
	$empno 		= $_GET['empno'];
	// $start_date = '2017-01-30';
	// $end_date = '2017-02-28';
	// $empno 		= 'J005';
		
	//create new phpexcel page
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Lucida Fax');
	//set font
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	
	$objSheet = $objPHPExcel->getActiveSheet();
	$title = "OTKS Attendance"; //set title cont.
	$objSheet->setTitle($title); //set title cont.
	
		//BORDERS STYLE
	//set all borders corner to thin 
	$styleArray = array(
	  'borders' => array(
		'allborders' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN //set borders
		)
	  ),
	  'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID, //set back color
        'color' => array('rgb'=>'FFFFFF'),
		)
	); 
	
	$styleArray2 = array(
	  'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'FFFFFF'),		
		)
	);
	
	$default_border = array(
		'style' => PHPExcel_Style_Border::BORDER_THIN
	);

	$styleArray3 = array(
	  'borders' => array(
		'bottom' => $default_border,
        'left' => $default_border,
        'top' => $default_border,
        'right' => $default_border,
	  )
	);
	
	$styleArray4 = array(
	  'borders' => array(
		'bottom' => $default_border	//set border only at the bottom
	  )
	);
	//how to use the style, values can also b replaced with a variable
	$objSheet->getStyle('A1:Z999')->applyFromArray($styleArray2);
	$objSheet->getStyle('A4:L4')->applyFromArray($styleArray);
	
	// Set Orientation, size and scaling
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
	$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
	
	//WORD WRAP
	$objPHPExcel->getActiveSheet()->getStyle('A2:Z999')->getAlignment()->setWrapText(true);
	
	//MERGING OF CELLS
	$objSheet->mergeCells('A1:L1'); 
	$objSheet->mergeCells('A2:L2'); 
	
	//ALIGNMENT SETTING
	$objSheet->getStyle('A1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A2:L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objSheet->getStyle('A4:L4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	//FONT SIZE AND STYLE CONFIGURATION
	$objSheet->getStyle('A1')->getFont()->setBold(true)->setSize(16); 
	$objSheet->getStyle('A2')->getFont()->setBold(true)->setSize(13); 
	$objSheet->getStyle('A4:L4')->getFont()->setBold(true)->setSize(10); 
			
	//SET WIDTH
	$objSheet->getColumnDimension('A')->setWidth(15);
	$objSheet->getColumnDimension('B')->setWidth(15);
	$objSheet->getColumnDimension('C')->setWidth(15);
	$objSheet->getColumnDimension('D')->setWidth(15);
	$objSheet->getColumnDimension('E')->setWidth(15);
	$objSheet->getColumnDimension('F')->setWidth(15);
	$objSheet->getColumnDimension('G')->setWidth(15);
	$objSheet->getColumnDimension('H')->setWidth(20);
	$objSheet->getColumnDimension('I')->setWidth(30);
	$objSheet->getColumnDimension('J')->setWidth(30);
	$objSheet->getColumnDimension('K')->setWidth(30);
	$objSheet->getColumnDimension('L')->setWidth(30);
		
	//SET HEIGHT
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(23);
	$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(18);
	$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);
	
	//Placing a value into a cell
	$objSheet->getCell('A1')->setValue(strtoupper($empno) . ' Attendance');
	
	if($start_date != '' && $end_date != '') {
		$objSheet->getCell('A2')->setValue('from ' . date('M d, Y', strtotime($start_date)) . ' to ' . date('M d, Y', strtotime($end_date)));
	}
	$objSheet->getCell('A4')->setValue('Inconsistency');
	$objSheet->getCell('B4')->setValue('Date In');
	$objSheet->getCell('C4')->setValue('Time In');
	$objSheet->getCell('D4')->setValue('Mode In');
	$objSheet->getCell('E4')->setValue('Date Out');
	$objSheet->getCell('F4')->setValue('Time Out');
	$objSheet->getCell('G4')->setValue('Mode Out');
	$objSheet->getCell('H4')->setValue('Employee #');
	$objSheet->getCell('I4')->setValue('Employee Name');
	$objSheet->getCell('J4')->setValue('Department');
	$objSheet->getCell('K4')->setValue('Position');
	$objSheet->getCell('L4')->setValue('Section');
	
	if($start_date != '' && $end_date != '' && $empno != '' ) {
		$array_fields = array('pkid','date','time_in','mode_in','date_out','time_out','mode_out','empno','LastName','Department','Position','Section','FirstName');
		$table 	   	= 'vw_raw_data';
		$joins 	   	= '';
		$sql_where 	= "WHERE ((date BETWEEN '" . $start_date . "' AND '" . $end_date . "') OR (date_out BETWEEN '" . $start_date . "' AND '" . $end_date . "')) AND empno = '".$empno."'";
		$sql_order 	= '';
		$sql_limit 	= '';
		$row_count	= 5;
		$result = OTKS::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
		while($row = mysqli_fetch_array($result)){
			if($row['time_in'] == "" || $row['time_out'] == ""){
				$inconsistencies = 'YES';
			}else{
				$inconsistencies = '';
			}
			
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row_count, $inconsistencies,PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row_count, $row["date"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row_count, $row["time_in"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$row_count, $row["mode_in"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$row_count, $row["date_out"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$row_count, $row["time_out"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$row_count, $row["mode_out"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$row_count, $row["empno"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$row_count, $row["LastName"].', '.$row['FirstName'],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, $row["Department"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$row_count, $row["Position"],PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$row_count, $row["Section"],PHPExcel_Cell_DataType::TYPE_STRING);
			
			
			/* Add some style :) */
			$objSheet->getStyle('A'.$row_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A'.$row_count.':L'.$row_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objSheet->getStyle('A'.$row_count.':L'.$row_count)->applyFromArray($styleArray);
		
			$row_count++;
		}
	} else {
		
	}
	unset($styleArray);
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename=OTKS_Overtime'.date('m-Y').'.xlsx'); //used for excel 2007 format
	//header('Content-Disposition: attachment;filename=PR Information.xls'); // used for excel 2003 format
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); //used for excel 2007 format
	//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // used for excel 2003 format
	$objWriter->save('php://output');
?>