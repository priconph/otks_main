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
	
	$aColumns = array(  'inconsistent', 'empno', 'SalaryType',
						'date', 'time_in', 'mode_in',
						'date_out', 'time_out', 'mode_out',
						'reg_hours', 'ot_credit', 'absent',
						'under_mins', 'leavecode', 'leavenum',
						/* OT's */
						'ot1',
						'ot2','ot2a',
						'ot3','ot3a',
						'ot4','ot4a',
						'ot5','ot5a',
						'ot6','ot6a',
						'nightdiff','aut',
						/* not used in the table */
						'pkid','late_mins',
						);
						
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "pkid";
	
	/* used this field for searching data typed in the search box */
	$array_search = array('empno',
							'date','time_in','mode_in',
							'date_out','time_out','mode_out');
	
	/* DB table to use */
	$sTable = "vw_daily_tfm";
	
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
		$sWhere .= "WHERE ";
	}else{
		$sWhere .= " AND ";
	}
	
	$date_start = $_GET['date_start'];
	$date_end = $_GET['date_end'];
	// $sWhere .= "lastupdate BETWEEN '" . $date_start . "' AND '" . $date_end . "'";
	// $sWhere .= "( (date BETWEEN '" . $date_start . "' AND '" . $date_end . "') OR (date_out BETWEEN '" . $date_start . "' AND '" . $date_end . "') )";
	$sWhere .= "(date BETWEEN '" . $date_start . "' AND '" . $date_end . "')";
	
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
			// /* additional */
			$inconsistencies = '';
			$irregular = '';
			
			// if($aRow['inconsistent'] == "1"){
			if($aRow['time_in'] == "" || $aRow['time_out'] == ""){
				$inconsistencies .= '<center><span class="badge fa fa-warning fa-lg" style="background-color:red;"> </span></center>';
			}else{

			}
			
			// $row[] = $query_used;
			$row[] = $inconsistencies;
			$row[] = $aRow['empno'].'<input type="hidden" class="pkid" value="'.$aRow['pkid'].'">'.'<input type="hidden" class="empno" value="'.$aRow['empno'].'">';		//1
			$row[] = $aRow['SalaryType'];	//2
			$row[] = $aRow['date'].'<input type="hidden" class="date" value="'.$aRow['date'].'">';			//3
			$row[] = $aRow['time_in'].'<input type="hidden" class="time_in" value="'.$aRow['time_in'].'">';		//4
			$row[] = $aRow['mode_in'];		//5
			$row[] = $aRow['date_out'].'<input type="hidden" class="date_out" value="'.$aRow['date_out'].'">';		//6
			$row[] = $aRow['time_out'].'<input type="hidden" class="time_out" value="'.$aRow['time_out'].'">';		//7
			$row[] = $aRow['mode_out'];		//8
			$row[] = $aRow['reg_hours'];	//9
			$row[] = $aRow['ot_credit'];	//10	
			$row[] = $aRow['absent'];		//11
			$row[] = $aRow['under_mins'];   //12
			$row[] = $aRow['leavecode'];    //13
			$row[] = $aRow['leavenum'];     //14
			$row[] = $aRow['ot1'];			//15
			$row[] = $aRow['ot2'];			//16
			$row[] = $aRow['ot2a'];			//17
			$row[] = $aRow['ot3'];			//18
			$row[] = $aRow['ot3a'];			//19
			$row[] = $aRow['ot4'];			//20
			$row[] = $aRow['ot4a'];			//21
			$row[] = $aRow['ot5'];			//22
			$row[] = $aRow['ot5a'];			//23
			$row[] = $aRow['ot6'];			//24
			$row[] = $aRow['ot6a'];			//25
			$row[] = $aRow['nightdiff'];	//26
			$row[] = $aRow['aut'];			//27
						
			
			array_push($output['aaData'],$row);
			// $ctr++;
		// }
	}
	// ob_end_clean();
	echo json_encode( $output );

?>