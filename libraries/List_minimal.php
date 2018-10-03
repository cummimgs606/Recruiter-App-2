<?php 
	
	//defined('BASEPATH') OR exit('No direct script access allowed');

	class List_minimal{

	    public function render($query, $uri)
	    {

			echo '<ul>';

			foreach ($query->result_array() as $key => $value)
			{	
				$array = [];
				$index = 0;

				foreach ($value as $item)
				{

					$array[$index] = $item;
					$index++;
				}

				$controller = $uri->segment(1);
				$method		= $uri->segment(2);
								
				$uri_array 	= [$controller, $method];
				$uri_string = implode("/", $uri_array);

				echo '<li>';

					echo anchor($uri_string.'/'.$array[0], $array[1]);

					echo '</li>';
				}

			echo '</ul>';
		}
	}

?>
