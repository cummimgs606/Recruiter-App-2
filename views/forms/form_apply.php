<?php

    if(validation_errors()){

        echo '<div class="row theme-white">
            
            <div class="panel column-4 theme-white">

                <label class="form-label">'.$label_form_errors.'</label>

                <div style="color:#AA0000; padding-left:180px" >'

                    .validation_errors().

                '</div>

            </div>

        </div>';

    }
?>

<div class="row theme-white">
    
    <div class="panel column-4 theme-pattern ">

        <?php echo form_open_multipart('/apply/'.$job_id,  'class="form"'); 
            
            echo '  <label  class="form-label">'.$label_first_name.'</label>
                    <input  type="text" 
                            name="candidate_first_name" 
                            value="'.$candidate_first_name.'" 
                            class="form-input"/>
                    
                    <label  class="form-label">'.$label_middle_name.'</label>
                    <input  type="text" 
                            name="candidate_middle_name" 
                            value="'.$candidate_middle_name.'" 
                            class="form-input"/>

                    <label  class="form-label">'.$label_last_name.'</label>
                    <input  type="text" 
                            name="candidate_last_name" 
                            value="'.$candidate_last_name.'" 
                            class="form-input"/>

                    <label  class="form-label">'.$label_salutation.'</label>
                    <input  type="text" 
                            name="candidate_salutation" 
                            value="'.$candidate_salutation.'" 
                            class="form-input"/>

                    <label  class="form-label">'.$label_email.'</label>
                    <input  type="email" 
                            name="candidate_email" 
                            value="'.$candidate_email.'" 
                            class="form-input"/>

                    <label  class="form-label">'.$label_phone_home.'</label>
                    <input  type="text" 
                            name="candidate_phone_home" 
                            value="'.$candidate_phone_home.'" 
                            class="form-input"/>

                    <label class="form-label">'.$label_phone_mobile.'</label>
                    <input  type="text" 
                            name="candidate_phone_mobile" 
                            value="'.$candidate_phone_mobile.'" 
                            class="form-input"/>

                    <label class="form-label">'.$label_candidate_cv.'</label>
                    <div class="upload-button-wrapper">
                        <button     class="upload-button"
                                    id="file_input_text">'.$button_upload_cv.'</button>
                        <input      type="file" 
                                    id="file_input"
                                    name="candidate_cv" 
                                    value="'.$candidate_cv.'" 
                                    class="form-input"/>
                    </div>

                    <input  type="hidden" 
                            name="job_application_campaign" 
                            value="'.$job_application_campaign.'" 
                            class="form-input"/>

                    <input  type="hidden" 
                            name="job_application_Keyword" 
                            value="'.$job_application_Keyword.'" 
                            class="form-input"/>

                    <input  type="hidden" 
                            name="job_application_location" 
                            value="'.$job_application_location.'"/>

                    <input  type="hidden" 
                            name="job_title" 
                            value="'.$job_title.'"/>

                    <input  type="hidden" 
                            name="job_id" 
                            value="'.$job_id.'" size="50" />

                    <input  type="hidden" 
                            name="job_type_id" 
                            value="'.$job_type_id.'"/> </p>

                    <input  type="hidden" 
                            name="consultant_name" 
                            value="'.$consultant_name.'"/> </p>

                    <label  class="form-label"> </label>
                    <input  type="submit" 
                            value="'.$button_submit.'" 
                            class="form-submit"/>'; ?>

        </form>

    </div>

</div>

<?php
echo '<script src="'.base_url().'frame-work/version-2016-r1-v2/javascripts/upload_button.js"></script>';
?>

<!---
    <div class="form-upload">
        <input type="file" name="candidate_cv"  value="'.$candidate_cv.'" class="form-input"/>
    </div>
--->
