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
						'created_by_name', 
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
			/* 
				MJ COMMENT 
				I added this in where part wherin only selected fields can be searched 
			*/ 
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
    if(isset($_GET['username']) || $_GET['username'] != ''){
		$array_where[] = " `req_approver` = '".$_GET['username']."' AND `req_status` != 0 ";
	} else{
		$array_where[] = " `req_approver` = '-' AND `req_status` != 0 ";
	}
	if($_GET['date_request'] != '') {
		$array_date_request = explode(" - ", $_GET['date_request']);
		$date_request_from 	= date('Y-m-d',strtotime($array_date_request[0]));
		$date_request_to 	= date('Y-m-d',strtotime($array_date_request[1]));
		$array_where[] = " (`req_date` BETWEEN '".$date_request_from."' AND '".$date_request_to."') ";
	}
	if($_GET['ot_type'] != '') {
		if($_GET['ot_type'] != 'All') {
			$array_where[] = " `ot_type`='".$_GET['ot_type']."' ";
		}
	}
	if($_GET['ot_range'] != '') {
		$array_ot_range = explode(" - ", $_GET['ot_range']);
		$date_range_from 	= date('Y-m-d',strtotime($array_ot_range[0]));
		$date_range_to 		= date('Y-m-d',strtotime($array_ot_range[1]));
		$array_where[] = " (`req_datefrom` BETWEEN '".$date_range_from."' AND '".$date_range_to."' OR `req_dateto` BETWEEN '".$date_range_from."' AND '".$date_range_to."') ";
	}
	if($_GET['ot_status'] != '') {
		if($_GET['ot_status'] != '-') {
			$array_where[] = " `req_status` = '".$_GET['ot_status']."' ";
		} else {
		
		}
	}
	$sWhere .= implode("AND",$array_where);
	
	// $sOrder .= "ORDER BY `req_status`";
	
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
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
	 
	// $query_used = $sQuery;
	
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
			$status = '<a class="ui blue ribbon label">For Edit</a>';
		}else if($aRow['req_status_name'] == 'For Approval'){
			$status = '<a class="ui yellow ribbon label">For Approval</a>';
		}else if($aRow['req_status_name'] == 'Approved'){
			$status = '<a class="ui green ribbon label">Approved</a>';
		}else if($aRow['req_status_name'] == 'Disapproved'){
			$status = '<a class="ui red ribbon label">Disapproved</a>';
		}else if($aRow['req_status_name'] == 'Cancelled'){
			$status = '<a class="ui red ribbon label">Cancelled</a>';
		}else{
			$status = '<a class="ui gray ribbon label">ERROR</a>';
		}
		$row[] = $status;
		$row[] = '<center>'.$aRow['date_created'].'</center>';
		$row[] = '<center>'.$aRow['created_by_name'].'</center>';
		$row[] = '<center>'.$aRow['ot_type'].'</center>';
		$row[] = '<center>'.$aRow['date_overtime'].'</center>';
		$row[] = '<center>'.$aRow['req_manpower'].'</center>';
		$row[] = nl2br($aRow['req_justification']);
		$row[] = '<center><button type="button" class="btn btn-primary fa fa-eye" id="btn_view_main" value="'.$aRow['pkid'].'" title="Click to view overtime main info"></button></center>';
		array_push($output['aaData'],$row);

	}
	// ob_end_clean();
	echo json_encode( $output );
	
//	 echo $query_used;

?>