<?php
	require('../../../media/PHPExcel.php'); //call the parent class
	require_once('../class/oop.php');
	
	// Add a get or post function here
	// Note: All php functions will work here except for codes that will display something like echo
	
	if($_GET['date_request'] != '') {
		$date_request 	= explode(" - ",$_GET['date_request']);
		$date_req_from	= date('Y-m-d', strtotime($date_request[0]));
		$date_req_to	= date('Y-m-d', strtotime($date_request[1]));
	}
	if($_GET['date_ot'] != '') {
		$date_ot 		= explode(" - ",$_GET['date_ot']);
		$date_ot_from	= date('Y-m-d', strtotime($date_ot[0]));
		$date_ot_to		= date('Y-m-d', strtotime($date_ot[1]));
	}
	if($_GET['ot_range'] != '') {
		$ot_range 		= explode(" - ",$_GET['ot_range']);
		$ot_date_from	= date('Y-m-d', strtotime($ot_range[0]));
		$ot_date_to		= date('Y-m-d', strtotime($ot_range[1]));
	}
	$ot_type 		= $_GET['ot_type'];
	$ot_status 		= $_GET['ot_status'];
	$username 		= $_GET['username'];
		
	//create new phpexcel page
	$objPHPExcel = new PHPExcel;
	$objPHPExcel->getDefaultStyle()->getFont()->setName('Lucida Fax');
	//set font
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
	
	$objSheet = $objPHPExcel->getActiveSheet();
	$title = "OTKS Overtime System"; //set title cont.
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
	$objSheet->getStyle('A4:LJ4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	
	//FONT SIZE AND STYLE CONFIGURATION
	$objSheet->getStyle('A1')->getFont()->setBold(true)->setSize(16); 
	$objSheet->getStyle('A2')->getFont()->setBold(true)->setSize(13); 
	$objSheet->getStyle('A4:L4')->getFont()->setBold(true)->setSize(10); 
			
	//SET WIDTH
	$objSheet->getColumnDimension('A')->setWidth(15);
	$objSheet->getColumnDimension('B')->setWidth(30);
	$objSheet->getColumnDimension('C')->setWidth(20);
	$objSheet->getColumnDimension('D')->setWidth(20);
	$objSheet->getColumnDimension('E')->setWidth(20);
	$objSheet->getColumnDimension('F')->setWidth(20);
	$objSheet->getColumnDimension('G')->setWidth(30);
	$objSheet->getColumnDimension('H')->setWidth(20);
	$objSheet->getColumnDimension('I')->setWidth(20);
	$objSheet->getColumnDimension('J')->setWidth(30);
	$objSheet->getColumnDimension('K')->setWidth(30);
	$objSheet->getColumnDimension('L')->setWidth(30);
		
	//SET HEIGHT
	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(23);
	$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(18);
	$objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
	$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(15);
	
	//Placing a value into a cell
	$objSheet->getCell('A1')->setValue('Filed Overtime Report');
	if($_GET['ot_range'] != '') {
		$objSheet->getCell('A2')->setValue('From '.date('M d, Y', strtotime($ot_date_from)).' To '.date('M d, Y', strtotime($ot_date_to)));
	}
	$objSheet->getCell('A4')->setValue('Employee #');
	$objSheet->getCell('B4')->setValue('Employee Name');
	$objSheet->getCell('C4')->setValue('Date / Time In');
	$objSheet->getCell('D4')->setValue('Date / Time Out');
	$objSheet->getCell('E4')->setValue('OT Date');
	$objSheet->getCell('F4')->setValue('OT Hours');
	$objSheet->getCell('G4')->setValue('Remarks');
	$objSheet->getCell('H4')->setValue('Status');
	$objSheet->getCell('I4')->setValue('Approver');
	$objSheet->getCell('J4')->setValue('Overtime Type');
	$objSheet->getCell('K4')->setValue('Last Update');
	$objSheet->getCell('L4')->setValue('Last Update By');
	
	if($_GET['date_request'] != '') {
		$where_date_request = " AND (main.req_date BETWEEN '$date_req_from' AND '$date_req_to') ";
	}
	if($_GET['date_ot'] != '') {
		$where_date_request = " AND (details.ot_date BETWEEN '$date_ot_from' AND '$date_ot_to') ";
	}
	if($ot_type != '-') {
		$where_ot_type = " AND (main.req_type='$ot_type') ";
	}
	if($_GET['ot_range'] != '') {
		$where_ot_range = " AND ((main.req_datefrom BETWEEN '$ot_date_from' AND '$ot_date_to') OR (main.req_dateto BETWEEN '$ot_date_from' AND '$ot_date_to')) ";
	}	
	if($ot_status != '-') {
		$where_status = ' AND main.req_status='.$ot_status;
	}
	/* Iterate the data */
	$array_fields = array('details.date_time_in', 'details.date_time_out', 'details.ot_date', 'details.empno', 'details.valid_ot', 'details.remarks', 'main.req_status', 'main.req_approver', 'main.req_type','main.lastupdate', 'main.username','main.lastupdate', 'main.username');
	$table 	   	= 'tk_overtime_details details';
	$joins 	   	= 'LEFT JOIN tkovertime_main main ON main.pkid = details.fkid_ot_main';
	$sql_where 	= 'WHERE main.req_approver="'.$username.'" AND main.logdel=0 AND details.logdel=0 '.$where_date_request.$where_ot_type.$where_ot_range.$where_status;
	$sql_order 	= 'ORDER BY details.ot_date';
	$sql_limit 	= '';
	$row_count	= 5;
	$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
	while($row = mysqli_fetch_array($result)){
		$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$row_count, $row["empno"],PHPExcel_Cell_DataType::TYPE_STRING);
		/* Get the full name of employee */
		$array_fields_emp_name  = array('CONCAT(`firstname`," ",`lastname`) AS emp_name');
		$table_name 	   		= 'db_hris.vw_EmpInfo_Rapid';
		$sql_where_name 		= 'WHERE EmpNo="'.$row["empno"].'"';
		$result_emp_name 		= OT::getInstance()->select_query($array_fields_emp_name,$table_name,'',$sql_where_name,'','');
		if($row_emp_name = mysqli_fetch_array($result_emp_name)) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row_count, $row_emp_name["emp_name"],PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$row_count, 'ERROR',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		if($row["date_time_in"] != '') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row_count, date('M d, Y h:i:s',strtotime($row["date_time_in"])),PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$row_count, '',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		if($row["date_time_out"] != '') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$row_count, date('M d, Y h:i:s',strtotime($row["date_time_out"])),PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$row_count, '',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		if($row["ot_date"] != '') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$row_count, date('M d, Y',strtotime($row["ot_date"])),PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$row_count, '',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		
		// $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$row_count, $row["valid_ot"],PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$row_count, number_format($row["valid_ot"],2,".",""));
		$objPHPExcel->getActiveSheet()->getStyle('F'.$row_count)->getNumberFormat()->setFormatCode('#,##0.00');
		$objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$row_count, $row["remarks"],PHPExcel_Cell_DataType::TYPE_STRING);
		if($row["req_status"] == 0) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$row_count, 'Draft',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row["req_status"] == 1) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$row_count, 'For Approval',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row["req_status"] == 2) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$row_count, 'Approved',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row["req_status"] == 3) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$row_count, 'Disapproved',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row["req_status"] == 4) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$row_count, 'Cancelled',PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$row_count, 'Cancelled',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		/* Get the full name of approver */
		$array_fields_approver_name  = array('CONCAT(`firstname`," ",`lastname`) AS emp_name');
		$sql_where_app_name 		 = 'WHERE username="'.$row["req_approver"].'"';
		$result_app_name 			 = OT::getInstance()->select_query($array_fields_approver_name,$table_name,'',$sql_where_app_name,'','');
		if($row_app_name = mysqli_fetch_array($result_app_name)) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$row_count, $row_app_name["emp_name"],PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$row_count, 'ERROR',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		/* Get the equivalent overtime */
		if($row['req_type'] == '1') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, 'Regular',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row['req_type'] == '2') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, 'Legal Sunday',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row['req_type'] == '3') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, 'Sunday',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row['req_type'] == '4') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, 'Special Non Working Holiday',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row['req_type'] == '5') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, 'Sunday/Legal Holiday',PHPExcel_Cell_DataType::TYPE_STRING);
		} else if($row['req_type'] == '6') {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, 'Sunday/Special Holiday',PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$row_count, 'ERROR',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		
		$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$row_count, $row['lastupdate'],PHPExcel_Cell_DataType::TYPE_STRING);
		/* Get the full name of username */
		$array_fields_approver_name  = array('CONCAT(`firstname`," ",`lastname`) AS emp_name');
		$sql_where_app_name 		 = 'WHERE username="'.$row["username"].'"';
		$result_app_name 			 = OT::getInstance()->select_query($array_fields_approver_name,$table_name,'',$sql_where_app_name,'','');
		if($row_app_name = mysqli_fetch_array($result_app_name)) {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$row_count, $row_app_name["emp_name"],PHPExcel_Cell_DataType::TYPE_STRING);
		} else {
			$objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$row_count, 'ERROR',PHPExcel_Cell_DataType::TYPE_STRING);
		}
		
		/* Add some style :) */
		$objSheet->getStyle('A'.$row_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('C'.$row_count.':F'.$row_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('H'.$row_count.':L'.$row_count)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objSheet->getStyle('A'.$row_count.':L'.$row_count)->applyFromArray($styleArray);
	
		$row_count++;
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