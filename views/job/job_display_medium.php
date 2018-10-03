<?php 

	$index = $row_index;

	foreach ($query->result() as $row)
	{
		$path = $uri_path.'/'.$index.'/2';
		$link = $index.' - '.$row->job_title;

		echo '<div class="row theme-white">
			    <div class="column-12">
			        <a href="#">
			            <div class="bar over-flow">
			                '.anchor($path, $link).'</p><div class="icon icon-arrowRight right"></div>
			            </div>
			        </a>
			        <div class="panel">
			            <div class="condense-text">
			                <b>'.$label_job_location.':</b>'.$row->job_location_text.'</p>
			                <b>'.$label_job_salary.':</b>'.$row->job_salary.'</p>
			                <b>'.$label_job_description.':</b>'.truncateString($row->job_description, 200).'</p>
			            </div>
			        </div>
			    </div>
			</div>';

	    $index ++;
	}

	function truncateString($string, $length, $append = '...') {

	    $length -= strlen($append); // length of "..."
	    $string = substr($string, 0, $length);
	    $string = substr($string, 0, strrpos($string, ' '));
	    $string .= $append;

	    return $string;
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