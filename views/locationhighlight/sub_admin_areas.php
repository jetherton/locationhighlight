

	<h4><?php echo Kohana::lang('file.select');?>
		<?php echo $level_name_text; ?><?php echo Kohana::lang('file.for');?><?php echo $parent_name; ?>:
	</h4>
	<?php print form::dropdown('admin_area_'.$level, $admin_areas, 'standard'); ?>
	
	<a href="#" onclick="switchArea(<?php echo $level; ?>); return false;"><?php echo Kohana::lang('file.update');?></a><span id="admin_area_loading_<?php echo $level; ?>"></span>

	<div id="adminarea_level_<?php echo $level; ?>"></div>
