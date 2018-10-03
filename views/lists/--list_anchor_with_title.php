
<?php 
	
    echo    '<div class="row theme-white">

                <div class="column-12">

                    <div class="bar">

                        '.$page_header.'

                    </div>

                </div>

            </div>';

    echo 	'<div class="panel theme-white">';
 	
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

						$controller = $this->uri->segment(1);
						$method		= $this->uri->segment(2);
						
						$uri_array 	= [$controller, $method];
						$uri_string = implode("/", $uri_array);

						echo '<li>';

							echo anchor($uri_string.'/'.$array[0], $array[1]);

						echo '</li>';
					}

				echo '</ul>';


		echo '</div>';

        $query->next_result(); 
        $query->free_result(); 

?>

