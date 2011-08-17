<?php 
/**
 * data upload view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     John Etherton <john@ethertontech.com>  
 */
?>

<div class="bg">

	<!-- report-form -->
	<div class="report-form">
		<?php
		if ($form_error) {
		?>
			<!-- red-box -->
			<div class="red-box">
				<h3><?php echo Kohana::lang('ui_main.error');?></h3>
				<ul>
                <?php
				foreach ($errors as $error_item => $error_description)
				{
					print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
				}
				?>
				</ul>
			</div>
		<?php
		}
		?>
		<!-- column -->
		<div class="upload_container">
		
		<h3><?php echo Kohana::lang('layer.csv_upload');?></h3>
		<p><?php echo Kohana::lang('layer.csv_upload_details');?></p>
		
			<?php print form::open(NULL, array('id' => 'uploadForm', 'name' => 'uploadForm', 'enctype' => 'multipart/form-data')); ?>
            <p><b><?php echo Kohana::lang('ui_main.upload_file');?></b> <?php echo form::upload(array('name' => 'csvfile'), 'path/to/local/file'); ?></p>
			<button type="submit"><?php echo Kohana::lang('ui_main.upload');?></button>
			<?php print form::close(); ?>
		</div>
	</div>
</div>
