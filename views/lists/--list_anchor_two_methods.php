<?php 

    echo    '<div class="row theme-white">

                <div class="column-12">

                    <div class="bar">

                        '.$page_header.'

                    </div>

                </div>

            </div>';

	echo 	'<div class="panel theme-white">';

        	$result =  $query->result_array();

        	if(count($result ) > 20){
        		 
        		echo '<div class="flex-list">';
        	}

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

        	if(count($result ) > 20){
        		echo '</div>';
        	}


	echo '</div>';

     $query->next_result(); 
    $query->free_result(); 

?>

