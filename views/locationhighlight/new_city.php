<tr id="city_row_<?php echo $id; ?>">
	<td class="col-1" style="width:20px;">&nbsp;</td>
	<td class="col-2" style="width:50px;">
		<input type="text" id="city_name_<?php echo $id; ?>" name="city_name_<?php echo $id; ?>" />
	</td>
	<td class="col-3" style="width:200px;">
		<?php print form::dropdown('city_adminarea_'.$id, $city_admin_area_dropdown, "bla", 'style="width:150px;"'); ?>
	</td>
	<td class="col-3" style="width:250px;">
		<?php echo Kohana::lang("layer.lat");?>:
		<input type="text" id="city_lat_<?php echo $id; ?>" name="city_lat_<?php echo $id; ?>" />
		<br/>
		<?php echo Kohana::lang("layer.lon");?>:
		<input  type="text" id="city_lon_<?php echo $id; ?>" name="city_lon_<?php echo $id; ?>" />
	</td>
	<td class="col-4" style="width:150px;">
		<span id="city_status_<?php echo $id; ?>"></span>
		<ul>
			<li class="none-separator"><a id="save_city_btn_<?php echo $id; ?>" href="#" ><?php echo Kohana::lang('layer.save');?></a></li>
			<li><a id="del_city_btn_<?php echo $id; ?>" href="#" ><?php echo Kohana::lang('layer.delete');?></a></li>
		</ul>
	</td>
</tr>