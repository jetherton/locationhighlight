

	<h4>
		Select <?php echo $level_name_text; ?> for <?php echo $parent_name; ?>:
	</h4>
	<?php print form::dropdown('admin_area_'.$level, $admin_areas, 'standard'); ?>
	
	<a href="#" onclick="switchArea(<?php echo $level; ?>); return false;">update map</a><span id="admin_area_loading_<?php echo $level; ?>"></span>

	<div id="adminarea_level_<?php echo $level; ?>"></div>
