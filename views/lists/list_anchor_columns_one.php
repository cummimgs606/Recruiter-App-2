<?php 

	echo 	'<div class="row">
               
		        <div class="column-12">
		        
		            <div class="bar theme-white">'.$page_header_1.'</div>';

			            if(count($result_1) > 0){
							
	echo 				'<div class="panel theme-white">';

			            	$data['result'] = $result_1;
			            	$data['uri'] 	= $this->uri;

							$this->load->view('consultant/consultant_list_minimal', $data);

			            }else{

	echo 				'<div class="panel theme-white">';

	echo 					$error_no_results;
			            }
		        
	echo        	'</div>
		        
		        </div> 

			</div>';

?>

