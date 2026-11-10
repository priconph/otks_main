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
	
	$aColumns = array(  'status',
						'date_created',
						'date_from',
						'manpower',
						'justification',
						'pkid',
						'date_to',
						'username',
					  	'created_by'
						);
						
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno',
							// 'date','time_in','mode_in',
							// 'date_out','time_out','mode_out');
	
	/* DB table to use */
	$sTable = "tkstraight_main";
	
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

	if($sOrder == ""){
		$sOrder .= "ORDER BY `pkid` DESC";
	}else{
		$sOrder .= ", `date_created` DESC";
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
			$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%'";
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
	if(isset($_GET['username'])){
		$username = $_GET['username'];
	}else{
		$username = '';
	}
	
	
	$sWhere .= "`created_by` = '".$username."' AND logdel=0";
	
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
		
	
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
		
	// echo $sQuery."<hr>";
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
		if($aRow['status'] == 0){
			$status = '<a class="ui blue ribbon label">For Edit</a>';
		}else if($aRow['status'] == 1){
			$status = '<a class="ui yellow ribbon label">For Approval</a>';
		}else if($aRow['status'] == 2){
			$status = '<a class="ui green ribbon label">Approved</a>';
		}else if($aRow['status'] == 3){
			$status = '<a class="ui red ribbon label">Disapproved</a>';
		}else if($aRow['status'] == 4){
			$status = '<a class="ui red ribbon label">Cancelled</a>';
		}else{
			$status = '<a class="ui gray ribbon label">ERROR</a>';
		}
		
		// $new_date = date('Y-m-d',strtotime($aRow['date_created']));
		$new_date = date('M d, Y',strtotime($aRow['date_created']));
		
		$row[] = $status;
		$row[] = $new_date;
		$new_date_from = date('M d, Y', strtotime($aRow['date_from']));
		$new_date_to = date('M d, Y', strtotime($aRow['date_to']));
		
		$row[] = $new_date_from . ' - ' . $new_date_to;
		$row[] = $aRow['manpower'];
		$row[] = $aRow['justification'];
		$disabled_button = '';
		if($aRow['status'] == 4){
			$disabled_button = 'disabled';
		}
		$row[] = '<center><button class="btn btn-warning fa fa-edit" value="'.$aRow['pkid'].'"></button></center>';
//		$row[] = '<center><button class="btn btn-warning fa fa-edit" value="'.$aRow['pkid'].'" '.$disabled_button.'></button></center>';
		$row[] = '<center><button class="btn btn-danger fa fa-remove" value="'.$aRow['pkid'].'" '.$disabled_button.'></button></center>';
		
		array_push($output['aaData'],$row);

	}
	// ob_end_clean();
	echo json_encode( $output );
?>