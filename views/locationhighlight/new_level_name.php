	<tr>
		<td class="col-1" style="width:20px;">&nbsp;</td>
		<td class="col-2" style="width:50px;">
					<?php echo $next_level; ?>
		</td>
		<td class="col-3" style="width:200px;">
					<input type="text" id="level_name_form_<?php echo $next_level; ?>" name="" />
		</td>
		<td class="col-4" style="width:200px;">
			<span id="name_level_status<?php echo $next_level; ?>"></span>
			<ul>
				<li class="none-separator"><a href="#" onclick="saveLevelName('<?php echo $next_level; ?>'); return false;">Save</a></li>
				<li><a href="#" onclick="deleteLevelName('<?php echo $next_level; ?>'); return false;"> Delete</a></li>
			</ul>
		</td>
	</tr>