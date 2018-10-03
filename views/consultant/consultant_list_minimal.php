<?php 


	$tempArray = [];
	$consultant_name = [];
	$consultant_rank = [];
	$rowCount  = 0;

	foreach ($result as $row)
	{
		$tempArray[$rowCount]['consultant_id'] 				= $row['consultant_id'];
		$tempArray[$rowCount]['consultant_first_name'] 		= $row['consultant_first_name'];
		$tempArray[$rowCount]['consultant_middle_name'] 	= $row['consultant_middle_name'];			
		$tempArray[$rowCount]['consultant_last_name'] 		= $row['consultant_last_name'];
		$tempArray[$rowCount]['consultant_name'] 			= $row['consultant_first_name'].' '.$row['consultant_last_name'];				
		$tempArray[$rowCount]['consultant_job_title'] 		= $row['consultant_job_title'];			
		$tempArray[$rowCount]['consultant_rank'] 			= $row['consultant_rank'];			
		//$tempArray[$rowCount]['consultant_expertise'] 	= $row['consultant_expertise'];			
		$tempArray[$rowCount]['consultant_image'] 			= $row['consultant_image'];			
		$tempArray[$rowCount]['consultant_email'] 			= $row['consultant_email'];			
		//$tempArray[$rowCount]['consultant_linkedin'] 		= $row['consultant_linkedin'];			
		//$tempArray[$rowCount]['consultant_twitter'] 		= $row['consultant_twitter'];			
		//$tempArray[$rowCount]['consultant_phone_mobile'] 	= $row['consultant_phone_mobile'];			
		//$tempArray[$rowCount]['office_id'] 				= $row['office_id'];			
		$tempArray[$rowCount]['office_name'] 				= $row['office_name'];			
		//$tempArray[$rowCount]['practice_ids'] 			= $row['practice_ids'];		
		//$tempArray[$rowCount]['bio_ids'] 					= $row['bio_ids'];		
		
		$rowCount++;
	}

	foreach ($tempArray as $key => $row){
		$consultant_name[$key] 	= $row["consultant_name"];
		$consultant_rank[$key] 	= $row["consultant_rank"];
	}
	
	array_multisort($consultant_rank, SORT_ASC, $consultant_name, SORT_ASC, $tempArray);

	if (!empty($tempArray)) 
	{
		echo '<ul>';

			foreach ($tempArray as $row){

				$uri 				= 'consultant/find_by_id/'.$row['consultant_id'];
				$consultant_name 	= $row['consultant_name'];
			        	
			    
			echo 	'<li>';
			echo 		anchor($uri,$consultant_name); 
			echo 	'</li>';
			
			}
	
		echo '</ul>';
	}
?>

