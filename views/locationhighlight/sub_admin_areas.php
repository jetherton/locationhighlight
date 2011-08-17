<hr/>

	<?php if($adminareas_count>0){?>
		<h4 style="margin-bottom:5px;"><?php echo Kohana::lang('layer.select');?>
			<?php echo $level_name_text; ?> <?php echo Kohana::lang('layer.for');?> <?php echo $parent_name; ?>:
		</h4>
		<?php print form::dropdown('admin_area_'.$level, $admin_areas, 'standard'); ?>
		
		<a href="#" onclick="switchArea(<?php echo $level; ?>); return false;"><?php echo Kohana::lang('layer.update');?></a><span id="admin_area_loading_<?php echo $level; ?>"></span>
	
	<?php }?>
	

<?php if(count($cities) > 0){?>
	
		<h4 style="margin-bottom:5px;"><?php echo Kohana::lang('layer.cities');?>  <?php echo Kohana::lang('layer.for');?> <?php echo $parent_name; ?>:
		</h4>
		<?php print form::dropdown('cities_'.$level, $cities); ?>
		<a href="#" onclick="switchCities(<?php echo $level; ?>); return false;"><?php echo Kohana::lang('layer.update');?></a>
	
	<?php }?>
	

<div id="adminarea_level_<?php echo $level; ?>"></div>