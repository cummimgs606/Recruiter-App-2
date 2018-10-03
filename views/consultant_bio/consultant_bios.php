<?php

	echo 	'<div class="row theme-red">

				<div class="column-6">               

				    <div class="panel theme-red">

				        <h2><span class="white-text">'.$page_header.'</span></h2> 

				    </div>

				</div>

			</div>';

	echo '<ul>';

		$row = $query->row_array();

		if (isset($row))
		{
			//echo '<li>';
			echo '<h2>'.$row['bio_title'].'</h2></p>';
			
			echo '<i>'.$row['bio_expertise'].'</i></p>';

			echo $row['bio_strapline'].'</p>';
			echo $row['bio_about'].'</p>';
			//echo '</li>';
		}

	echo '</ul>';

	$query->next_result(); 
	$query->free_result(); 

?>

