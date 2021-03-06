<?PHP
class book_a_room_meetingsSearch
{
	############################################
	#
	# Meetings search
	#
	############################################
	
	public static function bookaroom_searchRequests( )
	{	
		$externals = self::getExternals();
		
		switch( $externals['action'] ) {
			case 'filterResults':
				$results = self::getMeetingList( $externals );
				self::showSearch( $externals, $results );
				break;
				
			default:
				self::showSearch( $externals, array(), TRUE );
				break;
		}
	}
	
	public static function getExternals()
	# Pull in POST and GET values
	{
		$final = array();

		# setup GET variables
		$getArr = array(	'action'					=> FILTER_SANITIZE_STRING);

		# pull in and apply to final
		if( $getTemp = filter_input_array( INPUT_GET, $getArr ) ) {
			$final = array_merge( $final, $getTemp );
		}
		# setup POST variables
		$postArr = array(	'action'					=> FILTER_SANITIZE_STRING,
		
							'roomID'					=> FILTER_SANITIZE_STRING,
							'endDate'					=> FILTER_SANITIZE_STRING,
							'nonProfit'					=> FILTER_SANITIZE_STRING,
							'searchTerms'				=> FILTER_SANITIZE_STRING,
							'status'					=> FILTER_SANITIZE_STRING,
							'startDate'					=> FILTER_SANITIZE_STRING,
							'timestamp'					=> FILTER_SANITIZE_STRING,);	

		# pull in and apply to final
		if( $postTemp = filter_input_array( INPUT_POST, $postArr ) ) {
			$final = array_merge( $final, $postTemp );
		}

		$arrayCheck = array_unique( array_merge( array_keys( $getArr ), array_keys( $postArr ) ) );
		
		foreach( $arrayCheck as $key ) {
			if( empty( $final[$key] ) ) {
				$final[$key] = NULL;
			} elseif( is_array( $final[$key] ) && ( $key == 'hours' || $key == 'amenity' || $key = 'res_id' ) ) {
				$final[$key] = array_filter( $final[$key], 'strlen' );
			} elseif( is_array( $final[$key] ) ) {
				$final[$key] = array_keys( $final[$key] );
			} else {
				$final[$key] = trim( $final[$key] );
			}
		}
		
		# calendar timestamp
		if( !empty( $final['submitCal'] ) ) {
			$final['timestamp'] = mktime( 0, 0, 0, $final['calMonth'], 1, $final['calYear'] );
		}		
		
		if( !empty( $final['roomID'] ) && substr( $final['roomID'], 0, 7 ) == 'branch-' ) {
			$final['branchID'] = substr( $final['roomID'], 7 );
			$final['roomID'] = NULL;
		} else {
			$final['branchID'] = NULL;
		}
		
		if( !empty( $final['roomID'] ) && substr( $final['roomID'], 0, 6 ) == 'noloc-' ) {
			$final['noloc-branchID'] = substr( $final['roomID'], 6 );
			$final['roomID'] = NULL;
		} else {
			$final['noloc-branchID'] = NULL;
		}
		
		return $final;
	}
	
