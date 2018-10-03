<style>

	.form-label {
	    width: 180px;
	    float: left;
	    padding-bottom: 6px;
	    margin-top: 8px;
	}

	.form {
	    padding: 0px;
	}

</style>


<?php echo form_open('test_mail/send',  'class="form"'); ?>

	<div class="row theme-white">

		<div class=" column-4 document-title document-title-text-centered">

       		<h1><span class="red-text">Email</span></h1> 

       	</div>	

    </div>

	<div class="row theme-white">
	    
	    <div class="panel column-4 theme-pattern ">

			<label class="form-label">from_email</label>
			<input type="text" name="from_email" value="<?php echo $from_email; ?>" class="form-input" />

			<label class="form-label">from_name</label>
			<input type="text" name="from_name" value="<?php echo $from_name; ?>" class="form-input" />	

			<label class="form-label">to_email</label>
			<input type="text" name="to_email" value="<?php echo $to_email; ?>" class="form-input" />

			<label class="form-label">to_name</label>
			<input type="text" name="to_name" value="<?php echo $to_name; ?>" class="form-input" />	

			<label class="form-label">subject</label>
			<input type="text" name="subject" value="<?php echo $subject; ?>" class="form-input" />

			<label class="form-label">message</label>
			<input type="text" name="message" value="<?php echo $message; ?>" class="form-input" />	

			<label class="form-label"></label>
			<input type="submit" name='submit' value="Submit" class="form-submit"/>		

	    </div>

	</div>

	<div class="row theme-white">

		<div class=" column-4 document-title document-title-text-centered">

       		<h1><span class="red-text">Email Preferences</span></h1> 

       	</div>	

    </div>

	<div class="row theme-white">

	    <div class="panel column-4 theme-pattern ">

			<input type="hidden" name="default" value="<?php echo $default; ?>" class="form-input" />		

			<label class="form-label">useragent</label>
			<input type="text" name="useragent" value="<?php echo $useragent; ?>" class="form-input" />

			<label class="form-label">protocol</label>
			<input type="text" name="protocol" value="<?php echo $protocol; ?>" class="form-input" />		

			<label class="form-label">mailpath</label>
			<input type="text" name="mailpath" value="<?php echo $mailpath; ?>" class="form-input" />

			<label class="form-label">smtp_host</label>
			<input type="text" name="smtp_host" value="<?php echo $smtp_host; ?>" class="form-input" />

			<label class="form-label">smtp_user</label>
			<input type="text" name="smtp_user" value="<?php echo $smtp_user; ?>" class="form-input" />

			<label class="form-label">smtp_pass</label>
			<input type="text" name="smtp_pass" value="<?php echo $smtp_pass; ?>" class="form-input" />

			<label class="form-label">smtp_port</label>
			<input type="text" name="smtp_port" value="<?php echo $smtp_port; ?>" class="form-input" />		

			<label class="form-label">smtp_timeout</label>
			<input type="text" name="smtp_timeout" value="<?php echo $smtp_timeout; ?>" class="form-input" />

			<label class="form-label">smtp_keepalive</label>
			<input type="text" name="smtp_keepalive" value="<?php echo $smtp_keepalive; ?>" class="form-input" />

			<label class="form-label">smtp_crypto</label>
			<input type="text" name="smtp_crypto" value="<?php echo $smtp_crypto; ?>" class="form-input" />

			<label class="form-label">wordwrap</label>
			<input type="text" name="wordwrap" value="<?php echo $wordwrap; ?>" class="form-input" />

			<label class="form-label">wrapchars</label>
			<input type="text" name="wrapchars" value="<?php echo $wrapchars; ?>" class="form-input" />		

			<label class="form-label">mailtype</label>
			<input type="text" name="mailtype" value="<?php echo $mailtype ; ?>" class="form-input" />

			<label class="form-label">charset</label>
			<input type="text" name="charset" value="<?php echo $charset; ?>" class="form-input" />

			<label class="form-label">validate</label>
			<input type="text" name="validate" value="<?php echo $validate; ?>" class="form-input" />

			<label class="form-label">priority</label>
			<input type="text" name="priority" value="<?php echo $priority; ?>" class="form-input" />

			<label class="form-label">crlf</label>
			<input type="text" name="crlf" value="<?php echo $crlf; ?>" class="form-input" />

			<label class="form-label">newline</label>
			<input type="text" name="newline" value="<?php echo $newline; ?>" class="form-input" />

			<label class="form-label">bcc_batch_mode</label>
			<input type="text" name="bcc_batch_mode" value="<?php echo $bcc_batch_mode; ?>" class="form-input" />

			<label class="form-label">bcc_batch_size</label>
			<input type="text" name="bcc_batch_size" value="<?php echo $bcc_batch_size; ?>" class="form-input" />

			<label class="form-label">dsn</label>
			<input type="text" name="dsn" value="<?php echo $dsn; ?>" class="form-input" />						
			
			<label class="form-label"></label>
			<input type="submit" name='submit' value="Submit" class="form-submit"/>

			<label class="form-label"></label>
			<input type="submit" name='reset' value="Reset" class="form-submit"/>

    	</div>

  		<div class="panel column-8 theme-pattern ">

			<table class="table">
				<colgroup>
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="60%">
				</colgroup>
				<thead>
					<tr class="table-odd"><th class="head">Preference</th>
						<th class="head">Default Value</th>
						<th class="head">Options</th>
						<th class="head">Description</th>
					</tr>
				</thead>
				<tbody >
					<tr >
						<td><strong>useragent</strong></td>
						<td>CodeIgniter</td>
						<td>None</td>
						<td>The “user agent”.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>protocol</strong></td>
						<td>mail</td>
						<td>mail, sendmail, or smtp</td>
						<td>The mail sending protocol.</td>
					</tr>
					<tr >
						<td><strong>mailpath</strong></td>
						<td>/usr/sbin/sendmail</td>
						<td>None</td>
						<td>The server path to Sendmail.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>smtp_host</strong></td>
						<td>LON-AD-MG03 / 10.3.4.17</td>
						<td>None</td>
						<td>SMTP Server Address.</td>
					</tr>
					<tr >
						<td><strong>smtp_user</strong></td>
							<td>No Default</td>
							<td>None</td>
							<td>SMTP Username.</td>
						</tr>
						<tr class="table-odd">
						<td><strong>smtp_pass</strong></td>
						<td>No Default</td>
						<td>None</td>
						<td>SMTP Password.</td>
					</tr>
					<tr >
						<td><strong>smtp_port</strong></td>
						<td>25</td>
						<td>None</td>
						<td>SMTP Port.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>smtp_timeout</strong></td>
						<td>5</td>
						<td>None</td>
						<td>SMTP Timeout (in seconds).</td>
					</tr>
					<tr >
						<td><strong>smtp_keepalive</strong></td>
						<td>FALSE</td>
						<td>TRUE or FALSE (boolean)</td>
						<td>Enable persistent SMTP connections.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>smtp_crypto</strong></td>
						<td>No Default</td>
						<td>tls or ssl</td>
						<td>SMTP Encryption</td>
					</tr>
					<tr >
						<td><strong>wordwrap</strong></td>
						<td>TRUE</td>
						<td>TRUE or FALSE (boolean)</td>
						<td>Enable word-wrap.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>wrapchars</strong></td>
						<td>76</td>
						<td>&nbsp;</td>
						<td>Character count to wrap at.</td>
					</tr>
					<tr >
						<td><strong>mailtype</strong></td>
						<td>text</td>
						<td>text or html</td>
						<td>Type of mail. If you send HTML email you must send it as a complete web
							page. Make sure you don’t have any relative links or relative image
							paths otherwise they will not work.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>charset</strong></td>
						<td><code class="docutils literal"><span class="pre">$config['charset']</span></code></td>
						<td>&nbsp;</td>
						<td>Character set (utf-8, iso-8859-1, etc.).</td>
					</tr>
					<tr >
						<td><strong>validate</strong></td>
						<td>FALSE</td>
						<td>TRUE or FALSE (boolean)</td>
						<td>Whether to validate the email address.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>priority</strong></td>
						<td>3</td>
						<td>1, 2, 3, 4, 5</td>
						<td>Email Priority. 1 = highest. 5 = lowest. 3 = normal.</td>
					</tr>
					<tr >
						<td><strong>crlf</strong></td>
						<td>\n</td>
						<td>“\r\n” or “\n” or “\r”</td>
						<td>Newline character. (Use “\r\n” to comply with RFC 822).</td>
					</tr>
					<tr class="table-odd">
						<td><strong>newline</strong></td>
						<td>\n</td>
						<td>“\r\n” or “\n” or “\r”</td>
						<td>Newline character. (Use “\r\n” to comply with RFC 822).</td>
					</tr>
					<tr >
						<td><strong>bcc_batch_mode</strong></td>
						<td>FALSE</td>
						<td>TRUE or FALSE (boolean)</td>
						<td>Enable BCC Batch Mode.</td>
					</tr>
					<tr class="table-odd">
						<td><strong>bcc_batch_size</strong></td>
						<td>200</td>
						<td>None</td>
						<td>Number of emails in each BCC batch.</td>
					</tr>
					<tr >
						<td><strong>dsn</strong></td>
						<td>FALSE</td>
						<td>TRUE or FALSE (boolean)</td>
						<td>Enable notify message from server</td>
					</tr>
				</tbody>
			</table>

	</div>  	

    </div>

</form>





<!---
useragent	
protocol	
mailpath	
smtp_host	
smtp_user	
smtp_pass	
smtp_port	
smtp_timeout	
smtp_keepalive	
smtp_crypto	
wordwrap	
wrapchars	
mailtype	
charset	
validate	
priority	
crlf	
newline	
bcc_batch_mode	
bcc_batch_size	
dsn
--->

