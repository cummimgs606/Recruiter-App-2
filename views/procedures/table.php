<html>
	<head>
    	<title><?php echo $page_title;?></title>
    	<?php  $this->load->view('templates/header'); ?>
	</head>
<body>
        

	<div class="main">

		<h1><?php echo $page_header;?></h1>
		     
		    <?php 
			    $template = array('table_open' => '<table border="1" cellpadding="2" cellspacing="1" class="pure-table pure-table-bordered pure-table-striped">');

				$this->table->set_template($template);

				if(is_object($query)){

					echo $this->table->generate($query);
				}
				else
				{
					//echo 'Result : '.$query.'</p>';

					echo '<table border="1" cellpadding="2" cellspacing="1" class="pure-table pure-table-bordered pure-table-striped">';
					echo '<thead><tr><th>result</th><tr></thead>';
					echo '<tbody><tr><td>'.$query.'</td></tr></tbody>';
					echo '</table>';
				}
		    ?>

		</div>
        
</body>
</html>
