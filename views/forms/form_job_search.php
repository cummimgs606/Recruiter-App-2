<?php 

	if(!$validation){

		echo '<div class="row theme-white">
    
			    <div class="panel column-4 theme-white">

			        <label class="form-label">Form Errors</label>

			        <div style="color:#AA0000; padding-left:180px" >'
			   
			            .validation_errors().'

			        </div>

			    </div>

			</div>';
	}
?>


<div class="row theme-white">
    
    <div class="panel column-4 theme-pattern ">

		<?php echo form_open($uri_back,  'class="form"'); ?>

			<label class="form-label"><?php echo $search_form_keyword;?></label>

			<input type="text" name="keyword" value="<?php echo $keyword; ?>" class="form-input" />

			<label class="form-label"><?php echo $search_form_location;?></label>

			<input type="text" name="location" value="<?php echo $location; ?>" class="form-input" />

			<label class="form-label"><?php echo $search_form_job_type;?></label>

			<?php $this->dropdown->job_type($job_type, $search_form_drop_down_job_type);?>

			<h5></h5>

			<label class="form-label"> </label>

			<input type="hidden" name="sent" value="true" />

			<input type="submit" name='submit' value="<?php echo $search_form_submit;?>" class="form-submit"/>

			</div>

		</form>

    </div>

</div>

