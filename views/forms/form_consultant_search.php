<?php 

echo '<div class="row theme-white">
    
    <div class="panel column-4 theme-pattern ">';
 

echo form_open('consultant/find_by_search'); 

echo '
		<label  class="form-label">'.$label_first_name.'</label>

			<input type="text" name="consultant_first_name" value="'.$consultant_first_name.'" class="form-input" />

			<label  class="form-label">'.$label_last_name.'</label>

			<input type="text" name="consultant_last_name" value="'.$consultant_last_name.'" class="form-input" />

			<label  class="form-label">'.$label_email.'</label>

			<input type="text" name="consultant_email" value="'.$consultant_email.'" class="form-input"  />

			<label  class="form-label"></label>

			<input type="submit" value="'.$button_submit.'" class="form-submit"/></div>

		</form>

	</div>

</div>';

?>

