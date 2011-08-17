<?php 
/**
 * Reports upload success view page.
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     John Etherton<john@ethertontech.com>  
 */
?>

<div class="bg">
	
	<h3><?php echo Kohana::lang('ui_main.upload_successful');?></h3>
	   <p>Successfully imported<?php echo $imported; ?> of <?php echo $rowcount; ?> data points.</p>

	
	<?php if(count($notices)){  ?>  
	<h3><?php echo Kohana::lang('ui_main.notices');?></h3>	
		<ul>
	<?php foreach($notices as $notice)  { ?>
	<li><?php echo $notice ?></li>

	<?php } }?>
	</ul>
	</div>
</div>