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

					       '.$message_success_title.'

					    </div>

				    </div>

				</div>';
	}


	echo 	'<div class="row theme-white">
			    
			    <div class="column-12 ">
			    
				    <div class="panel theme-white">
				        
				        <div class="condense-text">
				            
				            <p>'.$message_success_body.'</p>

				        </div>

				   	</div>
			    
			    </div>

			</div>';
?>


