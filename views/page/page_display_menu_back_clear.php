<?php 
	
	echo '<style>.float-right{float:right; 
								padding:none;
								margin:none;
								padding-right:16px;
								;} 
			</style>';

	echo 	'<div class="row theme-grey">

                <div class="column-12">

                    <div class="bar">

                        '.anchor($uri_back, $button_back).'

                        <div class="float-right">

                        	'.anchor($uri_string.'/0', $button_clear).'

                        </div>

                    </div>

                </div>

            </div>';

    echo 	'<div class="row theme-red">

				<div class="column-12">               

				    <div class="panel theme-red">

				        <h2><span class="white-text">'.$page_header.'</span></h2> 

				    </div>

				</div>

			</div>';
?>