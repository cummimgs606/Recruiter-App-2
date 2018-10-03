<?php 

	if($back_button_uri != ''){

		echo 	'<div class="row theme-grey">

				    <div class="column-12">

				        <div class="bar">

					        '.anchor($back_button_uri, $back_button_text).'

					    </div>

				    </div>

				</div>';
	}else{

		echo 	'<div class="row theme-grey">

				    <div class="column-12">

				        <div class="bar">

				        	'.$message_apply_title.'

					    </div>

				    </div>

				</div>';
	}
	
	echo 	'<div class="row theme-red">

				<div class="column-12">               

					<div class="panel theme-red">

				        <h2><span class="white-text">'.$job_title.'</span></h2> 

				    </div>

				</div>

			</div>';


	echo 	'<div class="row theme-white">
			    
			    <div class="column-12 ">
			    
				    <div class="panel theme-white">
				        
				        <div class="condense-text">
				        
				           	<p><b>'.$label_salary.':</b>'.$job_salary.'</p>
				           	<p><b>'.$label_location.':</b>'.$job_location_text.'</p>
				           	<p><b>'.$label_job_type.':</b>'.$job_type_name.'</p>
				           	<p><b>'.$label_telephone.':</b>'.$office_telephone.'</p>
				           	<p><b>'.$label_email.':</b><a href="mailto:'.$job_response_email.'">'.$job_response_email.'</a></p>
				        	
				       	</div>

				   	</div>
			    
			    </div>

			</div>';

	/*
	job_id, 
	job_title, 
	job_salary, 
	job_description, 
	job_featured, 
	job_start_date, 
	job_duration, 
	job_expiry_date, 
	job_response_email, 
	job_external_reference, 
	job_location_text, 
	postal_code, 
	job_type_id, 
	job_type_name, 
	consultant_id, 
	consultant_name, 
	consultant_phone_mobile, 
	brand_id, 
	brand_name, 
	office_id, 
	office_telephone, 
	language_id, 
	country_id, 
	job_source_id, 
	weight, id
	*/
?>