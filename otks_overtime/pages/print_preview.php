<?php
require_once('../class/oop.php');
// Include the main TCPDF library (search for installation path).
require_once('../../../media/tcpdf/tcpdf_include.php');

class MYPDF extends TCPDF {
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'This is a system generated report by Overtime System. ['.date('M d, Y h:i:s A').'] Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pkid = $_GET['pkid'];
$username = $_GET['username'];
//$pkid = 1;
//$username = 'ronfern';

/* Load main record */
$array_fields = array("req_by","req_status","IF(`req_type` = '1','Regular',IF(`req_type`= '2','Legal Sunday',IF(`req_type`='3','Sunday',IF(`req_type`='4','Special Non Working Holiday',IF(`req_type`='5','Sunday/Legal Holiday',IF(`req_type`='6','Sunday/Special Holiday','ERROR!')))))) as req_type","req_date","req_justification","req_manpower","req_datefrom","req_dateto","req_approver");
$table 	   	= 'db_otks.tkovertime_main';
$joins 	   	= '';
$sql_where 	= 'WHERE `pkid`="'.$pkid.'" AND `logdel`=0';
$sql_order 	= '';
$sql_limit 	= '';
$result = OT::getInstance()->select_query($array_fields,$table,$joins,$sql_where,$sql_order,$sql_limit);
//		$return['msg'] = $result;
if($row = mysqli_fetch_array($result)){
    $req_by 	        = $row['req_by'];
    $req_status 	    = $row['req_status'];
    $req_type 	        = $row['req_type'];
    $req_date 	        = $row['req_date'];
    $req_datefrom 	    = $row['req_datefrom'];
    $req_dateto     	= $row['req_dateto'];
    $req_manpower 	    = $row['req_manpower'];
    $req_justification  = $row['req_justification'];
    $req_approver       = $row['req_approver'];
}

$array_fields_emp_no = array('lastname','firstname','middlename','lastname','Division','Department');
$table_emp_no 	   	= 'db_hris.vw_EmpInfo_Rapid';
$joins_emp_no 	   	= '';
$sql_where_emp_no 	= 'WHERE username = "'.$req_by.'"';
$sql_order_emp_no 	= '';
$sql_limit_emp_no 	= '';
$result_emp_no = OT::getInstance()->select_query($array_fields_emp_no,$table_emp_no,$joins_emp_no,$sql_where_emp_no,$sql_order_emp_no,$sql_limit_emp_no);
if($row = mysqli_fetch_array($result_emp_no)){
    $EmpNo 			= $row['EmpNo'];
    $lastname 		= $row['lastname'];
    $firstname 		= $row['firstname'];
    $Division 		= $row['Division'];
    $Department 	= $row['Department'];
    $requestor_name = $lastname . ', '.$firstname;
}

if($req_status == 0) {
    $status = '<td style="width:22%;font-weight:bold;font-size:20px;font:Arial;color:black;align:right;" colspan="1"><i>[DRAFT REQUEST] </i></td>';
} else if($req_status == 1) {
    $status = '<td style="width:22%;font-weight:bold;font-size:20px;font:Arial;color:blue;align:right;" colspan="1"><i>[FOR APPROVAL] </i></td>';
} else if($req_status == 2) {
    $status = '<td style="width:22%;font-weight:bold;font-size:20px;font:Arial;color:blue;align:right;" colspan="1"><i>[APPROVED] </i></td>';
} else if($req_status == 3) {
    $status = '<td style="width:22%;font-weight:bold;font-size:20px;font:Arial;color:red;align:right;" colspan="1"><i>[DISAPPROVED] </i></td>';
} else if($req_status == 4) {
    $status = '<td style="width:22%;font-weight:bold;font-size:20px;font:Arial;color:red;align:right;" colspan="1"><i>[CANCELLED] </i></td>';
} else {
    $status = "ERROR!";
}

// set font
$pdf->SetFont('', '', 10);

// add a page
$pdf->AddPage('L');
$main_info = '
	<table style="width:100%;">
        <tr>
            <td style="width:70%;font-weight:bold;font-size:20px;font:Arial;" colspan="3"><i>Overtime Authorization Report </i></td>
            '.$status.'
        </tr>
		<tr>
			<td style="width:20%;font-weight:bold;">DEPARTMENT:</td>
			<td style="width:30%;"><i><u>'.$Department.'</u></i></td>
			<td style="width:20%;font-weight:bold;">OT Type:</td>
			<td style="width:30%;"><i><u>'.$req_type.'</u></i></td>
		</tr>
		<tr>
			<td style="width:20%;font-weight:bold;">DIVISION:</td>
			<td style="width:30%;"><i><u>'.$Division.'</u></i></td>
			<td style="width:30%;font-weight:bold;">MANPOWER INVOLVED:</td>
			<td style="width:20%;"><i><u>'.$req_manpower.'</u></i></td>
		</tr>
		<tr>
			<td style="width:20%;font-weight:bold;">JUSTIFICATION:</td>
			<td style="width:30%;"><i><u>'.$req_justification.'</u></i></td>
			<td style="width:10%;"><b>FROM: </b></td>
			<td style="width:15%;"><i><u>'.date('M d, Y',strtotime($req_datefrom)).'</u></i></td>
			<td style="width:10%;"><b>TO: </b></td>
			<td style="width:15%;"><i><u>'.date('M d, Y',strtotime($req_dateto)).'</u></i></td>
		</tr>
	</table><br><br><br>';
$pdf->writeHTMLCell(0, '', '', '12', $main_info, 0, 0, 0, true, 'J', true);
$title = '
    <h4>LIST OF AUTHORIZED EMPLOYEE WHO WILL RENDER OVERTIME</h4>';
$pdf->writeHTMLCell(0, '', '', '48', $title, 0, 0, 0, true, 'J', true);
$overtime = '
    <table>
        <tr style="font-weight:bold;">
            <th style="width:5%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">EN</th>
            <th style="width:15%;border-bottom:1pt solid black;border-top:1pt solid black;">Employee Name</th>
            <th style="width:10%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">Date / Time In</th>
            <th style="width:10%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">Date / Time Out</th>
            <th style="width:10%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">OT Date</th>
            <th style="width:5%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">OT Filed</th>
            <th style="width:5%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">Valid OT</th>
            <th style="width:15%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">Remarks</th>
            <th style="width:15%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">System Comment</th>
            <th style="width:10%;text-align:center;border-bottom:1pt solid black;border-top:1pt solid black;">Signature</th>
        </tr>';

$array_fields_details = array('CONCAT(hris.lastname,", ",hris.firstname) as emp_name','ot.ot_date', 'ot.empno', 'ot.filed_ot', 'ot.valid_ot', 'ot.remarks', 'ot.system_comment');
$table_details 	   	= 'tk_overtime_details ot';
$joins_details 	   	= 'INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.EmpNo = ot.empno';
$sql_order_details 	= 'ORDER BY ot.pkid';
$sql_limit_details 	= '';

if($req_status != 0) {
    $sql_where_details 	= 'WHERE ot.fkid_ot_main="'.$pkid.'" AND ot.logdel=0';
} else {
    $sql_where_details 	= 'WHERE ot.fkid_ot_main="'.$pkid.'" AND ot.logdel=0';
}

$result_details = OT::getInstance()->select_query($array_fields_details,$table_details,$joins_details,$sql_where_details,$sql_order_details,$sql_limit_details);
$ctr = 0;
$record_count = 0;
while($row_details = mysqli_fetch_array($result_details)){
    $emp_name 	= $row_details['emp_name'];
    $ot_date	= $row_details['ot_date'];
    $empno 		= $row_details['empno'];
    $filed_ot 	= $row_details['filed_ot'];
    $valid_ot 	= $row_details['valid_ot'];
    $remarks 	= $row_details['remarks'];
    $system_comment 	= $row_details['system_comment'];
    
    if($system_comment == 'Multiple time in / time out! System cannot validate the overtime due to multiple record found in the set overtime date. Please contact Finance Department for attendance or print the overtime using manual process.') {
        $system_comment = 'Multiple time in / time out!';
    } 
    
    $array_fields_raw = array('time_in', 'date_out', 'time_out');
    $table_raw 	   	= 'db_otks.tkdataraw';
    $joins_raw 	   	= '';
    $sql_where_raw 	= 'WHERE date="'.$ot_date.'" AND empno="'.$empno.'"';
    $sql_order_raw 	= '';
    $sql_limit_raw 	= '';
    $result_raw = OT::getInstance()->select_query($array_fields_raw,$table_raw,$joins_raw,$sql_where_raw,$sql_order_raw,$sql_limit_raw);
	if($result_raw->num_rows == 1) {
		if($row_raw = mysqli_fetch_array($result_raw)){
			if($row_raw['time_in'] == '') {
				$date_time_in  = 'N/A';
			} else {
				$date_time_in  = $ot_date.' '.$row_raw['time_in'];
				$date_time_in  = date('M d, Y h:i:s A',strtotime($date_time_in));
			}
			if($row_raw['date_out'] == '' && $row_raw['time_out'] == '') {
				$date_time_out = 'N/A';
			} else {
				$date_time_out = $row_raw['date_out'].' '.$row_raw['time_out'];
				$date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
			}
		}
	} else {
		$date_time_in  = 'N/A';
		$date_time_out = 'N/A';
	}
	
	// if($row_raw = mysqli_fetch_array($result_raw)){
		// $date_time_in  = $ot_date.' '.$row_raw['time_in'];
		// $date_time_out = '1'.$row_raw['date_out'].' '.$row_raw['time_out'];
		// if($date_time_out == '') {
			// $date_time_out = 'N/A';
		// } else {			
			// $date_time_in  = date('M d, Y h:i:s A',strtotime($date_time_in));
			// $date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
		// }
        // $date_time_in  = $ot_date.' '.$row_raw['time_in'];
        // $date_time_out = $row_raw['date_out'].' '.$row_raw['time_out'];
        // $date_time_in  = date('M d, Y h:i:s A',strtotime($date_time_in));
        // $date_time_out = date('M d, Y h:i:s A',strtotime($date_time_out));
    // } else {
        // $date_time_in  = 'N/A';
        // $date_time_out = 'N/A';
    // }
    $overtime .= '
        <tr>
            <td colspan="10"><br></td>
        </tr>
        <tr style="">    
            <td style="width:5%;text-align:center;">'.$empno.'</td>
            <td style="width:15%;">'.$emp_name.'</td>
            <td style="width:10%;text-align:center;">'.$date_time_in.'</td>
            <td style="width:10%;text-align:center;">'.$date_time_out.'</td>
            <td style="width:10%;text-align:center;">'.date('M d, Y',strtotime($ot_date)).'</td>
            <td style="width:5%;text-align:center;">'.$filed_ot.'</td>
            <td style="width:5%;text-align:center;">'.$valid_ot.'</td>
            <td style="width:15%;">'.$remarks.'</td>
            <td style="width:15%;">'.$system_comment.'</td>
            <td style="width:10%;border-bottom:1pt solid black;"></td>
        </tr>';
    $record_count++;
    if($record_count == 9) {
        $overtime .= '
            <tr>
                <td colspan="10"><br><br></td>
            </tr>';
    }
}

$overtime .= '
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="10"></td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight:bold;">Requested by:</td>
            <td colspan="2" style="font-weight:bold;border-bottom:1pt solid black;text-align:center;">'.$requestor_name.'</td>
            <td colspan="6"></td>
        </tr>
        <tr>
            <td colspan="10"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="font-weight:bold;">Approved by:</td>
            <td colspan="8"></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2" style="font-weight:bold;">Section Head:</td>
            <td colspan="2" style="border-bottom:1pt solid black;"></td>
            <td colspan="2" style="font-weight:bold;"> Department Head:</td>
            <td colspan="2" style="border-bottom:1pt solid black;"></td>
        </tr>
    </table>
';


$pdf->writeHTMLCell(0, '', '', '55', $overtime, 0, 0, 0, true, 'J', true);
$pdf->lastPage();

// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output($Ctrl.'.pdf', 'I');

