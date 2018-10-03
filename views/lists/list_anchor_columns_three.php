<?php 

	echo 	'<div class="row theme-white">
               
		        <div class="column-4">
		        
		            <div class="bar theme-red">'.$page_header_1.'</div>
		        
		            <div class="panel">';

		            	$data['result'] = $result_1;
		            	$data['uri'] 	= $this->uri;

						$this->load->view('lists/list_anchor_minimal', $data);	

	echo        	'</div>
	
		        
		        </div>
		                
		        <div class="column-4">
		        
		            <div class="bar theme-red">'.$page_header_2.'</div>
		        
		            <div class="panel">';

		            	$data['result'] = $result_2;
		            	$data['uri'] 	= $this->uri;

		           		$this->load->view('lists/list_anchor_methods_two', $data);	                     

	echo 			'</div>
		        
		        </div> 

		        <div class="column-4">
		        
		            <div class="bar theme-red">'.$page_header_3.'</div>
		        
		            <div class="panel">';

		            	$data['result'] = $result_3;
		            	$data['uri'] 	= $this->uri;

		           		$this->load->view('consultant/consultant_list_minimal', $data);	                        

	echo 			'</div>
		        
		        </div> 

			</div>';

?>

