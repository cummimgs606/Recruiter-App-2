<!--<div style='background-color:#CCCCCC; padding:5px; padding-top:0px'>-->
<!--<h2><?php //echo $jobs_total; ?> Jobs found </h2>-->

<div class="row theme-grey">
    <div class="column-6">
        <div class="bar">

			<?php 

				if($jobs_total > 0){

					if($jobs_per_page == 1){

						echo 'Page '.$jobs_page_number.' : Jobs '.$jobs_start.' / '.$jobs_total;

					}else{

						echo 'Page '.$jobs_page_number.' : Jobs '.$jobs_start.' - '.$jobs_end.' / '.$jobs_total;

					}
				}
			?>

    	</div>
    </div>
</div>

