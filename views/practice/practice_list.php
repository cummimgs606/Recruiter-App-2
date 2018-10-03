<?php 

	echo '<div class="flex-list theme-pattern">';
	echo '<ul>';

		$all_zero = 0;

		foreach ($practices_merged as $key)
		{
			if($key['practice_user'] == '1'){
				$all_zero = 1;
			}
		}

		foreach ($practices_merged as $key)
		{
			$practice_id    	= $key['practice_id'];
	        $practice_name      = $key['practice_name'];
	        $practice_user      = $key['practice_user'];
	        $practice_linked    = $key['practice_linked'];

	  		$string = $practice_name;
	  		$link = $uri_string.'/'.$practice_id;

	  		echo '<li>';
	 
			if($practice_linked == '1' && $practice_user == '1'){

				echo anchor($link, $string, array('class'=>'red'));
			}

			if($practice_linked == '1' && $practice_user == '0'){

				echo anchor($link, $string, array('class'=>'black'));
			}

			if($practice_linked == '0' && $practice_user == '0'){

				if($all_zero == 0){

					echo anchor($link, $string, array('class'=>'black'));

				}else{

					echo anchor($uri_string, $string, array('class'=>'grey'));
				}
			}

			echo '</li>';

			
		}

	echo '</ul>';
	echo '</div>';
?>

