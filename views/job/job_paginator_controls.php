<?php echo '<style>.float-right{float:right; 
								padding:none;
								margin:none;
								padding-right:16px;
								;} 
			</style>';?>

<div class="row theme-grey">
    <div class="column-12">
        <div class="bar">

			<?php 

				if($jobs_total > 0){

					if($jobs_per_page == 1){

						echo $paginator_page.' '.$jobs_page_number.' : '.$paginator_jobs.' '.$jobs_start.' / '.$jobs_total;

					}else{

						echo $paginator_page.' '.$jobs_page_number.' : '.$paginator_jobs.' '.$jobs_start.' - '.$jobs_end.' / '.$jobs_total;

					}
				}
				



			?>

        	<div class="float-right">

				<?php 

					$pagination->initialize($settings);

				    echo $pagination->create_links();
					//echo form_open($uri_path); 
					/*
					echo '<input type="hidden" name="job_toggle_on" value="'.$job_toggle.'" />';
					echo '<input type="submit" value="'.$job_button_text.'" class="button_as_text" />';
					echo '</form>';
					*/
					/*
					$site 		= site_url();
					$controller = $this->uri->segment(1);
        			$method     = $this->uri->segment(2);
        			$page 		= 1;
					*/
					echo '  '.anchor($switch_button_url, $switch_button_text);
				?>	

			</div>

    	</div>

	</div>

</div>

