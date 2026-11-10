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
	$aColumns = array(  'ob.ob_status_name',
						'ob.date_time_created',
						'ob.ob_date',
						'ob.ob_purpose',
						'ob.ob_reason',
						'ob.ob_time_out',
						'CONCAT(ss.lastname,", ",ss.firstname) as ss_approver_name', 
                        'CONCAT(hris.lastname,", ",hris.firstname) as ob_approver_name', 
                        'ob.ob_pkid'
						);
						
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "ob_pkid";
	
	/* used this field for searching data typed in the search box */
	 $array_search = array('ob.ob_status_name',
                            'ob.date_time_created',
                            'ob.ob_date',
                            'ob.ob_purpose',
                            'ob.ob_reason',
                            'ob.ob_time_out',
                            'ob_approver_name', 
                            'ob.ss_approver_name', 
                            'ob.ob_pkid');
	
	/* DB table to use */
	$sTable = "vw_ut_ob ob INNER JOIN db_hris.vw_EmpInfo_Rapid hris ON hris.username = ob.ob_approver INNER JOIN db_hris.vw_supervisors ss ON ss.username = ob.supervisor_username";
	
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
//                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
//				 	  ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
                if($aColumns[ intval( $_GET['iSortCol_'.$i] ) ] == 'CONCAT(hris.lastname,", ",hris.firstname) as ob_approver_name'){
				    $sOrder .= 'CONCAT(hris.lastname,", ",hris.firstname)'."
				 	  ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";  
                }else if($aColumns[ intval( $_GET['iSortCol_'.$i] ) ] == 'CONCAT(ss.lastname,", ",ss.firstname) as ss_approver_name'){
				    $sOrder .= 'CONCAT(ss.lastname,", ",ss.firstname)'."
				 	  ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";  
                }else{
                     $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	  ".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";                    
                }
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
//			 if( in_array($aColumns[$i],$array_search) ){
//				$sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
//			 }
            if($aColumns[$i] == 'CONCAT(hris.lastname,", ",hris.firstname) as ob_approver_name'){
                 $sWhere .= "CONCAT(hris.lastname,' ,',hris.firstname) LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";         
            }else if($aColumns[$i] == 'CONCAT(ss.lastname,", ",ss.firstname) as ss_approver_name'){
                 $sWhere .= "CONCAT(ss.lastname,', ',ss.firstname) LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";         
            }else{
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
	
    if(isset($_GET['empno']) || $_GET['empno'] != ''){
		$empno = $_GET['empno'];
	}else{
		$empno = '';
	}
	
	
	$sWhere .= "ob.`empno` = '".$empno."'";
	
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
		if($aRow['ob_status_name'] == 'For Edit'){
            $disable = '';
			$status = '<a class="ui blue ribbon label">For Edit</a>';
		}else if($aRow['ob_status_name'] == 'For Approval'){
            $disable = '';
			$status = '<a class="ui yellow ribbon label">For Approval</a>';
		}else if($aRow['ob_status_name'] == 'Approved'){
            $disable = '';
			$status = '<a class="ui green ribbon label">Approved</a>';
		}else if($aRow['ob_status_name'] == 'Disapproved'){
            $disable = '';
			$status = '<a class="ui red ribbon label">Disapproved</a>';
		}else if($aRow['ob_status_name'] == 'Cancelled'){
            $disable = '';
			$status = '<a class="ui red ribbon label">Cancelled</a>';
		}else{
            $disable = ' disabled ';
			$status = '<a class="ui gray ribbon label">ERROR</a>';
		}
		
		$date_created = date('M d,Y h:i A',strtotime($aRow['date_time_created']));
		$date_ut_ob = date('M d,Y',strtotime($aRow['ob_date']));
		$ob_time_out = date('h:i A',strtotime($aRow['ob_time_out']));
		$row[] = $status;
		$row[] = '<center>'.$aRow['ob_purpose'].'</center>';
		$row[] = $date_created;
		$row[] = $date_ut_ob;
		$row[] = nl2br($aRow['ob_reason']);
		$row[] = $ob_time_out;
		$row[] = $aRow['ss_approver_name'];
		$row[] = $aRow['ob_approver_name'].'<input type="hidden" id="txt_pkid" value="'.$aRow['ob_pkid'].'">';
		$row[] = '<center><button type="button" id="btn_cancel" value="'.$aRow['ob_pkid'].'" class="btn btn-danger fa fa-close"'.$disable.'></button></center>';
		array_push($output['aaData'],$row);

	}
	// ob_end_clean();
	echo json_encode( $output );
	
	 // echo $query_used;

?>