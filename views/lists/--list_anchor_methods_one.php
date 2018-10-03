<?php

	echo '<ul>';

		foreach ($result as $key => $value)
		{	
			$array = [];
			$index = 0;

			foreach ($value as $item)
			{

				$array[$index] = $item;
				$index++;
			}

			$controller = $uri->segment(1);
			$method1	= $uri->segment(2);
										
			$uri_array 	= [$controller, $method1];
			$uri_string = implode("/", $uri_array);

				echo '<li>';

				echo anchor($uri_string.'/'.$array[0], $array[1]);

				echo '</li>';
		}

	echo '</ul>';

?>
