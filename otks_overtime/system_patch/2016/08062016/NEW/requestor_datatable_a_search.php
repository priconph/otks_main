<?php
	/*
	 * Script:    DataTables server-side script for PHP and MySQL
	 * Copyright: 2010 - Allan Jardine
	 * License:   GPL v2 or BSD (3-point)
	 */
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	 
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);

	$aColumns = array(  'req_status_name',
						'date_created', 
						'ot_type', 
						'date_overtime',
						'req_manpower', 
						'req_justification', 
						'pkid'
						);
	
	
						
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	$sTable = "vw_overtime";
	
	require_once('config.php');
	/* Database connection information */
	$gaSql['user']       = $username;
	$gaSql['password']   = $password;
	$gaSql['db']         = $db_name;
	$gaSql['server']     = $server;
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}	
	
	/*
	 * Ordering
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	 
	 /* wag gagalawin yung sWhere default to para sa searchbox ng datatables check mo sa baba kung pano gagawin mo :) */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			 // if( in_array($aColumns[$i],$array_search) ){
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			 // }
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	/* 
		dito ka mag add ng where mo, una check mo kung may laman na yung $sWhere pag wala append mo yung where mo na meron
		kasama where kapag naman may laman na AND na syempre diba :)
	*/
	
	if($sWhere == ""){
		$sWhere .= "WHERE ";
	}else{
		$sWhere .= " AND ";
	}
	
	$array_where = array();
	
	if($_GET['ot_type'] != ''){
		if($_GET['ot_type'] != 'All') {
			$array_where[] = " `ot_type` = '".$_GET['ot_type']."' ";
		} 
	}
    if($_GET['ot_status'] != ''){
		if($sWhere == 'WHERE ') {
			if($_GET['ot_status'] != '-') {
				$array_where[] = " `req_status` = '".$_GET['ot_status']."' ";
			} 
		} else {
			if($_GET['ot_status'] != '-') {
				$array_where[] = " `req_status` = '".$_GET['ot_status']."' ";
			}
		} 		
	}
	$username = $_GET['username'];
    if(isset($_GET['username']) || $_GET['username'] != ''){
		$array_where[] = " `created_by` = '".$username."' ";
	}else{
		$username = '';
	}
	if($_GET['date_request'] != ''){
		$date_request_arr 	= explode(" - ",$_GET['date_request']);
		$date_request_from 	= date('Y-m-d',strtotime($date_request_arr[0]));
		$date_request_to 	= date('Y-m-d',strtotime($date_request_arr[1]));
		$array_where[] = " (`req_date` BETWEEN '".$date_request_from."' AND '".$date_request_to."') ";
	}
	if($_GET['ot_range'] != ''){
		$ot_range_arr 	= explode(" - ",$_GET['ot_range']);
		$range_from 	= date('Y-m-d',strtotime($ot_range_arr[0]));
		$range_to 		= date('Y-m-d',strtotime($ot_range_arr[1]));
		$array_where[] = " (`req_datefrom` BETWEEN '".$range_from."' AND '".$range_to."') OR (`req_datefrom` BETWEEN '".$range_from."' AND '".$range_to."') ";
	}
	// $sWhere = substr_replace( $sWhere, "", -4 );
	$sWhere .= implode('AND',$array_where);
	
	// $sOrder .= " ORDER BY req_status";

	/*
	 * SQL queries
	 * Get data to display
	 */
	
	$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
		
	// echo $sQuery."<hr>";
	// echo implode('AND',$array_where)."<hr>";
	
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
	 
	$query_used = $sQuery;
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(".$sIndexColumn.")
		FROM   $sTable 
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	$ctr = 0;
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		unset($row);
		$row = array();
		if($aRow['req_status_name'] == 'For Edit'){
            $disable = '';
			$button = '<button type="button" class="btn btn-warning fa fa-edit" id="btn_edit" value="'.$aRow['pkid'].'" title="Click to update the record" '.$disable.'></button>';
			$status = '<a class="ui blue ribbon label">For Edit</a>';
		}else if($aRow['req_status_name'] == 'For Approval'){
            $disable = '';
//			$button = '<button type="button" class="btn btn-success fa fa-eye" id="btn_view" value="'.$aRow['pkid'].'" title="Click to view the record"></button>';
			$button = '<button type="button" class="btn btn-warning fa fa-edit" id="btn_edit" value="'.$aRow['pkid'].'" title="Click to update the record" '.$disable.'></button>';
			$status = '<a class="ui yellow ribbon label">For Approval</a>';
		}else if($aRow['req_status_name'] == 'Approved'){
            // $disable = ' disabled ';
            $disable = '';
			$button = '<button type="button" class="btn btn-success fa fa-eye" id="btn_view" value="'.$aRow['pkid'].'" title="Click to view the record"></button>';
			$status = '<a class="ui green ribbon label">Approved</a>';
		}else if($aRow['req_status_name'] == 'Disapproved'){
            $disable = ' disabled ';
			$button = '<button type="button" class="btn btn-success fa fa-eye" id="btn_view" value="'.$aRow['pkid'].'" title="Click to view the record"></button>';
			$status = '<a class="ui red ribbon label">Disapproved</a>';
		}else if($aRow['req_status_name'] == 'Cancelled'){
            $disable = ' disabled ';
			$button = '<button type="button" class="btn btn-success fa fa-eye" id="btn_view" value="'.$aRow['pkid'].'" title="Click to view the record"></button>';
			$status = '<a class="ui red ribbon label">Cancelled</a>';
		}else{
            $disable = ' disabled ';
			$button = '';
			$status = '<a class="ui gray ribbon label">ERROR</a>';
		}
		$row[] = $status;
		$row[] = '<center>'.$aRow['date_created'].'</center>';
		$row[] = '<center>'.$aRow['ot_type'].'</center>';
		$row[] = '<center>'.$aRow['date_overtime'].'</center>';
		$row[] = '<center>'.$aRow['req_manpower'].'</center>';
		$row[] = nl2br($aRow['req_justification']);
		$row[] = '<center>'.$button.'<button style="display:none;" value="'.$aRow['pkid'].'" id="btn_hidden"</button></center>';
		$row[] = '<center><button type="button" class="btn btn-danger fa fa-remove" id="btn_cancel" value="'.$aRow['pkid'].'" title="Click to cancel" '.$disable.'></button></center>';
        
		array_push($output['aaData'],$row);

	}
	// ob_end_clean();
	echo json_encode( $output );
	
	 // echo $query_used;

?>