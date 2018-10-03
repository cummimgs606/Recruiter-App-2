<?php 

	$index = $row_index;

	foreach ($query->result() as $row)
	{

		echo 	'<div class="row theme-red">

				    <div class="column-12">               

				        <div class="panel theme-red">

				            <h2><span class="white-text">'.$index.' - '.$row->job_title.'</span></h2> 

				        </div>

				    </div>

				</div>';

		echo 	'<div class="row theme-white">
			    
			    	<div class="column-12 ">
			    
				    	<div class="panel theme-white">
				        
				        	<div class="condense-text">
				            
				            	<p><b>'.$label_job_location.':</b>'.$row->job_location_text.'</p>
				            	<p><b>'.$label_job_salary.':</b>'.$row->job_salary.'</p>
				            	<p><b>'.$label_job_job_type.':</b>'.$row->job_type_name.'</p>

				        	</div>

				   		</div>
			    
			    	</div>

			    </div>';
            
        echo 	'<div class="panel theme-white">'

        			.$row->job_description.'
     
	                <form name="form" id="form" action="'.site_url('apply/'.$row->job_id).'" method="post">
	          
	                    <p>&nbsp;</p>
	                    <input name="submit" id="submit" type="submit" value="'.$button_apply.'" class="form-submit theme-red">
	                    
	                </form>

	           	</div>';

		echo 	'<div class="row theme-white">
			    
			    	<div class="column-12 ">
			    
				    	<div class="panel theme-white">
				        
				        	<div class="condense-text">
				            
				            	<p><b>'.$label_job_location.':</b>'.$row->job_location_text.'</p>
				            	<p><b>'.$label_job_salary.':</b>'.$row->job_salary.'</p>
				            	<p><b>'.$label_job_job_type.':</b>'.$row->job_type_name.'</p>

				        	</div>

				   		</div>
			    
			    	</div>

			    </div>';

	    $index ++;
	}
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