	public static function getMeetingList( $externals )
	{
		global $wpdb;
		
		# vaiables from includes
		$roomContList = bookaroom_settings_roomConts::getRoomContList();
		$roomList = bookaroom_settings_rooms::getRoomList();
		$branchList = bookaroom_settings_branches::getBranchList( TRUE );
		$amenityList = bookaroom_settings_amenities::getAmenityList();

		$page_num	= get_option( 'bookaroom_search_events_page_num' );
		$per_page	= get_option( 'bookaroom_search_events_per_page' );
		$order_by	= get_option( 'bookaroom_search_events_order_by' );
		$sort_order	= get_option( 'bookaroom_search_events_sort_order' );

		$where = array();
		
		$where[] = "`ti`.`ti_type` = 'meeting'";
		

		# check for branch
		if( !empty( $externals['roomID'] ) and array_key_exists( $externals['roomID'], $roomContList['id'] ) ) {
			# find all rooms in branch
			$where[] = "(`ti`.`ti_roomID` = '{$externals['roomID']}')";
		}
		
		# check for branch
		if( !empty( $externals['branchID'] ) and array_key_exists( $externals['branchID'], $branchList ) ) {
			# find all rooms in branch
			$branchArr = implode( ',',  $roomContList['branch'][$externals['branchID']] );
			$where[] = "(`ti`.`ti_roomID` IN ( {$branchArr} ) or `ti`.`ti_noLocation_branch` = '{$externals['branchID']}')";
		}
		# start time
		if( !empty( $externals['startDate'] ) and ( $startTimestamp =  date( 'Y-m-d H:i:s', strtotime( $externals['startDate'] ) ) ) !== false ) {
			$where[] = "`ti`.`ti_startTime` >= '{$startTimestamp}'";
		}

		# end time
		if( !empty( $externals['endDate'] ) and ( $endTimestamp =  date( 'Y-m-d H:i:s', strtotime( $externals['endDate']." + 1 days") ) ) !== false ) {
			$where[] = "`ti`.`ti_endTime` <= '$endTimestamp'";
		}

		# search term
		if( !empty( $externals['searchTerms'] ) ) {
			$where[] = " MATCH ( `res`.`me_desc`, `res`.`me_eventName`, `res`.`me_contactName`, `res`.`me_contactEmail`, `res`.`me_notes` ) AGAINST ('{$externals['searchTerms']}' IN NATURAL LANGUAGE MODE )";
			$scoreWhere = "`score` DESC, ";
		} else {
			$scoreWhere = NULL;
		}

		# check for status
		if( !empty( $externals['status'] ) ) {
			$statusArr = array( 'Pending' => 'pending', 'Pend. Payment' => 'pendPayment', 'Approved' => 'approved', 'Denied' => 'denied', 'Archived' => 'archived' );
			$statusArr = array( 'pending' => 'Pending', 'pendPayment' => 'Pend. Payment', 'approved' => 'Approved',  'denied' => 'Denied', 'archived' => 'Archived' );
			if( !empty( $statusArr[$externals['status']] ) ) {
				$where[] = "`res`.`me_status` = '{$externals['status']}'";
			}
		}
		
		# check for non-profit
		if( $externals['nonProfit'] == 'Non-profit' ) {
			$where[] = "`res`.`me_nonProfit` = 1";
		} elseif( $externals['nonProfit'] == 'Profit' ) {
			$where[] = "`res`.`me_nonProfit` = 0";
		}
						
		#  check for and build WHERE statment
		if( count( $where ) > 0 ) {
			$whereFinal = 'WHERE '.implode( ' AND ', $where );
		}
		
		$sql = "SELECT MATCH ( `res`.`me_desc`, `res`.`me_eventName`, `res`.`me_contactName`, `res`.`me_contactEmail`, `res`.`me_notes` ) AGAINST ('{$externals['searchTerms']}' IN NATURAL LANGUAGE MODE ) as `score`, 

`res`.`res_id`, 
`res`.`me_amenity`, 
`res`.`me_contactAddress1`, 
`res`.`me_contactAddress2`, 
`res`.`me_contactCity`, 
`res`.`me_contactEmail`, 
`res`.`me_contactName`, 
`res`.`me_contactPhonePrimary`, 
`res`.`me_contactPhoneSecondary`, 
`res`.`me_contactState`, 
`res`.`me_contactWebsite`, 
`res`.`me_contactZip`, 
`res`.`me_desc`, 
`res`.`me_eventName`, 
`res`.`me_nonProfit`, 
`res`.`me_numAttend`, 
`res`.`me_notes`, 
`res`.`me_status`, 
`ti`.`ti_created`, 	
		
		
		
		`ti`.`ti_roomID`, `ti`.`ti_noLocation_branch`, `ti`.`ti_id`, `ti`.`ti_startTime`, `ti`.`ti_endTime`, COUNT( DISTINCT `tiCount`.`ti_id` ) as eventCount
					FROM `{$wpdb->prefix}bookaroom_times` AS `ti`
					LEFT JOIN `{$wpdb->prefix}bookaroom_reservations` AS `res` ON `res`.`res_id` = `ti`.`ti_extID`
					LEFT JOIN `{$wpdb->prefix}bookaroom_times` AS `tiCount` ON `tiCount`.`ti_extID` = `res`.`res_id` 

					{$whereFinal}
					GROUP BY `ti`.`ti_id`
					ORDER BY {$scoreWhere}`ti`.`ti_startTime`, `res`.`ev_title` LIMIT 30";		
		$cooked = $wpdb->get_results( $sql, ARRAY_A );
		return $cooked;
		
	}
	
	protected static function showSearch( $externals, $pendingList = array(), $startPage = FALSE )
	{
		$roomContList = bookaroom_settings_roomConts::getRoomContList();
		$roomList = bookaroom_settings_rooms::getRoomList();
		$branchList = bookaroom_settings_branches::getBranchList( TRUE );
		$amenityList = bookaroom_settings_amenities::getAmenityList();
				
		# no location
		if( !empty( $externals['roomID'] ) and substr( $externals['roomID'], 0, 6 ) == 'noloc-' ) {
			$branchInfo = explode( '-', $externals['roomID'] );
			if( !array_key_exists( $branchInfo['0'], $branchList ) ) {
				$branchID = NULL;
				$roomID = NULL;
			}
		} else {
			$branchID = bookaroom_events::branch_and_room_id( $externals['roomID'], $branchList, $roomContList );
			$roomID = $externals['roomID'];
		}
		
		require( BOOKAROOM_PATH . 'templates/meetings/searchPending.php' );
	}
}