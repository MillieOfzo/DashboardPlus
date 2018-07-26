<?php
	$db_conn = new SafeMySQL(SCS_DB_CONN);
	
	$obj = new Home($db_conn);
		
	if(isset($_GET['get'])){
		if($_GET['get'] == 'markers'){
			
			$setinfo = true;
			if(isset($_GET['info']) && $_GET['info'] == 'no')
			{
				$setinfo = false;
			}
			
			if(isset($_GET['all'])){
				// Get all = true
				$obj->getMarkers(true,'',$setinfo);
			};
			
			if(isset($_GET['div'])){
				$obj->getMarkersDiv($_GET['time']);
			}
			// Only get changed locations since $_GET['time']
			$obj->getMarkers(false,$_GET['time'],$setinfo);
		}
		
		if($_GET['get'] == 'list'){

			if(isset($_GET['state'])){
				$obj->getList($_GET['state']);				
			}

			if(isset($_GET['rms'])){
				$obj->getListRms();				
			}			
		}

		if($_GET['get'] == 'event_count'){
			$obj->getEventCount();
		}		

	}