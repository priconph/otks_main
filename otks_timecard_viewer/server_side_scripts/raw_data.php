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

	$aColumns = array( 'inconsistent',
						'pkid',
						'date',
						'time_in',
						'mode_in',
						'date_out',
						'time_out',
						'mode_out',
						'empno',
						'LastName',
						'Department',
						'Position',
						'Section',
						'FirstName'
						);
	
	/* used this field for searching data typed in the search box */
	// $array_search = array('empno', 'LastName',
							// 'date', 'date_out');
	$array_search = array('empno', 'LastName');
							
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* DB table to use */
	$sTable = "vw_raw_data";
	
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
			if( in_array($aColumns[$i],$array_search) ){
				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
			}
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
		$sWhere .= "WHERE  ";
	}else{
		$sWhere .= "AND ";
	}
	
	$date_start = $_GET['date_start'];
	$date_end 	= $_GET['date_end'];
	$empno      = $_GET['empno'];
	
	// $sWhere .= "AND lastupdate BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
	// $sWhere .= "AND ( (date BETWEEN '" . $date_start . "' AND '" . $date_end . "') OR (date_out BETWEEN '" . $date_start . "' AND '" . $date_end . "') )";
	
	if($empno != ''){
		// $sWhere .= "((date BETWEEN '" . $date_start . "' AND '" . $date_end . "') OR (date_out BETWEEN '" . $date_start . "' AND '" . $date_end . "')) AND `empno` = '".$empno."'";
		$sWhere .= "((date BETWEEN '" . $date_start . "' AND '" . $date_end . "') OR (date_out BETWEEN '" . $date_start . "' AND '" . $date_end . "')) AND";
		$empno = explode(',',$empno);
		$array_empno_condition = array();
		for($x=0;$x<count($empno);$x++){
			$array_empno_condition[] = "`empno` = '".$empno[$x]."'";
		}
		$sWhere .= " (";
		$sWhere .= implode(' OR ',$array_empno_condition);
		$sWhere .= " )";
	}else{
		$sWhere .= "((date BETWEEN '" . $date_start . "' AND '" . $date_end . "') OR (date_out BETWEEN '" . $date_start . "' AND '" . $date_end . "'))";
	}
	
	
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
	
	$date_start = strtotime(str_replace(' ','',$date_start));
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		unset($row);
		
		/* additional */
		$inconsistencies = '';
		$irregular = '';
		
		if($aRow['time_in'] == "" || $aRow['time_out'] == ""){
			$inconsistencies .= '<center><span class="badge fa fa-warning fa-lg" style="background-color:red;"> </span></center>';
		}else{
		}
		
		$row_date 	= strtotime(str_replace(' ','',$aRow['date']));
		
		
		// if( $row_date >= $date_start ){
			$row[] = $inconsistencies;
			// if( $row_date >= $date_start ){
				// $msg = 'greater';
			// }
			// $row[] = $row_date .'//'. $date_start. ' '.$msg;
			// $row[] = $aRow['pkid'];
			$row[] = $aRow['date'];
			$row[] = $aRow['time_in'];
			$row[] = $aRow['mode_in'];
			$row[] = $aRow['date_out'];
			$row[] = $aRow['time_out'];
			$row[] = $aRow['mode_out'];
			$row[] = $aRow['empno'];
			$row[] = $aRow['LastName'] . ', ' . $aRow['FirstName'];
			$row[] = $aRow['Department'];
			$row[] = $aRow['Position'];
			$row[] = $aRow['Section'];
			array_push($output['aaData'],$row);
		// }
	}
	
	function get_time_difference($timein,$timeout){
		$time_in = strtotime($timein);
		$time_out = strtotime($timeout);

		$diff = $time_out - $time_in;
		/* seconds difference */
		$diff_in_sec = ($diff % 60); 

		$diff_in_min = $diff / 60;
		$diff_in_min = explode(".",$diff_in_min);
		/* get the minute difference */
		$diff_in_min = $diff_in_min[0];

		/* get difference in hour */
		$diff_in_hour = $diff_in_min / 60 ;
		
		$diff_in_min = $diff_in_min % 60;

		$diff_in_hour = explode(".",$diff_in_hour);
		$diff_in_hour = $diff_in_hour[0];

		$return = array();
		$return['hour'] = $diff_in_hour;
		$return['min'] = $diff_in_min;
		$return['sec'] = $diff_in_sec;
		
		return $return;
	}
	// ob_end_clean();
	echo json_encode( $output );

?>