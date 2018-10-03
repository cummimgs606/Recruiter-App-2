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

			$controller 	= $this->uri->segment(1);
			$method1		= $this->uri->segment(2);
			$method2		= $this->uri->segment(3);
						
			$uri_array 	= [$controller, $method1, $method2];
			$uri_string = implode("/", $uri_array);

				echo '<li>';

				echo anchor($uri_string.'/'.$array[0], $array[1]);

				echo '</li>';
		}

	echo '</ul>';

?>

