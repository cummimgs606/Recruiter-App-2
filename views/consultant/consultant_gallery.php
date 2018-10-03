<?php 

	//echo '*** consultant_gallery()</p>';
/*
    echo    '<div class="row theme-grey">

                <div class="column-12">

                    <div class="bar">

                        '.anchor($uri_last, 'BACK').'

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
*/

  
	    $count = count($query->result_array());

	    if($count == 1){

	    	echo 	'<div class="row theme-white">
	   
				        <div class="column-12">
				        
				            <div class="panel"> 
				     
				                <div class="">';

								foreach ($query->result_array() as $row)
								{

							echo 	'<div class="gallery-item-medium">
					                    '.img('consultant-images/'.$row['consultant_image']).'
					                    
					                </div>

					                <div class="condense-text">
					                        <p>
					                        </p><h5><a class="link" href="'.site_url().'/consultant/find_by_id/'.$row['consultant_id'].'">'.$row['consultant_first_name'].' '.$row['consultant_last_name'].'</a></h5>
					                        <p></p>
					                        <p>'.$row['consultant_job_title'].'</p>
					                        <p>'.$row['office_name'].'</p>
											<p>'.$row['office_telephone'].'</p>

					                        <ul class="list-icons left">
					                            <li><a href="mailto:'.$row['consultant_email'].'?Subject=HNCOM generated enquiry"><div class="icon icon-email"></div></a></li>
					                            <li><a href="'.$row['consultant_facebook'].'"><div class="icon icon-facebook"></div></a></li>
					                            <li><a href="'.$row['consultant_linkedin'].'"><div class="icon icon-linkedin"></div></a></li>
					                            <li><a href="'.$row['consultant_twitter'].'"><div class="icon icon-twitter"></div></a></li>
					            			</ul>

					                    </div> 
';
			}

			echo 				'</div>

							</div>  
					                                                                                
						</div>

					</div>';

	    }else{

	    	echo 	'<div class="row theme-white">
	   
				        <div class="column-12">
				        
				            <div class="panel flex-centered "> 
				     
				                <div class="gallery flex-centered">';

								foreach ($query->result_array() as $row)
								{

									/*
									consultant_id	
									consultant_first_name	
									consultant_middle_name	
									consultant_last_name	
									consultant_job_title	
									consultant_rank	
									consultant_expertise	
									consultant_image	
									consultant_email	
									consultant_linkedin	
									consultant_twitter	
									consultant_phone_mobile	
									office_id	
									office_name	
									practice_ids	
									bio_ids
									*/

							echo 	'<div class="gallery-item-medium">
					                    '.img('consultant-images/'.$row['consultant_image']).'
					                    <div class="condense-text">
					                        <p>
					                        </p><h5><a class="link" href="'.site_url().'/consultant/find_by_id/'.$row['consultant_id'].'">'.$row['consultant_first_name'].' '.$row['consultant_last_name'].'</a></h5>
					                        <p></p>
					                        <p>'.$row['consultant_job_title'].'</p>
					                        <p>'.$row['office_name'].'</p>
											<p>'.$row['office_telephone'].'</p>

					                        <ul class="list-icons left">
					                            <li><a href="mailto:'.$row['consultant_email'].'?Subject=HNCOM generated enquiry"><div class="icon icon-email"></div></a></li>
					                            <li><a href="'.$row['consultant_facebook'].'"><div class="icon icon-facebook"></div></a></li>
					                            <li><a href="'.$row['consultant_linkedin'].'"><div class="icon icon-linkedin"></div></a></li>
					                            <li><a href="'.$row['consultant_twitter'].'"><div class="icon icon-twitter"></div></a></li>
					            			</ul>

					                    </div> 

					                </div>';
			}

			echo 				'</div>

							</div>  
					                                                                                
						</div>

					</div>';

	    }

	//echo '</ul>';

	$query->next_result(); 
	$query->free_result(); 

?>






                    
           

                
                   
                        
                        

			
					
						
	

