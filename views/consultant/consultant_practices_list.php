<?php 


		$row_count  			= 0;
		$temp_array  			= [];
		$practice_amount 		= [];
		$practice_ids 			= [];
		$practice_names     	= [];
		$practices 				= [];
		$practices_intersected 	= [];

		$sort_amount			= [];
		$sort_names		 		= [];
		$sort_rank				= [];

		$string_new_pactice_count 		= 0;
		$string_new_pactice_names 		= '';


		foreach ($query->result_array() as $currentRow)
		{

			// WHERE practices_users intersect consultants_practice_ids

			//echo '$currentRow[practice_ids] : '.$currentRow['practice_ids'].'</p>';
			//echo '$currentRow[practice_names] : '.$currentRow['practice_names'].'</p>';
		
			//practice_ids  	= '2,9,17,22,40';
			//practice_names  	= 'Architecture - CIO - Education - Healthcare - Technology';
			//consultant_name 	= 'Tobias Eklund';

			$practice_ids 		= explode(',' , $currentRow['practice_ids']);
			$practice_names 	= explode(',' , $currentRow['practice_names']);
			$practices 			= array_combine($practice_ids, $practice_names);

			//var_dump($practices);
			/*
				array(5) { 
							[2]=> string(12) "Architecture" 
							[9]=> string(3) "CIO" 
							[17]=> string(9) "Education" 
							[22]=> string(10) "Healthcare" 
							[40]=> string(10) "Technology" 
						}
			*/

			$practices_intersected 		= array_intersect($practice_ids, $practices_user);
			
			//var_dump($practices_intersected);
			/*
				array(3) { 
							[2]=> string(2) "17" 
							[3]=> string(2) "22" 
							[4]=> string(2) "40" 
						}
			*/

			$string_new_pactice_count 		= 0;
			$string_new_pactice_names 		= '';

			foreach ($practices as $key  => $value)
			{
				if(in_array($key, $practices_intersected)){

					$string_new_pactice_count++;

					if($string_new_pactice_count == count($practices_intersected)){

						$separator = '';

					}else{

						$separator = ' - ';
					}

					$string_new_pactice_names = $string_new_pactice_names.$value.$separator;
				}
			}

			$string_new_pactice_names = rtrim($string_new_pactice_names); 

			/*
				echo $string_new_pactice_count.'</p>';
				echo $string_new_pactice_names.'</p>';
			
				3
				Education - Healthcare - Technology
			*/

			if(count($practices_intersected) != 0 ){

				$temp_array[$row_count ]['practice_amount'] 	= $string_new_pactice_count;//count($practice_amount);
				$temp_array[$row_count ]['practice_names'] 		= $string_new_pactice_names;//$currentRow["practice_names"];
				$temp_array[$row_count ]['consultant_name'] 	= $currentRow["consultant_first_name"].' '.$currentRow["consultant_last_name"];
				$temp_array[$row_count ]['consultant_id'] 		= $currentRow["consultant_id"];
				$temp_array[$row_count ]['consultant_rank'] 	= $currentRow["consultant_rank"];

				// echo 'consultant_name : '.$temp_array[$row_count ]['consultant_name'].'</p>';
					
				$row_count ++;
			}
		}


		if (empty($temp_array)) {
			    return;
		}

		// -------------------------------------
		// SORT ON START
		// -------------------------------------

		foreach ($temp_array as $key => $row){
			$sort_amount[$key] 	= $row["practice_amount"];
			$sort_names[$key] 	= $row["practice_names"];
			$sort_rank[$key] 	= $row["consultant_rank"];
		}
	
		array_multisort($sort_amount, SORT_DESC, $sort_rank, SORT_ASC, $sort_names, SORT_STRING , $temp_array);

		// -------------------------------------
		// SORT ON END
		// -------------------------------------


		$max_amount = $temp_array[0]['practice_amount'];

		$row_count  = 0;


		//echo 	'<ul>';

		foreach ($temp_array as $currentRow){

			// -------------------------------------
			// START DISPLAY PRACTICE NAMES
			// -------------------------------------

			$new_practice_names = $temp_array[$row_count ]['practice_names'];

			if(!isset($old_practice_names)){

				$old_practice_names = '';
			}

			$flagChange = 0;

			if($max_amount < 6 ){

				if($old_practice_names != $new_practice_names){

					echo 	'</ul>
							</div>

								<div class="bar theme-white">

							        <span class="red-text">'.$new_practice_names.'</span>

							    </div>

							</div>
							<div class="panel">
							<ul>';
				}
			}

			$old_practice_names = $new_practice_names;

			// -------------------------------------
			// END DISPLAY PRACTICE NAMES
			// -------------------------------------

			// -------------------------------------
			// START DISPLAY CONSULTANT NAMES
			// -------------------------------------

			

			$uri_string 		= 'consultant/find_by_id/'.$temp_array[$row_count ]['consultant_id'];
			$consultant_name 	= $temp_array[$row_count ]['consultant_name'];

			echo 	'<li>
							'.anchor($uri_string, $consultant_name, array('class'=>'black')).' 
					</li>';
							

			// -------------------------------------
			// END DISPLAY CONSULTANT NAMES
			// -------------------------------------

			if($flagChange == 1){

				//echo '</ul>';
			}					

			$row_count ++;
		}

	

	$query->next_result(); 
	$query->free_result(); 

?>


